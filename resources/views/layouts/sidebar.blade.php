@php
    // ===== Penentuan menu yang tampil (kunci sama dengan matriks Hak Akses) =====
    $sbU = auth()->user();
    $sbIsAdmin = str_contains(strtolower((string) ($sbU->role ?? '')), 'admin');

    $canKonsumen = $sbIsAdmin || $sbU->hasMenu('data-konsumen');
    $canUnit     = $sbIsAdmin || $sbU->hasMenu('data-unit');
    $canTeknisi  = $sbIsAdmin || $sbU->hasMenu('data-teknisi');
    $canRegis    = $sbIsAdmin || $sbU->hasMenu('registrasi-servis');
    $canClosing  = $sbIsAdmin || $sbU->hasMenu('closing');
    $canPengingat= $sbIsAdmin || $sbU->hasMenu('pengingat-perawatan');
    $canFollowUp = $sbIsAdmin || $sbU->hasMenu('follow-up');
    $canLaporan  = $sbIsAdmin || $sbU->hasMenu('laporan');

    $showDataMaster    = $canKonsumen || $canUnit || $canTeknisi;
    $showLayananServis = $canRegis || $canClosing;
    $showDashSub       = $canPengingat || $canFollowUp;
    $showUserMgmt      = $sbIsAdmin; // khusus Superadmin
    $showHeadingCrm    = $showDataMaster || $showLayananServis || $showUserMgmt;

    // Menu Pengaturan Akun aktif (termasuk Switch Profile yang kini ada di dalamnya)
    $pengaturanAktif   = request()->routeIs('profile.edit', 'password.edit', 'team.manage', 'users.profile-auth*');
