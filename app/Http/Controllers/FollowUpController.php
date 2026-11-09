<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\Servis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowUpController extends Controller
{
    public function index(Request $request)
    {
        // Pastikan setiap tiket yang sudah closing punya agenda Happy Call (H+3)
        $this->sinkronHappyCall();

        // Pilihan urutan: terbaru (default), terlama, abjad (A-Z), abjad_desc (Z-A)
        $urut = $request->query('urut', 'terbaru');
        if (!in_array($urut, ['terbaru', 'terlama', 'abjad', 'abjad_desc'], true)) {
            $urut = 'terbaru';
        }

        $query = FollowUp::with(['unit.konsumen', 'servis'])
            ->where('kategori', 'Happy Call');

        if ($urut === 'terlama') {
            $query->orderBy('tanggal_jadwal')->orderBy('id_follow_up');
        } else {
            // terbaru (juga dipakai sebagai urutan dasar untuk pilihan abjad)
            $query->orderByDesc('tanggal_jadwal')->orderByDesc('id_follow_up');
        }

        $agenda = $query->get();

        $agenda->each(function ($f) {
            $konsumen = $f->unit->konsumen ?? null;

            $f->nama_konsumen = $konsumen->nama ?? '-';
            $f->no_wa         = $konsumen->no_whatsapp ?? '';
            $f->label_unit    = $this->labelUnit($f->unit);

            // Layanan diambil dari keluhan/permintaan servis, bukan dari catatan
            // yang berisi kelengkapan saat registrasi.
            $f->layanan = \Illuminate\Support\Str::limit($f->servis->keluhan ?? $f->servis->catatan ?? '-', 60);

            $tglServis = $f->servis
                ? Carbon::parse($f->servis->tanggal_closing ?? $f->servis->tanggal_masuk)->translatedFormat('j F Y')
                : null;

            $f->draft_wa = "Halo Bapak/Ibu {$f->nama_konsumen}, kami dari Jawaratech ingin mengonfirmasi hasil servis {$f->label_unit} Anda"
                . ($tglServis ? " pada tanggal {$tglServis}" : '')
                . '. Apakah unit sudah berfungsi dengan baik dan tidak ada kendala? Terima kasih.';

            $f->wa_nomor = FollowUp::nomorWa($f->no_wa);
            $f->wa_link  = FollowUp::linkWa($f->no_wa, $f->draft_wa);
        });

        // Urut abjad berdasarkan nama konsumen (nama berasal dari relasi, jadi diurutkan di sini)
        if ($urut === 'abjad') {
            $agenda = $agenda->sortBy(fn ($f) => mb_strtolower($f->nama_konsumen))->values();
        } elseif ($urut === 'abjad_desc') {
            $agenda = $agenda->sortByDesc(fn ($f) => mb_strtolower($f->nama_konsumen))->values();
        }

        $totalAgenda     = $agenda->count();
        $belumDihubungi  = $agenda->where('status', 'Belum Dihubungi')->count();
        $sudahDihubungi  = $agenda->where('status', 'Sudah Dihubungi')->count();
        $jadwalUlang     = $agenda->where('status', 'Perlu Jadwal Ulang')->count();

        return view('followup.index', compact(
            'agenda', 'totalAgenda', 'belumDihubungi', 'sudahDihubungi', 'jadwalUlang', 'urut'
        ));
    }

    public function update(Request $request, $id)
    {
        $f = FollowUp::findOrFail($id);

        $request->validate([
            'status'               => 'required|in:Belum Dihubungi,Sudah Dihubungi,Perlu Jadwal Ulang',
            'catatan'              => 'nullable|string|max:1000',
            'tanggal_jadwal_ulang' => 'required_if:status,Perlu Jadwal Ulang|nullable|date|after_or_equal:today',
        ], [
            'status.required'                      => 'Status follow-up wajib dipilih.',
            'status.in'                            => 'Status follow-up tidak valid.',
            'catatan.max'                          => 'Catatan maksimal 1000 karakter.',
            'tanggal_jadwal_ulang.required_if'     => 'Tanggal jadwal ulang wajib diisi jika status Perlu Jadwal Ulang.',
            'tanggal_jadwal_ulang.date'            => 'Format tanggal jadwal ulang tidak valid.',
            'tanggal_jadwal_ulang.after_or_equal'  => 'Tanggal jadwal ulang tidak boleh sebelum hari ini.',
        ]);

        $f->status               = $request->status;
        $f->catatan_hasil        = $request->catatan;
        $f->tanggal_jadwal_ulang = $request->status === 'Perlu Jadwal Ulang' ? $request->tanggal_jadwal_ulang : null;
        $f->id_pengguna          = auth()->id();

        if ($request->status === 'Belum Dihubungi') {
            $f->waktu_kontak = null;
        } elseif (!$f->waktu_kontak) {
            $f->waktu_kontak = now();
        }

        $f->save();

        return redirect()->route('followup.index')
            ->with('success', 'Hasil follow-up berhasil disimpan.');
    }

    /**
     * Dipanggil saat tombol Chat / "Buka WhatsApp dengan Draft Ini" diklik.
     * Hanya mengubah status jika masih "Belum Dihubungi"; status lain tidak ditimpa.
     */
    public function tandaiDihubungi($id)
    {
        $f = FollowUp::findOrFail($id);

        if ($f->status === 'Belum Dihubungi') {
            $f->status       = 'Sudah Dihubungi';
            $f->waktu_kontak = now();
            $f->id_pengguna  = auth()->id();
            $f->save();
        }

        return response()->json(['ok' => true]);
    }

    // ---------------------------------------------------------------------

    /**
     * Buat agenda Happy Call (H+3 setelah closing) untuk tiket Selesai yang belum punya agenda.
     * Aman dijalankan berulang: tiket yang sudah punya agenda dilewati.
     */
    private function sinkronHappyCall(): void
    {
        $belum = Servis::where('status', 'Selesai')
            ->whereNotNull('tanggal_closing')
            ->whereNotIn('id_servis', function ($q) {
                $q->select('id_servis')
                  ->from('tr_follow_up')
                  ->where('kategori', 'Happy Call')
                  ->whereNotNull('id_servis');
            })
            ->get(['id_servis', 'id_unit', 'tanggal_closing']);

        if ($belum->isEmpty()) {
            return;
        }

        $baris = $belum->map(fn ($s) => [
            'id_unit'        => $s->id_unit,
            'id_servis'      => $s->id_servis,
            'kategori'       => 'Happy Call',
            'tanggal_jadwal' => Carbon::parse($s->tanggal_closing)->addDays(3)->toDateString(),
            'status'         => 'Belum Dihubungi',
        ])->all();

        DB::table('tr_follow_up')->insert($baris);
    }

    private function labelUnit($u): string
    {
        if (!$u) {
            return '-';
        }

        return trim($u->jenis_unit . ' ' . $u->merek) . ($u->tipe_model ? ' (' . $u->tipe_model . ')' : '');
    }
}