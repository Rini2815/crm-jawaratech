<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceJobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\ProfileController;

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
    Route::get('/dashboard', function () {
        return view('service-jobs.dashboard');
    })->name('dashboard');

        // --- Rute Kelola Akun Tim (UI Only, belum ada logic backend) ---
    Route::get('/kelola-akun-tim', [ProfileController::class, 'manageUsers'])->name('team.manage');

    // --- Rute Manajemen Pengguna ---
    Route::get('/hak-akses', function () {
        return view('manajemen-pengguna.index');
    })->name('hak-akses');

    Route::get('/hak-akses/tambah', function () {
        return view('manajemen-pengguna.create');
    })->name('tambah-pengguna');

    Route::post('/hak-akses/tambah', function () {
        return redirect()->route('hak-akses');
    })->name('simpan-pengguna');

    // --- Rute Data Konsumen ---
    Route::get('/data-konsumen', function () {
        return view('data-konsumen.index');
    })->name('data-konsumen');

    Route::post('/data-konsumen/tambah', function () {
        return redirect()->route('data-konsumen');
    })->name('simpan-konsumen');

    Route::put('/data-konsumen/edit/{id}', function ($id) {
        return redirect()->route('data-konsumen');
    })->name('update-konsumen');

    // --- Rute Data Unit Servis ---
    Route::get('/service-jobs', function () {
        return view('service-jobs.index');
    })->name('service-jobs.index');

    Route::get('/service-jobs/create', function () {
        return view('service-jobs.create');
    })->name('service-jobs.create');

    Route::post('/service-jobs', function () {
        return redirect()->route('service-jobs.index');
    })->name('service-jobs.store');

    Route::get('/service-jobs/{id}/edit', function ($id) {
        return view('service-jobs.edit', ['id' => $id]);
    })->name('service-jobs.edit');

    Route::put('/service-jobs/{id}', function ($id) {
        return redirect()->route('service-jobs.index');
    })->name('service-jobs.update');

    Route::delete('/service-jobs/{id}', function ($id) {
        return redirect()->route('service-jobs.index');
    })->name('service-jobs.destroy');

    // --- Rute Registrasi Layanan Servis ---
    Route::get('/layanan-servis/registrasi', function () {
        return view('registrasi.index');
    })->name('registrasi.index');

    Route::get('/layanan-servis/registrasi/create', function () {
        return view('registrasi.create');
    })->name('registrasi.create');

    Route::post('/layanan-servis/registrasi', function () {
        return redirect()->route('registrasi.index');
    })->name('registrasi.store');

    Route::get('/layanan-servis/registrasi/{id}/edit', function ($id) {
        return view('registrasi.edit', ['id' => $id]);
    })->name('registrasi.edit');

    Route::put('/layanan-servis/registrasi/{id}', function ($id) {
        return redirect()->route('registrasi.index');
    })->name('registrasi.update');

    Route::delete('/layanan-servis/registrasi/{id}', function ($id) {
        return redirect()->route('registrasi.index');
    })->name('registrasi.destroy');

    // --- Rute Closing Servis & Transaksi ---
    Route::get('/layanan-servis/closing', function () {
        return view('closing.index');
    })->name('closing.index');

    Route::get('/layanan-servis/closing/create', function () {
        return view('closing.create');
    })->name('closing.create');

    Route::post('/layanan-servis/closing', function () {
        return redirect()->route('closing.index');
    })->name('closing.store');

    Route::get('/layanan-servis/closing/{id}/edit', function ($id) {
        return view('closing.edit', ['id' => $id]);
    })->name('closing.edit');

    Route::put('/layanan-servis/closing/{id}', function ($id) {
        return redirect()->route('closing.index');
    })->name('closing.update');

    Route::delete('/layanan-servis/closing/{id}', function ($id) {
        return redirect()->route('closing.index');
    })->name('closing.destroy');

    // --- Rute Follow-up Konsumen ---
    Route::get('/layanan-servis/followup', function () {
        return view('followup.index');
    })->name('followup.index');

    Route::get('/layanan-servis/followup/create', function () {
        return view('followup.create');
    })->name('followup.create');

    Route::post('/layanan-servis/followup', function () {
        return redirect()->route('followup.index');
    })->name('followup.store');

    Route::get('/layanan-servis/followup/{id}/edit', function ($id) {
        return view('followup.edit', ['id' => $id]);
    })->name('followup.edit');

    Route::put('/layanan-servis/followup/{id}', function ($id) {
        return redirect()->route('followup.index');
    })->name('followup.update');

    Route::delete('/layanan-servis/followup/{id}', function ($id) {
        return redirect()->route('followup.index');
    })->name('followup.destroy');

    // --- Rute Pengaturan Sistem (Profil & Password) ---
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/ubah-password', [ProfileController::class, 'editPassword'])->name('password.edit');
    Route::put('/ubah-password', [ProfileController::class, 'updatePassword'])->name('password.update.self');

    // --- Rute Notifikasi ---
    Route::get('/notifikasi', [ProfileController::class, 'notifications'])->name('notifications.index');

    // --- Rute Resource Bawaan ---
    Route::resource('service-jobs', ServiceJobController::class);

    // --- Rute Laporan & Log Kronologis ---
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/kronologis', [ReportController::class, 'kronologis'])->name('report.kronologis');
    Route::get('/report/export-daily-pdf', [ReportController::class, 'exportDailyPdf'])->name('report.export.pdf');
    Route::get('/report/export-excel', [ReportController::class, 'exportExcel'])->name('report.export.excel');

    // --- Rute Jadwal Perawatan ---
    Route::get('/schedules', [SchedulesController::class, 'index'])->name('schedules.index');

}); // Penutup group middleware('auth')