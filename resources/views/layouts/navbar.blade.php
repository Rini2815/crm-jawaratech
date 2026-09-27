<nav class="sb-topnav navbar navbar-expand navbar-dark" style="background: linear-gradient(135deg, #12161f 0%, #0d1b2a 40%, #450a10 100%) !important; border-bottom: 4px solid #525363bc !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);">
    <!-- Logo & Brand di Pojok Kiri Atas -->
    <a class="navbar-brand ps-3 fw-bold d-flex align-items-center" href="{{ route('service-jobs.index') }}">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" style="width: 32px; height: 32px; object-fit: contain; background: #fff; border-radius: 4px; padding: 2px; margin-right: 10px;">
        <span>CRM Jawaratech</span>
    </a>
    
    <!-- Tombol Toggle Sidebar -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-white" id="sidebarToggle" href="#!"><i class="fas fa-bars fa-lg"></i></button>
    
    <!-- Spacer Pengisi Jarak -->
    <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
    
    <!-- Menu Navbar Kanan (Notifikasi & User Superadmin) -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 align-items-center">
        
        <!-- 1. ICON LONCENG NOTIFIKASI CRM -->
        <li class="nav-item dropdown me-3 position-relative">
            <a class="nav-link text-white position-relative px-2" id="navbarDropdownNotif" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell fa-lg"></i>
                <!-- Badge Jumlah Notifikasi -->
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; padding: 0.25em 0.45em;">
                    3
                    <span class="visually-hidden">Notifikasi Perawatan</span>
                </span>
            </a>

            <!-- Pop-up Dropdown Notifikasi -->
            <ul class="dropdown-menu dropdown-menu-end shadow-lg py-0" aria-labelledby="navbarDropdownNotif" style="background-color: #0f172a; border: 1px solid #334155; min-width: 330px; border-radius: 12px;">
                <!-- Header Pop-Up -->
                <li class="dropdown-header d-flex justify-content-between align-items-center py-2 px-3" style="background-color: #1e293b; color: #f8fafc; border-bottom: 1px solid #334155; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <span class="fw-bold"><i class="fas fa-tools text-primary me-2"></i> Pengingat Perawatan</span>
                    <span class="badge bg-primary rounded-pill">3 Jatuh Tempo</span>
                </li>

                <!-- Item 1: Notifikasi Unit AC (Interval 3 Bulan) -->
                <li>
                    <a class="dropdown-item d-flex align-items-start gap-3 py-2 px-3 border-bottom border-secondary border-opacity-25" href="#" style="color: #f8fafc; white-space: normal;">
                        <div class="bg-primary bg-opacity-25 text-primary p-2 rounded-circle mt-1">
                            <i class="fas fa-snowflake fa-fw"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="small text-white">Siti Aminah</strong>
                                <span class="text-warning extra-small" style="font-size: 0.7rem;"><i class="fas fa-clock me-1"></i>Minggu 1</span>
                            </div>
                            <p class="mb-1 small text-light opacity-75">Jadwal Cuci AC (3 Bulan) - Sharp 1 PK</p>
                            <div class="d-flex gap-2 mt-1">
                                <span class="btn btn-sm btn-success py-0 px-2 rounded-pill" style="font-size: 0.75rem;">
                                    <i class="fab fa-whatsapp me-1"></i> WA Konsumen
                                </span>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Item 2: Notifikasi Unit Mesin Cuci (Interval 1 Tahun) -->
                <li>
                    <a class="dropdown-item d-flex align-items-start gap-3 py-2 px-3 border-bottom border-secondary border-opacity-25" href="#" style="color: #f8fafc; white-space: normal;">
                        <div class="bg-info bg-opacity-25 text-info p-2 rounded-circle mt-1">
                            <i class="fas fa-soap fa-fw"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="small text-white">Budi Santoso</strong>
                                <span class="text-danger extra-small" style="font-size: 0.7rem;"><i class="fas fa-exclamation-circle me-1"></i>Minggu 2</span>
                            </div>
                            <p class="mb-1 small text-light opacity-75">Cek Maintenance (1 Tahun) - Mesin Cuci LG</p>
                            <div class="d-flex gap-2 mt-1">
                                <span class="btn btn-sm btn-success py-0 px-2 rounded-pill" style="font-size: 0.75rem;">
                                    <i class="fab fa-whatsapp me-1"></i> Follow-Up
                                </span>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Item 3: Notifikasi Unit Dispenser / Water Heater (Interval 6 Bulan) -->
                <li>
                    <a class="dropdown-item d-flex align-items-start gap-3 py-2 px-3" href="#" style="color: #f8fafc; white-space: normal;">
                        <div class="bg-warning bg-opacity-25 text-warning p-2 rounded-circle mt-1">
                            <i class="fas fa-faucet fa-fw"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="small text-white">Hendra Wijaya</strong>
                                <span class="text-warning extra-small" style="font-size: 0.7rem;"><i class="fas fa-clock me-1"></i>Minggu 1</span>
                            </div>
                            <p class="mb-1 small text-light opacity-75">Pembersihan Elemen (6 Bulan) - Dispenser Miyako</p>
                            <div class="d-flex gap-2 mt-1">
                                <span class="btn btn-sm btn-success py-0 px-2 rounded-pill" style="font-size: 0.75rem;">
                                    <i class="fab fa-whatsapp me-1"></i> WA Konsumen
                                </span>
                            </div>
                        </div>
                    </a>
                </li>

                <!-- Footer Pop-up -->
                <li style="border-top: 1px solid #334155;">
                    <a class="dropdown-item text-center fw-bold text-info py-2 small" href="#" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                        Lihat Semua Riwayat & Log Perawatan <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </li>
            </ul>
        </li>

        <!-- 2. DROPDOWN USER SUPERADMIN -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white fw-semibold" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw me-1"></i> Superadmin
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarDropdown" style="background: #0d1b2a; border-radius: 8px;">
                <li><a class="dropdown-item text-white py-2" href="#" style="transition: 0.2s;"><i class="fas fa-user me-2 text-info"></i> Profil Saya</a></li>
                <li><hr class="dropdown-divider my-1" style="border-color: rgba(255, 255, 255, 0.15);" /></li>
                <li><a class="dropdown-item text-white py-2" href="#" style="transition: 0.2s;"><i class="fas fa-sign-out-alt me-2 text-danger"></i> Keluar</a></li>
            </ul>
        </li>
    </ul>
</nav>
