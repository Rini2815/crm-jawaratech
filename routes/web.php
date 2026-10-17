<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceJobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\UserManagementController; 
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ClosingController;
use App\Http\Controllers\FollowUpController;
use App\Http\Middleware\CekMenu;

// 1. Halaman utama (URL root '/') diarahkan langsung ke DASHBOARD
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 2. KELOMPOK GUEST: Rute yang HANYA bisa diakses jika BELUM login
Route::middleware('guest')->group(function () {

    // Fitur Login Biasa
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Fitur Login dengan Google
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

    // Fitur Lupa Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');
});

// 3. KELOMPOK AUTH: Rute yang DIKUNCI (HANYA BISA DIAKSES JIKA SUDAH LOGIN)
Route::middleware('auth')->group(function () {

    // =====================================================================
    // A. TERBUKA UNTUK SEMUA USER YANG SUDAH LOGIN
    // =====================================================================

    // Fitur Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- Rute Dashboard ---
    Route::get('/dashboard', function () {
        return view('service-jobs.dashboard');
    })->name('dashboard');

    // --- Rute Pengaturan Sistem: Kelola Akun Profil (hanya akun milik sendiri) ---
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/ubah-password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('/ubah-password', [ProfileController::class, 'updatePassword'])->name('password.update.self');

    // --- Rute Notifikasi ---
    Route::get('/notifikasi', [ProfileController::class, 'notifications'])->name('notifications.index');

    // =====================================================================
    // B. KHUSUS SUPERADMIN (tidak bisa didelegasikan lewat matriks)
    // =====================================================================
    Route::middleware(CekMenu::class . ':superadmin')->group(function () {

        // --- Rute Kelola Akun Tim ---
        Route::get('/kelola-akun-tim', [ProfileController::class, 'manageUsers'])->name('team.manage');

        // --- MANAJEMEN PENGGUNA ---
        // 1. Data Pengguna
        Route::get('/data-pengguna', [UserManagementController::class, 'index'])->name('data-pengguna.index');

        // 2. Hak Akses
        Route::get('/hak-akses', [UserManagementController::class, 'index'])->name('hak-akses');

        // Rute form tambah
        Route::get('/hak-akses/tambah', function () {
            return view('user-management.create'); 
        })->name('tambah-pengguna');

        // Rute Tambah / Simpan Data Baru
        Route::post('/hak-akses/tambah', [UserManagementController::class, 'store'])->name('simpan-pengguna');

        // Rute Edit / Ubah Data
        Route::put('/hak-akses/{id}', [UserManagementController::class, 'update'])->name('update-pengguna');

        // Rute Hapus
        Route::delete('/hak-akses/{id}', [UserManagementController::class, 'destroy'])->name('hapus-pengguna');

        // 3. Switch Profile (Otoritas Akses Profil)
        Route::get('/users/profile-auth', function () {
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
                    'role_color' => 'bg-primary',
                    'is_you' => false,
                ],
                (object)[
                    'id' => 3,
                    'name' => 'Fajar Kurniawan',
                    'email' => 'fajar.dm@jawaratech.com',
                    'role' => 'Digital Marketing',
                    'role_color' => 'bg-primary',
                    'is_you' => false,
                ],
            ]);

            return view('profile.manage-users', compact('teamAccounts'));
        })->name('users.profile-auth');

        // --- Rute User Group / Kelola Role ---
        Route::get('/user-group', [UserGroupController::class, 'index'])->name('user-group.index');
        Route::post('/user-group/update', [UserGroupController::class, 'update'])->name('user-group.update');
        Route::post('/user-group/store', [UserGroupController::class, 'store'])->name('user-group.store');
        Route::delete('/user-group/{roleName}', [UserGroupController::class, 'destroy'])->name('user-group.destroy');
    });

    // =====================================================================
    // C. DAPAT DIATUR LEWAT MATRIKS HAK AKSES (kunci menu di tanda kutip)
    // =====================================================================

    // --- Data Konsumen ---
    Route::middleware(CekMenu::class . ':data-konsumen')->group(function () {
        Route::get('/data-konsumen', [KonsumenController::class, 'index'])->name('data-konsumen');

        Route::post('/data-konsumen/tambah', [KonsumenController::class, 'store'])->name('simpan-konsumen');

        Route::put('/data-konsumen/edit/{id}', [KonsumenController::class, 'update'])->name('update-konsumen');

        Route::delete('/data-konsumen/hapus/{id}', [KonsumenController::class, 'destroy'])->name('hapus-konsumen');
    });

    // --- Data Unit Servis ---
    Route::middleware(CekMenu::class . ':data-unit')->group(function () {
        Route::get('/data-unit', [UnitController::class, 'index'])->name('data-unit.index');

        Route::get('/service-jobs', [UnitController::class, 'index'])->name('service-jobs.index');

        Route::get('/service-jobs/create', [UnitController::class, 'create'])->name('service-jobs.create');

        Route::post('/service-jobs', [UnitController::class, 'store'])->name('service-jobs.store');

        Route::get('/service-jobs/{id}/edit', [UnitController::class, 'edit'])->name('service-jobs.edit');

        Route::put('/service-jobs/{id}', [UnitController::class, 'update'])->name('service-jobs.update');

        Route::delete('/service-jobs/{id}', [UnitController::class, 'destroy'])->name('service-jobs.destroy');

        // --- Rute Resource Bawaan (hanya 'show'; sisanya sudah ditangani UnitController di atas) ---
        Route::resource('service-jobs', ServiceJobController::class)->only(['show']);
    });

    // --- Registrasi Servis ---
    Route::middleware(CekMenu::class . ':registrasi-servis')->group(function () {
        Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi.index');

        Route::get('/registrasi-servis', [RegistrasiController::class, 'index'])->name('registrasi-servis.index');

        Route::post('/registrasi-servis', [RegistrasiController::class, 'store'])->name('registrasi-servis.store');

        // Cetak tanda terima unit / SPK
        Route::get('/registrasi-servis/{id}/cetak', [RegistrasiController::class, 'cetak'])->name('registrasi-servis.cetak');

        Route::put('/registrasi-servis/{id}', [RegistrasiController::class, 'update'])->name('registrasi-servis.update');

        Route::delete('/registrasi-servis/{id}', [RegistrasiController::class, 'destroy'])->name('registrasi-servis.destroy');
    });

    // --- Closing Servis ---
    Route::middleware(CekMenu::class . ':closing')->group(function () {
        Route::get('/layanan-servis/closing', [ClosingController::class, 'index'])->name('closing.index');

        // Halaman lama (kini form berupa modal di halaman daftar)
        Route::get('/layanan-servis/closing/create', function () {
            return redirect()->route('closing.index');
        })->name('closing.create');

        Route::post('/layanan-servis/closing', [ClosingController::class, 'store'])->name('closing.store');

        Route::get('/layanan-servis/closing/{id}/cetak', [ClosingController::class, 'cetak'])->name('closing.cetak');

        Route::put('/layanan-servis/closing/{id}', [ClosingController::class, 'update'])->name('closing.update');

        Route::delete('/layanan-servis/closing/{id}', [ClosingController::class, 'destroy'])->name('closing.destroy');
    });
    
    // --- Pengingat Perawatan (FR12) ---
    Route::middleware(CekMenu::class . ':pengingat-perawatan')->group(function () {
        Route::get('/schedules', [SchedulesController::class, 'index'])->name('schedules.index');

        // Tombol Chat: catat agenda follow-up lalu buka WhatsApp
        Route::post('/schedules/hubungi', [SchedulesController::class, 'hubungi'])->name('schedules.hubungi');
    });

    // --- Follow-up Konsumen: Chat WhatsApp & Happy Call (FR07, FR11) ---
    Route::middleware(CekMenu::class . ':follow-up')->group(function () {
        Route::get('/layanan-servis/followup', [FollowUpController::class, 'index'])->name('followup.index');

        // Halaman lama (pencatatan kini lewat modal edit di halaman daftar)
        Route::get('/layanan-servis/followup/create', function () {
            return redirect()->route('followup.index');
        })->name('followup.create');

        Route::put('/layanan-servis/followup/{id}', [FollowUpController::class, 'update'])->name('followup.update');
    });

    // --- Laporan & Log Kronologis ---
    Route::middleware(CekMenu::class . ':laporan')->group(function () {
        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::get('/report/kronologis', [ReportController::class, 'kronologis'])->name('report.kronologis');
        Route::get('/report/export-daily-pdf', [ReportController::class, 'exportDailyPdf'])->name('report.export.pdf');
        Route::get('/report/export-excel', [ReportController::class, 'exportExcel'])->name('report.export.excel');
    });

});