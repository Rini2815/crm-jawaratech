<?php

namespace App\Http\Controllers;

use App\Models\Teknisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TeknisiController extends Controller
{
    public function index()
    {
        $teknisi = Teknisi::orderBy('nama_teknisi')->get();

        // Jumlah servis per teknisi: total dan yang masih berjalan (belum Selesai)
        $statistik = DB::table('tr_servis')
            ->select(
                'id_teknisi',
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN status != 'Selesai' THEN 1 ELSE 0 END) as aktif")
            )
            ->groupBy('id_teknisi')
            ->get()
            ->keyBy('id_teknisi');

        $totalTeknisi    = $teknisi->count();
        $teknisiBertugas = $statistik->filter(fn ($s) => (int) $s->aktif > 0)->count();
        $totalServis     = (int) $statistik->sum('total');

        return view('data-teknisi.index', compact(
            'teknisi', 'statistik', 'totalTeknisi', 'teknisiBertugas', 'totalServis'
        ));
    }

    public function store(Request $request)
    {
        $request->merge(['nama_teknisi' => trim((string) $request->nama_teknisi)]);

        $request->validate([
            'nama_teknisi' => ['required', 'string', 'max:45', 'unique:ms_teknisi,nama_teknisi'],
        ], $this->pesan());

        Teknisi::create(['nama_teknisi' => $request->nama_teknisi]);

        return redirect()->route('data-teknisi.index')
            ->with('success', "Teknisi {$request->nama_teknisi} berhasil ditambahkan.");
    }

    public function update(Request $request, $id)
    {
        $teknisi = Teknisi::findOrFail($id);

        $request->merge(['nama_teknisi' => trim((string) $request->nama_teknisi)]);

        $request->validate([
            'nama_teknisi' => [
                'required', 'string', 'max:45',
                Rule::unique('ms_teknisi', 'nama_teknisi')->ignore($teknisi->id_teknisi, 'id_teknisi'),
            ],
        ], $this->pesan());

        $teknisi->update(['nama_teknisi' => $request->nama_teknisi]);

        return redirect()->route('data-teknisi.index')
            ->with('success', 'Data teknisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $teknisi = Teknisi::findOrFail($id);

        // Tiket servis merujuk ke teknisi tanpa cascade, jadi tolak jika sudah punya riwayat
        if (DB::table('tr_servis')->where('id_teknisi', $teknisi->id_teknisi)->exists()) {
            return redirect()->route('data-teknisi.index')
                ->with('error', "Teknisi {$teknisi->nama_teknisi} tidak bisa dihapus karena sudah memiliki riwayat servis.");
        }

        $nama = $teknisi->nama_teknisi;
        $teknisi->delete();

        return redirect()->route('data-teknisi.index')
            ->with('success', "Teknisi {$nama} berhasil dihapus.");
    }

    private function pesan(): array
    {
        return [
            'nama_teknisi.required' => 'Nama teknisi wajib diisi.',
            'nama_teknisi.max'      => 'Nama teknisi maksimal 45 karakter.',
            'nama_teknisi.unique'   => 'Nama teknisi tersebut sudah terdaftar.',
        ];
    }
}