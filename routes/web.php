<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Route untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [Login::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Login::class, 'login'])->name('login.perform');
});

// Route terproteksi (sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [Login::class, 'logout'])->name('logout');
});