<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;

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

// Route terproteksi untuk ADMIN
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Route terproteksi untuk USER biasa
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