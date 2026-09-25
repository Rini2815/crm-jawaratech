<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CRM Jawaratech</title>
    <!-- Font Awesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Gradasi dengan warna merah/maroon di pojok kanan bawah */
            background: linear-gradient(135deg, #3d0716 0%, #031e42 45%, #9cb2c7 75%, #4a0d1a 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
            position: relative;
        }

        /* --- Animasi Ikon Sparepart & Servis di Latar Belakang --- */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }
        
        .bg-icon {
            position: absolute;
            animation: spinAndFloat linear infinite;
        }

        .icon-dark { color: rgba(0, 0, 0, 0.15); }   
        .icon-light { color: rgba(255, 255, 255, 0.1); } 
        
        @keyframes spinAndFloat {
            0% { transform: rotate(0deg) translateY(0px); }
            50% { transform: rotate(180deg) translateY(-20px); }
            100% { transform: rotate(360deg) translateY(0px); }
        }
        
        /* 1. Pasangan Gear (Kiri Atas) */
        .bg-icon:nth-child(1) { font-size: 280px; top: -40px; left: -30px; animation-duration: 30s; }
        .bg-icon:nth-child(2) { font-size: 130px; top: 140px; left: 160px; animation-duration: 20s; animation-direction: reverse; }

        /* 2. Pasangan Kipas/Blower AC (Kanan Atas) */
        .bg-icon:nth-child(3) { font-size: 200px; top: 20px; right: 10px; animation-duration: 25s; }
        .bg-icon:nth-child(4) { font-size: 120px; top: 180px; right: 190px; animation-duration: 18s; animation-direction: reverse; }

        /* 3. Pasangan Cogs/Mesin (Kanan Bawah) */
        .bg-icon:nth-child(5) { font-size: 200px; bottom: -20px; right: -20px; animation-duration: 35s; }
        .bg-icon:nth-child(6) { font-size: 130px; bottom: 80px; right: 170px; animation-duration: 22s; animation-direction: reverse; }

        /* 4. Pasangan Chip Elektrik (Kiri Tengah) */
        .bg-icon:nth-child(7) { font-size: 180px; top: 35%; left: 3%; animation-duration: 28s; }
        .bg-icon:nth-child(8) { font-size: 90px; top: 50%; left: 18%; animation-duration: 20s; animation-direction: reverse; }

        /* 5. Pasangan Obeng & Kunci Pas (Kanan Tengah) */
        .bg-icon:nth-child(9) { font-size: 120px; top: 40%; right: 4%; animation-duration: 24s; }
      
        /* 6. Pasangan 2 Gerigi (Pojok Kiri Bawah) */
        .bg-icon:nth-child(11) { font-size: 160px; bottom: 30px; left: 50px; animation-duration: 20s; } 
        .bg-icon:nth-child(12) { font-size: 90px; bottom: 130px; left: 160px; animation-duration: 15s; animation-direction: reverse; } 

        /* --- Kotak Kaca Transparan Terluar --- */
        .glass-outer {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3);
            z-index: 1; 
        }

        /* Kotak Login Utama di dalam Outer */
        .login-container {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 18px;
            padding: 55px 45px 35px 45px;
            width: 380px;
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.05), 0 15px 25px rgba(0, 0, 0, 0.3);
            color: #fff;
            text-align: center;
            box-sizing: border-box;
            position: relative;
            margin-top: 40px;
        }

        /* Lingkaran Putih untuk Logo */
        .logo-circle {
            width: 95px;
            height: 95px;
            background-color: #ffffff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: -47px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.85), 0 0 30px rgba(0, 0, 0, 0.6); 
        }

        .logo-circle img {
            width: 65px;
        }

        .login-container h2 {
            margin: 10px 0 25px;
            font-weight: 600;
            font-size: 24px;
            letter-spacing: 1px;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            font-size: 12px;
            margin-bottom: 5px;
            color: rgba(255, 255, 255, 0.9);
            padding-left: 2px;
        }

        .input-wrapper {
            display: flex;
            align-items: center;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 6px;
            border-bottom: 3px solid #000000; 
            padding: 0 12px;
            transition: 0.3s;
        }

        .input-wrapper:focus-within {
            background: rgba(0, 0, 0, 0.3);
            border-bottom-color: #333333; 
        }

        .input-wrapper i.fa-envelope, .input-wrapper i.fa-lock {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        .input-wrapper input {
            width: 100%;
            padding: 10px;
            background: transparent;
            border: none;
            color: #fff;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
        }

        .input-wrapper input::placeholder {
            color: rgba(255, 255, 255, 0.4);
            font-size: 12px;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            margin-bottom: 25px;
            color: rgba(255, 255, 255, 0.9);
        }

        .options label {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .options a {
            color: #ffffff; 
            text-decoration: none;
            transition: 0.3s;
        }

        .options a:hover {
            text-decoration: underline;
            color: #ddd;
        }

        /* Tombol Login Utama Warna Hitam */
        .btn {
            width: 100%;
            padding: 12px;
            background: #111111; 
            color: #ffffff;      
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.6);
            margin-bottom: 12px;
        }

        .btn:hover {
            background: #2a2a2a; 
        }

        /* Tombol Login dengan Google */
        .btn-google {
            width: 100%;
            padding: 11px;
            background: rgba(255, 255, 255, 0.1); 
            color: #ffffff;      
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            margin-bottom: 15px;
        }

        .btn-google:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        /* Container Bulat Putih di Belakang Ikon Google agar Terlihat Jelas */
        .google-icon-wrapper {
            width: 24px;
            height: 24px;
            background-color: #ffffff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Membuat Ikon Google Berwarna Warni Asli (Biru, Merah, Kuning, Hijau) */
        .google-icon {
            font-size: 14px;
            background: conic-gradient(#ea4335 0deg 90deg, #fbbc05 90deg 180deg, #34a853 180deg 270deg, #4285f4 270deg 360deg);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Branding Jawaratech di bawah form */
        .brand-footer {
            margin-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 15px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            letter-spacing: 0.5px;
        }

        .brand-footer span {
            font-weight: 600;
            color: #ffffff;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        .alert {
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
            margin-bottom: 15px;
            text-align: center;
        }
        .alert-error {
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid rgba(255, 0, 0, 0.4);
        }
        .alert-success {
            background: rgba(0, 255, 0, 0.2);
            border: 1px solid rgba(0, 255, 0, 0.4);
        }
    </style>
</head>
<body>

    <!-- Animasi Background Pasangan (Besar & Kecil) -->
    <div class="bg-animation">
        <!-- Pasangan Kiri Atas (Gear) -->
        <i class="fa-solid fa-gear bg-icon icon-dark"></i>
        <i class="fa-solid fa-gear bg-icon icon-light"></i> 

        <!-- Pasangan Kanan Atas (Fan/Blower AC) -->
        <i class="fa-solid fa-fan bg-icon icon-light"></i> 
        <i class="fa-solid fa-fan bg-icon icon-dark"></i>

        <!-- Pasangan Kanan Bawah (Cogs) -->
        <i class="fa-solid fa-cogs bg-icon icon-dark"></i> 
        <i class="fa-solid fa-cogs bg-icon icon-light"></i>

        <!-- Pasangan Kiri Tengah (Chip Elektrik) -->
        <i class="fa-solid fa-microchip bg-icon icon-dark"></i>
        <i class="fa-solid fa-microchip bg-icon icon-light"></i>

        <!-- Pasangan Kanan Tengah (Obeng & Kunci Pas) -->
        <i class="fa-solid fa-screwdriver-wrench bg-icon icon-dark"></i>
        <i class="fa-solid fa-screwdriver-wrench bg-icon icon-light"></i>
        
        <!-- Pasangan Kiri Bawah (Gear) -->
        <i class="fa-solid fa-gear bg-icon icon-light"></i> 
        <i class="fa-solid fa-gear bg-icon icon-dark"></i>  
    </div>

    <!-- Wrapper Luar (Efek Kaca Double) -->
    <div class="glass-outer">
        <div class="login-container">
            
            <!-- Logo Bulat di Tengah Atas -->
            <div class="logo-circle">
                <img src="{{ asset('image/logo.png') }}" alt="Logo Jawaratech">
            </div>
            
            <h2>Login</h2>

            <!-- Pesan Alert -->
            @if($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@jawaratech.com">
                    </div>
                </div>
                
                <div class="input-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" required placeholder="Masukkan password Anda">
                    </div>
                </div>
                
                <div class="options">
                    <label><input type="checkbox" name="remember"> Remember me</label>
                    <a href="{{ url('/forgot-password') }}">Forgot Password?</a>
                </div>

                <button type="submit" class="btn">LOGIN</button>
                
                <!-- Tombol Login dengan Google (Dilengkapi Background Putih untuk Ikon) -->
                <a href="{{ url('/auth/google') }}" class="btn-google">
                    <div class="google-icon-wrapper">
                        <i class="fa-brands fa-google google-icon"></i>
                    </div> 
                    Login dengan Google
                </a>
            </form>

            <!-- Teks Branding Jawaratech di Bawah Form -->
            <div class="brand-footer">
                CRM System &mdash; Powered by <span>Jawaratech</span>
            </div>
        </div>
    </div>

</body>
</html>