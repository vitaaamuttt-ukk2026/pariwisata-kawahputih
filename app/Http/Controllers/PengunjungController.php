<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\InfoContent;
use App\Models\OperasionalSetting;
use App\Models\Order;
use App\Models\Paket;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * CONTROLLER GABUNGAN (A + B).
 * Setiap method diberi label asalnya. Method yang ada di kedua proyek
 * (dashboard, tiket, prosesPembayaran) digabung menjadi satu versi yang
 * melayani tampilan tema A maupun tema B.
 */
class PengunjungController extends Controller
{
    // ========================================
    // HALAMAN PENGUNJUNG
    // ========================================

    /** [B] data dinamis CMS + operasional; [A] $orders hanya diisi bila tema A aktif */
    public function dashboard()
    {
        $setting = OperasionalSetting::getSetting();

        $heroImage = InfoContent::get('hero_image', '');
        $photoSpots = json_decode(InfoContent::get('photo_spots', '[]'), true) ?: [];
        $moodRecommendations = json_decode(InfoContent::get('mood_recommendations', '[]'), true) ?: [];

        if (empty($moodRecommendations)) {
            $moodRecommendations = [
                ['title' => 'Santai', 'subtitle' => 'Tenang & Sejuk', 'icon' => '🌴', 'color' => 'bg-emerald-50'],
                ['title' => 'Petualangan', 'subtitle' => 'Trekking & Sunrise', 'icon' => '🥾', 'color' => 'bg-orange-50'],
                ['title' => 'Romantis', 'subtitle' => 'Spot Foto Pasangan', 'icon' => '💕', 'color' => 'bg-pink-50'],
                ['title' => 'Keluarga', 'subtitle' => 'Aman untuk Anak', 'icon' => '👨‍👩‍👧', 'color' => 'bg-blue-50'],
            ];
        }

        // [A] dashboard tema A membutuhkan $orders (tiket QR). Tidak dihitung di tema B.
        $orders = config('portal.visitor_theme') === 'a'
            ? Order::where('user_id', auth()->id())->latest()->get()
            : collect();

        return view('pengunjung.dashboard', compact('setting', 'heroImage', 'moodRecommendations', 'photoSpots', 'orders'));
    }

    /** [A] nama method lama, dipertahankan sebagai alias */
    public function index()
    {
        return $this->dashboard();
    }

    /** [B] */
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

    /** [B] */
    public function detail(): View
    {
        return view('pengunjung.detail');
    }

    /** [B] paket dari database */
    public function wisata(): View
    {
        $pakets = Paket::where('is_active', true)
                       ->orderBy('kategori')
                       ->orderBy('urutan')
                       ->get();
        $groupedPakets = $pakets->groupBy('kategori');
        return view('pengunjung.wisata', compact('groupedPakets'));
    }

    /** [A] */
    public function penginapan()
    {
        return view('pengunjung.penginapan');
    }

    /** [A & B] */
    public function booking()
    {
        return view('pengunjung.booking');
    }

    /** [A] */
    public function pembayaran()
    {
        return view('pengunjung.pembayaran');
    }

    /**
     * [A + B digabung]
     * - Validasi: gabungan aturan (B: bukti wajib, keranjang wajib & valid;
     *   A: tanggal tidak boleh lampau, no HP min 10 digit, jumlah tiket maks 100)
     * - Menyimpan: user_id (B), items JSON (A), paket berupa teks ringkas "Nama (xQty)"
     *   (terbaca di tema A maupun B), kode booking gaya A, bukti disimpan gaya B
     *   (path relatif disk public, agar terbaca halaman admin A).
     */
    public function prosesPembayaran(Request $request): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('pengunjung.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'nama_pengunjung'   => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255'],
            'no_hp'             => ['required', 'string', 'min:10', 'max:20'],
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today'],
            'jumlah_tiket'      => ['required', 'integer', 'min:1', 'max:100'],
            'metode_pembayaran' => ['required', 'in:qris,va,transfer'],
            'cart_data'         => ['nullable', 'string'],
            'bukti_pembayaran'  => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $cartItems = json_decode($validated['cart_data'] ?? '', true);

