<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceJobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;

// 1. Halaman utama (URL root '/') sekarang diarahkan langsung ke DASHBOARD
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
    
    // --- RUTE DASHBOARD ---
    Route::get('/dashboard', function () {
        return view('service-jobs.dashboard'); 
    })->name('dashboard');

    // --- Rute Data Servis ---
    Route::resource('service-jobs', ServiceJobController::class);
});