@endphp

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="width: 260px !important; min-width: 260px !important; background: linear-gradient(135deg, #455169 0%, #091a2d 40%, #42050b 100%); border-right: 3px solid #25252c;">

    <div class="sb-sidenav-menu" style="width: 260px !important;">
        <div class="nav px-2">
            <div class="pt-2"></div>

            <!-- 1. DASHBOARD (terbuka untuk semua user yang login) -->
            <div class="sb-sidenav-menu-heading text-white-50 fw-normal" style="font-size: 11px;">UTAMA</div>
            <div class="menu-box d-flex align-items-center justify-content-between px-3 py-2">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none text-white flex-grow-1">
                    <div class="sb-nav-link-icon text-white me-2"><i class="fas fa-home"></i></div>
                    <span class="nav-text fw-normal">Dashboard</span>
                </a>
                @if($showDashSub)
                <a href="#" data-bs-toggle="collapse" data-bs-target="#collapseDashboard" aria-expanded="{{ request()->routeIs('schedules*', 'followup*') ? 'true' : 'false' }}" class="text-white-50 text-decoration-none px-2">
                    <i class="fas fa-angle-down"></i>
                </a>
                @endif
            </div>

            @if($showDashSub)
            <div class="collapse {{ request()->routeIs('schedules*', 'followup*') ? 'show' : '' }}" id="collapseDashboard" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    @if($canPengingat)
                    <a class="nav-link {{ $canFollowUp ? 'sub-item-divider' : '' }} {{ request()->routeIs('schedules*') ? 'text-info fw-bold active-sub' : 'text-white-50' }}" href="{{ route('schedules.index') }}">
                        <i class="fas fa-bell me-2 text-white"></i> Pengingat Perawatan
                    </a>
                    @endif
                    @if($canFollowUp)
                    <a class="nav-link {{ request()->routeIs('followup*') ? 'text-info fw-bold active-sub' : '' }}" href="{{ route('followup.index') }}">
                        <i class="fab fa-whatsapp me-2 text-white"></i> Follow-up WhatsApp
                    </a>
                    @endif
                </nav>
            </div>
            @endif

            <!-- 2. DATA MASTER (Data Konsumen, Data Unit, Data Teknisi) -->
            @if($showHeadingCrm)
            <div class="sb-sidenav-menu-heading text-white-50 fw-normal mt-2" style="font-size: 11px;">MANAJEMEN CRM</div>
            @endif

            @if($showDataMaster)
            <a class="nav-link {{ request()->routeIs('data-konsumen*', 'data-unit*', 'data-teknisi*', 'service-jobs*') ? '' : 'collapsed' }} menu-box" 
               href="#" data-bs-toggle="collapse" data-bs-target="#collapseMaster" 
               aria-expanded="{{ request()->routeIs('data-konsumen*', 'data-unit*', 'data-teknisi*', 'service-jobs*') ? 'true' : 'false' }}" 
               style="border-color: {{ request()->routeIs('data-konsumen*', 'data-unit*', 'data-teknisi*', 'service-jobs*') ? '#38bdf8' : 'rgba(216, 231, 238, 0.3)' }} !important;">
                <div class="sb-nav-link-icon text-white"><i class="fas fa-database"></i></div>
                <span class="nav-text text-white fw-normal">Data Master</span>
                <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse {{ request()->routeIs('data-konsumen*', 'data-unit*', 'data-teknisi*', 'service-jobs*') ? 'show' : '' }}" id="collapseMaster" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    @if($canKonsumen)
                    <a class="nav-link {{ ($canUnit || $canTeknisi) ? 'sub-item-divider' : '' }} {{ request()->routeIs('data-konsumen*') ? 'text-info fw-bold active-sub' : '' }}" href="{{ route('data-konsumen') }}">
                        <i class="fas fa-users me-2 text-white"></i> Data Konsumen
                    </a>
                    @endif
                    @if($canUnit)
                    <a class="nav-link {{ $canTeknisi ? 'sub-item-divider' : '' }} {{ request()->routeIs('data-unit*', 'service-jobs*') ? 'text-info fw-bold active-sub' : '' }}" href="{{ route('data-unit.index') }}">
                        <i class="fas fa-box me-2 text-white"></i> Data Unit
                    </a>
                    @endif
                    @if($canTeknisi)
                    <a class="nav-link {{ request()->routeIs('data-teknisi*') ? 'text-info fw-bold active-sub' : '' }}" href="{{ route('data-teknisi.index') }}">
                        <i class="fas fa-user-cog me-2 text-white"></i> Data Teknisi
                    </a>
                    @endif
                </nav>
            </div>
            @endif

            <!-- 3. MANAJEMEN PENGGUNA (khusus Superadmin) -->
            @if($showUserMgmt)
                <a class="nav-link {{ request()->routeIs('hak-akses*', 'user-group*', 'data-pengguna*') ? '' : 'collapsed' }} menu-box" 
                   href="#" data-bs-toggle="collapse" data-bs-target="#collapseUserMgmt" 
                   aria-expanded="{{ request()->routeIs('hak-akses*', 'user-group*', 'data-pengguna*') ? 'true' : 'false' }}" 
                   style="border-color: {{ request()->routeIs('hak-akses*', 'user-group*', 'data-pengguna*') ? '#38bdf8' : 'rgba(216, 231, 238, 0.3)' }} !important;">
                    <div class="sb-nav-link-icon text-white"><i class="fas fa-users-cog"></i></div>
                    <span class="nav-text text-white fw-normal">Manajemen Pengguna</span>
                    <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse {{ request()->routeIs('hak-akses*', 'user-group*', 'data-pengguna*') ? 'show' : '' }}" id="collapseUserMgmt" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link sub-item-divider {{ request()->routeIs('data-pengguna*') ? 'text-info fw-bold active-sub' : '' }}" href="{{ route('data-pengguna.index') }}">
                            <i class="fas fa-user-friends me-2 text-white"></i> Data Pengguna
                        </a>
                        <a class="nav-link {{ request()->routeIs('user-group*') ? 'text-info fw-bold active-sub' : '' }}" href="{{ route('user-group.index') }}">
                            <i class="fas fa-shield-alt me-2 text-white"></i> Hak Akses
                        </a>
                    </nav>
                </div>
            @endif

            <!-- 4. LAYANAN SERVIS (Registrasi Servis, Closing Servis) -->
            @if($showLayananServis)
                <a class="nav-link {{ request()->routeIs('registrasi-servis*', 'closing*') ? '' : 'collapsed' }} menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapseServis" aria-expanded="{{ request()->routeIs('registrasi-servis*', 'closing*') ? 'true' : 'false' }}">
                    <div class="sb-nav-link-icon text-white"><i class="fas fa-wrench"></i></div>
                    <span class="nav-text text-white fw-normal">Layanan Servis</span>
                    <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ request()->routeIs('registrasi-servis*', 'closing*') ? 'show' : '' }}" id="collapseServis" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        @if($canRegis)
                        <a class="nav-link {{ $canClosing ? 'sub-item-divider' : '' }} {{ request()->routeIs('registrasi-servis*') ? 'text-info fw-bold active-sub' : '' }}" href="{{ route('registrasi-servis.index') }}">
                            <i class="fas fa-tools me-2 text-white"></i> Registrasi Servis
                        </a>
                        @endif
                        @if($canClosing)
                        <a class="nav-link {{ request()->routeIs('closing*') ? 'text-info fw-bold active-sub' : '' }}" href="{{ route('closing.index') }}">
                            <i class="fas fa-check-circle me-2 text-white"></i> Closing Servis
                        </a>
                        @endif
                    </nav>
                </div>
            @endif

            <!-- 5. LAPORAN -->
            <div class="sb-sidenav-menu-heading text-white-50 fw-normal mt-2" style="font-size: 11px;">LAPORAN & SISTEM</div>

            @if($canLaporan)
            <a class="nav-link {{ request()->routeIs('report*') ? '' : 'collapsed' }} menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="{{ request()->routeIs('report*') ? 'true' : 'false' }}">
                <div class="sb-nav-link-icon text-white"><i class="fas fa-file-pdf"></i></div>
                <span class="nav-text text-white fw-normal">Laporan</span>
                <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse {{ request()->routeIs('report*') ? 'show' : '' }}" id="collapseLaporan" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{ request()->routeIs('report.index') ? 'text-info fw-bold active-sub' : '' }}" href="{{ route('report.index') }}">
                        <i class="fas fa-file-invoice me-2 text-white"></i> Laporan & Rekapitulasi
                    </a>
                </nav>
            </div>
            @endif

            <!-- 6. PENGATURAN AKUN (semua user yang login; Switch Profile khusus Superadmin) -->
            <a class="nav-link {{ $pengaturanAktif ? '' : 'collapsed' }} menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePengaturan" aria-expanded="{{ $pengaturanAktif ? 'true' : 'false' }}">
                <div class="sb-nav-link-icon text-white"><i class="fas fa-user-shield"></i></div>
                <span class="nav-text text-white fw-normal">Pengaturan Akun</span>
                <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse {{ $pengaturanAktif ? 'show' : '' }}" id="collapsePengaturan" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{ $showUserMgmt ? 'sub-item-divider' : '' }} {{ request()->routeIs('profile.edit', 'password.edit', 'team.manage') ? 'text-info fw-bold active-sub' : '' }}" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-circle me-2 text-white"></i> Profil & Ubah Password
                    </a>
                    @if($showUserMgmt)
                    <a class="nav-link {{ request()->routeIs('users.profile-auth*') ? 'text-info fw-bold active-sub' : '' }}" href="{{ route('users.profile-auth') }}">
                        <i class="fas fa-id-badge me-2 text-white"></i> Impersonate / Switch Profile
                    </a>
                    @endif
                </nav>
            </div>

        </div>
    </div>

    <!-- FOOTER SIDEBAR -->
    @php
        $sbUser = auth()->user();
    @endphp
    <div class="sb-sidenav-footer p-3" style="width: 260px !important; background: rgba(13, 27, 42, 0.95) !important; border-top: 1px solid rgba(255,255,255,0.15);">
        <div class="sb-status-label">Status Akun</div>
        <div class="sb-status-card {{ $sbIsAdmin ? 'is-admin' : 'is-marketing' }}">
            <div class="sb-status-avatar">{{ strtoupper(substr($sbUser->name, 0, 1)) }}</div>
            <div class="sb-status-info">
                <div class="sb-status-name">{{ $sbUser->name }}</div>
                <span class="sb-status-active">
                    <span class="sb-status-dot"></span> Aktif
                </span>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">
            @csrf
        </form>
    </div>
