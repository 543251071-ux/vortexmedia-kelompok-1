<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KomputerController;
use App\Http\Controllers\Login;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PemesananController;
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

    // ✅ ROUTE REGISTER (BARU)
    Route::get('/register', [Login::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [Login::class, 'register'])->name('register.perform');
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
    Route::patch('/komputer/{komputer}/status', [KomputerController::class, 'updateStatus'])->name('komputer.updateStatus');

    // Halaman Pelanggan / User (Vortex Play)
    Route::view('/home', 'home')->name('home');
    Route::view('/rent', 'rent')->name('rent');
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
    Route::get('/payment/struk/{token}', [PaymentController::class, 'struk'])->name('payment.struk');

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

        // Generate token pembayaran unik
        $token = PaymentController::generateToken();

        return redirect()->route('rent')->with([
            'success' => 'Data pemesanan slot bermain berhasil disimpan! Silakan lanjutkan pembayaran.',
            'payment_token' => $token,
        ]);
    })->name('rent.submit');
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