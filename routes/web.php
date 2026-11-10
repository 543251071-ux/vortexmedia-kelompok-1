<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Login;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect halaman utama langsung ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [Login::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Login::class, 'login'])->name('login.perform');
});

// ==========================================
// ROUTE YANG SUDAH DIPERBAIKI
// ==========================================

// 1. Route yang HANYA butuh login (bisa diakses Admin & User biasa)
// Ini agar Anda bisa bebas klik sidebar tanpa error "Akses ditolak"
Route::middleware(['auth'])->group(function () {
    // Halaman Dashboard / Pengguna
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Halaman Pemesanan & Komputer
    Route::view('/pemesanan', 'pemesanan')->name('pemesanan.index');
    Route::view('/komputer', 'komputer')->name('komputer');
});

// 2. Route Khusus ADMIN (Jika nanti Anda butuh halaman khusus admin)
// Route::middleware(['auth', AdminMiddleware::class])->group(function () {
//     // Masukkan route yang benar-benar rahasia admin di sini nanti
// });

// 3. Route terproteksi untuk USER biasa
Route::middleware(['auth', UserMiddleware::class])->group(function () {
    // Halaman utama user (belum dibuat, sementara tampilkan placeholder)
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});

// Route profile (redirect ke dashboard)
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return redirect()->route('dashboard');
    })->name('profile.edit');

    Route::post('/logout', [Login::class, 'logout'])->name('logout');
});