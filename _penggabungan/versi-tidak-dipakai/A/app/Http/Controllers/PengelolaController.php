<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PengelolaController extends Controller
{
    public function dashboard(): View 
    { 
        // Data statistik untuk kartu KPI
        $stats = [
            'total_hari_ini' => 0, 
            'total_minggu_ini' => 0,
            'total_bulan_ini' => 0,
            'pendapatan' => 0,
            'sudah_verifikasi' => 0,
            'menunggu_verifikasi' => 0,
            'belum_verifikasi' => 0,
            'dibatalkan' => 0,
        ];

        // Data untuk Chart.js (Grafik)
        $chartLabels = json_encode(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']);
        $chartVisitors = json_encode([0, 0, 0, 0, 0, 0, 0]);
        
        return view('pengelola.dashboard', compact('stats', 'chartLabels', 'chartVisitors')); 
    }

    public function operasional(): View { return view('pengelola.operasional'); }

    public function analitik(): View
    {
        $stats = [
            'total' => Reservasi::count(),
            'verified' => Reservasi::where('status', 'approved')->count(),
            'pending' => Reservasi::where('status', 'pending')->count(),
            'today' => Reservasi::whereDate('tanggal', today())->count(),
        ];

        $chartLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $chartVisitors = [12, 18, 15, 22, 27, 19, 24];
        $chartStatus = [
            'approved' => Reservasi::where('status', 'approved')->count(),
            'pending' => Reservasi::where('status', 'pending')->count(),
            'cancelled' => Reservasi::where('status', 'cancelled')->count(),
        ];

        return view('pengelola.analitik', compact('stats', 'chartLabels', 'chartVisitors', 'chartStatus'));
    }

    public function pengaturan(): View { return view('pengelola.pengaturan'); }

    public function reservasi(Request $request): View
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

        return view('pengelola.reservasi', compact('reservasi', 'search'));
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
}