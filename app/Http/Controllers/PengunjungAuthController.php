<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PengunjungAuthController extends Controller
{
    public function showLogin(): View
    {
        // UBAH DI SINI: tambahkan 'auth.'
        return view('pengunjung.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->role === 'pengunjung') {
                return redirect()->intended(route('pengunjung.dashboard'))->with('success', 'Login berhasil!');
            }
            
            Auth::logout();
            return back()->withErrors(['email' => 'Akun ini bukan akun pengunjung.']);
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegister(): View
    {
        // UBAH DI SINI: tambahkan 'auth.'
        return view('pengunjung.auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_hp' => $validated['no_hp'] ?? null,
            'role' => 'pengunjung',
        ]);

        Auth::login($user);

        return redirect()->route('pengunjung.dashboard')->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('pengunjung.login')->with('success', 'Anda telah logout.');
    }
}