        if (!is_array($cartItems) || $cartItems === []) {
            return back()
                ->withErrors(['cart_data' => 'Keranjang kosong atau tidak valid. Silakan pilih paket wisata kembali.'])
                ->withInput();
        }

        $totalBayar = 0;
        $namaPaketArray = [];
        $items = [];
        $totalQty = 0;

        foreach ($cartItems as $item) {
            if (!is_array($item)) {
                return back()
                    ->withErrors(['cart_data' => 'Isi keranjang tidak valid. Silakan pilih paket wisata kembali.'])
                    ->withInput();
            }

            $qty = filter_var($item['qty'] ?? $item['quantity'] ?? null, FILTER_VALIDATE_INT);
            $price = filter_var($item['price'] ?? null, FILTER_VALIDATE_FLOAT);
            $name = $item['name'] ?? null;

            if ($qty === false || $qty < 1 || $price === false || $price < 0 || !is_string($name) || trim($name) === '') {
                return back()
                    ->withErrors(['cart_data' => 'Rincian paket tidak valid. Silakan pilih paket wisata kembali.'])
                    ->withInput();
            }
            $name = trim($name);

            $totalBayar += $qty * $price;
            $totalQty += $qty;
            $namaPaketArray[] = $name . ' (x' . $qty . ')';
            $items[] = ['name' => $name, 'qty' => $qty, 'price' => $price, 'subtotal' => $qty * $price];
        }

        if ($totalQty > 100) {
            return back()
                ->withErrors(['cart_data' => 'Jumlah tiket maksimal 100 orang per booking.'])
                ->withInput();
        }

        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $bookingCode = 'KP-' . date('YmdHis') . '-' . random_int(100, 999);

        Booking::create([
            'user_id'           => Auth::id(),
            'booking_code'      => $bookingCode,
            'nama_lengkap'      => $validated['nama_pengunjung'],
            'email'             => $validated['email'],
            'no_hp'             => $validated['no_hp'],
            'jumlah_pengunjung' => $totalQty,
            'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
            'paket'             => implode(', ', $namaPaketArray),
            'items'             => $items,
            'total_bayar'       => $totalBayar,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'bukti_pembayaran'  => $buktiPath,
            'status'            => Booking::STATUS_PENDING,
            'paid_at'           => null,
        ]);

        return redirect()->route('pengunjung.tiket')->with('success', 'Pesanan berhasil diajukan! Kode: ' . $bookingCode);
    }

    /**
     * [B + A digabung] Tiket milik user: cocok lewat user_id (B) ATAU email (A),
     * sehingga booking lama yang dibuat tanpa user_id tetap tampil.
     */
    public function tiket()
    {
        if (!Auth::check()) {
            return redirect()->route('pengunjung.login')->with('error', 'Silakan login.');
        }

        $user = Auth::user();
        $bookings = Booking::where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhere('email', $user->email);
            })
            ->latest()
            ->get();

        return view('pengunjung.tiket', compact('bookings'));
    }

    /** [A] nama method lama, dipertahankan sebagai alias */
    public function statusTiket()
    {
        return $this->tiket();
    }

    /** [B] */
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

    // ========================================
    // LOGIN / LOGOUT PENGUNJUNG VERSI A (dipertahankan, halaman /login-pengunjung)
    // ========================================

    /** [A] */
    public function prosesLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        }

        if ($user->role !== 'pengunjung') {
            return back()->withErrors([
                'email' => 'Akun ini bukan akun pengunjung. Silakan login melalui halaman yang sesuai.'
            ])->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('pengunjung.dashboard');
    }

    /** [A] */
    public function prosesLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pengunjung.login');
    }
}
