<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use App\Models\Teknisi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClosingController extends Controller
{
    private const GARANSI      = [0, 7, 14, 30, 60];
    private const METODE       = ['Tunai', 'QRIS/Transfer'];
    private const STATUS_BAYAR = ['Belum Lunas', 'DP', 'Lunas'];
    private const STATUS_SIAP  = ['Proses Servis', 'Selesai']; // tiket yang boleh di-closing

    public function index(Request $request)
    {
        $query = Servis::with(['unit.konsumen', 'teknisi'])
            ->whereNotNull('no_invoice')
            ->orderByDesc('tanggal_closing')
            ->orderByDesc('id_servis');

        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        // Filter periode berdasarkan tanggal closing (hari ini, minggu ini, bulan ini, tahun ini)
        if ($request->filled('periode')) {
            $sekarang = now();

            switch ($request->periode) {
                case 'hari_ini':
                    $query->whereDate('tanggal_closing', $sekarang->toDateString());
                    break;
                case 'minggu_ini':
                    $query->whereBetween('tanggal_closing', [
                        $sekarang->copy()->startOfWeek()->toDateString(),
                        $sekarang->copy()->endOfWeek()->toDateString(),
                    ]);
                    break;
                case 'bulan_ini':
                    $query->whereYear('tanggal_closing', $sekarang->year)
                          ->whereMonth('tanggal_closing', $sekarang->month);
                    break;
                case 'tahun_ini':
                    $query->whereYear('tanggal_closing', $sekarang->year);
                    break;
            }
        }

        if ($request->filled('search')) {
            $kata = trim($request->search);
            $query->where(function ($q) use ($kata) {
                $q->where('no_invoice', 'like', "%{$kata}%")
                  ->orWhere('no_tiket', 'like', "%{$kata}%")
                  ->orWhereHas('teknisi', fn ($t) => $t->where('nama_teknisi', 'like', "%{$kata}%"))
                  ->orWhereHas('unit.konsumen', fn ($k) => $k->where('nama', 'like', "%{$kata}%"));
            });
        }

        $closing = $query->get();

        // Kartu statistik: dihitung dari seluruh data (tidak terpengaruh filter)
        $totalTransaksi = Servis::whereNotNull('no_invoice')->count();
        $totalOmset     = (int) Servis::whereNotNull('no_invoice')->sum('total_bayar');
        $totalLunas     = Servis::whereNotNull('no_invoice')->where('status_pembayaran', 'Lunas')->count();

        $tiketSiap = Servis::with(['unit.konsumen', 'teknisi'])
            ->whereNull('no_invoice')
            ->whereIn('status', self::STATUS_SIAP)
            ->orderBy('no_tiket')
            ->get();

        $teknisi          = Teknisi::orderBy('nama_teknisi')->pluck('nama_teknisi');
        $noInvoiceBerikut = $this->buatNoInvoice(now());

        return view('closing.index', compact(
            'closing', 'totalTransaksi', 'totalOmset', 'totalLunas',
            'tiketSiap', 'teknisi', 'noInvoiceBerikut'
        ));
    }

    public function store(Request $request)
    {
        $request->validate(array_merge([
            'servis_id'   => 'required|exists:tr_servis,id_servis',
            'tgl_closing' => 'required|date|before_or_equal:today',
        ], $this->aturanUmum()), $this->pesan());

        $servis = Servis::findOrFail($request->servis_id);

        if ($servis->no_invoice) {
            return back()->withErrors(['servis_id' => "Tiket {$servis->no_tiket} sudah memiliki invoice."])->withInput();
        }

        if (!in_array($servis->status, self::STATUS_SIAP)) {
            return back()->withErrors(['servis_id' => "Tiket {$servis->no_tiket} masih berstatus {$servis->status}. Closing hanya untuk tiket Proses Servis atau Selesai."])->withInput();
        }

        // Teknisi selalu mengikuti data registrasi tiket (tidak diambil dari input form)
        if (!$servis->id_teknisi) {
            return back()->withErrors(['servis_id' => "Tiket {$servis->no_tiket} belum memiliki teknisi. Lengkapi teknisi pada data tiket terlebih dahulu."])->withInput();
        }

        $tglClosing = Carbon::parse($request->tgl_closing)->startOfDay();

        if ($tglClosing->lt($servis->tanggal_masuk)) {
            return back()->withErrors(['tgl_closing' => 'Tanggal closing tidak boleh sebelum tanggal masuk servis (' . $servis->tanggal_masuk->format('d/m/Y') . ').'])->withInput();
        }

        [$jasa, $sparepart, $diskon, $total] = $this->hitung($request);

        if ($salah = $this->cekBiaya($request, $jasa, $sparepart, $diskon, $total)) {
            return back()->withErrors($salah)->withInput();
        }

        $servis = DB::transaction(function () use ($request, $servis, $tglClosing, $jasa, $sparepart, $diskon, $total) {
            $noInvoice  = $this->buatNoInvoice($tglClosing);
            $hari       = (int) $request->garansi;
            $statusLama = $servis->status;

            // id_teknisi tidak diubah: tetap teknisi bawaan tiket
            $servis->update(array_merge([
                'no_invoice'        => $noInvoice,
                'tanggal_closing'   => $tglClosing->toDateString(),
                'biaya_jasa'        => $jasa,
                'biaya_sparepart'   => $sparepart,
                'diskon'            => $diskon,
                'total_bayar'       => $total,
                'masa_garansi_hari' => $hari,
                'garansi_berakhir'  => $hari > 0 ? $tglClosing->copy()->addDays($hari)->toDateString() : null,
                'metode_pembayaran' => $request->metode_pembayaran,
                'catatan'           => $request->rincian_pengerjaan,
                'status'            => 'Selesai',
            ], $this->kolomPembayaran($request, null, $total, $tglClosing)));

            // Riwayat status (dipakai Laporan / Log Kronologis)
            DB::table('tr_riwayat_status')->insert([
                'id_servis'   => $servis->id_servis,
                'id_pengguna' => auth()->id(),
                'status_lama' => $statusLama,
                'status_baru' => 'Selesai',
                'catatan'     => 'Closing servis, invoice ' . $noInvoice,
                'created_at'  => now(),
            ]);

            // Jadwal Happy Call H+3 setelah closing (FR11)
            DB::table('tr_follow_up')->insert([
                'id_unit'        => $servis->id_unit,
                'id_servis'      => $servis->id_servis,
                'id_pengguna'    => null,
                'kategori'       => 'Happy Call',
                'tanggal_jadwal' => $tglClosing->copy()->addDays(3)->toDateString(),
                'status'         => 'Belum Dihubungi',
            ]);

            return $servis;
        });

        // Tombol "Simpan & Cetak Struk": langsung buka nota untuk dicetak
        if ($request->input('aksi') === 'cetak') {
            return redirect()->route('closing.cetak', ['id' => $servis->id_servis, 'auto' => 1])
                ->with('success', "Closing tiket {$servis->no_tiket} berhasil disimpan (invoice {$servis->no_invoice}).");
        }

        // Tombol "Simpan Saja": kembali ke daftar, nota bisa dicetak nanti
        return redirect()->route('closing.index')
            ->with('success', "Closing tiket {$servis->no_tiket} berhasil disimpan (invoice {$servis->no_invoice}). Nota bisa dicetak kapan saja lewat tombol Cetak.");
    }

    public function update(Request $request, $id)
    {
        $servis = Servis::whereNotNull('no_invoice')->findOrFail($id);

        $request->validate($this->aturanUmum(), $this->pesan());

        [$jasa, $sparepart, $diskon, $total] = $this->hitung($request);

        if ($salah = $this->cekBiaya($request, $jasa, $sparepart, $diskon, $total)) {
            return back()->withErrors($salah)->withInput();
        }

        DB::transaction(function () use ($request, $servis, $jasa, $sparepart, $diskon, $total) {
            $hari = (int) $request->garansi;

            // id_teknisi tidak diubah: tetap teknisi bawaan tiket
            $servis->update(array_merge([
                'biaya_jasa'        => $jasa,
                'biaya_sparepart'   => $sparepart,
                'diskon'            => $diskon,
                'total_bayar'       => $total,
                'masa_garansi_hari' => $hari,
                'garansi_berakhir'  => $hari > 0 ? $servis->tanggal_closing->copy()->addDays($hari)->toDateString() : null,
                'metode_pembayaran' => $request->metode_pembayaran,
                'catatan'           => $request->rincian_pengerjaan,
            ], $this->kolomPembayaran($request, $servis, $total, now())));
        });

        return redirect()->route('closing.index')
            ->with('success', "Invoice {$servis->no_invoice} berhasil diperbarui.");
    }

    // Menghapus = membatalkan closing: data invoice dikosongkan, tiket kembali ke Proses Servis
    public function destroy($id)
    {
        $servis = Servis::whereNotNull('no_invoice')->findOrFail($id);

        $sudahDihubungi = DB::table('tr_follow_up')
            ->where('id_servis', $servis->id_servis)
            ->where('kategori', 'Happy Call')
            ->where('status', '!=', 'Belum Dihubungi')
            ->exists();

        if ($sudahDihubungi) {
            return redirect()->route('closing.index')
                ->with('error', "Closing {$servis->no_invoice} tidak bisa dibatalkan karena Happy Call-nya sudah dihubungi.");
        }

        $noInvoice = $servis->no_invoice;

        DB::transaction(function () use ($servis, $noInvoice) {
            DB::table('tr_follow_up')
                ->where('id_servis', $servis->id_servis)
                ->where('kategori', 'Happy Call')
                ->where('status', 'Belum Dihubungi')
                ->delete();

            $servis->update([
                'no_invoice'        => null,
                'tanggal_closing'   => null,
                'biaya_jasa'        => 0,
                'jumlah_dp'         => 0,
                'biaya_sparepart'   => 0,
                'diskon'            => 0,
                'total_bayar'       => 0,
                'masa_garansi_hari' => 0,
                'garansi_berakhir'  => null,
                'status_pembayaran' => 'Belum Lunas',
                'tanggal_dp'        => null,
                'tanggal_pelunasan' => null,
                'jumlah_pelunasan'  => null,
                'metode_pembayaran' => null,
                'catatan'           => null,
                'status'            => 'Proses Servis',
            ]);

            DB::table('tr_riwayat_status')->insert([
                'id_servis'   => $servis->id_servis,
                'id_pengguna' => auth()->id(),
                'status_lama' => 'Selesai',
                'status_baru' => 'Proses Servis',
                'catatan'     => 'Closing dibatalkan, invoice ' . $noInvoice,
                'created_at'  => now(),
            ]);
        });

        return redirect()->route('closing.index')
            ->with('success', "Closing {$noInvoice} dibatalkan. Tiket {$servis->no_tiket} kembali ke Proses Servis.");
    }

    public function cetak(Request $request, $id)
    {
        $s    = Servis::with(['unit.konsumen', 'teknisi'])->whereNotNull('no_invoice')->findOrFail($id);
        $auto = $request->boolean('auto');

        return view('closing.cetak', compact('s', 'auto'));
    }

    // ---------------------------------------------------------------------

    private function buatNoInvoice(Carbon $tanggal): string
    {
        $prefix = 'INV-' . $tanggal->format('Ym') . '-';

        $terakhir = Servis::where('no_invoice', 'like', $prefix . '%')
            ->orderByRaw('CAST(SUBSTRING(no_invoice, ?) AS UNSIGNED) DESC', [strlen($prefix) + 1])
            ->value('no_invoice');

        $urut = $terakhir ? ((int) substr($terakhir, strlen($prefix))) + 1 : 1;

        return $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);
    }

    private function hitung(Request $r): array
    {
        $jasa      = (int) $r->biaya_jasa;
        $sparepart = (int) $r->biaya_sparepart;
        $diskon    = (int) $r->diskon;

        return [$jasa, $sparepart, $diskon, $jasa + $sparepart - $diskon];
    }

    private function cekBiaya(Request $r, int $jasa, int $sparepart, int $diskon, int $total): ?array
    {
        if ($diskon > $jasa + $sparepart) {
            return ['diskon' => 'Diskon tidak boleh melebihi total biaya jasa dan sparepart.'];
        }

        if ($r->status_pembayaran === 'DP') {
            $dp = (int) $r->jumlah_dp;
            if ($dp < 1 || $dp >= $total) {
                return ['jumlah_dp' => 'Jumlah DP harus lebih dari 0 dan kurang dari total bayar (Rp ' . number_format($total, 0, ',', '.') . ').'];
            }
        }

        return null;
    }

    // Kolom pembayaran sesuai status: Belum Lunas / DP / Lunas
    private function kolomPembayaran(Request $r, ?Servis $s, int $total, Carbon $tglBayar): array
    {
        $status = $r->status_pembayaran;

        if ($status === 'Lunas') {
            $dp          = $s ? min((int) $s->jumlah_dp, $total) : 0;
            $sudahLunas  = $s && $s->status_pembayaran === 'Lunas' && $s->tanggal_pelunasan;

            return [
                'status_pembayaran' => 'Lunas',
                'jumlah_dp'         => $dp,
                'tanggal_dp'        => ($dp > 0 && $s && $s->tanggal_dp) ? $s->tanggal_dp->toDateString() : null,
                'tanggal_pelunasan' => $sudahLunas ? $s->tanggal_pelunasan->toDateString() : $tglBayar->toDateString(),
                'jumlah_pelunasan'  => $total - $dp,
            ];
        }

        if ($status === 'DP') {
            $sudahDp = $s && $s->status_pembayaran === 'DP' && $s->tanggal_dp;

            return [
                'status_pembayaran' => 'DP',
                'jumlah_dp'         => (int) $r->jumlah_dp,
                'tanggal_dp'        => $sudahDp ? $s->tanggal_dp->toDateString() : $tglBayar->toDateString(),
                'tanggal_pelunasan' => null,
                'jumlah_pelunasan'  => null,
            ];
        }

        return [
            'status_pembayaran' => 'Belum Lunas',
            'jumlah_dp'         => 0,
            'tanggal_dp'        => null,
            'tanggal_pelunasan' => null,
            'jumlah_pelunasan'  => null,
        ];
    }

    private function aturanUmum(): array
    {
        return [
            'rincian_pengerjaan' => 'required|string|max:2000',
            'biaya_jasa'         => 'required|integer|min:0|max:999999999',
            'biaya_sparepart'    => 'nullable|integer|min:0|max:999999999',
            'diskon'             => 'nullable|integer|min:0|max:999999999',
            'metode_pembayaran'  => 'required|in:' . implode(',', self::METODE),
            'garansi'            => 'required|in:' . implode(',', self::GARANSI),
            'status_pembayaran'  => 'required|in:' . implode(',', self::STATUS_BAYAR),
            'jumlah_dp'          => 'nullable|integer|min:1|required_if:status_pembayaran,DP',
        ];
    }

    private function pesan(): array
    {
        return [
            'servis_id.required'             => 'Tiket servis wajib dipilih.',
            'servis_id.exists'               => 'Tiket servis tidak ditemukan.',
            'tgl_closing.required'           => 'Tanggal closing wajib diisi.',
            'tgl_closing.date'               => 'Format tanggal closing tidak valid.',
            'tgl_closing.before_or_equal'    => 'Tanggal closing tidak boleh melebihi hari ini.',
            'rincian_pengerjaan.required'    => 'Rincian tindakan / sparepart wajib diisi.',
            'rincian_pengerjaan.max'         => 'Rincian maksimal 2000 karakter.',
            'biaya_jasa.required'            => 'Biaya jasa wajib diisi.',
            'biaya_jasa.integer'             => 'Biaya jasa harus berupa angka bulat.',
            'biaya_jasa.min'                 => 'Biaya jasa tidak boleh negatif.',
            'biaya_sparepart.integer'        => 'Biaya sparepart harus berupa angka bulat.',
            'biaya_sparepart.min'            => 'Biaya sparepart tidak boleh negatif.',
            'diskon.integer'                 => 'Diskon harus berupa angka bulat.',
            'diskon.min'                     => 'Diskon tidak boleh negatif.',
            'metode_pembayaran.required'     => 'Metode pembayaran wajib dipilih.',
            'metode_pembayaran.in'           => 'Metode pembayaran tidak valid.',
            'garansi.required'               => 'Masa garansi wajib dipilih.',
            'garansi.in'                     => 'Masa garansi tidak valid.',
            'status_pembayaran.required'     => 'Status pembayaran wajib dipilih.',
            'status_pembayaran.in'           => 'Status pembayaran tidak valid.',
            'jumlah_dp.required_if'          => 'Jumlah DP wajib diisi jika status pembayaran DP.',
            'jumlah_dp.integer'              => 'Jumlah DP harus berupa angka bulat.',
            'jumlah_dp.min'                  => 'Jumlah DP minimal Rp 1.',
        ];
    }
}