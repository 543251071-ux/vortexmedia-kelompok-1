<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect halaman utama langsung ke login (Opsional)
Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [Login::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Login::class, 'login'])->name('login.perform');
});

// Route terproteksi (sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tambahkan ini agar tidak error jika ada sisa panggilan route profile dari Breeze
    Route::get('/profile', function () {
        return redirect()->route('dashboard');
    })->name('profile.edit');

    Route::post('/logout', [Login::class, 'logout'])->name('logout');
});