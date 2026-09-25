<nav class="sb-topnav navbar navbar-expand navbar-dark" style="background: linear-gradient(135deg, #12161f 0%, #0d1b2a 40%, #450a10 100%) !important; border-bottom: 4px solid #8c2233 !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);">
    <!-- Logo & Brand di Pojok Kiri Atas -->
    <a class="navbar-brand ps-3 fw-bold d-flex align-items-center" href="{{ route('service-jobs.index') }}">
        <img src="{{ asset('image/logo.png') }}" alt="Logo" style="width: 32px; height: 32px; object-fit: contain; background: #fff; border-radius: 4px; padding: 2px; margin-right: 10px;">
        <span>CRM Jawaratech</span>
    </a>
    
    <!-- Tombol Toggle Sidebar -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-white" id="sidebarToggle" href="#!"><i class="fas fa-bars fa-lg"></i></button>
    
    <!-- Spacer -->
    <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
    
    <!-- User Menu di Kanan -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white fw-semibold" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw me-1"></i> Admin
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarDropdown" style="background: #0d1b2a;">
                <li><a class="dropdown-item text-white py-2" href="#" style="transition: 0.2s;"><i class="fas fa-sign-out-alt me-2 text-info"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

<style>
    /* Efek garis bawah ganda: perpaduan garis merah tebal dengan aksen bayangan hitam */
    .sb-topnav.navbar {
        border-bottom: 3px solid #d90429 !important;
        box-shadow: inset 0 -3px 0 0 #000000, 0 4px 8px rgba(0, 0, 0, 0.5) !important;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #0b3954 !important;
        color: #38bdf8 !important;
    }
</style>