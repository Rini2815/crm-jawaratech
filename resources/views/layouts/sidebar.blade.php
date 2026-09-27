<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="width: 260px !important; min-width: 260px !important; background: linear-gradient(135deg, #455169 0%, #091a2d 40%, #42050b 100%); border-right: 3px solid #25252c;">
    <div class="sb-sidenav-menu" style="width: 260px !important;">
        <div class="nav px-2">
            <div class="pt-2"></div>

            <!-- 1. DASHBOARD -->
            <div class="sb-sidenav-menu-heading text-white-50 fw-normal" style="font-size: 11px;">UTAMA</div>

            <!-- Box Utama Dashboard -->
            <div class="menu-box d-flex align-items-center justify-content-between px-3 py-2" style="background: #4682cb3f; margin: 5px 8px; border-radius: 8px; border: 1.5px solid rgba(216, 231, 238, 0.3);">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none text-white flex-grow-1">
                    <div class="sb-nav-link-icon text-white me-2"><i class="fas fa-home"></i></div>
                    <span class="nav-text fw-normal">Dashboard</span>
                </a>
                <a href="#" data-bs-toggle="collapse" data-bs-target="#collapseDashboard" aria-expanded="false" class="text-white-50 text-decoration-none px-2">
                    <i class="fas fa-angle-down"></i>
                </a>
            </div>

            <!-- Dropdown Sub-Menu Dashboard -->
            <div class="collapse" id="collapseDashboard" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link text-white-50" href="{{ route('schedules.index') }}">
                        <i class="fas fa-clock me-2 text-white"></i> Jadwal Perawatan
                    </a>
                </nav>
            </div>

            <!-- 2. DATA MASTER -->
            <div class="sb-sidenav-menu-heading text-white-50 fw-normal mt-2" style="font-size: 11px;">MANAJEMEN CRM</div>
            <a class="nav-link collapsed menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMaster" aria-expanded="false" style="background: #4682cb3f; border-radius: 8px; border: 1.5px solid rgba(216, 231, 238, 0.3);">
                <div class="sb-nav-link-icon text-white"><i class="fas fa-database"></i></div>
                <span class="nav-text text-white fw-normal">Data Master</span>
                <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseMaster" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub-item-divider" href="{{ route('data-konsumen') }}">
                        <i class="fas fa-users me-2 text-white"></i> Data Konsumen
                    </a>
                    <a class="nav-link" href="{{ route('service-jobs.index') }}">
                        <i class="fas fa-tools me-2 text-white"></i> Data Unit Servis
                    </a>
                </nav>
            </div>

            <!-- 3. MANAJEMEN PENGGUNA (Hanya muncul jika punya salah satu hak akses) -->
            @if(auth()->user()->hasMenu('hak-akses') || auth()->user()->hasMenu('user-group') || auth()->user()->hasMenu('kelola-akun'))
                <a class="nav-link collapsed menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUserMgmt" aria-expanded="false" style="background: #4682cb3f; border-radius: 8px; border: 1.5px solid rgba(216, 231, 238, 0.3);">
                    <div class="sb-nav-link-icon text-white"><i class="fas fa-user-cog"></i></div>
                    <span class="nav-text text-white fw-normal">Manajemen Pengguna</span>
                    <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseUserMgmt" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        
                        {{-- Submenu 1: Hak Akses Pengguna --}}
                        @if(auth()->user()->hasMenu('hak-akses'))
                            <a class="nav-link sub-item-divider {{ request()->routeIs('hak-akses*') ? 'text-info fw-bold' : '' }}" href="{{ route('hak-akses') }}">
                                <i class="fas fa-id-badge me-2 text-white"></i> Hak Akses Pengguna
                            </a>
                        @endif

                        {{-- Submenu 2: User Group / Kelola Role (SUBMENU BARU) --}}
                        @if(auth()->user()->hasMenu('user-group'))
                            <a class="nav-link sub-item-divider {{ request()->routeIs('user-group*') ? 'text-info fw-bold' : '' }}" href="{{ route('user-group.index') }}">
                                <i class="fas fa-users-cog me-2 text-white"></i> User Group / Kelola Role
                            </a>
                        @endif

                        {{-- Submenu 3: Kelola Akun --}}
                        @if(auth()->user()->hasMenu('kelola-akun'))
                            <a class="nav-link {{ request()->routeIs('team.manage') ? 'text-info fw-bold' : '' }}" href="{{ route('team.manage') }}">
                                <i class="fas fa-user-secret me-2 text-white"></i> Kelola Akun
                            </a>
                        @endif

                    </nav>
                </div>
            @endif

            <!-- 4. LAYANAN SERVIS -->
            @if(auth()->user()->hasMenu('layanan-servis'))
                <a class="nav-link collapsed menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapseServis" aria-expanded="false" style="background: #4682cb3f; border-radius: 8px; border: 1.5px solid rgba(216, 231, 238, 0.3);">
                    <div class="sb-nav-link-icon text-white"><i class="fas fa-wrench"></i></div>
                    <span class="nav-text text-white fw-normal">Layanan Servis</span>
                    <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseServis" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link sub-item-divider" href="{{ route('registrasi.index') }}">
                            <i class="fas fa-user-plus me-2 text-white"></i> Registrasi Unit
                        </a>
                        <a class="nav-link sub-item-divider" href="{{ route('closing.index') }}">
                            <i class="fas fa-check-circle me-2 text-white"></i> Closing Servis
                        </a>
                        <a class="nav-link" href="{{ route('followup.index') }}">
                            <i class="fas fa-comments me-2 text-white"></i> Follow-up Konsumen
                        </a>
                    </nav>
                </div>
            @endif

            <!-- 5. RIWAYAT LAPORAN -->
            <div class="sb-sidenav-menu-heading text-white-50 fw-normal mt-2" style="font-size: 11px;">LAPORAN & SISTEM</div>
            <a class="nav-link collapsed menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="false" style="background: #4682cb3f; border-radius: 8px; border: 1.5px solid rgba(216, 231, 238, 0.3);">
                <div class="sb-nav-link-icon text-white"><i class="fas fa-file-pdf"></i></div>
                <span class="nav-text text-white fw-normal">Laporan</span>
                <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLaporan" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub-item-divider {{ request()->routeIs('report.kronologis') ? 'text-info fw-bold' : '' }}" href="{{ route('report.kronologis') }}">
                        <i class="fas fa-history me-2 text-white"></i> Log Kronologis
                    </a>
                    <a class="nav-link {{ request()->routeIs('report.index') ? 'text-info fw-bold' : '' }}" href="{{ route('report.index') }}">
                        <i class="fas fa-print me-2 text-white"></i> Riwayat Laporan
                    </a>
                </nav>
            </div>

            <!-- 6. PENGATURAN SISTEM -->
            <a class="nav-link collapsed menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePengaturan" aria-expanded="false" style="background: #4682cb3f; border-radius: 8px; border: 1.5px solid rgba(216, 231, 238, 0.3);">
                <div class="sb-nav-link-icon text-white"><i class="fas fa-user-shield"></i></div>
                <span class="nav-text text-white fw-normal">Pengaturan Sistem</span>
                <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePengaturan" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub-item-divider {{ request()->routeIs('profile.edit') ? 'text-info fw-bold' : '' }}" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-circle me-2 text-white"></i> Manajemen Profil 
                    </a>
                    <a class="nav-link {{ request()->routeIs('password.edit') ? 'text-info fw-bold' : '' }}" href="{{ route('password.edit') }}">
                        <i class="fas fa-key me-2 text-white"></i> Ubah Password
                    </a>
                </nav>
            </div>

        </div>
    </div>

    <!-- FOOTER SIDEBAR: TOMBOL KELUAR APLIKASI -->
    <div class="sb-sidenav-footer p-3" style="width: 260px !important; background: rgba(13, 27, 42, 0.95) !important; border-top: 1px solid rgba(255,255,255,0.15);">
        <form method="POST" action="{{ route('logout') }}" id="logout-form" class="m-0">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt me-2"></i>
                <span>Keluar Aplikasi</span>
            </button>
        </form>
    </div>
