<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Paket;
use App\Models\OperasionalSetting;
use App\Models\InfoContent;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PengunjungController extends Controller
{
    public function dashboard(): View
    {
        $setting = OperasionalSetting::getSetting();
        
        // Ambil data dinamis dari database
        $heroImage = InfoContent::get('hero_image', '');
        $photoSpots = json_decode(InfoContent::get('photo_spots', '[]'), true) ?: [];
        $moodRecommendations = json_decode(InfoContent::get('mood_recommendations', '[]'), true) ?: [];
        
        // Data default jika admin belum mengedit (IKON SUDAH DIPERBAIKI)
        if (empty($moodRecommendations)) {
            $moodRecommendations = [
                ['title' => 'Santai', 'subtitle' => 'Tenang & Sejuk', 'icon' => '🌴', 'color' => 'bg-emerald-50'],
                ['title' => 'Petualangan', 'subtitle' => 'Trekking & Sunrise', 'icon' => '🥾', 'color' => 'bg-orange-50'],
                ['title' => 'Romantis', 'subtitle' => 'Spot Foto Pasangan', 'icon' => '💕', 'color' => 'bg-pink-50'],
                ['title' => 'Keluarga', 'subtitle' => 'Aman untuk Anak', 'icon' => '👨‍👩‍👧', 'color' => 'bg-blue-50'],
            ];
        }
        
        return view('pengunjung.dashboard', compact('setting', 'heroImage', 'moodRecommendations', 'photoSpots'));
    }

    public function info(): View
    {
        $info = [
            'sejarah' => InfoContent::get('sejarah', 'Kawah Putih adalah tempat wisata...'),
            'lokasi' => InfoContent::get('lokasi', 'Jl. Raya Soreang-Ciwidey...'),
            'jam_operasional' => InfoContent::get('jam_operasional', '07:00 - 17:00'),
            'fasilitas' => InfoContent::get('fasilitas', 'Parkir, Toilet, Warung'),
            'tiket_domestik' => InfoContent::get('tiket_domestik', '30000'),
            'tiket_mancanegara' => InfoContent::get('tiket_mancanegara', '80000'),
            'shuttle_price' => InfoContent::get('shuttle_price', '25000'),
            'parkir_motor' => InfoContent::get('parkir_motor', '5000'),
            'parkir_mobil' => InfoContent::get('parkir_mobil', '20000'),
            'tips_1' => InfoContent::get('tips_1', 'Bawa jaket.'),
            'tips_2' => InfoContent::get('tips_2', 'Gunakan masker.'),
            'tips_3' => InfoContent::get('tips_3', 'Siapkan uang tunai.'),
            'tips_4' => InfoContent::get('tips_4', 'Sepatu nyaman.'),
            'hero_image' => InfoContent::get('hero_image', ''),
            'photo_spots' => json_decode(InfoContent::get('photo_spots', '[]'), true) ?: [],
            'hotels' => json_decode(InfoContent::get('hotels', '[]'), true) ?: [],
            'gallery' => json_decode(InfoContent::get('gallery', '[]'), true) ?: [],
        ];
        
        return view('pengunjung.info', compact('info'));
    }

    public function detail(): View
    {
        return view('pengunjung.detail');
    }

    public function wisata(): View
    {
        $pakets = Paket::where('is_active', true)
                       ->orderBy('kategori')
                       ->orderBy('urutan')
                       ->get();
        $groupedPakets = $pakets->groupBy('kategori');
        return view('pengunjung.wisata', compact('groupedPakets'));
    }

    public function booking(): View
    {
        return view('pengunjung.booking');
    }

    public function prosesPembayaran(Request $request): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('pengunjung.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'nama_pengunjung'   => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'no_hp'             => 'required|string|max:20',
            'tanggal_kunjungan' => 'required|date',
            'jumlah_tiket'      => 'required|integer|min:1',
            'metode_pembayaran' => 'required|in:qris,va,transfer',
            'cart_data'         => 'required|string',
            'bukti_pembayaran'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $cartItems = json_decode($validated['cart_data'], true);

        if (empty($cartItems) || !is_array($cartItems)) {
            return back()->with('error', 'Data keranjang tidak valid.');
        }

        $totalBayar = 0;
        $namaPaketArray = [];
        $detailPaketArray = [];
        
        foreach ($cartItems as $item) {
            $subtotal = ($item['price'] ?? 0) * ($item['qty'] ?? 0);
            $totalBayar += $subtotal;
            $namaPaketArray[] = $item['name'] . ' (x' . $item['qty'] . ')';
            $detailPaketArray[] = [
                'nama' => $item['name'],
                'qty' => $item['qty'],
                'harga' => $item['price'],
                'subtotal' => $subtotal
            ];
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $bookingCode = 'KP-' . date('Ymd') . '-' . strtoupper(substr(md5(time() . rand()), 0, 4));

        Booking::create([
            'user_id'           => Auth::id(),
            'booking_code'      => $bookingCode,
            'nama_lengkap'      => $validated['nama_pengunjung'],
            'email'             => $validated['email'],
            'no_hp'             => $validated['no_hp'],
            'jumlah_pengunjung' => $validated['jumlah_tiket'],
            'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
            'paket'             => json_encode($detailPaketArray, JSON_UNESCAPED_UNICODE),
            'total_bayar'       => $totalBayar,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'bukti_pembayaran'  => $buktiPath,
            'status'            => 'pending',
            'paid_at'           => null,
        ]);

        return redirect()->route('pengunjung.tiket')->with('success', 'Pesanan berhasil diajukan! Kode: ' . $bookingCode);
    }

    public function tiket()
    {
        if (!Auth::check()) {
            return redirect()->route('pengunjung.login')->with('error', 'Silakan login.');
        }

        $userId = Auth::id();
        $bookings = Booking::where('user_id', $userId)->latest()->get();
        
        return view('pengunjung.tiket', compact('bookings'));
    }

    public function checkStatus(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([]);
        }

        $bookings = Booking::where('user_id', Auth::id())
            ->select('id', 'status', 'status_kunjungan')
            ->get()
            ->pluck('status', 'id')
            ->toArray();

        return response()->json($bookings);
    }
}