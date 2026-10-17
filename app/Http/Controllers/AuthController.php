<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Menampilkan form/halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Memproses data dari form login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Hanya akun berstatus Aktif yang boleh login
        if (Auth::attempt(array_merge($credentials, ['status' => 'Aktif']))) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah, atau akun tidak aktif.',
        ])->onlyInput('email');
    }

    /**
     * Mengarahkan user ke halaman login Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Menangani callback/respon setelah user login via Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            // Akun harus sudah dibuat Superadmin dan berstatus Aktif
            if (!$user || $user->status !== 'Aktif') {
                return redirect('/login')->withErrors([
                    'email' => 'Akun Google ini belum terdaftar atau tidak aktif. Hubungi Superadmin.',
                ]);
            }

            if (empty($user->google_id)) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }

            Auth::login($user);

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }

    /**
     * Memproses logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}