</nav>

<style>
    /* Reset zoom/scaling agar layout fixed ke 260px dengan padding konten yang presisi */
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

    .menu-box {
        margin: 4px 6px;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        padding: 8px 10px !important;
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

    /* Kotak Container Latar Belakang Sub-menu Dropdown */
    .sb-sidenav-menu-nested {
        background: #4682cb6c !important;
        margin: 4px 6px 6px 6px;
        padding: 6px 8px;
        border-radius: 8px;
        border: 1.5px solid rgba(216, 231, 238, 0.3) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    }

    .sb-sidenav-menu-nested .nav-link {
        font-size: 12.5px !important;
        font-weight: 400 !important;
        padding: 6px 10px !important;
        color: #ffffff !important;
        border-radius: 6px !important;
        margin: 2px 0;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .sub-item-divider {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        margin-bottom: 3px !important;
        padding-bottom: 7px !important;
    }

    .sb-sidenav-menu-nested .nav-link:hover,
    .sb-sidenav-menu-nested .nav-link:active {
        background-color: rgba(255, 255, 255, 0.12) !important;
        color: #38bdf8 !important;
        padding-left: 14px !important;
    }

    /* CSS KUSTOM TOMBOL KELUAR APLIKASI */
    .btn-logout {
        width: 100%;
        background-color: rgba(239, 68, 68, 0.15);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 13.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .btn-logout:hover {
        background-color: rgba(239, 68, 68, 0.3);
        color: #ffffff;
        border-color: rgba(239, 68, 68, 0.6);
    }
</style>