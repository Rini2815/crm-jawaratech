<nav class="sb-topnav navbar navbar-expand navbar-dark" style="background: linear-gradient(135deg, #12161f 0%, #0d1b2a 40%, #450a10 100%) !important; border-bottom: 4px solid #525363bc !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);">
    <!-- Logo & Brand di Pojok Kiri Atas -->
    <a class="navbar-brand ps-3 fw-bold d-flex align-items-center" href="{{ route('service-jobs.index') ?? '#' }}">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" style="width: 32px; height: 32px; object-fit: contain; background: #fff; border-radius: 4px; padding: 2px; margin-right: 10px;">
        <span>CRM Jawaratech</span>
    </a>
    
    <!-- Tombol Toggle Sidebar -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-white" id="sidebarToggle" href="#!"><i class="fas fa-bars fa-lg"></i></button>
    
    <!-- Spacer Pengisi Jarak -->
    <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
    
    <!-- Menu Navbar Kanan (Notifikasi & User Superadmin) -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 align-items-center">
        
        <!-- 1. ICON LONCENG NOTIFIKASI CRM (SUDAH DINAMIS) -->
        @php
            $notifList = \Illuminate\Support\Facades\DB::table('tr_follow_up')
                ->join('ms_unit', 'tr_follow_up.id_unit', '=', 'ms_unit.id_unit')
                ->join('ms_konsumen', 'ms_unit.id_konsumen', '=', 'ms_konsumen.id_konsumen')
                ->where('tr_follow_up.status', 'Belum Dihubungi')
                ->select('ms_konsumen.nama', 'ms_unit.jenis_unit', 'ms_unit.merek', 'tr_follow_up.tanggal_jadwal', 'ms_konsumen.no_whatsapp')
                ->orderBy('tr_follow_up.tanggal_jadwal', 'asc')
                ->take(4) // Tampilkan maksimal 4 notif terbaru di dropdown
                ->get();
                
            $globalNotifCount = \Illuminate\Support\Facades\DB::table('tr_follow_up')->where('status', 'Belum Dihubungi')->count();
        @endphp

        <li class="nav-item dropdown me-3 position-relative">
            <a class="nav-link text-white position-relative px-2" id="navbarDropdownNotif" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fa-lg"></i>
                <!-- Badge Jumlah Notifikasi Muncul Hanya Jika Ada Notif -->
                @if($globalNotifCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; padding: 0.25em 0.45em;">
                    {{ $globalNotifCount }}
                    <span class="visually-hidden">Notifikasi Perawatan</span>
                </span>
                @endif
            </a>

            <!-- Pop-up Dropdown Notifikasi -->
            <ul class="dropdown-menu dropdown-menu-end shadow-lg py-0" aria-labelledby="navbarDropdownNotif" style="background-color: #0f172a; border: 1px solid #334155; min-width: 330px; border-radius: 12px; overflow: hidden;">
                <!-- Header Pop-Up -->
                <li class="dropdown-header d-flex justify-content-between align-items-center py-2 px-3" style="background-color: #1e293b; color: #f8fafc; border-bottom: 1px solid #334155;">
                    <span class="fw-bold"><i class="fas fa-tools text-primary me-2"></i> Pengingat Perawatan</span>
                    <span class="badge bg-primary rounded-pill">{{ $globalNotifCount }} Pelanggan</span>
                </li>

                <!-- Isi Daftar Notifikasi Dinamis dari Database -->
                <div style="max-height: 300px; overflow-y: auto;">
                    @forelse($notifList as $notif)
                        @php
                            $jenis = strtolower($notif->jenis_unit ?? '');
                            $icon = 'fa-tools'; $icon_color = 'text-primary'; $bg_color = 'bg-primary';
                            if (str_contains($jenis, 'ac')) { $icon = 'fa-snowflake'; $icon_color = 'text-info'; $bg_color = 'bg-info'; } 
                            elseif (str_contains($jenis, 'dispenser')) { $icon = 'fa-tint'; $icon_color = 'text-warning'; $bg_color = 'bg-warning'; } 
                            elseif (str_contains($jenis, 'cuci')) { $icon = 'fa-tshirt'; $icon_color = 'text-success'; $bg_color = 'bg-success'; } 
                            elseif (str_contains($jenis, 'heater')) { $icon = 'fa-fire'; $icon_color = 'text-danger'; $bg_color = 'bg-danger'; }
                        @endphp
                        <li>
                            <a class="dropdown-item d-flex align-items-start gap-3 py-2 px-3 border-bottom border-secondary border-opacity-25" href="{{ route('schedules.index') ?? '#' }}" style="color: #f8fafc; white-space: normal;">
                                <div class="{{ $bg_color }} bg-opacity-25 {{ $icon_color }} p-2 rounded-circle mt-1">
                                    <i class="fas {{ $icon }} fa-fw"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <!-- Nama Asli dari Database -->
                                        <strong class="small text-white">{{ $notif->nama }}</strong>
                                        <span class="text-warning extra-small" style="font-size: 0.7rem;"><i class="fas fa-clock me-1"></i>Jatuh Tempo</span>
                                    </div>
                                    <p class="mb-1 small text-light opacity-75">Perawatan {{ $notif->jenis_unit }} - {{ $notif->merek }}</p>
                                    <div class="d-flex gap-2 mt-1">
                                        <button type="button" class="btn btn-sm btn-success py-0 px-2 rounded-pill" style="font-size: 0.75rem;" onclick="window.open('https://wa.me/{{ preg_replace('/[^0-9]/', '', $notif->no_whatsapp) }}', '_blank'); event.preventDefault();">
                                            <i class="fab fa-whatsapp me-1"></i> Chat
                                        </button>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li>
                            <div class="p-4 text-center text-muted small">
                                Belum ada pelanggan yang masuk jadwal perawatan.
                            </div>
                        </li>
                    @endforelse
                </div>

                <!-- Footer Pop-up -->
                <li style="border-top: 1px solid #334155;">
                    <a class="dropdown-item text-center fw-bold text-info py-2 small" href="{{ route('notifications.index') ?? '#' }}">
                        Lihat Semua Pengingat <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </li>

        <!-- 2. DROPDOWN USER (badge role) -->
        @php
            $nbRoleRaw = (string) (auth()->user()->role ?? '');
            $nbRoleLabel = $nbRoleRaw !== '' ? ucwords(str_replace(['_', '-'], ' ', $nbRoleRaw)) : 'Pengguna';
            $nbIsAdmin = str_contains(strtolower($nbRoleRaw), 'admin');
        @endphp
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nb-role-pill {{ $nbIsAdmin ? 'is-admin' : 'is-marketing' }}" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas {{ $nbIsAdmin ? 'fa-user-shield' : 'fa-bullhorn' }} me-1"></i> {{ $nbRoleLabel }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarDropdown" style="background: #0d1b2a; border-radius: 8px;">
                <li><a class="dropdown-item text-white py-2" href="{{ route('profile.edit') ?? '#' }}" style="transition: 0.2s;"><i class="fas fa-user me-2 text-info"></i> Profil Saya</a></li>
                <li><hr class="dropdown-divider my-1" style="border-color: rgba(255, 255, 255, 0.15);" /></li>
                <li>
                    <a class="dropdown-item text-white py-2" href="#" style="transition: 0.2s;" data-bs-toggle="modal" data-bs-target="#modalLogoutConfirm">
                        <i class="fas fa-sign-out-alt me-2 text-danger"></i> Keluar
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="modalLogoutConfirm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden" style="background-color: #0f172a; color: #fff;">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 60px; height: 60px; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35);">
                        <i class="fas fa-sign-out-alt fa-lg text-danger"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">Yakin ingin keluar?</h5>
                <p class="text-light opacity-75 small mb-4">
                    Anda akan keluar dari sesi CRM Jawaratech dan diarahkan kembali ke halaman login.
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-light rounded-pill px-4" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold" onclick="document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-1"></i> Ya, Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Badge role di pojok kanan atas */
    .nb-role-pill {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px !important;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.2px;
        transition: all 0.2s ease;
    }

    .nb-role-pill.is-admin {
        color: #fecaca !important;
        background: rgba(239, 68, 68, 0.22);
        border: 1px solid rgba(248, 113, 113, 0.55);
        box-shadow: 0 0 12px rgba(239, 68, 68, 0.25);
    }

    .nb-role-pill.is-marketing {
        color: #bae6fd !important;
        background: rgba(56, 189, 248, 0.2);
        border: 1px solid rgba(56, 189, 248, 0.55);
        box-shadow: 0 0 12px rgba(56, 189, 248, 0.25);
    }

    .nb-role-pill.is-admin:hover,
    .nb-role-pill.is-admin:focus,
    .nb-role-pill.is-admin.show {
        color: #ffffff !important;
        background: rgba(239, 68, 68, 0.38);
        box-shadow: 0 0 16px rgba(239, 68, 68, 0.45);
    }

    .nb-role-pill.is-marketing:hover,
    .nb-role-pill.is-marketing:focus,
    .nb-role-pill.is-marketing.show {
        color: #ffffff !important;
        background: rgba(56, 189, 248, 0.35);
        box-shadow: 0 0 16px rgba(56, 189, 248, 0.45);
    }
</style>