<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard admin
     */
    public function penginapan()
    {
        return view('admin.penginapan');
    }

    public function index()
    {
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'verified' => Booking::where('status', 'verified')->count(),
            'dibatalkan' => Booking::where('status', 'rejected')->count(),
            'pendapatan' => Booking::where('status', 'verified')->sum('total_bayar'),
            'lunas' => Booking::where('status', 'verified')->count(),
            'total_hari_ini' => Booking::whereDate('created_at', today())->count(),
            'sudah_verifikasi' => Booking::where('status', 'verified')->count(),
            'belum_verifikasi' => Booking::where('status', 'pending')->count(),
        ];

        $chartLabels = [];
        $chartData = [];
        $chartRevenue = [];
        $chartVisitors = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->parse($date)->format('d M');
            $chartData[] = Booking::whereDate('created_at', $date)->count();
            $chartRevenue[] = Booking::whereDate('created_at', $date)->sum('total_bayar');
            $chartVisitors[] = Booking::whereDate('created_at', $date)->count();
        }

        $statusCounts = [
            'paid' => Booking::where('status', 'verified')->count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'cancelled' => Booking::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', compact('stats', 'chartLabels', 'chartData', 'chartRevenue', 'chartVisitors', 'statusCounts'));
    }

    public function booking(Request $request)
    {
        $status = $request->query('status', 'pending');
        $allowedStatus = ['all', 'pending', 'verified', 'rejected'];

        if (!in_array($status, $allowedStatus, true)) {
            $status = 'pending';
        }

        $query = Booking::query()->with('wisata');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        $riwayatBookings = Booking::query()
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->with(['wisata', 'verifiedBy'])
            ->orderBy('verified_at', 'desc')
            ->paginate(10);

        return view('admin.booking', compact('bookings', 'riwayatBookings', 'status'));
    }
        /**
     * Dashboard (alias untuk index)
     */
    public function dashboard()
    {
        return $this->index();
    }

    /**
     * Halaman Kelola Wisata
     */
    public function wisata()
    {
        return view('admin.wisata');
    }

    /**
     * Konfirmasi booking
     */
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'rejected_by' => null,
            'rejected_at' => null,
        ]);
        return redirect()->back()->with('success', 'Booking berhasil diverifikasi!');
    }

    /**
     * Cancel booking
     */
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'rejected',
            'rejected_by' => auth()->id(),
            'rejected_at' => now(),
            'verified_by' => null,
            'verified_at' => null,
        ]);
        return redirect()->back()->with('success', 'Booking dibatalkan!');
    }

    /**
     * Verifikasi booking
     */
    public function verifyBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'rejected_by' => null,
            'rejected_at' => null,
        ]);
        return redirect()->back()->with('success', 'Booking berhasil diverifikasi!');
    }

    /**
     * Halaman Pengelola
     */
    public function pengelola()
    {
        $pengelola = User::where('role', 'pengelola')->latest()->get();

        return view('admin.pengelola', compact('pengelola'));
    }

    /**
     * Store pengelola
     */
    public function storePengelola(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'pengelola',
        ]);

        return redirect()->back()->with('success', 'Pengelola berhasil ditambahkan!');
    }

    /**
     * Destroy pengelola
     */
    public function destroyPengelola(User $user)
    {
        if ($user->role !== 'pengelola') {
            abort(403, 'Akun ini bukan pengelola.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Pengelola berhasil dihapus!');
    }
}