<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PengunjungController extends Controller
{
    // ========================================
    // HALAMAN-HALAMAN PENGUNJUNG
    // ========================================
    
    public function index()
    {
        // Ambil data order milik user yang login
        $orders = \App\Models\Order::where('user_id', auth()->id())->latest()->get();
        
        return view('pengunjung.dashboard', compact('orders'));
    }

    public function info()
    {
        return view('pengunjung.info');
    }

    public function wisata()
    {
        return view('pengunjung.wisata');
    }

    public function penginapan()
    {
        return view('pengunjung.penginapan');
    }

    public function booking()
    {
        return view('pengunjung.booking');
    }

    public function pembayaran()
    {
        return view('pengunjung.pembayaran');
    }

    public function prosesPembayaran(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('pengunjung.login');
        }

        $validated = $request->validate([
            'nama_pengunjung' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'no_hp' => ['required', 'string', 'min:10', 'max:20'],
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today'],
            'jumlah_tiket' => ['nullable', 'integer', 'min:1', 'max:100'],
            'metode_pembayaran' => ['required', 'in:qris,va,transfer'],
            'cart_data' => ['nullable', 'string'],
            'bukti_pembayaran' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $cartData = json_decode($validated['cart_data'] ?? '[]', true);
        if (!is_array($cartData) || empty($cartData)) {
            $cartData = [[
                'name' => 'Tiket Kawah Putih',
                'qty' => (int) ($validated['jumlah_tiket'] ?? 1),
                'price' => 65000,
            ]];
        }

        $totalBayar = collect($cartData)->sum(function ($item) {
            $qty = (int) ($item['qty'] ?? $item['quantity'] ?? 0);
            $price = (float) ($item['price'] ?? 0);
            return $qty * $price;
        });

        $paket = collect($cartData)->map(function ($item) {
            return $item['name'] ?? 'Paket Kawah Putih';
        })->unique()->implode(', ');

        $booking = \App\Models\Booking::create([
            'booking_code' => 'KP-' . date('YmdHis') . '-' . random_int(100, 999),
            'nama_lengkap' => $validated['nama_pengunjung'],
            'email' => $validated['email'] ?: Auth::user()->email,
            'no_hp' => $validated['no_hp'],
            'jumlah_pengunjung' => (int) ($validated['jumlah_tiket'] ?? collect($cartData)->sum(fn($item) => (int) ($item['qty'] ?? $item['quantity'] ?? 0))),
            'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
            'paket' => $paket ?: 'Paket Kawah Putih',
            'items' => $cartData,
            'total_bayar' => (float) $totalBayar,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'status' => 'pending',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = $booking->booking_code . '.' . $file->extension();
            Storage::disk('public')->putFileAs('bukti-pembayaran', $file, $fileName);
            $booking->update(['bukti_pembayaran' => $fileName]);
        }

        return redirect()->route('pengunjung.tiket')->with('success', 'Booking berhasil diajukan. Menunggu verifikasi admin.');
    }

    public function statusTiket()
    {
        $bookings = collect();

        if (auth()->check()) {
            $bookings = \App\Models\Booking::where('email', auth()->user()->email)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('pengunjung.tiket', compact('bookings'));
    }

    // ========================================
    // FUNGSI LOGIN PENGUNJUNG (BARU)
    // ========================================
    
    public function prosesLogin(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Cari user berdasarkan email
        $user = User::where('email', $credentials['email'])->first();

        // 3. Cek apakah user ada DAN password benar
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        // 4. Cek apakah user adalah pengunjung (bukan admin/pengelola)
        if ($user->role !== 'pengunjung') {
            return back()->withErrors([
                'email' => 'Akun ini bukan akun pengunjung. Silakan login melalui halaman yang sesuai.'
            ])->withInput();
        }

        // 5. Jika semua benar, lakukan login
        Auth::login($user);
        $request->session()->regenerate();

        // 6. Arahkan ke dashboard pengunjung
        return redirect()->route('pengunjung.dashboard');
    }

    // ========================================
    // FUNGSI LOGOUT PENGUNJUNG (BARU)
    // ========================================
    
    public function prosesLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pengunjung.login');
    }
}