<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KonsumenController extends Controller
{
    public function index()
    {
        // Konsumen terbaru di paling atas
        $konsumen = Konsumen::withCount('unit')->orderByDesc('id_konsumen')->get();

        $totalKonsumen = $konsumen->count();
        $totalUnit     = Unit::count();
        $unitGaransi   = Unit::where('status_garansi', 'Aktif')->count();

        return view('data-konsumen.index', compact('konsumen', 'totalKonsumen', 'totalUnit', 'unitGaransi'));
    }

    public function store(Request $request)
    {
        $request->merge(['no_wa' => preg_replace('/\D/', '', (string) $request->no_wa)]);

        $request->validate([
            'nama'   => 'required|string|max:45',
            'no_wa'  => 'required|digits_between:8,15|unique:ms_konsumen,no_whatsapp',
            'alamat' => 'required|string|max:100',
        ], $this->pesan());

        Konsumen::create([
            'nama'        => $request->nama,
            'no_whatsapp' => $request->no_wa,
            'alamat'      => $request->alamat,
        ]);

        return redirect()->route('data-konsumen')->with('success', 'Data konsumen berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $konsumen = Konsumen::findOrFail($id);

        $request->merge(['no_wa' => preg_replace('/\D/', '', (string) $request->no_wa)]);

        $request->validate([
            'nama'   => 'required|string|max:45',
            'no_wa'  => [
                'required', 'digits_between:8,15',
                Rule::unique('ms_konsumen', 'no_whatsapp')->ignore($konsumen->id_konsumen, 'id_konsumen'),
            ],
            'alamat' => 'required|string|max:100',
        ], $this->pesan());

        $konsumen->update([
            'nama'        => $request->nama,
            'no_whatsapp' => $request->no_wa,
            'alamat'      => $request->alamat,
        ]);

        return redirect()->route('data-konsumen')->with('success', 'Data konsumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $konsumen = Konsumen::withCount('unit')->findOrFail($id);

        // Relasi ke ms_unit tidak cascade, jadi tolak jika konsumen masih punya unit
        if ($konsumen->unit_count > 0) {
            return redirect()->route('data-konsumen')
                ->with('error', "Konsumen {$konsumen->nama} tidak bisa dihapus karena masih memiliki {$konsumen->unit_count} unit terdaftar.");
        }

        $konsumen->delete();

        return redirect()->route('data-konsumen')->with('success', 'Data konsumen berhasil dihapus.');
    }

    private function pesan(): array
    {
        return [
            'nama.required'          => 'Nama lengkap wajib diisi.',
            'nama.max'               => 'Nama maksimal 45 karakter.',
            'no_wa.required'         => 'Nomor WhatsApp wajib diisi.',
            'no_wa.digits_between'   => 'Nomor WhatsApp harus berupa angka 8 sampai 15 digit.',
            'no_wa.unique'           => 'Nomor WhatsApp sudah terdaftar pada konsumen lain.',
            'alamat.required'        => 'Alamat domisili wajib diisi.',
            'alamat.max'             => 'Alamat maksimal 100 karakter.',
        ];
    }
}