<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CRM Jawaratech</title>
    
    <!-- 1. Google Font 'Inter' -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome Icon -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    <!-- SB Admin CSS via CDN Resmi -->
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin@7.0.7/dist/css/styles.css" rel="stylesheet" />

<style>
    /* 1. Import Font Inter dari Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    /* 2. Paksa seluruh halaman menggunakan Inter */
    html, body, *, 
    h1, h2, h3, h4, h5, h6, 
    p, span, div, input, button, select, textarea,
    table, th, td, .badge {
        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
    }

    /* 3. Styling khusus Header Tabel agar persis seperti di gambar */
    table th, .table th {
        font-family: 'Inter', sans-serif !important;
        font-weight: 700 !important;
        letter-spacing: 0.5px !important; /* Efek huruf agak renggang seperti di gambar */
        text-transform: uppercase;
    }

    /* 4. Styling isi tabel & elemen kartu kecil */
    table td, .table td {
        font-family: 'Inter', sans-serif !important;
    }
</style>

<style>
    /* 1. Reset & Styling Dropdown Pop-up Navbar */
    .navbar .dropdown-menu {
        background-color: #0f172a !important; /* Background Navy Gelap */
        border: 1px solid #334155 !important;  /* Border Pinggiran Gelap Tegas */
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6), 0 8px 10px -6px rgba(0, 0, 0, 0.5) !important;
        border-radius: 12px !important;
        padding: 0 !important;
        min-width: 320px;                      /* Ukuran ideal pop-up notifikasi */
        outline: none !important;              /* Menghilangkan garis/outline ganda */
    }

    /* 2. Menghilangkan Garis Pembatas (Divider) Bawaan Bootstrap yang Menyebabkan "Garis 2" */
    .navbar .dropdown-menu .dropdown-divider {
        border: none !important;
        border-top: 1px solid #1e293b !important; /* Garis tipis halus saja */
        margin: 0 !important;
        opacity: 1 !important;
    }

    /* 3. Header & Footer Pop-up Notifikasi */
    .navbar .dropdown-header {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 10px 15px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        border-bottom: 1px solid #334155 !important;
    }

    /* 4. Item Notifikasi & Efek Hover */
    .navbar .dropdown-menu .dropdown-item {
        color: #f8fafc !important;
        padding: 12px 15px !important;
        white-space: normal !important;        /* Agar teks tidak terpotong */
        border-bottom: 1px solid rgba(51, 65, 85, 0.4) !important; /* Hilangkan border ganda */
        transition: background-color 0.2s ease;
    }

    .navbar .dropdown-menu .dropdown-item:last-child {
        border-bottom: none !important;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .navbar .dropdown-menu .dropdown-item:hover,
    .navbar .dropdown-menu .dropdown-item:focus {
        background-color: #1e293b !important; /* Highlight saat kursor diatasnya */
    }

    /* 5. Styling Badge Lonceng Notifikasi di Navbar */
    .nav-link .badge-notif {
        position: absolute;
        top: 6px;
        right: 4px;
        font-size: 0.65rem;
        padding: 0.25em 0.45em;
    }

    /* 6. Animasi untuk Floating Bubble Notifikasi */
    @keyframes slideInUp {
        from { transform: translateY(100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-up {
        animation: slideInUp 0.5s ease-out forwards;
    }
</style>
</head>
<body class="sb-nav-fixed">
    <!-- Navbar Atas -->
    @include('layouts.navbar')

    <div id="layoutSidenav">
        <!-- Sidebar Kiri -->
        <div id="layoutSidenav_nav">
            @include('layouts.sidebar')
        </div>

        <!-- Konten Utama -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 pt-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- JS Bootstrap & SB Admin via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin@7.0.7/dist/js/scripts.js"></script>
<!-- ================================================================= -->
    <!-- FITUR NOTIFIKASI AUDIO & FLOATING COMIC BUBBLE POP-UP (ANTI BERISIK) -->
    <!-- ================================================================= -->
    @php
        $globalNotifCount = 0;
        $todayNotifCount = 0;
        try {
            // Ambil semua data yang masih 'Belum Dihubungi'
            $notifData = \Illuminate\Support\Facades\DB::table('tr_follow_up')
                            ->where('status', 'Belum Dihubungi')
                            ->get();
            $globalNotifCount = $notifData->count();
            
            // Hitung secara spesifik: berapa yang jatuh temponya HARI INI atau SUDAH LEWAT
            $todayNotifCount = $notifData->filter(function($item) {
                return \Carbon\Carbon::parse($item->tanggal_jadwal)->isPast() || \Carbon\Carbon::parse($item->tanggal_jadwal)->isToday();
            })->count();
            
        } catch (\Exception $e) {}
    @endphp

    @if($globalNotifCount > 0)
        <!-- Elemen Audio untuk Suara Lonceng/Ting -->
        <audio id="global-notif-sound" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>

        <!-- Container Bubble Melayang ala "Komik" di Pojok Kanan Bawah -->
        <div id="floating-notification-bubble" class="position-fixed bottom-0 end-0 m-4 animate-slide-up" style="z-index: 9999; display: none;">
            
            <!-- Kotak Teks Balon Komik -->
            <div class="p-3 rounded-4 position-relative shadow-lg text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border: 2px solid #38bdf8; max-width: 320px; cursor: pointer;" onclick="window.location.href='{{ route('schedules.index') ?? '#' }}'">
                
                <!-- Ekor Balon Komik (Segitiga mengarah ke bawah) -->
                <div style="position: absolute; bottom: -11px; right: 30px; width: 0; height: 0; border-left: 10px solid transparent; border-right: 10px solid transparent; border-top: 11px solid #38bdf8;"></div>
                <div style="position: absolute; bottom: -8px; right: 30px; width: 0; height: 0; border-left: 10px solid transparent; border-right: 10px solid transparent; border-top: 10px solid #1e293b;"></div>

                <div class="d-flex align-items-start gap-3">
                    <div class="bg-primary bg-opacity-25 text-primary p-2 rounded-circle d-flex align-items-center justify-content-center mt-1" style="width: 40px; height: 40px; flex-shrink: 0;">
                        <i class="fas fa-bullhorn fa-lg animate-bounce"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h6 class="fw-bold mb-0 text-info" style="font-size: 13px;">Halo Admin! 👋</h6>
                            <button type="button" class="btn-close btn-close-white" onclick="event.stopPropagation(); closeBubble();" aria-label="Close" style="font-size: 10px;"></button>
                        </div>
                        
                        <!-- Logika Teks Pengingat (Prioritas Hari Ini) -->
                        @if($todayNotifCount > 0)
                            <p class="small mb-0 text-light opacity-85" style="font-size: 12px;">Hari ini ada <strong>{{ $todayNotifCount }} jadwal penting</strong> yang harus segera diingatkan ke pelanggan!</p>
                            <span class="badge bg-danger mt-2 fw-bold" style="font-size: 9px;"><i class="fas fa-exclamation-triangle me-1"></i> WAJIB FOLLOW-UP HARI INI</span>
                        @else
                            <p class="small mb-0 text-light opacity-85" style="font-size: 12px;">Masih ada <strong>{{ $globalNotifCount }} pelanggan</strong> antrean mendatang yang belum dihubungi.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Ikon Avatar Pendukung (Bisa diganti logo Jawaratech) -->
            <div class="text-end mt-2 pe-3">
                <div class="bg-dark border border-info rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg" style="width: 40px; height: 40px;">
                    <i class="fas fa-robot text-info fa-lg"></i>
                </div>
            </div>

        </div>

  <!-- Script untuk Auto-Play Suara Cerdas & Tutup Bubble -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let currentTotalCount = {{ $globalNotifCount }};
                let currentTodayCount = {{ $todayNotifCount }};
                
                // Ganti localStorage jadi sessionStorage (memori sementara per sesi buka web)
                let lastTotalCount = sessionStorage.getItem('crm_notif_total');
                let lastTodayCount = sessionStorage.getItem('crm_notif_today');
                
                let bubble = document.getElementById('floating-notification-bubble');
                if (bubble) {
                    bubble.style.display = 'block';
                }

                // LOGIKA CERDAS: Bunyi jika baru buka tab web (null) ATAU ada notif baru masuk ATAU ada jadwal hari ini yang baru
                if (lastTotalCount === null || currentTotalCount > parseInt(lastTotalCount) || currentTodayCount > parseInt(lastTodayCount || 0)) {
                    
                    let audio = document.getElementById('global-notif-sound');
                    if (audio) {
                        // Coba mainkan suara
                        let playPromise = audio.play();
                        if (playPromise !== undefined) {
                            playPromise.catch(function(error) {
                                console.log("Info: Browser menahan suara sampai admin melakukan klik pertama di layar.");
                            });
                        }
                    }
                } 
                
                // Simpan data terbaru ke memori sementara
                sessionStorage.setItem('crm_notif_total', currentTotalCount);
                sessionStorage.setItem('crm_notif_today', currentTodayCount);
            });

            // Fungsi menutup bubble
            function closeBubble() {
                let bubble = document.getElementById('floating-notification-bubble');
                if (bubble) {
                    bubble.style.transition = "opacity 0.4s ease, transform 0.4s ease";
                    bubble.style.opacity = "0";
                    bubble.style.transform = "translateY(20px)";
                    setTimeout(() => bubble.remove(), 400);
                }
            }
        </script>
    @endif
</body>
</html>