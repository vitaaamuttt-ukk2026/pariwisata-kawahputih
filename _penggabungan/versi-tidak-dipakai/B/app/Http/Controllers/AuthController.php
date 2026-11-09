<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('login');
    }

    // Proses login
    public function processLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            // TAMBAHAN: 'pengunjung' agar user biasa bisa login
            'role' => 'required|in:admin,pengelola,pengunjung', 
        ], [
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal 6 karakter!',
            'role.required' => 'Role wajib dipilih!',
            'role.in' => 'Role tidak valid!',
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->role;
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->role !== $role) {
                Auth::logout();
                return back()->withErrors([
                    'email' => "Email ini tidak terdaftar sebagai {$role}. Silakan pilih role yang sesuai.",
                ])->withInput($request->only('email'));
            }

            $request->session()->regenerate();
            return $this->redirectBasedOnRole($user)->with('success', "Selamat datang, {$user->name}!");
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    // Redirect berdasarkan role
    private function redirectBasedOnRole($user)
{
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'pengelola':
            return redirect()->route('pengelola.dashboard');
        case 'pengunjung':
            return redirect()->route('pengunjung.dashboard'); // ← Tambahkan ini
        default:
            Auth::logout();
            return redirect()->route('login');
    }
}

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}