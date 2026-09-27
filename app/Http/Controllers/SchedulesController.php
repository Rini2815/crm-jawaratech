<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    public function index(Request $request)
    {
        // Data Dummy untuk Cek Tampilan UI
        $schedules = collect([
            (object)[
                'id' => 1,
                'no_nota' => 'INV-202601001',
                'nama_pelanggan' => 'Budi Santoso',
                'no_hp' => '081234567890',
                'nama_perangkat' => 'AC Panasonic 1 PK',
                'kategori_perangkat' => 'AC',
                'updated_at' => '2026-06-27 10:00:00',
                'interval_perawatan' => '3 Bulan',
                'tgl_jatuh_tempo' => '27 Sep 2026',
                'status_minggu' => 'Minggu 1',
                'badge_color' => 'bg-warning text-dark',
                'wa_link' => 'https://wa.me/6281234567890?text=Halo%20Budi%20Santoso,%20jadwal%20perawatan%20berkala%20AC%20Anda%20sudah%20waktunya.'
            ],
            (object)[
                'id' => 2,
                'no_nota' => 'INV-202601002',
                'nama_pelanggan' => 'Siti Aminah',
                'no_hp' => '082198765432',
                'nama_perangkat' => 'Dispenser Modena',
                'kategori_perangkat' => 'Dispenser',
                'updated_at' => '2026-03-15 14:30:00',
                'interval_perawatan' => '6 Bulan',
                'tgl_jatuh_tempo' => '15 Sep 2026',
                'status_minggu' => 'Minggu 2',
                'badge_color' => 'bg-danger text-white',
                'wa_link' => 'https://wa.me/6282198765432?text=Halo%20Siti%20Aminah,%20jadwal%20perawatan%20berkala%20Dispenser%20Anda%20sudah%20waktunya.'
            ],
            (object)[
                'id' => 3,
                'no_nota' => 'INV-202509003',
                'nama_pelanggan' => 'Ahmad Dahlan',
                'no_hp' => '085712345678',
                'nama_perangkat' => 'Mesin Cuci Sharp Front Loading',
                'kategori_perangkat' => 'Mesin Cuci',
                'updated_at' => '2025-09-01 09:15:00',
                'interval_perawatan' => '1 Tahun',
                'tgl_jatuh_tempo' => '01 Sep 2026',
                'status_minggu' => 'Terlewat (>2 Wk)',
                'badge_color' => 'bg-dark text-white',
                'wa_link' => 'https://wa.me/6285712345678?text=Halo%20Ahmad%20Dahlan,%20jadwal%20perawatan%20berkala%20Mesin%20Cuci%20Anda%20sudah%20terlewat.'
            ],
            (object)[
                'id' => 4,
                'no_nota' => 'INV-202608004',
                'nama_pelanggan' => 'Eko Prasetyo',
                'no_hp' => '089611223344',
                'nama_perangkat' => 'AC Daikin 1.5 PK',
                'kategori_perangkat' => 'AC',
                'updated_at' => '2026-08-10 11:20:00',
                'interval_perawatan' => '3 Bulan',
                'tgl_jatuh_tempo' => '10 Nov 2026',
                'status_minggu' => 'Mendatang',
                'badge_color' => 'bg-secondary text-white',
                'wa_link' => 'https://wa.me/6289611223344?text=Halo%20Eko%20Prasetyo...'
            ],
        ]);

        // Ringkasan Angka Card Dummy
        $totalJatuhTempo = 3;
        $totalAc = 2;
        $totalDispenser = 1;
        $totalMesinCuci = 1;

        return view('schedules.index', compact('schedules', 'totalJatuhTempo', 'totalAc', 'totalDispenser', 'totalMesinCuci'));
    }
}