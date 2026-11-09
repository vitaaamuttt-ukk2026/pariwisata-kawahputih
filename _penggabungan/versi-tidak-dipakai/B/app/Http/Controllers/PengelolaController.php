<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\OperasionalSetting;
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
            'sudah_verifikasi'   => Booking::where('status', 'paid')->count(),
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
            $revenueData[] = (int) Booking::whereDate('created_at', $date)->where('status', 'paid')->sum('total_bayar');
            $bookingData[] = Booking::whereDate('created_at', $date)->count();
        }

        $stats = [
            'total_booking' => Booking::count(),
            'total_pendapatan' => Booking::where('status', 'paid')->sum('total_bayar'),
            'booking_lunas' => Booking::where('status', 'paid')->count(),
            'booking_pending' => Booking::where('status', 'pending')->count(),
            'booking_cancel' => Booking::where('status', 'cancelled')->count(),
            'pengunjung_total' => Booking::where('status', 'paid')->sum('jumlah_pengunjung'),
        ];

        $topPakets = DB::table('bookings')
            ->where('status', 'paid')
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
                $booking->update(['status' => 'paid', 'paid_at' => now()]);
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
                $booking = Booking::where('id', $id)->whereIn('status', ['pending', 'paid'])->firstOrFail();
                $booking->update(['status' => 'cancelled']);
            });
            return back()->with('success', 'Reservasi dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function storeReservasi(Request $request): RedirectResponse
    {
        return back()->with('success', 'Reservasi ditambahkan!');
    }

    public function destroyReservasi($reservasi): RedirectResponse
    {
        $reservasi->delete();
        return back()->with('success', 'Reservasi dihapus.');
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