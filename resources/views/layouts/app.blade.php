<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CRM Jawaratech</title>
    <!-- FontAwesome Icon -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- SB Admin CSS via CDN Resmi -->
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin@7.0.7/dist/css/styles.css" rel="stylesheet" />
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