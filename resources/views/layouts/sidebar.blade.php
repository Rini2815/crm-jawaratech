<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="width: 260px !important; min-width: 260px !important; background: linear-gradient(135deg, #29364d 0%, #0d1b2a 40%, #42050b 100%); border-right: 3px solid #5b1924;">
    <div class="sb-sidenav-menu" style="width: 260px !important;">
        <div class="nav px-2">
            
            <div class="pt-2"></div>

            <!-- 1. DASHBOARD -->
            <div class="sb-sidenav-menu-heading text-white-50 fw-normal" style="font-size: 11px;">UTAMA</div>
            <div class="menu-box d-flex align-items-center justify-content-between px-3 py-2" style="background: #4682cb3f; margin: 5px 8px; border-radius: 8px; border: 1.5px solid rgba(216, 231, 238, 0.3);">
                <!-- Bagian Kiri: Klik untuk langsung ke halaman Dashboard -->
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-decoration-none text-white flex-grow-1">
                    <div class="sb-nav-link-icon text-white me-2"><i class="fas fa-home"></i></div>
                    <span class="nav-text fw-normal">Dashboard</span>
                </a>
                <!-- Bagian Kanan: Tombol Panah untuk Buka Dropdown Sub-menu -->
                <a href="#" data-bs-toggle="collapse" data-bs-target="#collapseDashboard" aria-expanded="false" class="text-white-50 text-decoration-none px-2">
                    <i class="fas fa-angle-down"></i>
                </a>
            </div>
            <div class="collapse" id="collapseDashboard" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('service-jobs.index') }}">
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
                    <a class="nav-link sub-item-divider" href="{{ route('service-jobs.index') }}">
                        <i class="fas fa-users me-2 text-white"></i> Data Konsumen
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-tools me-2 text-white"></i> Data Unit Servis
                    </a>
                </nav>
            </div>

            <!-- 3. MANAJEMEN PENGGUNA -->
            <a class="nav-link collapsed menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUserMgmt" aria-expanded="false" style="background: #4682cb3f; border-radius: 8px; border: 1.5px solid rgba(216, 231, 238, 0.3);">
                <div class="sb-nav-link-icon text-white"><i class="fas fa-user-cog"></i></div>
                <span class="nav-text text-white fw-normal">Manajemen Pengguna</span>
                <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseUserMgmt" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="#">
                        <i class="fas fa-id-badge me-2 text-white"></i> Hak Akses Pengguna
                    </a>
                </nav>
            </div>

            <!-- 4. LAYANAN SERVIS -->
            <a class="nav-link collapsed menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapseServis" aria-expanded="false" style="background: #4682cb3f; border-radius: 8px; border: 1.5px solid rgba(216, 231, 238, 0.3);">
                <div class="sb-nav-link-icon text-white"><i class="fas fa-wrench"></i></div>
                <span class="nav-text text-white fw-normal">Layanan Servis</span>
                <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseServis" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub-item-divider" href="{{ route('service-jobs.index') }}">
                        <i class="fas fa-user-plus me-2 text-white"></i> Registrasi Unit
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-check-circle me-2 text-white"></i> Closing Servis
                    </a>
                </nav>
            </div>

            <!-- 5. RIWAYAT LAPORAN -->
            <div class="sb-sidenav-menu-heading text-white-50 fw-normal mt-2" style="font-size: 11px;">LAPORAN & SISTEM</div>
            <a class="nav-link collapsed menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="false" style="background: #4682cb3f; border-radius: 8px; border: 1.5px solid rgba(216, 231, 238, 0.3);">
                <div class="sb-nav-link-icon text-white"><i class="fas fa-file-pdf"></i></div>
                <span class="nav-text text-white fw-normal">Riwayat Laporan</span>
                <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLaporan" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub-item-divider" href="#">
                        <i class="fas fa-history me-2 text-white"></i> Log Kronologis
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-print me-2 text-white"></i> Cetak PDF
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
                    <a class="nav-link sub-item-divider" href="#">
                        <i class="fas fa-user-circle me-2 text-white"></i> Profil Akun
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-key me-2 text-white"></i> Ubah Password
                    </a>
                </nav>
            </div>

            <!-- 7. PUSAT INFORMASI -->
            <a class="nav-link collapsed menu-box" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLog" aria-expanded="false" style="background: #4682cb3f; border-radius: 8px; border: 1.5px solid rgba(216, 231, 238, 0.3);">
                <div class="sb-nav-link-icon text-white"><i class="fas fa-info-circle"></i></div>
                <span class="nav-text text-white fw-normal">Pusat Informasi</span>
                <div class="sb-sidenav-collapse-arrow text-white-50"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLog" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub-item-divider" href="#">
                        <i class="fas fa-archive me-2 text-white"></i> Arsip Berkas
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-book me-2 text-white"></i> Panduan Sistem
                    </a>
                </nav>
            </div>

        </div>
    </div>
    
    <div class="sb-sidenav-footer" style="width: 260px !important; background: rgba(13, 27, 42, 0.95) !important; border-top: 1px solid rgba(255,255,255,0.15);">
        <div class="small text-white-50">Login sebagai:</div>
        <span class="text-white fw-normal">Admin Jawaratech</span>
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
</style>