<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Login;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Http\Request;
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

    // Halaman Pelanggan / User (Vortex Play)
    Route::view('/home', 'home')->name('home');
    Route::view('/rent', 'rent')->name('rent');
    Route::view('/about', 'about')->name('about');

    // Form Rent Booking
    Route::post('/rent', function (Request $request) {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:100'],
        ]);

        $user = auth()->user();
        if ($user) {
            $user->nama = $validated['nama'];
            $user->nomor_telepon = $validated['nomor_telepon'];
            $user->save();
        }

        return redirect()->route('rent')->with('success', 'Data pemesanan slot bermain berhasil disimpan! Silakan lanjutkan pembayaran.');
    })->name('rent.submit');
});

// 2. Route Khusus ADMIN (Jika nanti Anda butuh halaman khusus admin)
// Route::middleware(['auth', AdminMiddleware::class])->group(function () {
//     // Masukkan route yang benar-benar rahasia admin di sini nanti
// });

// 3. Route terproteksi untuk USER biasa (alias)
Route::middleware(['auth', UserMiddleware::class])->group(function () {
    // Route spesifik user dapat ditambahkan di sini
});

// Route profile (redirect ke dashboard)
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return redirect()->route('dashboard');
    })->name('profile.edit');

    Route::post('/logout', [Login::class, 'logout'])->name('logout');
});
