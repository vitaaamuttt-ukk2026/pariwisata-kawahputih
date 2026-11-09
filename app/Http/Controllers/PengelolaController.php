<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\OperasionalSetting;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PengelolaController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'total_hari_ini'     => Booking::whereDate('created_at', today())->count(),
            'sudah_verifikasi'   => Booking::lunas()->count(),
            'belum_verifikasi'   => Booking::where('status', 'pending')->count(),
        ];

        $chartLabels = [];
        $chartVisitors = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartVisitors[] = Booking::whereDate('created_at', $date)->count();
        }

        $recentBookings = Booking::latest()->take(10)->get();

        return view('pengelola.dashboard', compact('stats', 'chartLabels', 'chartVisitors', 'recentBookings'));
    }

    public function reservasi(): View
    {
        $search = request('search', ''); // Menambahkan variabel search agar tidak error
        $reservasi = Booking::latest()->get();
        
        return view('pengelola.reservasi', compact('reservasi', 'search'));
    }

    public function operasional(): View
    {
        $setting = OperasionalSetting::getSetting();
        return view('pengelola.operasional', compact('setting'));
    }

    public function updateOperasional(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'suhu' => 'nullable|string|max:50',
                'kondisi_cuaca' => 'nullable|string|max:100',
                'status_angin' => 'nullable|string|max:100',
                'status_siaran' => 'nullable|string|max:100',
                'kuota_maksimal' => 'nullable|integer|min:0',
                'pengunjung_aktif' => 'nullable|integer|min:0',
                'status_gerbang' => 'nullable|string|max:100',
                'buletin_lapangan' => 'nullable|string',
                'status_dermaga' => 'nullable|string|max:100',
                'info_dermaga' => 'nullable|string',
                'zona_terumbu_karang' => 'nullable|integer|min:0',
                'zona_terumbu_kapasitas' => 'nullable|integer|min:0',
                'zona_mangrove' => 'nullable|integer|min:0',
                'zona_mangrove_kapasitas' => 'nullable|integer|min:0',
            ]);

            $setting = OperasionalSetting::first();
            if (!$setting) {
                OperasionalSetting::create($validated);
            } else {
                $setting->update($validated);
            }

            return back()->with('success', 'Data operasional berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function analitik(): View
    {
        $labels = [];
        $revenueData = [];
        $bookingData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d M');
            $revenueData[] = (int) Booking::whereDate('created_at', $date)->lunas()->sum('total_bayar');
            $bookingData[] = Booking::whereDate('created_at', $date)->count();
        }

        $stats = [
            'total_booking' => Booking::count(),
            'total_pendapatan' => Booking::lunas()->sum('total_bayar'),
            'booking_lunas' => Booking::lunas()->count(),
            'booking_pending' => Booking::where('status', 'pending')->count(),
            'booking_cancel' => Booking::batal()->count(),
            'pengunjung_total' => Booking::lunas()->sum('jumlah_pengunjung'),
        ];

        $topPakets = DB::table('bookings')
            ->whereIn('status', Booking::STATUS_LUNAS)
            ->select('paket', DB::raw('SUM(jumlah_pengunjung) as total'))
            ->groupBy('paket')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('pengelola.analitik', compact('labels', 'revenueData', 'bookingData', 'stats', 'topPakets'));
    }

    public function pengaturan(): View
    {
        $user = Auth::user();
        return view('pengelola.pengaturan', compact('user'));
    }

    public function updatePengaturan(Request $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();

            return back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function verifyReservasi($id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $booking = Booking::where('id', $id)->where('status', 'pending')->firstOrFail();
                $booking->update(['status' => Booking::STATUS_VERIFIED, 'paid_at' => now()]);
            });
            return back()->with('success', 'Reservasi berhasil diverifikasi!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function cancelReservasi($id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $booking = Booking::where('id', $id)->whereIn('status', array_merge(['pending'], Booking::STATUS_LUNAS))->firstOrFail();
                $booking->update(['status' => Booking::STATUS_REJECTED]);
            });
            return back()->with('success', 'Reservasi dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // ------------------------------------------------------------------
    // [dari A] Reservasi manual (tabel `reservasis`): daftar + pencarian + paginasi,
    // tambah, hapus. Menggantikan storeReservasi/destroyReservasi milik B yang
    // hanya stub (store tidak menyimpan; destroy akan error karena $reservasi string).
    // Halaman daftar kini di /pengelola/reservasi-manual (rute: pengelola.reservasi.manual)
    // karena /pengelola/reservasi dipakai halaman monitor booking online milik B.
    // ------------------------------------------------------------------
    public function reservasiManual(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $query = Reservasi::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%");
            });
        }

        $reservasi = $query->latest()->paginate(10)->appends(['search' => $search]);

        return view('pengelola.reservasi-manual', compact('reservasi', 'search'));
    }

    public function storeReservasi(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'jumlah_pax' => 'required|integer|min:1',
            'tanggal' => 'required|date',
        ]);

        Reservasi::create([
            'nama_tamu' => $request->nama_tamu,
            'jumlah_pax' => $request->jumlah_pax,
            'status' => 'Menunggu',
            'tanggal' => $request->tanggal,
        ]);

        return back()->with('success', 'Data reservasi berhasil ditambahkan!');
    }

    public function destroyReservasi(Reservasi $reservasi): RedirectResponse
    {
        $reservasi->delete();
        return back()->with('success', 'Data reservasi berhasil dihapus!');
    }

    public function cekKode(): View
    {
        return view('pengelola.cek-kode');
    }

    public function tandaiDipakai($id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status_kunjungan' => 'sedang']);
        return back()->with('success', 'Tiket sedang digunakan.');
    }

    public function tandaiSelesai($id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status_kunjungan' => 'selesai']);
        return back()->with('success', 'Kunjungan selesai.');
    }

    public function tandaiSedang($id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status_kunjungan' => 'sedang']);
        return back()->with('success', 'Kunjungan sedang berlangsung.');
    }
}