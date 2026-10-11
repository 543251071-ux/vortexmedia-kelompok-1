<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class Login extends Controller
{
    public function showLoginForm(): View
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'regex:/[0-9]/'],
        ], [
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung minimal 1 angka.',
        ]);

        $identity = trim($credentials['email']);
        $user = User::query()
            ->where('email', $identity)
            ->orWhere('nama', $identity)
            ->first();

        if ($user === null) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        $password = $credentials['password'];
        $storedPassword = trim((string) $user->password);
        $isLegacyPassword = password_get_info($storedPassword)['algoName'] === 'unknown';
        $passwordMatches = $isLegacyPassword
            ? hash_equals($storedPassword, $password)
            : Hash::check($password, $storedPassword);

        if (! $passwordMatches) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        if ($isLegacyPassword) {
            $user->password = Hash::make($password);
            $user->save();
        }

        Auth::login($user);
        $request->session()->regenerate();

        // Redirect berdasarkan role
        if ($user->isAdmin()) {
            return redirect()->intended('/dashboard');
        }

        return redirect()->intended('/home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
