<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('status', 'pending')
            ->with('wisata')
            ->orderBy('created_at', 'desc')
            ->get();

        $riwayatBookings = Booking::where('status', 'verified')
            ->with(['wisata', 'verifiedBy'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.booking', compact('bookings', 'riwayatBookings'));
    }

    public function verify($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'verified',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
            'paid_at' => now(),
            'rejected_by' => null,
            'rejected_at' => null,
        ]);
        return redirect()->back()->with('success', 'Booking berhasil diverifikasi!');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'verified_by' => null,
            'verified_at' => null,
        ]);
        return redirect()->back()->with('success', 'Booking berhasil ditolak!');
    }

    public function detail($id)
    {
        $booking = Booking::with(['wisata', 'verifiedBy'])->findOrFail($id);

        return response()->json([
            'booking_code' => $booking->booking_code,
            'visitor_name' => $booking->nama_lengkap,
            'phone' => $booking->no_hp,
            'email' => $booking->email,
            'wisata' => $booking->wisata->nama ?? '-',
            'booking_date' => \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d M Y'),
            'quantity' => $booking->jumlah_pengunjung,
            'total_price' => $booking->total_bayar,
            'status' => $booking->status,
        ]);
    }

    public function cetak($id)
    {
        $booking = Booking::with(['wisata', 'verifiedBy'])->findOrFail($id);
        return view('admin.booking.cetak', compact('booking'));
    }

    public function export()
    {
        $bookings = Booking::where('status', 'verified')
            ->with(['wisata', 'verifiedBy'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $filename = 'riwayat_booking_' . date('Y-m-d_His') . '.csv';

        return response()->stream(function () use ($bookings) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No. Booking', 'Nama', 'Telepon', 'Wisata', 'Tgl Kunjungan', 'Jumlah', 'Total', 'Status']);

            foreach ($bookings as $booking) {
                fputcsv($handle, [
                    $booking->booking_code,
                    $booking->nama_lengkap,
                    $booking->no_hp ?? '-',
                    $booking->wisata->nama ?? '-',
                    $booking->tanggal_kunjungan,
                    $booking->jumlah_pengunjung,
                    $booking->total_bayar,
                    $booking->status,
                ]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}