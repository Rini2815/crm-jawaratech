<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchedulesController extends Controller
{
    public function index(Request $request)
    {
        $akhirBulan = Carbon::today()->endOfMonth();

        $schedules = $this->hitungJadwal();

        // Status tindak lanjut (dari tr_follow_up) untuk siklus perawatan yang sedang berjalan
        $tindakLanjut = DB::table('tr_follow_up')
            ->where('kategori', 'Pengingat Perawatan')
            ->get()
            ->keyBy(fn ($f) => $f->id_unit . '|' . $f->tanggal_jadwal);

        $schedules->each(function ($j) use ($tindakLanjut) {
            $j->follow_status = optional(
                $tindakLanjut->get($j->id_unit . '|' . $j->jatuh_tempo->toDateString())
            )->status;
        });

        // Kartu ringkasan: unit yang sudah jatuh tempo / terlewat sampai akhir bulan ini
        $perluDihubungi  = $schedules->filter(fn ($j) => $j->jatuh_tempo->lte($akhirBulan));
        $totalJatuhTempo = $perluDihubungi->count();
        $totalAc         = $perluDihubungi->where('kelompok', 'AC')->count();
        $totalDispenser  = $perluDihubungi->where('kelompok', 'Dispenser')->count();
        $totalWaterHeater = $perluDihubungi->where('kelompok', 'Water Heater')->count();
        $totalMesinCuci  = $perluDihubungi->where('kelompok', 'Mesin Cuci')->count();

        return view('schedules.index', compact(
            'schedules', 'totalJatuhTempo', 'totalAc', 'totalDispenser', 'totalWaterHeater', 'totalMesinCuci'
        ));
    }

    /**
     * Tombol Chat: catat agenda follow-up (jika belum ada untuk siklus ini),
     * lalu buka WhatsApp konsumen dengan template pesan.
     */
    public function hubungi(Request $request)
    {
        $request->validate([
            'id_unit' => 'required|exists:ms_unit,id_unit',
        ]);

        $j = $this->hitungJadwal((int) $request->id_unit)->first();

        if (!$j) {
            return redirect()->route('schedules.index')
                ->with('error', 'Unit ini sedang dalam proses servis atau tidak ditemukan, sehingga pengingat tidak dapat dibuat.');
        }

        $sudahAda = DB::table('tr_follow_up')
            ->where('kategori', 'Pengingat Perawatan')
            ->where('id_unit', $j->id_unit)
            ->whereDate('tanggal_jadwal', $j->jatuh_tempo->toDateString())
            ->exists();

        if (!$sudahAda) {
            DB::table('tr_follow_up')->insert([
                'id_unit'        => $j->id_unit,
                'id_servis'      => null,
                'id_pengguna'    => auth()->id(),
                'kategori'       => 'Pengingat Perawatan',
                'tanggal_jadwal' => $j->jatuh_tempo->toDateString(),
                'status'         => 'Belum Dihubungi',
            ]);
        }

        return redirect()->away(FollowUp::linkWa($j->no_hp, $this->pesanPengingat($j)));
    }

    // ---------------------------------------------------------------------

    /**
     * Hitung jadwal perawatan semua unit (atau satu unit): jatuh tempo = servis terakhir + interval_bulan
     */
    private function hitungJadwal(?int $idUnit = null)
    {
        $hariIni    = Carbon::today();
        $akhirBulan = $hariIni->copy()->endOfMonth();

        // Unit yang sedang dalam proses servis tidak perlu diingatkan perawatan
        $sedangServis = DB::table('tr_servis')
            ->where('status', '!=', 'Selesai')
            ->pluck('id_unit')
            ->all();

        // Tanggal closing terakhir per unit
        $closingTerakhir = DB::table('tr_servis')
            ->where('status', 'Selesai')
            ->whereNotNull('tanggal_closing')
            ->select('id_unit', DB::raw('MAX(tanggal_closing) as terakhir'))
            ->groupBy('id_unit')
            ->pluck('terakhir', 'id_unit');

        $unit = Unit::with('konsumen')
            ->when($idUnit, fn ($q) => $q->where('id_unit', $idUnit))
            ->get();

        return $unit
            ->reject(fn ($u) => in_array($u->id_unit, $sedangServis))
            ->map(function ($u) use ($closingTerakhir, $hariIni, $akhirBulan) {
                $dariClosing = isset($closingTerakhir[$u->id_unit]);
                $dasar       = Carbon::parse($dariClosing ? $closingTerakhir[$u->id_unit] : $u->tanggal_masuk)->startOfDay();

                $interval   = max(1, (int) $u->interval_bulan);
                $jatuhTempo = $dasar->copy()->addMonthsNoOverflow($interval)->startOfDay();
                $telat      = (int) round(($hariIni->timestamp - $jatuhTempo->timestamp) / 86400); // positif = sudah lewat

                $status = $this->statusJatuhTempo($telat, $jatuhTempo, $akhirBulan);

                $kelompok = match ($u->jenis_unit) {
                    'AC'           => 'AC',
                    'Mesin Cuci'   => 'Mesin Cuci',
                    'Water Heater' => 'Water Heater',
                    default        => 'Dispenser',
                };

                return (object) [
                    'id_unit'            => $u->id_unit,
                    'nama_pelanggan'     => $u->konsumen->nama ?? '-',
                    'no_hp'              => $u->konsumen->no_whatsapp ?? '',
                    'jenis_unit'         => $u->jenis_unit,
                    'kelompok'           => $kelompok,
                    'nama_perangkat'     => trim($u->jenis_unit . ' ' . $u->merek) . ($u->tipe_model ? ' (' . $u->tipe_model . ')' : ''),
                    'interval_label'     => $interval % 12 === 0 ? ($interval / 12) . ' Tahun' : $interval . ' Bulan',
                    'terakhir'           => $dasar,
                    'dari_closing'       => $dariClosing,
                    'jatuh_tempo'        => $jatuhTempo,
                    'status_label'       => $status['label'],
                    'badge'              => $status['badge'],
                    'ikon_status'        => $status['ikon'],
                    'warna_tanggal'      => $status['warna'],
                    'keterangan'         => $status['keterangan'],
                    'follow_status'      => null,
                ];
            })
            ->sortBy(fn ($j) => $j->jatuh_tempo->timestamp)
            ->values();
    }

    private function statusJatuhTempo(int $telat, Carbon $jatuhTempo, Carbon $akhirBulan): array
    {
        if ($telat > 14) {
            return ['label' => 'Terlewat', 'badge' => 'bg-dark text-white', 'ikon' => 'fa-exclamation-triangle', 'warna' => 'text-danger', 'keterangan' => "{$telat} hari lewat"];
        }
        if ($telat > 7) {
            return ['label' => 'Minggu 2', 'badge' => 'bg-danger text-white', 'ikon' => 'fa-exclamation-circle', 'warna' => 'text-danger', 'keterangan' => "{$telat} hari lewat"];
        }
        if ($telat >= 0) {
            return ['label' => 'Minggu 1', 'badge' => 'bg-warning text-dark', 'ikon' => 'fa-clock', 'warna' => 'text-warning', 'keterangan' => $telat === 0 ? 'Jatuh tempo hari ini' : "{$telat} hari lewat"];
        }
        if ($jatuhTempo->lte($akhirBulan)) {
            return ['label' => 'Segera', 'badge' => 'bg-info text-dark', 'ikon' => 'fa-hourglass-half', 'warna' => 'text-warning', 'keterangan' => abs($telat) . ' hari lagi'];
        }

        return ['label' => 'Mendatang', 'badge' => 'bg-secondary text-white', 'ikon' => 'fa-calendar-check', 'warna' => 'text-secondary', 'keterangan' => abs($telat) . ' hari lagi'];
    }

    private function pesanPengingat($j): string
    {
        return "Halo Bapak/Ibu {$j->nama_pelanggan}, kami dari Jawaratech. {$j->nama_perangkat} Anda sudah waktunya perawatan berkala (jadwal "
            . $j->jatuh_tempo->translatedFormat('j F Y')
            . "). Apakah Bapak/Ibu berkenan kami jadwalkan servisnya? Terima kasih.";
    }
}