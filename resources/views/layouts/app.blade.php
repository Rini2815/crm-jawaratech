<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'CRM Jawaratech')</title>

    <!-- Google Font 'Inter' (cukup dimuat sekali di sini, tanpa @import di CSS) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icon -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- SB Admin CSS via CDN Resmi -->
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin@7.0.7/dist/css/styles.css" rel="stylesheet" />

    <style>
        /* ===== Font Inter ===== */
        body, button, input, select, textarea, .table th, .table td, .badge {
            font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
        }

        /* Header tabel */
        table th, .table th {
            font-weight: 700 !important;
            letter-spacing: 0.5px !important;
            text-transform: uppercase;
        }

        /* ===== Dropdown pop-up navbar ===== */
        .navbar .dropdown-menu {
            background-color: #0f172a !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6), 0 8px 10px -6px rgba(0, 0, 0, 0.5) !important;
            border-radius: 12px !important;
            padding: 0 !important;
            min-width: 320px;
            outline: none !important;
        }

        .navbar .dropdown-menu .dropdown-divider {
            border: none !important;
            border-top: 1px solid #1e293b !important;
            margin: 0 !important;
            opacity: 1 !important;
        }

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

        .navbar .dropdown-menu .dropdown-item {
            color: #f8fafc !important;
            padding: 12px 15px !important;
            white-space: normal !important;
            border-bottom: 1px solid rgba(51, 65, 85, 0.4) !important;
            transition: background-color 0.2s ease;
        }

        .navbar .dropdown-menu .dropdown-item:last-child {
            border-bottom: none !important;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .navbar .dropdown-menu .dropdown-item:hover,
        .navbar .dropdown-menu .dropdown-item:focus {
            background-color: #1e293b !important;
        }

        /* Badge lonceng notifikasi */
        .nav-link .badge-notif {
            position: absolute;
            top: 6px;
            right: 4px;
            font-size: 0.65rem;
            padding: 0.25em 0.45em;
        }

        /* ===== Animasi bubble notifikasi ===== */
        @keyframes slideInUp {
            from { transform: translateY(100%); opacity: 0; }
            to   { transform: translateY(0); opacity: 1; }
        }
        .animate-slide-up { animation: slideInUp 0.5s ease-out forwards; }

        /* animate-bounce bukan class bawaan Bootstrap, jadi didefinisikan sendiri */
        @keyframes bubbleBounce {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-4px); }
        }
        .animate-bounce { animation: bubbleBounce 1s ease-in-out infinite; }

        /* ===== Toast alert melayang pojok kanan atas ===== */
        .alert-dismissible {
            position: fixed !important;
            top: 80px;
            right: 20px;
            z-index: 2000;
            width: 380px;
            max-width: calc(100vw - 40px);
            margin: 0 !important;
            padding: 14px 44px 14px 16px !important;
            border: none !important;
            border-radius: 10px !important;
            color: #ffffff !important;
            font-size: 0.875rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.35) !important;
            animation: toastMasuk 0.35s ease;
        }
        .alert-dismissible.alert-success { background: #16a34a !important; }
        .alert-dismissible.alert-danger  { background: #dc2626 !important; }
        .alert-dismissible ul { padding-left: 1.1rem; margin-bottom: 0; }

        /* Tombol x: tanpa kotak, tanpa border */
        .alert-dismissible .alert-close,
        .alert-dismissible .btn-close,
        .alert-dismissible .close,
        .alert-dismissible button {
            position: absolute !important;
            top: 10px !important;
            right: 14px !important;
            transform: none !important;
            width: auto !important;
            height: auto !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            outline: none !important;
            color: #ffffff !important;
            font-size: 1.4rem !important;
            line-height: 1 !important;
            opacity: 0.85;
            filter: none !important;
            cursor: pointer;
        }
        .alert-dismissible button:hover { opacity: 1; }

        @keyframes toastMasuk {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
    </style>

    @stack('styles')
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

    <!-- Toast alert: tutup manual atau hilang otomatis setelah 6 detik -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.alert-dismissible').forEach(function (a) {
                var tutup = function () {
                    a.style.transition = 'opacity .4s';
                    a.style.opacity = '0';
                    setTimeout(function () { a.remove(); }, 400);
                };
                var btn = a.querySelector('button');
                if (btn) btn.addEventListener('click', function (e) { e.preventDefault(); tutup(); });
                setTimeout(tutup, 6000);
            });
        });
    </script>

    <!-- ================================================================= -->
    <!-- NOTIFIKASI AUDIO & FLOATING BUBBLE POP-UP                         -->
    <!-- ================================================================= -->
    @php
        $globalNotifCount = 0;
        $todayNotifCount  = 0;
        try {
            $belumDihubungi = \Illuminate\Support\Facades\DB::table('tr_follow_up')
                                ->where('status', 'Belum Dihubungi');

            // Total antrean yang belum dihubungi (cukup COUNT, tidak perlu ambil semua baris)
            $globalNotifCount = (clone $belumDihubungi)->count();

            // Jadwal hari ini atau yang sudah lewat
            $todayNotifCount = (clone $belumDihubungi)
                                ->whereDate('tanggal_jadwal', '<=', now()->toDateString())
                                ->count();
        } catch (\Throwable $e) {}

        // route() akan error kalau nama route belum ada, jadi dicek dulu
        $schedulesUrl = \Illuminate\Support\Facades\Route::has('schedules.index')
                            ? route('schedules.index')
                            : '#';
    @endphp

    @if($globalNotifCount > 0)
        <!-- Suara notifikasi (pastikan file ada di public/sounds/notification.mp3) -->
        <audio id="global-notif-sound" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>

        <!-- Bubble melayang pojok kanan bawah -->
        <div id="floating-notification-bubble" class="position-fixed bottom-0 end-0 m-4 animate-slide-up" style="z-index: 9999; display: none;">

            <div class="p-3 rounded-4 position-relative shadow-lg text-white"
                 style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border: 2px solid #38bdf8; max-width: 320px; cursor: pointer;"
                 onclick="window.location.href='{{ $schedulesUrl }}'">

                <!-- Ekor balon -->
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

                        @if($todayNotifCount > 0)
                            <p class="small mb-0 text-light opacity-75" style="font-size: 12px;">
                                Hari ini ada <strong>{{ $todayNotifCount }} jadwal penting</strong> yang harus segera diingatkan ke pelanggan!
                            </p>
                            <span class="badge bg-danger mt-2 fw-bold" style="font-size: 9px;">
                                <i class="fas fa-exclamation-triangle me-1"></i> WAJIB FOLLOW-UP HARI INI
                            </span>
                        @else
                            <p class="small mb-0 text-light opacity-75" style="font-size: 12px;">
                                Masih ada <strong>{{ $globalNotifCount }} pelanggan</strong> antrean mendatang yang belum dihubungi.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Ikon avatar pendukung -->
            <div class="text-end mt-2 pe-3">
                <div class="bg-dark border border-info rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg" style="width: 40px; height: 40px;">
                    <i class="fas fa-robot text-info fa-lg"></i>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var currentTotalCount = {{ (int) $globalNotifCount }};
                var currentTodayCount = {{ (int) $todayNotifCount }};

                // sessionStorage: ingatan sementara selama tab dibuka
                var lastTotalCount = sessionStorage.getItem('crm_notif_total');
                var lastTodayCount = sessionStorage.getItem('crm_notif_today');

                var bubble = document.getElementById('floating-notification-bubble');
                if (bubble) bubble.style.display = 'block';

                // Bunyi jika: tab baru dibuka, ada notif baru, atau ada jadwal hari ini yang baru
                if (lastTotalCount === null
                    || currentTotalCount > parseInt(lastTotalCount, 10)
                    || currentTodayCount > parseInt(lastTodayCount || 0, 10)) {

                    var audio = document.getElementById('global-notif-sound');
                    if (audio) {
                        var playPromise = audio.play();
                        if (playPromise !== undefined) {
                            playPromise.catch(function () {
                                // Browser memblokir autoplay: bunyikan saat admin klik pertama kali
                                document.addEventListener('click', function () {
                                    audio.play().catch(function () {});
                                }, { once: true });
                            });
                        }
                    }
                }

                sessionStorage.setItem('crm_notif_total', currentTotalCount);
                sessionStorage.setItem('crm_notif_today', currentTodayCount);
            });

            function closeBubble() {
                var bubble = document.getElementById('floating-notification-bubble');
                if (bubble) {
                    bubble.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    bubble.style.opacity = '0';
                    bubble.style.transform = 'translateY(20px)';
                    setTimeout(function () { bubble.remove(); }, 400);
                }
            }
        </script>
    @endif

    @stack('scripts')
</body>
</html>