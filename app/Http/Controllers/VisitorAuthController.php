<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VisitorAuthController extends Controller
{
    // Tampilkan halaman login pengunjung
    public function showLoginForm()
    {
        return view('visitor.login');
    }

    // Proses login pengunjung
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah user ada dan role-nya 'pengunjung'
        $user = User::where('email', $credentials['email'])
                    ->where('role', 'pengunjung')
                    ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            
            return redirect()->intended(route('pengunjung.dashboard'))
                            ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah, atau akun ini bukan akun pengunjung.',
        ])->onlyInput('email');
    }

    // Tampilkan halaman register pengunjung
    public function showRegisterForm()
    {
        return view('visitor.register');
    }

    // Proses register pengunjung
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'required|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pengunjung',
            'no_hp' => $validated['no_hp'] ?? null,
        ]);

        Auth::login($user);
        
        return redirect()->route('pengunjung.dashboard')
                        ->with('success', 'Akun berhasil dibuat! Selamat datang di Kawah Putih.');
    }

    // Logout pengunjung
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('visitor.login')
                        ->with('success', 'Anda telah logout.');
    }
}