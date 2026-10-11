<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Hanya izinkan user dengan role 'user'.
     * Jika admin, redirect ke dashboard admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('info', 'Anda login sebagai admin.');
        }

        return $next($request);
    }
}
