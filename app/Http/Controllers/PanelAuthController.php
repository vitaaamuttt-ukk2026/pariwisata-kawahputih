<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanelAuthController extends Controller
{
    public function showLogin($role)
    {
        if (!in_array($role, ['admin', 'pengelola'])) abort(404);
        
        // DIPERBAIKI: Selalu arahkan ke 1 file 'login.blade.php' saja
        return view('auth.login', compact('role'));
    }

    public function login(Request $request, $role)
    {
        if (!in_array($role, ['admin', 'pengelola'])) abort(404);

        $credentials = $request->validate([
            'email' => 'required|email', 
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === $role) {
                $request->session()->regenerate();
                return redirect()->route("{$role}.dashboard");
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Akun ini tidak memiliki akses sebagai ' . ucfirst($role) . '.'])->onlyInput('email');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $role = auth()->user()->role ?? 'admin';
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('panel.login', ['role' => $role])
                         ->with('success', 'Anda telah berhasil keluar.');
    }
}