<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileAuthController extends Controller
{
    public function index()
    {
        // Ambil ID user yang sedang login (untuk mendeteksi "Akun Anda")
        $loggedInUserId = Auth::id(); // Atau Auth::user()->id_pengguna jika custom

        // Ambil semua data pengguna dari database
        $users = DB::table('ms_pengguna')->get();

        // Siapkan Collection untuk dilempar ke Blade
        $teamAccounts = collect();

        foreach ($users as $user) {
            // Tentukan Role (jika tabel Anda punya kolom role, gunakan itu. Jika tidak, sesuaikan)
            // Asumsi: ada kolom 'role' di tabel ms_pengguna dengan value 'Superadmin' / 'Digital Marketing'
            $role = $user->role ?? 'Digital Marketing'; 
            
            // Tentukan warna badge berdasarkan role
            $roleColor = ($role === 'Superadmin') ? 'bg-danger' : 'bg-primary';

            $teamAccounts->push((object)[
                'id' => $user->id_pengguna, // Sesuaikan primary key tabel Anda
                'name' => $user->nama,      // Sesuaikan kolom nama
                'email' => $user->email,    // Sesuaikan kolom email
                'role' => $role,
                'role_color' => $roleColor,
                'is_you' => ($user->id_pengguna == $loggedInUserId) // Deteksi akun sendiri
            ]);
        }

        return view('profile.manage-users', compact('teamAccounts'));
    }

    public function impersonate($id)
    {
        // 1. Simpan ID admin asli ke session (buat jaga-jaga kalau mau bikin tombol "Kembali ke Admin" nanti)
        session()->put('admin_asli', Auth::id());

        // 2. Paksa pindah sesi login ke akun target tanpa password!
        Auth::loginUsingId($id);

        // 3. Arahkan langsung ke halaman Dashboard (pastikan route name-nya benar 'dashboard')
        return redirect()->route('dashboard')->with('success', 'Berhasil beralih akun!');
    }
}