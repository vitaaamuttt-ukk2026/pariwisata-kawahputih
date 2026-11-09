<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tiket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TiketController extends Controller
{
    /**
     * Harga paket untuk alur form (Tiket).
     * Sesuaikan nama paket dengan opsi di form-pemesanan.
     */
    private const HARGA_PAKET = [
        'Reguler' => 30000,
        'Premium' => 50000,
    ];

    /**
     * Katalog harga untuk alur booking (Booking).
     * Harga SELALU dihitung di server, tidak dipercaya dari browser.
     */
    private const KATALOG = [
        'paket-lengkap'     => ['name' => 'Paket Lengkap Kawah Putih',      'price' => 65000, 'visitor' => true],
        'tiket-domestik'    => ['name' => 'Tiket Masuk Kawah (Domestik)',   'price' => 30000, 'visitor' => true],
        'tiket-mancanegara' => ['name' => 'Tiket Masuk Kawah (Mancanegara)', 'price' => 80000, 'visitor' => true],
        'shuttle'           => ['name' => 'Shuttle Ontang-Anting (PP)',     'price' => 25000, 'visitor' => false],
        'jembatan'          => ['name' => 'Jembatan Ponton & Skywalk',      'price' => 15000, 'visitor' => false],
        'sunan-ibu'         => ['name' => 'Puncak Sunan Ibu (Sunrise)',     'price' => 10000, 'visitor' => false],
        'parkir-mobil'      => ['name' => 'Parkir Kendaraan (Roda 4)',      'price' => 20000, 'visitor' => false],
    ];

    /* ==========================================================
     |  ALUR FORM (Tiket)
     |========================================================== */

    /** Halaman form pemesanan. */
    public function create(): View
    {
        return view('pengunjung.form-pemesanan');
    }

    /** Simpan pemesanan, buat kode unik, lanjut ke halaman pembayaran. */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_pengunjung'   => ['required', 'string', 'max:255'],
            'no_hp'             => ['required', 'string', 'min:10', 'max:15'],
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today'],
            'paket_wisata'      => ['required', 'in:' . implode(',', array_keys(self::HARGA_PAKET))],
            'jumlah_tiket'      => ['required', 'integer', 'min:1', 'max:50'],
        ]);

        $subtotal = self::HARGA_PAKET[$data['paket_wisata']] * $data['jumlah_tiket'];
        $kodeUnik = random_int(100, 999);

        $tiket = Tiket::create([
            'kode_transaksi'    => $this->kodeTransaksi('TKP'),
            'nama_pengunjung'   => $data['nama_pengunjung'],
            'no_hp'             => $data['no_hp'],
            'tanggal_kunjungan' => $data['tanggal_kunjungan'],
            'paket_wisata'      => $data['paket_wisata'],
            'jumlah_tiket'      => $data['jumlah_tiket'],
            'total_harga'       => $subtotal + $kodeUnik,
            'kode_unik'         => $kodeUnik,
            'status_pembayaran' => 'pending',
        ]);

        return redirect()->route('pembayaran', $tiket->id);
    }

    /** Halaman pembayaran (QRIS + kode unik). */
    public function pembayaran(int $id): View
    {
        $tiket = Tiket::findOrFail($id);

        return view('pengunjung.pembayaran', compact('tiket'));
    }

    /** Riwayat tiket: hanya yang sudah LUNAS, dicari berdasarkan nomor HP. */
    public function riwayat(Request $request): View
    {
        $no_hp = trim((string) $request->input('no_hp'));

        $tikets = $no_hp === ''
            ? collect()
            : Tiket::where('no_hp', $no_hp)
                ->where('status_pembayaran', 'paid')
                ->latest()
                ->get();

        return view('pengunjung.riwayat', compact('tikets', 'no_hp'));
    }

    /* ==========================================================
     |  ALUR BOOKING (Booking, JSON)
     |========================================================== */

    /** Halaman portal pengunjung. */
    public function pengunjung(): View
    {
        return view('pengunjung');
    }

    /** Simpan booking baru (status pending). */
    public function storeBooking(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nama_lengkap'      => ['required', 'string', 'max:255'],
            'no_hp'             => ['required', 'string', 'min:10', 'max:15'],
            'email'             => ['required', 'email', 'max:255'],
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today'],
            'jumlah_pengunjung' => ['required', 'integer', 'min:1', 'max:100'], // diisi sendiri oleh pengunjung
            'items'             => ['required', 'array', 'min:1'],
            'items.*.id'        => ['required', 'string', 'in:' . implode(',', array_keys(self::KATALOG))],
            'items.*.quantity'  => ['required', 'integer', 'min:1', 'max:50'],
        ]);

        // Gabungkan item yang sama, hitung harga dari katalog server.
        $items = [];
        foreach ($data['items'] as $item) {
            $id = $item['id'];
            $items[$id] ??= [
                'id'       => $id,
                'name'     => self::KATALOG[$id]['name'],
                'price'    => self::KATALOG[$id]['price'],
                'quantity' => 0,
            ];
            $items[$id]['quantity'] += (int) $item['quantity'];
        }
        $items = array_values($items);

        $subtotal    = 0;
        $adaTiketMasuk = false;
        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $adaTiketMasuk = $adaTiketMasuk || self::KATALOG[$item['id']]['visitor'];
        }

        if (! $adaTiketMasuk) {
            return response()->json([
                'success' => false,
                'message' => 'Pilih minimal satu tiket masuk atau paket lengkap.',
            ], 422);
        }

        $kodeUnik = random_int(100, 999);

        $booking = Booking::create([
            'booking_code'      => $this->kodeTransaksi('KP'),
            'nama_lengkap'      => $data['nama_lengkap'],
            'no_hp'             => $data['no_hp'],
            'email'             => $data['email'],
            'tanggal_kunjungan' => $data['tanggal_kunjungan'],
            'jumlah_pengunjung' => $data['jumlah_pengunjung'],
            'items'             => $items,                 // pastikan di-cast 'array' pada model Booking
            'total_bayar'       => $subtotal + $kodeUnik,  // sudah termasuk kode unik
            'kode_unik'         => $kodeUnik,
            'metode_pembayaran' => 'QRIS',
            'status'            => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'booking' => $booking,
        ], 201);
    }

    /** Konfirmasi pembayaran (simulasi) -> status menjadi paid. */
    public function confirmPayment(int $id): JsonResponse
    {
        $booking = DB::transaction(function () use ($id) {
            $booking = Booking::lockForUpdate()->findOrFail($id);

            if ($booking->status === 'pending') {
                $booking->update([
                    'status'  => 'paid',
                    'paid_at' => now(),
                ]);
            }

            return $booking;
        });

        if (! $booking->wasChanged('status')) {
            return response()->json([
                'success' => false,
                'message' => 'Booking ini sudah dibayar atau tidak dapat diproses.',
            ], 409);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil!',
            'booking' => $booking,
        ]);
    }

    /** Riwayat tiket (hanya yang sudah lunas) milik nomor HP tertentu. */
    public function history(Request $request): JsonResponse
    {
        $data = $request->validate([
            'no_hp' => ['required', 'string', 'min:10', 'max:15'],
        ]);

        $bookings = Booking::where('status', 'paid')
            ->where('no_hp', $data['no_hp'])
            ->latest()
            ->get();

        return response()->json([
            'success'  => true,
            'bookings' => $bookings,
        ]);
    }

    /* ==========================================================
     |  HELPER
     |========================================================== */

    /** Kode transaksi unik, contoh: KP-20261009-A7K2QX. */
    private function kodeTransaksi(string $prefix): string
    {
        return sprintf('%s-%s-%s', $prefix, now()->format('Ymd'), Str::upper(Str::random(6)));
    }
}