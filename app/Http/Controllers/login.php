<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Login extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 1. Cari user di tb_user berdasarkan email
        $user = User::get()->first(function ($u) use ($request) {
            return trim($u->email) === trim($request->email);
        });

        // 2. Verifikasi password langsung (plain text)
        if ($user && trim($user->password) === $request->password) {
            
            // Login-kan user ke sesi Laravel
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // 3. Jika gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}