<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Query dasar yang dipakai bersama oleh tampilan web, PDF, dan CSV.
     * Satu baris = satu servis, lengkap dengan konsumen, unit, teknisi,
     * dan follow-up terakhir untuk unit tersebut (tanpa membuat baris dobel).
     */
    private function buildQuery(Request $request, bool $defaultTahun = false)
    {
        $filterTanggal = $request->input('tanggal');
        $filterBulan   = $request->input('bulan');
        $filterTahun   = $defaultTahun ? $request->input('tahun', date('Y')) : $request->input('tahun');
        $idKonsumen    = $request->input('id_konsumen');

        // Follow-up terbaru per unit (1 baris per unit supaya data servis tidak dobel)
        $followUp = DB::table('tr_follow_up')
            ->select(
                'id_unit',
                DB::raw('MAX(tanggal_jadwal) as tanggal_jadwal_fu'),
                DB::raw('MAX(status) as status_follow_up'),
                DB::raw('MAX(catatan_hasil) as catatan_hasil')
            )
            ->groupBy('id_unit');

        $query = DB::table('tr_servis')
            ->join('ms_unit', 'tr_servis.id_unit', '=', 'ms_unit.id_unit')
            ->join('ms_konsumen', 'ms_unit.id_konsumen', '=', 'ms_konsumen.id_konsumen')
            ->leftJoin('ms_teknisi', 'tr_servis.id_teknisi', '=', 'ms_teknisi.id_teknisi')
            ->leftJoinSub($followUp, 'fu', 'fu.id_unit', '=', 'tr_servis.id_unit')
            ->select(
                'tr_servis.*',
                'ms_unit.jenis_unit',
                'ms_unit.merek',
                'ms_unit.tipe_model',
                'ms_unit.tanggal_masuk',
                'ms_unit.status_garansi',
                'ms_konsumen.id_konsumen',
                'ms_konsumen.nama',
                'ms_konsumen.no_whatsapp',
                'ms_konsumen.alamat',
                'ms_teknisi.nama_teknisi',
                'fu.tanggal_jadwal_fu',
                'fu.status_follow_up',
                'fu.catatan_hasil'
            )
            ->orderBy('ms_konsumen.id_konsumen', 'asc')
            ->orderBy('tr_servis.created_at', 'desc');

        if (!empty($idKonsumen)) {
            $query->where('ms_konsumen.id_konsumen', $idKonsumen);
        }
        if (!empty($filterTanggal)) {
            $query->whereDate('tr_servis.created_at', $filterTanggal);
        }
        if (!empty($filterBulan)) {
            $query->whereMonth('tr_servis.created_at', $filterBulan);
        }
        if (!empty($filterTahun)) {
            $query->whereYear('tr_servis.created_at', $filterTahun);
        }

        return $query;
    }

    /**
     * Teks periode berdasarkan TANGGAL REGISTRASI servis (bukan no tiket),
     * contoh: "30 Okt 2026 - 31 Okt 2026" atau "31 Okt 2026".
     */
    private function periodeLaporan($rows): string
    {
        $tgl = collect($rows)->pluck('created_at')->filter();
        if ($tgl->isEmpty()) {
            return Carbon::now()->translatedFormat('d M Y');
        }
        $min = Carbon::parse($tgl->min())->translatedFormat('d M Y');
        $max = Carbon::parse($tgl->max())->translatedFormat('d M Y');
        return $min === $max ? $min : "$min - $max";
    }

    /**
     * Ambil data closing/pembayaran (total bayar, status bayar, masa garansi, tgl closing)
     * dari kolom tr_servis. Beberapa kemungkinan nama kolom dicoba berurutan.
     * Hasilnya disimpan di properti x_* supaya dipakai sama di web, PDF, dan CSV.
     */
    private function tambahDataClosing($item)
    {
        $keys = array_keys(get_object_vars($item));

        // Cari kolom: nama persis dulu, kalau tidak ada cari yang mengandung kata kunci.
        $find = function (array $exact, array $groups = [], array $exclude = []) use ($item, $keys) {
            foreach ($exact as $n) {
                if (isset($item->$n) && $item->$n !== '') {
                    return $item->$n;
                }
            }
            foreach ($groups as $words) {
                foreach ($keys as $k) {
                    $lk = strtolower($k);
                    if (in_array($lk, $exclude, true)) continue;
                    $ok = true;
                    foreach ($words as $w) {
                        if (strpos($lk, $w) === false) { $ok = false; break; }
                    }
                    if ($ok && isset($item->$k) && $item->$k !== '') {
                        return $item->$k;
                    }
                }
            }
            return null;
        };

        $skipGaransi = ['status_garansi'];

        // Perkiraan selesai (bisa tanggal, bisa jumlah hari)
        $perkiraan = $find(
            ['perkiraan_selesai', 'estimasi_selesai', 'tanggal_estimasi', 'tgl_perkiraan_selesai'],
            [['perkiraan'], ['estimasi'], ['target', 'selesai']],
            ['status']
        );
        if ($perkiraan !== null && is_numeric($perkiraan) && (int) $perkiraan <= 365) {
            $basis = $item->tanggal_masuk ?? $item->created_at ?? null;
            $perkiraan = $basis ? Carbon::parse($basis)->addDays((int) $perkiraan)->toDateString() : null;
        }
        $item->x_perkiraan = $perkiraan;

        // Biaya
        $item->x_sparepart = $find(['biaya_sparepart', 'biaya_spare_part', 'sparepart', 'biaya_part'], [['sparepart'], ['spare'], ['part']]);
        $item->x_diskon    = $find(['diskon', 'potongan', 'discount'], [['diskon'], ['potongan'], ['discount']]);
        $total = $find(['total_bayar', 'total_biaya', 'grand_total', 'total_tagihan', 'total'], [['total', 'bayar'], ['total']]);
        if ($total === null && isset($item->biaya_jasa)) {
            $total = (float) $item->biaya_jasa + (float) ($item->x_sparepart ?? 0) - (float) ($item->x_diskon ?? 0);
        }
        $item->x_total_bayar  = $total;

        $item->x_status_bayar = $find(['status_pembayaran', 'status_bayar', 'payment_status'], [['status', 'bayar'], ['status', 'pembayaran'], ['payment']]);

        $item->x_tgl_closing = $find(['tanggal_closing', 'tgl_closing', 'closed_at', 'tanggal_selesai'], [['closing'], ['tgl', 'selesai']]);
        if ($item->x_tgl_closing === null && ($item->status ?? '') === 'Selesai') {
            $item->x_tgl_closing = $item->updated_at ?? null;
        }

        // Garansi
        $item->x_garansi_hari = $find(
            ['garansi_hari', 'masa_garansi', 'durasi_garansi', 'lama_garansi'],
            [['garansi', 'hari'], ['masa', 'garansi'], ['durasi', 'garansi'], ['lama', 'garansi'], ['garansi']],
            $skipGaransi
        );
        $item->x_garansi_sampai = $find(
            ['garansi_sampai', 'garansi_berlaku_hingga', 'tanggal_garansi_berakhir', 'tanggal_garansi_akhir', 'garansi_berakhir'],
            [['garansi', 'sampai'], ['garansi', 'berakhir'], ['garansi', 'hingga'], ['garansi', 'akhir'], ['garansi', 'tgl'], ['garansi', 'tanggal']],
            $skipGaransi
        );
        // Kalau yang ketemu di kolom "hari" ternyata berupa tanggal, pindahkan
        if ($item->x_garansi_sampai === null && $item->x_garansi_hari !== null && preg_match('/^\d{4}-\d{2}-\d{2}/', (string) $item->x_garansi_hari)) {
            $item->x_garansi_sampai = $item->x_garansi_hari;
            $item->x_garansi_hari = null;
        }
        if ($item->x_garansi_sampai === null && $item->x_garansi_hari !== null && $item->x_tgl_closing !== null) {
            $hari = (int) preg_replace('/\D/', '', (string) $item->x_garansi_hari);
            if ($hari > 0) {
                $item->x_garansi_sampai = Carbon::parse($item->x_tgl_closing)->addDays($hari)->toDateString();
            }
        }
        return $item;
    }

    private function prosesRows($rows)
    {
        return collect($rows)->map(fn ($r) => $this->tambahDataClosing($r));
    }

    /**
     * Halaman utama Laporan & Riwayat Servis
     */
    public function index(Request $request)
    {
        $filterTanggal = $request->input('tanggal');
        $filterBulan   = $request->input('bulan');
        $filterTahun   = $request->input('tahun', date('Y'));

        // Statistik
        $totalKonsumen   = DB::table('ms_konsumen')->count();
        $closingBulanIni = DB::table('tr_servis')->where('status', 'Selesai')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $garansiAktif    = DB::table('ms_unit')->where('status_garansi', 'like', '%Aktif%')->count();

        $antreanPerawatan = 0;
        $followUpTerkirim = 0;
        try {
            $antreanPerawatan = DB::table('tr_follow_up')->where('status', 'Belum Dihubungi')->count();
            $followUpTerkirim = DB::table('tr_follow_up')->where('status', '!=', 'Belum Dihubungi')->count();
        } catch (\Exception $e) {}

        $totalUnitTahunIni = DB::table('tr_servis')->whereYear('created_at', date('Y'))->count();

        // Diagnosa: buka /report?debug=1 untuk melihat nama kolom yang tersedia
        if ($request->has('debug')) {
            $contoh = $this->buildQuery($request, true)->first();
            $tabel = [];
            try { $tabel = array_map(fn ($t) => array_values((array) $t)[0], DB::select('SHOW TABLES')); } catch (\Exception $e) {}
            dd([
                'kolom_baris_laporan' => $contoh ? array_keys(get_object_vars($contoh)) : [],
                'contoh_nilai'        => $contoh,
                'semua_tabel'         => $tabel,
            ]);
        }

        $riwayatServis = $this->buildQuery($request, true)->paginate(10)->appends($request->all());
        $riwayatServis->getCollection()->transform(fn ($r) => $this->tambahDataClosing($r));

        return view('report.index', compact(
            'totalKonsumen', 'closingBulanIni', 'garansiAktif',
            'antreanPerawatan', 'followUpTerkirim', 'totalUnitTahunIni',
            'riwayatServis', 'filterTanggal', 'filterBulan', 'filterTahun'
        ));
    }

    public function kronologis(Request $request)
    {
        return view('report.kronologis');
    }

    public function exportDailyPdf(Request $request)
    {
        $id_konsumen = $request->input('id_konsumen');

        $konsumen = null;
        if ($id_konsumen) {
            $konsumen = DB::table('ms_konsumen')->where('id_konsumen', $id_konsumen)->first();
        }

        $riwayatServis = $this->prosesRows($this->buildQuery($request)->get());

        $periode =$this->periodeLaporan($riwayatServis);
        // Judul = nama file saat disimpan sebagai PDF (tanpa no tiket)
        $judulLaporan = $konsumen
            ? 'Laporan Servis ' . $konsumen->nama . ' - Registrasi ' . $periode
            : 'Laporan Rekapitulasi Servis - Registrasi ' . $periode;

        return view('report.pdf', compact('konsumen', 'riwayatServis', 'periode', 'judulLaporan'));
    }

    public function exportExcel(Request $request)
    {
        $id_konsumen = $request->input('id_konsumen');

        $konsumen = null;
        if ($id_konsumen) {
            $konsumen = DB::table('ms_konsumen')->where('id_konsumen', $id_konsumen)->first();
        }

        $riwayatServis = $this->prosesRows($this->buildQuery($request)->get());
        $periode = $this->periodeLaporan($riwayatServis);

        // Nama file berdasarkan tanggal registrasi (bukan no tiket)
        $periodeFile = str_replace([' - ', ' '], ['_sd_', '-'], $periode);
        $fileName = 'Laporan_Servis_Jawaratech_Registrasi_' . $periodeFile . '.xls';

        // Tampilan Excel dirender dari view report/excel.blade.php (lengkap dengan warna, lebar kolom, dan format Rp)
        $html = view('report.excel', compact('konsumen', 'riwayatServis', 'periode'))->render();

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }
}