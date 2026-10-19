<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use App\Models\Servis;
use App\Models\Teknisi;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrasiController extends Controller
{
    private const STATUS_AWAL = ['Menunggu Konfirmasi', 'Sedang Dicek', 'Proses Servis'];
    private const STATUS_SEMUA = ['Menunggu Konfirmasi', 'Sedang Dicek', 'Proses Servis', 'Selesai'];
    private const KELENGKAPAN = ['Unit Utama', 'Remote AC/TV', 'Kabel Power', 'Adaptor'];

    public function index(Request $request)
    {
        // Tiket terbaru di atas, tiket pertama (nomor 1) di paling bawah
        $query = Servis::with(['unit.konsumen', 'teknisi'])
            ->orderByDesc('id_servis');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $kata = trim($request->search);
            $query->where(function ($q) use ($kata) {
                $q->where('no_tiket', 'like', "%{$kata}%")
                  ->orWhereHas('teknisi', fn ($t) => $t->where('nama_teknisi', 'like', "%{$kata}%"))
                  ->orWhereHas('unit', function ($u) use ($kata) {
                      $u->where('merek', 'like', "%{$kata}%")
                        ->orWhere('jenis_unit', 'like', "%{$kata}%")
                        ->orWhere('tipe_model', 'like', "%{$kata}%")
                        ->orWhereHas('konsumen', fn ($k) => $k->where('nama', 'like', "%{$kata}%")
                            ->orWhere('no_whatsapp', 'like', "%{$kata}%"));
                  });
            });
        }

        $tiket = $query->get();

        // Kartu statistik: dihitung dari seluruh data (tidak terpengaruh filter)
        $tiketAktif   = Servis::where('status', '!=', 'Selesai')->count();
        $tiketProses  = Servis::whereIn('status', ['Sedang Dicek', 'Proses Servis'])->count();
        $tiketSelesai = Servis::where('status', 'Selesai')->count();

        $konsumen       = Konsumen::with('unit')->orderBy('nama')->get();
        $teknisi        = Teknisi::orderBy('nama_teknisi')->pluck('nama_teknisi');
        $noTiketBerikut = $this->buatNoTiket();

        return view('registrasi.index', compact(
            'tiket', 'tiketAktif', 'tiketProses', 'tiketSelesai',
            'konsumen', 'teknisi', 'noTiketBerikut'
        ));
    }

    public function store(Request $request)
    {
        $request->validate(array_merge([
            'konsumen_id' => 'required|exists:ms_konsumen,id_konsumen',
            'unit_id'     => 'required|exists:ms_unit,id_unit',
            'status'      => 'required|in:' . implode(',', self::STATUS_AWAL),
        ], $this->aturanUmum()), $this->pesan());

        // Unit harus milik konsumen yang dipilih
        $unitSah = Unit::where('id_unit', $request->unit_id)
            ->where('id_konsumen', $request->konsumen_id)
            ->exists();

        if (!$unitSah) {
            return back()->withErrors(['unit_id' => 'Unit yang dipilih bukan milik konsumen tersebut.'])
                ->withInput()->with('_modal', 'tambah');
        }

        // Satu unit tidak boleh punya dua tiket aktif sekaligus
        $adaTiketAktif = Servis::where('id_unit', $request->unit_id)->where('status', '!=', 'Selesai')->exists();

        if ($adaTiketAktif) {
            return back()->withErrors(['unit_id' => 'Unit ini masih memiliki tiket servis yang belum selesai.'])
                ->withInput()->with('_modal', 'tambah');
        }

        $noTiket = null;

        DB::transaction(function () use ($request, &$noTiket) {
            $teknisi = Teknisi::firstOrCreate(['nama_teknisi' => trim($request->teknisi)]);
            $noTiket = $this->buatNoTiket();

            $servis = Servis::create([
                'id_unit'                  => $request->unit_id,
                'id_teknisi'               => $teknisi->id_teknisi,
                'no_tiket'                 => $noTiket,
                'tanggal_masuk'            => $request->tgl_masuk,
                'tanggal_estimasi_selesai' => $request->perkiraan_selesai,
                'keluhan'                  => $request->keluhan,
                'kelengkapan'              => $this->gabungKelengkapan($request),
                'status'                   => $request->status,
            ]);

            DB::table('tr_riwayat_status')->insert([
                'id_servis'   => $servis->id_servis,
                'id_pengguna' => auth()->id(),
                'status_lama' => null,
                'status_baru' => $servis->status,
                'catatan'     => 'Tiket registrasi dibuat',
                'created_at'  => now(),
            ]);
        });

        return redirect()->route('registrasi-servis.index')
            ->with('success', "Tiket {$noTiket} berhasil didaftarkan.");
    }

    public function update(Request $request, $id)
    {
        $servis = Servis::findOrFail($id);

        if ($servis->no_invoice) {
            return redirect()->route('registrasi-servis.index')
                ->with('error', "Tiket {$servis->no_tiket} sudah di-closing (invoice {$servis->no_invoice}) dan tidak bisa diubah dari halaman ini.");
        }

        $request->validate(array_merge([
            'status' => 'required|in:' . implode(',', self::STATUS_SEMUA),
        ], $this->aturanUmum()), $this->pesan());

        DB::transaction(function () use ($request, $servis) {
            $teknisi    = Teknisi::firstOrCreate(['nama_teknisi' => trim($request->teknisi)]);
            $statusLama = $servis->status;

            $servis->update([
                'id_teknisi'               => $teknisi->id_teknisi,
                'tanggal_masuk'            => $request->tgl_masuk,
                'tanggal_estimasi_selesai' => $request->perkiraan_selesai,
                'keluhan'                  => $request->keluhan,
                'kelengkapan'              => $this->gabungKelengkapan($request),
                'status'                   => $request->status,
            ]);

            if ($statusLama !== $request->status) {
                DB::table('tr_riwayat_status')->insert([
                    'id_servis'   => $servis->id_servis,
                    'id_pengguna' => auth()->id(),
                    'status_lama' => $statusLama,
                    'status_baru' => $request->status,
                    'catatan'     => 'Status diperbarui dari Registrasi Servis',
                    'created_at'  => now(),
                ]);
            }
        });

        return redirect()->route('registrasi-servis.index')
            ->with('success', "Tiket {$servis->no_tiket} berhasil diperbarui.");
    }

    /**
     * Cetak tanda terima unit / SPK (tanpa biaya; nota invoice dicetak dari halaman Closing)
     */
    public function cetak($id)
    {
        $s = Servis::with(['unit.konsumen', 'teknisi'])->findOrFail($id);

        return view('registrasi.cetak', compact('s'));
    }

    public function destroy($id)
    {
        $servis = Servis::findOrFail($id);

        if ($servis->no_invoice || $servis->status === 'Selesai') {
            return redirect()->route('registrasi-servis.index')
                ->with('error', "Tiket {$servis->no_tiket} sudah selesai/di-closing sehingga tidak bisa dihapus.");
        }

        if (DB::table('tr_follow_up')->where('id_servis', $servis->id_servis)->exists()) {
            return redirect()->route('registrasi-servis.index')
                ->with('error', "Tiket {$servis->no_tiket} tidak bisa dihapus karena sudah memiliki data follow-up.");
        }

        DB::transaction(function () use ($servis) {
            DB::table('tr_riwayat_status')->where('id_servis', $servis->id_servis)->delete();
            $servis->delete(); // tr_servis_detail ikut terhapus (cascade)
        });

        return redirect()->route('registrasi-servis.index')
            ->with('success', "Tiket {$servis->no_tiket} berhasil dihapus.");
    }

    // ---------------------------------------------------------------------

    private function buatNoTiket(): string
    {
        $prefix = 'SRV-' . now()->format('Ym') . '-';

        $terakhir = Servis::where('no_tiket', 'like', $prefix . '%')
            ->orderByRaw('CAST(SUBSTRING(no_tiket, ?) AS UNSIGNED) DESC', [strlen($prefix) + 1])
            ->value('no_tiket');

        $urut = $terakhir ? ((int) substr($terakhir, strlen($prefix))) + 1 : 1;

        return $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);
    }

    private function gabungKelengkapan(Request $request): ?string
    {
        $pilihan = array_values(array_intersect(self::KELENGKAPAN, (array) $request->kelengkapan));

        return $pilihan ? implode(', ', $pilihan) : null; // maksimal 47 karakter, kolom varchar(50)
    }

    private function aturanUmum(): array
    {
        return [
            'tgl_masuk'         => 'required|date',
            'perkiraan_selesai' => 'nullable|date|after_or_equal:tgl_masuk',
            'keluhan'           => 'required|string|max:1000',
            'kelengkapan'       => 'nullable|array',
            'kelengkapan.*'     => 'in:' . implode(',', self::KELENGKAPAN),
            'teknisi'           => 'required|string|max:45',
        ];
    }

    private function pesan(): array
    {
        return [
            'konsumen_id.required'            => 'Konsumen wajib dipilih.',
            'konsumen_id.exists'              => 'Konsumen yang dipilih tidak ditemukan.',
            'unit_id.required'                => 'Unit servis wajib dipilih.',
            'unit_id.exists'                  => 'Unit yang dipilih tidak ditemukan.',
            'tgl_masuk.required'              => 'Tanggal masuk wajib diisi.',
            'tgl_masuk.date'                  => 'Format tanggal masuk tidak valid.',
            'perkiraan_selesai.date'          => 'Format perkiraan selesai tidak valid.',
            'perkiraan_selesai.after_or_equal'=> 'Perkiraan selesai tidak boleh sebelum tanggal masuk.',
            'keluhan.required'                => 'Keluhan utama wajib diisi.',
            'keluhan.max'                     => 'Keluhan maksimal 1000 karakter.',
            'teknisi.required'                => 'Nama teknisi wajib diisi.',
            'teknisi.max'                     => 'Nama teknisi maksimal 45 karakter.',
            'status.required'                 => 'Status servis wajib dipilih.',
            'status.in'                       => 'Status servis tidak valid.',
        ];
    }
}