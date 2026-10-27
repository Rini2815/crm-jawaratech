<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProfileAuthController extends Controller
{
    public function index()
    {
        // Ambil ID user yang sedang login (untuk mendeteksi "Akun Anda")
        $loggedInUserId = Auth::id();

        // Ambil semua pengguna beserta nama role dari tabel ms_role
        $users = DB::table('ms_pengguna')
            ->leftJoin('ms_role', 'ms_pengguna.id_role', '=', 'ms_role.id_role')
            ->select(
                'ms_pengguna.id_pengguna',
                'ms_pengguna.id_role',
                'ms_pengguna.nama',
                'ms_pengguna.email',
                'ms_pengguna.status',
                'ms_role.nama_role'
            )
            ->orderBy('ms_pengguna.id_pengguna')
            ->get();

        // Siapkan Collection untuk dilempar ke Blade
        $teamAccounts = collect();

        foreach ($users as $user) {
            // id_role 1 = Super Administrator, selain itu pakai nama role dari ms_role
            $isSuperadmin = (int) $user->id_role === 1;
            $role = $isSuperadmin ? 'Superadmin' : ($user->nama_role ?? 'Digital Marketing');

            // Tentukan warna badge berdasarkan role
            $roleColor = $isSuperadmin ? 'bg-danger' : 'bg-primary';

            $isYou = ((int) $user->id_pengguna === (int) $loggedInUserId);

            $teamAccounts->push((object)[
                'id' => $user->id_pengguna,
                'name' => $user->nama,
                'email' => $user->email,
                'role' => $role,
                'role_color' => $roleColor,
                'is_you' => $isYou,
                // Sesuai FR10: hanya akun non-Superadmin yang boleh dimasuki
                'can_impersonate' => !$isSuperadmin && !$isYou && $user->status === 'Aktif',
            ]);
        }

        return view('profile.manage-users', compact('teamAccounts'));
    }

    public function impersonate($id)
    {
        $target = DB::table('ms_pengguna')->where('id_pengguna', $id)->first();

        // Validasi di sisi server (bukan hanya tombol yang disembunyikan)
        if (!$target) {
            return redirect()->route('users.profile-auth')
                ->with('error', 'Akun tujuan tidak ditemukan.');
        }

        if ((int) $target->id_pengguna === (int) Auth::id()) {
            return redirect()->route('users.profile-auth')
                ->with('error', 'Anda sedang memakai akun ini.');
        }

        if ((int) $target->id_role === 1) {
            return redirect()->route('users.profile-auth')
                ->with('error', 'Akun Superadmin tidak dapat dimasuki lewat fitur ini.');
        }

        if ($target->status !== 'Aktif') {
            return redirect()->route('users.profile-auth')
                ->with('error', 'Akun tujuan tidak aktif.');
        }

        // Catat siapa masuk ke akun siapa (jejak audit sederhana di storage/logs/laravel.log)
        Log::info('Impersonate: pengguna #' . Auth::id() . ' masuk sebagai #' . $target->id_pengguna . ' (' . $target->nama . ')');

        // 1. Simpan ID admin asli ke session
        session()->put('admin_asli', Auth::id());

        // 2. Pindah sesi login ke akun target tanpa password
        Auth::loginUsingId($target->id_pengguna);

        // 3. Arahkan ke Dashboard
        return redirect()->route('dashboard')->with('success', 'Berhasil beralih akun!');
    }
}