<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        // Menggunakan kolom asli dari database: 'tanggal_jadwal'
        $rawNotifs = DB::table('tr_follow_up')
            ->join('ms_unit', 'tr_follow_up.id_unit', '=', 'ms_unit.id_unit')
            ->join('ms_konsumen', 'ms_unit.id_konsumen', '=', 'ms_konsumen.id_konsumen')
            ->select(
                'tr_follow_up.*', 
                'ms_konsumen.nama as nama_pelanggan', 
                'ms_konsumen.no_whatsapp as no_hp', 
                'ms_unit.jenis_unit as nama_perangkat',
                'ms_unit.merek'
            )
            ->orderBy('tr_follow_up.tanggal_jadwal', 'asc') // Sudah pakai nama kolom yang benar
            ->get();

        $notifications = collect();
        $totalJatuhTempo = 0;

        foreach ($rawNotifs as $item) {
            $jenis = strtolower($item->nama_perangkat ?? '');
            $icon = 'fa-tools'; $icon_bg = 'bg-primary';

            if (str_contains($jenis, 'ac')) { $icon = 'fa-snowflake'; $icon_bg = 'bg-info'; } 
            elseif (str_contains($jenis, 'dispenser')) { $icon = 'fa-tint'; $icon_bg = 'bg-warning'; } 
            elseif (str_contains($jenis, 'cuci')) { $icon = 'fa-tshirt'; $icon_bg = 'bg-success'; } 
            elseif (str_contains($jenis, 'heater')) { $icon = 'fa-fire'; $icon_bg = 'bg-danger'; }

            // Parse tanggal dari kolom 'tanggal_jadwal'
            $tglTempo = Carbon::parse($item->tanggal_jadwal ?? now());
            $now = Carbon::now();
            
            if ($tglTempo->isPast()) {
                $status_minggu = 'Terlewat / Jatuh Tempo';
                $badge_color = 'bg-danger';
                $totalJatuhTempo++;
            } else {
                $selisihHari = $now->diffInDays($tglTempo, false);
                $status_minggu = 'Mendatang (' . round($selisihHari) . ' hari lagi)';
                $badge_color = 'bg-warning text-dark';
            }

            $pesanWa = "Halo {$item->nama_pelanggan}, kami dari Jawaratech ingin mengingatkan bahwa unit {$item->nama_perangkat} ({$item->merek}) sudah waktunya melakukan perawatan berkala.";
            $nomor_hp = $item->no_hp ?? '000';
            $waLink = "https://wa.me/" . preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $nomor_hp)) . "?text=" . urlencode($pesanWa);

            $notifications->push((object)[
                'nama_pelanggan' => $item->nama_pelanggan ?? 'Pelanggan',
                'no_hp' => $item->no_hp ?? '-',
                'nama_perangkat' => ($item->nama_perangkat ?? 'Unit') . ' (' . ($item->merek ?? '-') . ')',
                'jenis_notif' => $item->kategori ?? 'Perawatan Berkala',
                'tgl_jatuh_tempo' => $tglTempo->translatedFormat('d F Y'),
                'status_minggu' => $status_minggu,
                'badge_color' => $badge_color,
                'icon' => $icon,
                'icon_bg' => $icon_bg,
                'wa_link' => $waLink
            ]);
        }

        return view('notifications.index', compact('notifications', 'totalJatuhTempo'));
    }
}