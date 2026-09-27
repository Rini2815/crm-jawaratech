<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil (Manajemen Profil)
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Menyimpan perubahan profil (nama & email)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Menampilkan halaman ubah password
     */
    public function editPassword()
    {
        return view('profile.password');
    }

    /**
     * Menyimpan password baru
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('password.edit')->with('success', 'Password berhasil diubah.');
    }

    /**
     * Menampilkan halaman notifikasi lengkap.
     *
     * CATATAN: Masih menggunakan data DUMMY, mengikuti pola yang sama
     * dengan SchedulesController (belum terhubung ke database asli).
     * Nanti tinggal diganti jika backend jadwal sudah siap.
     */
    public function notifications()
    {
        $notifications = collect([
            (object)[
                'id' => 1,
                'nama_pelanggan' => 'Budi Santoso',
                'no_hp' => '081234567890',
                'nama_perangkat' => 'AC Panasonic 1 PK',
                'kategori_perangkat' => 'AC',
                'jenis_notif' => 'Jadwal Cuci AC (3 Bulan)',
                'tgl_jatuh_tempo' => '27 Sep 2026',
                'status_minggu' => 'Minggu 1',
                'badge_color' => 'bg-warning text-dark',
                'icon' => 'fa-snowflake',
                'icon_bg' => 'bg-primary',
                'label_aksi' => 'WA Konsumen',
                'wa_link' => 'https://wa.me/6281234567890?text=Halo%20Budi%20Santoso,%20jadwal%20perawatan%20berkala%20AC%20Anda%20sudah%20waktunya.',
            ],
            (object)[
                'id' => 2,
                'nama_pelanggan' => 'Siti Aminah',
                'no_hp' => '082198765432',
                'nama_perangkat' => 'Dispenser Modena',
                'kategori_perangkat' => 'Dispenser',
                'jenis_notif' => 'Pembersihan Elemen (6 Bulan)',
                'tgl_jatuh_tempo' => '15 Sep 2026',
                'status_minggu' => 'Minggu 2',
                'badge_color' => 'bg-danger text-white',
                'icon' => 'fa-faucet',
                'icon_bg' => 'bg-warning',
                'label_aksi' => 'Follow-Up',
                'wa_link' => 'https://wa.me/6282198765432?text=Halo%20Siti%20Aminah,%20jadwal%20perawatan%20berkala%20Dispenser%20Anda%20sudah%20waktunya.',
            ],
            (object)[
                'id' => 3,
                'nama_pelanggan' => 'Ahmad Dahlan',
                'no_hp' => '085712345678',
                'nama_perangkat' => 'Mesin Cuci Sharp Front Loading',
                'kategori_perangkat' => 'Mesin Cuci',
                'jenis_notif' => 'Cek Maintenance (1 Tahun)',
                'tgl_jatuh_tempo' => '01 Sep 2026',
                'status_minggu' => 'Terlewat (>2 Wk)',
                'badge_color' => 'bg-dark text-white',
                'icon' => 'fa-soap',
                'icon_bg' => 'bg-info',
                'label_aksi' => 'Follow-Up',
                'wa_link' => 'https://wa.me/6285712345678?text=Halo%20Ahmad%20Dahlan,%20jadwal%20perawatan%20berkala%20Mesin%20Cuci%20Anda%20sudah%20terlewat.',
            ],
            (object)[
                'id' => 4,
                'nama_pelanggan' => 'Eko Prasetyo',
                'no_hp' => '089611223344',
                'nama_perangkat' => 'AC Daikin 1.5 PK',
                'kategori_perangkat' => 'AC',
                'jenis_notif' => 'Jadwal Cuci AC (3 Bulan)',
                'tgl_jatuh_tempo' => '10 Nov 2026',
                'status_minggu' => 'Mendatang',
                'badge_color' => 'bg-secondary text-white',
                'icon' => 'fa-snowflake',
                'icon_bg' => 'bg-primary',
                'label_aksi' => 'WA Konsumen',
                'wa_link' => 'https://wa.me/6289611223344?text=Halo%20Eko%20Prasetyo,%20jadwal%20perawatan%20berkala%20AC%20Anda%20sudah%20waktunya.',
            ],
        ]);

        $totalJatuhTempo = $notifications->whereIn('status_minggu', ['Minggu 1', 'Minggu 2', 'Terlewat (>2 Wk)'])->count();

        return view('notifications.index', compact('notifications', 'totalJatuhTempo'));
    }

    /**
     * Menampilkan halaman Kelola Akun Tim (Superadmin & Digital Marketing).
     *
     * CATATAN PENTING: Ini BARU TAMPILAN (UI only).
     * Tombol "Login Sebagai" belum berfungsi secara nyata karena:
     * - Tabel `users` belum punya kolom `role`
     * - Logic impersonation (Auth::loginUsingId, dsb) belum dibuat
     * Data di bawah ini masih dummy, menunggu backend role & impersonation dikerjakan.
     */
    public function manageUsers()
    {
        $teamAccounts = collect([
            (object)[
                'id' => 1,
                'name' => 'Admin Jawaratech',
                'email' => 'admin@jawaratech.com',
                'role' => 'Superadmin',
                'role_color' => 'bg-danger',
                'is_you' => true,
            ],
            (object)[
                'id' => 2,
                'name' => 'Rina Marketing',
                'email' => 'rina.dm@jawaratech.com',
                'role' => 'Digital Marketing',
                'role_color' => 'bg-info',
                'is_you' => false,
            ],
            (object)[
                'id' => 3,
                'name' => 'Fajar Kurniawan',
                'email' => 'fajar.dm@jawaratech.com',
                'role' => 'Digital Marketing',
                'role_color' => 'bg-info',
                'is_you' => false,
            ],
        ]);

        return view('profile.manage-users', compact('teamAccounts'));
    }
}