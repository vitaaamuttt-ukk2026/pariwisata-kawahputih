<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('panel.login', ['role' => $role]);
        }

        // Cek apakah role user sesuai dengan yang diminta
        if (Auth::user()->role !== $role) {
            Auth::logout();
            return redirect()->route('panel.login', ['role' => $role])
                ->withErrors(['email' => 'Anda tidak memiliki akses ke halaman ini.']);
        }

        return $next($request);
    }
}