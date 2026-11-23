<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KomputerController;
use App\Http\Controllers\Login;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PemesananController;
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

    Route::view('/register', 'regiter')->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.perform');
});

// ==========================================
// ROUTE YANG SUDAH DIPERBAIKI
// ==========================================

// 1. Route yang HANYA butuh login (bisa diakses Admin & User biasa)
// Ini agar Anda bisa bebas klik sidebar tanpa error "Akses ditolak"
Route::middleware(['auth'])->group(function () {
    // Halaman Dashboard / Pengguna
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman Pemesanan (tersambung ke tb_pemesanan)
    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');

    // Halaman Komputer (tersambung ke tb_komputer)
    Route::get('/komputer', [KomputerController::class, 'index'])->name('komputer');
    Route::post('/komputer', [KomputerController::class, 'store'])->name('komputer.store');
    Route::patch('/komputer/{komputer}/status', [KomputerController::class, 'updateStatus'])->name('komputer.updateStatus');

    // Halaman Pelanggan / User (Vortex Play)
    Route::view('/home', 'home')->name('home');
    Route::get('/rent', [PemesananController::class, 'rent'])->name('rent');
    Route::view('/about', 'about')->name('about');

    // ==========================================
    // PAYMENT ROUTES
    // ==========================================

    // Halaman konfirmasi di HP (dari scan QR) — tidak perlu auth agar bisa dibuka di HP
    // Dibuat di dalam auth group agar token masih terlindungi session context

    // Polling status pembayaran (dari layar komputer)
    Route::get('/payment/status/{token}', [PaymentController::class, 'status'])->name('payment.status');

    // SSE stream status pembayaran (alternatif real-time)
    Route::get('/payment/stream/{token}', [PaymentController::class, 'stream'])->name('payment.stream');

    // Halaman struk setelah pembayaran berhasil
    Route::get('/struk/{token?}', [PaymentController::class, 'struk'])->name('struk');

    // Form Rent Booking
    Route::post('/rent', [PemesananController::class, 'store'])->name('rent.submit');
});

// 2. Route Khusus ADMIN (Jika nanti Anda butuh halaman khusus admin)
// Route::middleware(['auth', AdminMiddleware::class])->group(function () {
//     // Masukkan route yang benar-benar rahasia admin di sini nanti
// });

// ==========================================
// PAYMENT CONFIRM — Tanpa auth (dibuka di HP setelah scan QR)
// ==========================================
Route::get('/payment/confirm/{token}', [PaymentController::class, 'confirmPage'])->name('payment.confirm.page');
Route::post('/payment/confirm/{token}', [PaymentController::class, 'confirm'])->name('payment.confirm');
Route::get('/payment/struk/{token}', [PaymentController::class, 'struk'])->name('payment.struk');

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
