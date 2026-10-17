<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    public function index()
    {
        $unit     = Unit::with('konsumen')->orderByDesc('tanggal_masuk')->orderByDesc('id_unit')->get();
        $konsumen = Konsumen::orderBy('nama')->get();

        $totalUnit       = $unit->count();
        $unitAC          = $unit->where('jenis_unit', 'AC')->count();
        $unitDispenser   = $unit->where('jenis_unit', 'Dispenser')->count();
        $unitWaterHeater = $unit->where('jenis_unit', 'Water Heater')->count();
        $unitMesinCuci   = $unit->where('jenis_unit', 'Mesin Cuci')->count();

        return view('service-jobs.index', compact(
            'unit', 'konsumen', 'totalUnit', 'unitAC', 'unitDispenser', 'unitWaterHeater', 'unitMesinCuci'
        ));
    }

    public function create()
    {
        $konsumen = Konsumen::orderBy('nama')->get();

        return view('service-jobs.create', compact('konsumen'));
    }

    public function store(Request $request)
    {
        $request->validate(array_merge([
            'konsumen_id' => 'required|exists:ms_konsumen,id_konsumen',
        ], $this->aturan()), $this->pesan());

        Unit::create([
            'id_konsumen'    => $request->konsumen_id,
            'jenis_unit'     => $request->jenis_unit,
            'merek'          => $request->merek,
            'tipe_model'     => $request->tipe,
            'tanggal_masuk'  => $request->tgl_masuk,
            'interval_bulan' => $request->interval_bulan,
            'status_garansi' => $request->status_garansi,
        ]);

        return redirect()->route('service-jobs.index')->with('success', 'Data unit servis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $unit = Unit::with('konsumen')->findOrFail($id);

        return view('service-jobs.edit', compact('unit'));
    }

    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        $request->validate($this->aturan(), $this->pesan());

        // Pemilik unit tidak diubah (di form hanya tampil read-only)
        $unit->update([
            'jenis_unit'     => $request->jenis_unit,
            'merek'          => $request->merek,
            'tipe_model'     => $request->tipe,
            'tanggal_masuk'  => $request->tgl_masuk,
            'interval_bulan' => $request->interval_bulan,
            'status_garansi' => $request->status_garansi,
        ]);

        return redirect()->route('service-jobs.index')->with('success', 'Data unit servis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);

        // tr_servis & tr_follow_up mengacu ke ms_unit tanpa cascade
        $adaServis   = DB::table('tr_servis')->where('id_unit', $unit->id_unit)->exists();
        $adaFollowUp = DB::table('tr_follow_up')->where('id_unit', $unit->id_unit)->exists();

        if ($adaServis || $adaFollowUp) {
            return redirect()->route('service-jobs.index')
                ->with('error', 'Unit tidak bisa dihapus karena sudah memiliki riwayat servis atau follow-up.');
        }

        $unit->delete();

        return redirect()->route('service-jobs.index')->with('success', 'Data unit servis berhasil dihapus.');
    }

    private function aturan(): array
    {
        return [
            'jenis_unit'     => 'required|in:AC,Dispenser,Water Heater,Mesin Cuci',
            'merek'          => 'required|string|max:20',
            'tipe'           => 'required|string|max:45',
            'tgl_masuk'      => 'required|date',
            'interval_bulan' => 'required|integer|min:1|max:60',
            'status_garansi' => 'required|in:Aktif,Tidak Bergaransi',
        ];
    }

    private function pesan(): array
    {
        return [
            'konsumen_id.required'    => 'Pemilik unit wajib dipilih.',
            'konsumen_id.exists'      => 'Konsumen yang dipilih tidak ditemukan.',
            'jenis_unit.required'     => 'Jenis unit wajib dipilih.',
            'jenis_unit.in'           => 'Jenis unit tidak valid.',
            'merek.required'          => 'Merek unit wajib diisi.',
            'merek.max'               => 'Merek maksimal 20 karakter.',
            'tipe.required'           => 'Model / tipe wajib diisi.',
            'tipe.max'                => 'Model / tipe maksimal 45 karakter.',
            'tgl_masuk.required'      => 'Tanggal wajib diisi.',
            'tgl_masuk.date'          => 'Format tanggal tidak valid.',
            'interval_bulan.required' => 'Interval perawatan wajib diisi.',
            'interval_bulan.integer'  => 'Interval perawatan harus berupa angka bulat.',
            'interval_bulan.min'      => 'Interval perawatan minimal 1 bulan.',
            'interval_bulan.max'      => 'Interval perawatan maksimal 60 bulan.',
            'status_garansi.required' => 'Status garansi wajib dipilih.',
            'status_garansi.in'       => 'Status garansi tidak valid.',
        ];
    }
}