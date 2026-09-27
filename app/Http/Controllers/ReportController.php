<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\ServiceJob; // Uncomment ini nanti jika model databasenya sudah kamu buat

class ReportController extends Controller
{
    /**
     * Menampilkan halaman utama Laporan & Riwayat Servis (Log Komprehensif)
     */
    public function index(Request $request)
    {
        // 1. Menangkap filter dari form (Hari, Bulan, Tahun)
        // Jika tidak ada input, default-nya akan mengambil tanggal dan tahun hari ini
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));

        // 2. Di sini nanti tempat menaruh logika query database (opsional)
        /*
        $query = ServiceJob::query();
        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }
        if ($tahun) {
            $query->whereYear('created_at', $tahun);
        }
        $reports = $query->get();
        */

        // 3. Me-return tampilan view (menggunakan 'report.index' tanpa 's' agar sinkron)
        return view('report.index', compact('tanggal', 'bulan', 'tahun'));
    }

    /**
     * Menampilkan halaman khusus Log Kronologis
     */
    public function kronologis(Request $request)
    {
        $keyword = $request->input('keyword');
        $status = $request->input('status');
        $bulan = $request->input('bulan', '09');

        return view('report.kronologis', compact('keyword', 'status', 'bulan'));
    }

    /**
     * Fungsi untuk Export Laporan Harian ke PDF
     */
    public function exportDailyPdf(Request $request)
    {
        $tanggal = $request->input('tanggal', date('Y-m-d'));

        // Nanti query datanya di sini:
        // $data = ServiceJob::whereDate('created_at', $tanggal)->get();

        // CATATAN: Untuk bisa membuat PDF, install library DomPDF (composer require barryvdh/laravel-dompdf)
        /*
        $pdf = \PDF::loadView('report.pdf_template', compact('data', 'tanggal'));
        return $pdf->download('Laporan_Harian_Jawaratech_' . $tanggal . '.pdf');
        */

        return "Fitur Export PDF untuk tanggal $tanggal sedang disiapkan. (Butuh install DomPDF)";
    }

    /**
     * Fungsi untuk Export Laporan Rekap ke Excel (Bulanan/Tahunan)
     */
    public function exportExcel(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', date('Y'));

        // CATATAN: Untuk bisa membuat Excel, install library Laravel Excel (composer require maatwebsite/excel)
        /*
        return \Excel::download(new \App\Exports\ReportExport($bulan, $tahun), 'Rekap_Laporan_Jawaratech_'.$tahun.'.xlsx');
        */

        $namaBulan = $bulan ? "Bulan ke-$bulan" : "Semua Bulan";
        return "Fitur Export Excel untuk $namaBulan Tahun $tahun sedang disiapkan. (Butuh install Laravel Excel)";
    }
}