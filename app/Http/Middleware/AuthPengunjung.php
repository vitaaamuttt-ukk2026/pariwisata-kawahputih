<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthPengunjung
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika BELUM login ATAU role-nya BUKAN 'pengunjung'
        if (!Auth::check() || Auth::user()->role !== 'pengunjung') {
            // Paksa redirect ke halaman login khusus pengunjung
            return redirect()->route('pengunjung.login');
        }

        // Jika sudah login dan role-nya 'pengunjung', izinkan masuk
        return $next($request);
    }
}