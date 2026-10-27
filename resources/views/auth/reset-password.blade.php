<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - CRM Jawaratech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #3d0716 0%, #031e42 45%, #9cb2c7 75%, #4a0d1a 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
            position: relative;
        }

        .bg-animation { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden; pointer-events: none; }
        .bg-icon { position: absolute; animation: spinAndFloat linear infinite; }
        .icon-dark { color: rgba(0, 0, 0, 0.15); }
        .icon-light { color: rgba(255, 255, 255, 0.1); }

        @keyframes spinAndFloat {
            0% { transform: rotate(0deg) translateY(0px); }
            50% { transform: rotate(180deg) translateY(-20px); }
            100% { transform: rotate(360deg) translateY(0px); }
        }

        .bg-icon:nth-child(1) { font-size: 280px; top: -40px; left: -30px; animation-duration: 30s; }
        .bg-icon:nth-child(2) { font-size: 130px; top: 140px; left: 160px; animation-duration: 20s; animation-direction: reverse; }
        .bg-icon:nth-child(3) { font-size: 200px; top: 20px; right: 10px; animation-duration: 25s; }
        .bg-icon:nth-child(4) { font-size: 120px; top: 180px; right: 190px; animation-duration: 18s; animation-direction: reverse; }
        .bg-icon:nth-child(5) { font-size: 200px; bottom: -20px; right: -20px; animation-duration: 35s; }
        .bg-icon:nth-child(6) { font-size: 130px; bottom: 80px; right: 170px; animation-duration: 22s; animation-direction: reverse; }
        .bg-icon:nth-child(7) { font-size: 180px; top: 35%; left: 3%; animation-duration: 28s; }
        .bg-icon:nth-child(8) { font-size: 90px; top: 50%; left: 18%; animation-duration: 20s; animation-direction: reverse; }
        .bg-icon:nth-child(9) { font-size: 120px; top: 40%; right: 4%; animation-duration: 24s; }
        .bg-icon:nth-child(11) { font-size: 160px; bottom: 30px; left: 50px; animation-duration: 20s; }
        .bg-icon:nth-child(12) { font-size: 90px; bottom: 130px; left: 160px; animation-duration: 15s; animation-direction: reverse; }

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

        .logo-circle {
            width: 95px; height: 95px; background-color: #ffffff; border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            position: absolute; top: -47px; left: 50%; transform: translateX(-50%);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.85), 0 0 30px rgba(0, 0, 0, 0.6);
        }
        .logo-circle img { width: 65px; }

        .login-container h2 {
            margin: 10px 0 8px; font-weight: 600; font-size: 24px; letter-spacing: 1px;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
        }
        .subtitle { font-size: 12px; color: rgba(255, 255, 255, 0.75); margin: 0 0 22px; line-height: 1.5; }

        .input-group { margin-bottom: 18px; text-align: left; }
        .input-group label { display: block; font-size: 12px; margin-bottom: 5px; color: rgba(255, 255, 255, 0.9); padding-left: 2px; }

        .input-wrapper {
            display: flex; align-items: center; background: rgba(0, 0, 0, 0.2);
            border-radius: 6px; border-bottom: 3px solid #000000; padding: 0 12px; transition: 0.3s;
        }
        .input-wrapper:focus-within { background: rgba(0, 0, 0, 0.3); border-bottom-color: #333333; }
        .input-wrapper i { color: rgba(255, 255, 255, 0.6); font-size: 14px; }
        .input-wrapper input {
            width: 100%; padding: 10px; background: transparent; border: none;
            color: #fff; font-size: 14px; outline: none; box-sizing: border-box;
        }
        .input-wrapper input::placeholder { color: rgba(255, 255, 255, 0.4); font-size: 12px; }

        .btn {
            width: 100%; padding: 12px; background: #111111; color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px;
            font-size: 15px; font-weight: 800; letter-spacing: 1px; cursor: pointer;
            transition: 0.3s; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.6); margin-bottom: 12px;
        }
        .btn:hover { background: #2a2a2a; }

        .back-link { display: inline-block; font-size: 12px; color: #ffffff; text-decoration: none; margin-bottom: 5px; }
        .back-link:hover { text-decoration: underline; color: #ddd; }

        .brand-footer {
            margin-top: 15px; border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 15px; font-size: 12px; color: rgba(255, 255, 255, 0.7); letter-spacing: 0.5px;
        }
        .brand-footer span { font-weight: 600; color: #ffffff; text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5); }

        .alert { padding: 10px; border-radius: 5px; font-size: 12px; margin-bottom: 15px; text-align: center; }
        .alert-error { background: rgba(255, 0, 0, 0.2); border: 1px solid rgba(255, 0, 0, 0.4); }
    </style>
</head>
<body>

    <div class="bg-animation">
        <i class="fa-solid fa-gear bg-icon icon-dark"></i>
        <i class="fa-solid fa-gear bg-icon icon-light"></i>
        <i class="fa-solid fa-fan bg-icon icon-light"></i>
        <i class="fa-solid fa-fan bg-icon icon-dark"></i>
        <i class="fa-solid fa-cogs bg-icon icon-dark"></i>
        <i class="fa-solid fa-cogs bg-icon icon-light"></i>
        <i class="fa-solid fa-microchip bg-icon icon-dark"></i>
        <i class="fa-solid fa-microchip bg-icon icon-light"></i>
        <i class="fa-solid fa-screwdriver-wrench bg-icon icon-dark"></i>
        <i class="fa-solid fa-screwdriver-wrench bg-icon icon-light"></i>
        <i class="fa-solid fa-gear bg-icon icon-light"></i>
        <i class="fa-solid fa-gear bg-icon icon-dark"></i>
    </div>

    <div class="glass-outer">
        <div class="login-container">

            <div class="logo-circle">
                <img src="{{ asset('image/logo.png') }}" alt="Logo Jawaratech">
            </div>

            <h2>Reset Password</h2>
            <p class="subtitle">Buat password baru untuk akun Anda.</p>

            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email', $email) }}" required placeholder="contoh@jawaratech.com">
                    </div>
                </div>

                <div class="input-group">
                    <label>Password Baru</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" required placeholder="Minimal 8 karakter">
                    </div>
                </div>

                <div class="input-group">
                    <label>Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi password baru">
                    </div>
                </div>

                <button type="submit" class="btn">SIMPAN PASSWORD</button>

                <a href="{{ route('login') }}" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Login</a>
            </form>

            <div class="brand-footer">
                CRM System &mdash; Powered by <span>Jawaratech</span>
            </div>
        </div>
    </div>

</body>
</html>