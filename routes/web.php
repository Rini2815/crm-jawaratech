<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\ProfileAuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TeknisiController; // <-- BARU

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

    // Fitur Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- Rute Dashboard ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Rute Pengaturan Sistem: Kelola Akun Profil ---
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/ubah-password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('/ubah-password', [ProfileController::class, 'updatePassword'])->name('password.update.self');

    // --- Rute Notifikasi ---
    Route::get('/notifikasi', [ProfileController::class, 'notifications'])->name('notifications.index');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    // =====================================================================
    // B. KHUSUS SUPERADMIN
    // =====================================================================
    Route::middleware(CekMenu::class . ':superadmin')->group(function () {
        Route::get('/kelola-akun-tim', [ProfileController::class, 'manageUsers'])->name('team.manage');

        // --- MANAJEMEN PENGGUNA ---
        Route::get('/data-pengguna', [UserManagementController::class, 'index'])->name('data-pengguna.index');
        Route::get('/hak-akses', [UserManagementController::class, 'index'])->name('hak-akses');

        Route::get('/hak-akses/tambah', function () {
            return view('user-management.create'); 
        })->name('tambah-pengguna');

        Route::post('/hak-akses/tambah', [UserManagementController::class, 'store'])->name('simpan-pengguna');
        Route::put('/hak-akses/{id}', [UserManagementController::class, 'update'])->name('update-pengguna');
        Route::delete('/hak-akses/{id}', [UserManagementController::class, 'destroy'])->name('hapus-pengguna');

        // --- Switch Profile (Impersonate) ---
        Route::get('/users/profile-auth', [ProfileAuthController::class, 'index'])->name('users.profile-auth');
        Route::post('/users/impersonate/{id}', [ProfileAuthController::class, 'impersonate'])->name('users.impersonate');

        // --- Rute User Group / Kelola Role ---
        Route::get('/user-group', [UserGroupController::class, 'index'])->name('user-group.index');
        Route::post('/user-group/update', [UserGroupController::class, 'update'])->name('user-group.update');
        Route::post('/user-group/store', [UserGroupController::class, 'store'])->name('user-group.store');
        Route::delete('/user-group/{roleName}', [UserGroupController::class, 'destroy'])->name('user-group.destroy');
    });

    // =====================================================================
    // C. DAPAT DIATUR LEWAT MATRIKS HAK AKSES
    // =====================================================================

    // --- Data Konsumen ---
    Route::middleware(CekMenu::class . ':data-konsumen')->group(function () {
        Route::get('/data-konsumen', [KonsumenController::class, 'index'])->name('data-konsumen');
        Route::post('/data-konsumen/tambah', [KonsumenController::class, 'store'])->name('simpan-konsumen');
        Route::put('/data-konsumen/edit/{id}', [KonsumenController::class, 'update'])->name('update-konsumen');
        Route::delete('/data-konsumen/hapus/{id}', [KonsumenController::class, 'destroy'])->name('hapus-konsumen');
    });

    // --- Data Teknisi --- (BARU)
    Route::middleware(CekMenu::class . ':data-teknisi')->group(function () {
        Route::get('/data-teknisi', [TeknisiController::class, 'index'])->name('data-teknisi.index');
        Route::post('/data-teknisi', [TeknisiController::class, 'store'])->name('data-teknisi.store');
        Route::put('/data-teknisi/{id}', [TeknisiController::class, 'update'])->name('data-teknisi.update');
        Route::delete('/data-teknisi/{id}', [TeknisiController::class, 'destroy'])->name('data-teknisi.destroy');
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

        Route::resource('service-jobs', ServiceJobController::class)->only(['show']);
    });

    // --- Registrasi Servis ---
    Route::middleware(CekMenu::class . ':registrasi-servis')->group(function () {
        Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi.index');
        Route::get('/registrasi-servis', [RegistrasiController::class, 'index'])->name('registrasi-servis.index');
        Route::post('/registrasi-servis', [RegistrasiController::class, 'store'])->name('registrasi-servis.store');
        Route::get('/registrasi-servis/{id}/cetak', [RegistrasiController::class, 'cetak'])->name('registrasi-servis.cetak');
        Route::put('/registrasi-servis/{id}', [RegistrasiController::class, 'update'])->name('registrasi-servis.update');
        Route::delete('/registrasi-servis/{id}', [RegistrasiController::class, 'destroy'])->name('registrasi-servis.destroy');
    });

    // --- Closing Servis ---
    Route::middleware(CekMenu::class . ':closing')->group(function () {
        Route::get('/layanan-servis/closing', [ClosingController::class, 'index'])->name('closing.index');
        Route::get('/layanan-servis/closing/create', function () {
            return redirect()->route('closing.index');
        })->name('closing.create');
        Route::post('/layanan-servis/closing', [ClosingController::class, 'store'])->name('closing.store');
        Route::get('/layanan-servis/closing/{id}/cetak', [ClosingController::class, 'cetak'])->name('closing.cetak');
        Route::put('/layanan-servis/closing/{id}', [ClosingController::class, 'update'])->name('closing.update');
        Route::delete('/layanan-servis/closing/{id}', [ClosingController::class, 'destroy'])->name('closing.destroy');
    });
    
    // --- Pengingat Perawatan ---
    Route::middleware(CekMenu::class . ':pengingat-perawatan')->group(function () {
        Route::get('/schedules', [SchedulesController::class, 'index'])->name('schedules.index');
        Route::post('/schedules/hubungi', [SchedulesController::class, 'hubungi'])->name('schedules.hubungi');
    });

    // --- Follow-up Konsumen ---
    Route::middleware(CekMenu::class . ':follow-up')->group(function () {
        Route::get('/layanan-servis/followup', [FollowUpController::class, 'index'])->name('followup.index');
        Route::get('/layanan-servis/followup/create', function () {
            return redirect()->route('followup.index');
        })->name('followup.create');
        Route::put('/layanan-servis/followup/{id}', [FollowUpController::class, 'update'])->name('followup.update');
    });

    // --- Laporan & Log Kronologis ---
    Route::middleware(CekMenu::class . ':laporan')->group(function () {
        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::get('/report/kronologis', [ReportController::class, 'kronologis'])->name('report.kronologis');
        
        // Rute Export PDF & Excel (CSV)
        Route::get('/report/export-daily-pdf', [ReportController::class, 'exportDailyPdf'])->name('report.pdf');
        Route::get('/report/export-excel', [ReportController::class, 'exportExcel'])->name('report.excel');
    });
});