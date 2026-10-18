<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman utama Laporan & Riwayat Servis (Log Komprehensif)
     */
    public function index(Request $request)
    {
        $filterTanggal = $request->input('tanggal');
        $filterBulan = $request->input('bulan');
        $filterTahun = $request->input('tahun', date('Y'));

        // Statistik
        $totalKonsumen = DB::table('ms_konsumen')->count();
        $closingBulanIni = DB::table('tr_servis')->where('status', 'Selesai')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $garansiAktif = DB::table('ms_unit')->where('status_garansi', 'like', '%Aktif%')->count();
        
        $antreanPerawatan = 0;
        $followUpTerkirim = 0;
        try {
            $antreanPerawatan = DB::table('tr_follow_up')->where('status', 'Belum Dihubungi')->count();
            $followUpTerkirim = DB::table('tr_follow_up')->where('status', '!=', 'Belum Dihubungi')->count();
        } catch (\Exception $e) {}

        $totalUnitTahunIni = DB::table('tr_servis')->whereYear('created_at', date('Y'))->count();

        // Query Utama menggunakan kolom asli: tipe_model dan tanggal_masuk
        $query = DB::table('tr_servis')
            ->join('ms_unit', 'tr_servis.id_unit', '=', 'ms_unit.id_unit')
            ->join('ms_konsumen', 'ms_unit.id_konsumen', '=', 'ms_konsumen.id_konsumen')
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
                'ms_konsumen.alamat'
            )
            ->orderBy('tr_servis.created_at', 'desc');

        if (!empty($filterTanggal)) {
            $query->whereDate('tr_servis.created_at', $filterTanggal);
        }
        if (!empty($filterBulan)) {
            $query->whereMonth('tr_servis.created_at', $filterBulan);
        }
        if (!empty($filterTahun)) {
            $query->whereYear('tr_servis.created_at', $filterTahun);
        }

        $riwayatServis = $query->paginate(10)->appends($request->all());

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

        if ($id_konsumen) {
            $konsumen = DB::table('ms_konsumen')->where('id_konsumen', $id_konsumen)->first();
            
            $riwayatServis = DB::table('tr_servis')
                ->join('ms_unit', 'tr_servis.id_unit', '=', 'ms_unit.id_unit')
                ->join('ms_konsumen', 'ms_unit.id_konsumen', '=', 'ms_konsumen.id_konsumen')
                ->where('ms_konsumen.id_konsumen', $id_konsumen)
                ->select(
                    'tr_servis.*', 
                    'ms_unit.jenis_unit', 
                    'ms_unit.merek', 
                    'ms_unit.tipe_model',
                    'ms_unit.tanggal_masuk',
                    'ms_unit.status_garansi'
                )
                ->orderBy('tr_servis.created_at', 'desc')
                ->get();
        } else {
            $konsumen = null;
            
            $riwayatServis = DB::table('tr_servis')
                ->join('ms_unit', 'tr_servis.id_unit', '=', 'ms_unit.id_unit')
                ->join('ms_konsumen', 'ms_unit.id_konsumen', '=', 'ms_konsumen.id_konsumen')
                ->select(
                    'tr_servis.*', 
                    'ms_unit.jenis_unit', 
                    'ms_unit.merek', 
                    'ms_unit.tipe_model',
                    'ms_unit.tanggal_masuk',
                    'ms_unit.status_garansi',
                    'ms_konsumen.nama',
                    'ms_konsumen.no_whatsapp'
                )
                ->orderBy('tr_servis.created_at', 'desc')
                ->get();
        }

        return view('report.pdf', compact('konsumen', 'riwayatServis'));
    }

    public function exportExcel(Request $request)
    {
        return "Fitur Export Excel siap.";
    }
}