<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CRM Jawaratech</title>
    
    <!-- 1. Google Font 'Inter' (Sama seperti halaman temanmu) -->
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
</body>
</html>
