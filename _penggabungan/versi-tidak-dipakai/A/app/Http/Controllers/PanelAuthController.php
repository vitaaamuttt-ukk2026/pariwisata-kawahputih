<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class PanelAuthController extends Controller
{
    public function showLogin($role)
    {
        if (!in_array($role, ['admin', 'pengelola'])) {
            abort(404);
        }

        return view('auth.login', compact('role'));
    }

    public function login(Request $request, $role): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        if ($user->role !== $role) {
            return back()->withErrors([
                'email' => "Akun ini tidak memiliki akses sebagai {$role}. Silakan login melalui halaman yang sesuai."
            ])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->forget('url.intended');

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'pengelola') {
            return redirect()->route('pengelola.dashboard');
        }

        return redirect('/');
    }

    public function logout(Request $request): RedirectResponse
    {
        $role = Auth::user()?->role;
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'pengelola') {
            return redirect()->route('panel.login', ['role' => 'pengelola']);
        }

        return redirect()->route('panel.login', ['role' => 'admin']);
    }
}