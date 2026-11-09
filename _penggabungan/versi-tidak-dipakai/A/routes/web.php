<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengelolaController;
use App\Http\Controllers\PanelAuthController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\AdminController;

// ==========================================
// 1. FALLBACK LOGIN
// ==========================================
Route::get('/login', function () {
    if (Auth::check()) {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'pengelola' => redirect()->route('pengelola.dashboard'),
            'pengunjung' => redirect()->route('pengunjung.dashboard'),
            default => redirect()->route('pengunjung.login'),
        };
    }

    return redirect()->route('pengunjung.login');
})->name('login');

// ==========================================
// 2. ROUTE PENGUNJUNG (PUBLIK)
// ==========================================
// Dashboard hanya bisa dibuka setelah login
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return app(PengunjungController::class)->index();
})->name('pengunjung.dashboard');

Route::get('/login-pengunjung', function () {
    return view('auth.login-pengunjung');
})->name('pengunjung.login');

Route::post('/login-pengunjung', [\App\Http\Controllers\PengunjungController::class, 'prosesLogin'])->name('pengunjung.login.post');
Route::post('/logout-pengunjung', [\App\Http\Controllers\PengunjungController::class, 'prosesLogout'])->name('pengunjung.logout');
Route::get('/info', [PengunjungController::class, 'info'])->name('pengunjung.info');
Route::get('/wisata', [PengunjungController::class, 'wisata'])->name('pengunjung.wisata');
Route::get('/penginapan', [PengunjungController::class, 'penginapan'])->name('pengunjung.penginapan');
Route::get('/booking', [PengunjungController::class, 'booking'])->name('pengunjung.booking');
Route::get('/pembayaran', [PengunjungController::class, 'pembayaran'])->name('pengunjung.pembayaran');
Route::post('/pembayaran/proses', [PengunjungController::class, 'prosesPembayaran'])->name('pengunjung.pembayaran.proses');
Route::get('/tiket', [PengunjungController::class, 'statusTiket'])->name('pengunjung.tiket');
Route::get('/status-tiket', [PengunjungController::class, 'statusTiket'])->name('pengunjung.status');

// ==========================================
// 3. ROUTE LOGIN PANEL (ADMIN & PENGELOLA)
// ==========================================
Route::get('/{role}/login', [PanelAuthController::class, 'showLogin'])
    ->whereIn('role', ['admin', 'pengelola'])
    ->name('panel.login');

Route::post('/{role}/login', [PanelAuthController::class, 'login'])
    ->whereIn('role', ['admin', 'pengelola'])
    ->middleware('throttle:5,1')
    ->name('panel.login.post');

Route::post('/logout', [PanelAuthController::class, 'logout'])->name('panel.logout');

// ==========================================
// 4. ROUTE KHUSUS ADMIN
// ==========================================
Route::middleware(['auth', 'admin:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/wisata', [AdminController::class, 'wisata'])->name('wisata');
    Route::get('/penginapan', [AdminController::class, 'penginapan'])->name('penginapan');
    Route::get('/booking', [AdminController::class, 'booking'])->name('booking');
    
    Route::post('/booking/{booking}/confirm', [AdminController::class, 'confirm'])->name('booking.confirm');
    Route::post('/booking/{booking}/cancel', [AdminController::class, 'cancel'])->name('booking.cancel');
    Route::post('/bookings/{booking}/verify', [AdminController::class, 'verifyBooking'])->name('bookings.verify');
    Route::get('/pengelola', [AdminController::class, 'pengelola'])->name('pengelola');
    Route::post('/pengelola', [AdminController::class, 'storePengelola'])->name('pengelola.store');
    Route::delete('/pengelola/{user}', [AdminController::class, 'destroyPengelola'])->name('pengelola.destroy');

    // Route Booking Controller Tambahan
    Route::get('/booking/riwayat', [BookingController::class, 'riwayat'])->name('booking.riwayat');
    Route::get('/booking/{id}/detail', [BookingController::class, 'detail'])->name('booking.detail');
    Route::get('/booking/{id}/cetak', [BookingController::class, 'cetak'])->name('booking.cetak');
    Route::get('/booking/riwayat/export', [BookingController::class, 'export'])->name('booking.riwayat.export');
    Route::patch('/booking/{id}/verify', [BookingController::class, 'verify'])->name('booking.verify');
    Route::patch('/booking/{id}/reject', [BookingController::class, 'reject'])->name('booking.reject');
});

// ==========================================
// 5. ROUTE KHUSUS PENGELOLA (SUDAH DIBERSIHKAN DARI DUPLIKAT)
// ==========================================
Route::middleware(['auth', 'admin:pengelola'])->prefix('pengelola')->name('pengelola.')->group(function () {
    Route::get('/', [PengelolaController::class, 'dashboard'])->name('dashboard');
    Route::get('/reservasi', [PengelolaController::class, 'reservasi'])->name('reservasi');
    Route::get('/operasional', [PengelolaController::class, 'operasional'])->name('operasional');
    Route::get('/analitik', [PengelolaController::class, 'analitik'])->name('analitik');
    Route::get('/pengaturan', [PengelolaController::class, 'pengaturan'])->name('pengaturan');
    
    Route::post('/reservasi', [PengelolaController::class, 'storeReservasi'])->name('reservasi.store');
    Route::delete('/reservasi/{reservasi}', [PengelolaController::class, 'destroyReservasi'])->name('reservasi.destroy');
});

Route::get('/403-test', function () {
    abort(403, 'Forbidden');
});

Route::get('/500-test', function () {
    throw new \RuntimeException('Simulated server error for testing the branded 500 page.');
});