</nav>

<!-- CSS Sidebar Terstruktur & Rapi -->
<style>
    /* =========================================
        LAYOUT & CONTAINERS
       ========================================= */
    #layoutSidenav_nav {
        width: 260px !important;
        flex: 0 0 260px !important;
    }

    #layoutSidenav_content {
        padding-left: 260px !important;
        min-width: 0;
        flex-grow: 1;
    }

    @media (max-width: 992px) {
        #layoutSidenav_content {
            padding-left: 0 !important;
        }
    }

    /* =========================================
        MENU ITEMS (PARENT BOX)
       ========================================= */
    .menu-box {
        margin: 4px 6px;
        padding: 8px 10px !important;
        border-radius: 8px;
        background: #4682cb3f;
        border: 1.5px solid rgba(216, 231, 238, 0.3);
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .menu-box:hover {
        background: #3a6fae85 !important;
        border-color: #38bdf8 !important;
    }

    .menu-box .nav-text {
        flex-grow: 1;
        white-space: nowrap;
        font-size: 13px;
    }

    /* =========================================
        SUB-MENU (NESTED DROPDOWN)
       ========================================= */
    .sb-sidenav-menu-nested {
        margin: 4px 6px 6px 6px;
        padding: 6px 8px;
        background: #4682cb6c !important;
        border: 1.5px solid rgba(216, 231, 238, 0.3) !important;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    }

    .sb-sidenav-menu-nested .nav-link {
        margin: 2px 0;
        padding: 6px 10px !important;
        font-size: 12.5px !important;
        font-weight: 400 !important;
        color: #ffffff !important;
        border-radius: 6px !important;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .sb-sidenav-menu-nested .nav-link:hover, 
    .sb-sidenav-menu-nested .nav-link.active-sub {
        background-color: rgba(255, 255, 255, 0.12) !important;
        color: #38bdf8 !important;
        padding-left: 14px !important;
    }

    .sub-item-divider {
        margin-bottom: 3px !important;
        padding-bottom: 7px !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    /* =========================================
        FOOTER STATUS CARD
       ========================================= */
    .sb-status-label {
        margin-bottom: 6px;
        font-size: 10px;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.45);
    }

    .sb-status-card {
        padding: 10px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 12px;
    }

    .sb-status-card.is-admin {
        border-color: rgba(248, 113, 113, 0.45);
        box-shadow: 0 0 14px rgba(239, 68, 68, 0.15);
    }

    .sb-status-card.is-marketing {
        border-color: rgba(56, 189, 248, 0.45);
        box-shadow: 0 0 14px rgba(56, 189, 248, 0.15);
    }

    .sb-status-avatar {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 50%;
        font-weight: 700;
        font-size: 15px;
        color: #fff;
    }

    .is-admin .sb-status-avatar {
        background: linear-gradient(135deg, #f87171, #b91c1c);
    }

    .is-marketing .sb-status-avatar {
        background: linear-gradient(135deg, #38bdf8, #2563eb);
    }

    .sb-status-info {
        min-width: 0;
        flex: 1;
    }

    .sb-status-name {
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sb-status-active {
        margin-top: 2px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        font-weight: 600;
        color: #4ade80;
    }

    .sb-status-dot {
        width: 9px;
        height: 9px;
        flex-shrink: 0;
        background: #22c55e;
        border-radius: 50%;
        animation: sbPulse 2s infinite;
    }

    @keyframes sbPulse {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.55); }
        70% { box-shadow: 0 0 0 7px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
</style>