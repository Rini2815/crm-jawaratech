<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = now()->month;
        $tahunIni = now()->year;

        // 1. Angka untuk Kartu Statistik
        $totalKonsumen = DB::table('ms_konsumen')->count();
        $servisMasuk = DB::table('tr_servis')->count();
        $servisSelesai = DB::table('tr_servis')->where('status', 'Selesai')->count();
        $jadwalPerawatan = DB::table('tr_follow_up')->where('status', 'Belum Dihubungi')->count();

        // 2. Data Tabel Antrean (Relasi: tr_servis -> ms_unit -> ms_konsumen)
        $antreanTerbaru = DB::table('tr_servis')
            ->join('ms_unit', 'tr_servis.id_unit', '=', 'ms_unit.id_unit')
            ->join('ms_konsumen', 'ms_unit.id_konsumen', '=', 'ms_konsumen.id_konsumen')
            ->select('ms_konsumen.nama', 'ms_unit.jenis_unit', 'tr_servis.status')
            ->orderBy('tr_servis.created_at', 'desc')
            ->limit(5)
            ->get();

        // 3. Data Chart Bar (Kategori Unit Servis yang masuk) -> BULAN INI
        $dataUnitBulan = DB::table('tr_servis')
            ->join('ms_unit', 'tr_servis.id_unit', '=', 'ms_unit.id_unit')
            ->whereMonth('tr_servis.created_at', $bulanIni)
            ->whereYear('tr_servis.created_at', $tahunIni)
            ->select('ms_unit.jenis_unit', DB::raw('count(tr_servis.id_servis) as total'))
            ->groupBy('ms_unit.jenis_unit')
            ->pluck('total', 'jenis_unit')
            ->toArray();

        $chartKeluhan = [
            'AC' => $dataUnitBulan['AC'] ?? 0,
            'Mesin Cuci' => $dataUnitBulan['Mesin Cuci'] ?? 0,
            'Dispenser' => $dataUnitBulan['Dispenser'] ?? 0,
            'Water Heater' => $dataUnitBulan['Water Heater'] ?? 0,
        ];

        // 4. Data Chart Pie (Proporsi Status Servis)
        $statusSelesai = DB::table('tr_servis')->where('status', 'Selesai')->count();
        $statusPengecekan = DB::table('tr_servis')->whereIn('status', ['Sedang Dicek', 'Proses Servis'])->count();
        $statusMenunggu = DB::table('tr_servis')->where('status', 'Menunggu Konfirmasi')->count();

        // 5. Data List Pengingat Servis Berkala (Relasi: tr_follow_up -> ms_unit -> ms_konsumen)
        $listPengingat = DB::table('tr_follow_up')
            ->join('ms_unit', 'tr_follow_up.id_unit', '=', 'ms_unit.id_unit')
            ->join('ms_konsumen', 'ms_unit.id_konsumen', '=', 'ms_konsumen.id_konsumen')
            ->where('tr_follow_up.status', 'Belum Dihubungi')
            ->select('ms_konsumen.nama', 'ms_konsumen.no_whatsapp', 'ms_unit.jenis_unit', 'tr_follow_up.kategori')
            ->orderBy('tr_follow_up.tanggal_jadwal', 'asc')
            ->limit(3)
            ->get();

        // 6. Persentase Informasi Layanan -> TAHUN INI
        $dataUnitTahun = DB::table('tr_servis')
            ->join('ms_unit', 'tr_servis.id_unit', '=', 'ms_unit.id_unit')
            ->whereYear('tr_servis.created_at', $tahunIni)
            ->select('ms_unit.jenis_unit', DB::raw('count(tr_servis.id_servis) as total'))
            ->groupBy('ms_unit.jenis_unit')
            ->pluck('total', 'jenis_unit')
            ->toArray();

        $totalServisTahun = array_sum($dataUnitTahun);

        $hitungPersen = function ($jenis) use ($dataUnitTahun, $totalServisTahun) {
            return $totalServisTahun > 0
                ? round((($dataUnitTahun[$jenis] ?? 0) / $totalServisTahun) * 100)
                : 0;
        };

        $persenAC = $hitungPersen('AC');
        $persenMC = $hitungPersen('Mesin Cuci');
        $persenDS = $hitungPersen('Dispenser');
        $persenWH = $hitungPersen('Water Heater');

        // Menyiapkan raw data untuk ditampilkan di view (angka unit tahunan)
        $unitTahunan = [
            'AC' => $dataUnitTahun['AC'] ?? 0,
            'Mesin Cuci' => $dataUnitTahun['Mesin Cuci'] ?? 0,
            'Dispenser' => $dataUnitTahun['Dispenser'] ?? 0,
            'Water Heater' => $dataUnitTahun['Water Heater'] ?? 0,
        ];

        return view('service-jobs.dashboard', compact(
            'totalKonsumen',
            'servisMasuk',
            'servisSelesai',
            'jadwalPerawatan',
            'antreanTerbaru',
            'chartKeluhan',
            'statusSelesai',
            'statusPengecekan',
            'statusMenunggu',
            'listPengingat',
            'persenAC',
            'persenMC',
            'persenDS',
            'persenWH',
            'unitTahunan'
        ));
    }
}