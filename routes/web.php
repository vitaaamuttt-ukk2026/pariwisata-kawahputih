<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminController as AdminBookingController;   // [A] Admin\AdminController
use App\Http\Controllers\Admin\BookingController;                           // [A]
use App\Http\Controllers\PengelolaController;
use App\Http\Controllers\PanelAuthController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PengunjungAuthController;
use App\Models\OperasionalSetting;

/*
| ROUTES GABUNGAN proyek A + proyek B. Label [A]/[B] = asal rute.
| Rute yang bentrok (URL atau nama sama) dijelaskan di komentar "BENTROK".
*/

// ==========================================
// 1. FALLBACK LOGIN [A]
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
// 2. PENGUNJUNG - PUBLIK
// ==========================================
// [A] BENTROK "/" : A mewajibkan login, B publik. Dipakai perilaku A (ada tes & laporan A).
// Untuk membuka "/" bagi tamu (perilaku B) hapus pengecekan Auth::check() di bawah.
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return app(PengunjungController::class)->dashboard();
})->name('pengunjung.dashboard');

Route::get('/info', [PengunjungController::class, 'info'])->name('pengunjung.info');                 // A & B
Route::get('/detail', [PengunjungController::class, 'detail'])->name('pengunjung.detail');           // B
Route::get('/penginapan', [PengunjungController::class, 'penginapan'])->name('pengunjung.penginapan'); // A
Route::get('/pembayaran', [PengunjungController::class, 'pembayaran'])->name('pengunjung.pembayaran'); // A

Route::get('/api/operasional', function () {                                                          // B
    return response()->json(OperasionalSetting::getSetting());
})->name('api.operasional');

// ==========================================
// 3. AUTH PENGUNJUNG
// ==========================================
// [B] login / register / logout
Route::middleware('guest')->group(function () {
    Route::get('/pengunjung/login', [PengunjungAuthController::class, 'showLogin'])->name('pengunjung.login');
    Route::post('/pengunjung/login', [PengunjungAuthController::class, 'login']);
    Route::get('/pengunjung/register', [PengunjungAuthController::class, 'showRegister'])->name('pengunjung.register');
    Route::post('/pengunjung/register', [PengunjungAuthController::class, 'register']);
});
Route::post('/pengunjung/logout', [PengunjungAuthController::class, 'logout'])->name('pengunjung.logout');

// [A] halaman login pengunjung versi A tetap tersedia di /login-pengunjung.
// BENTROK NAMA: A memakai 'pengunjung.login' & 'pengunjung.logout' (dipakai B untuk rute di atas),
// maka rute A diganti nama menjadi '*.a'. 'pengunjung.login.post' tetap (dipakai view auth/login-pengunjung).
Route::get('/login-pengunjung', function () {
    return view('auth.login-pengunjung');
})->name('pengunjung.login.a');
Route::post('/login-pengunjung', [PengunjungController::class, 'prosesLogin'])->name('pengunjung.login.post');
Route::post('/logout-pengunjung', [PengunjungController::class, 'prosesLogout'])->name('pengunjung.logout.a');

// ==========================================
// 4. PENGUNJUNG - WAJIB LOGIN [B] (+ /status-tiket dari A)
// ==========================================
Route::middleware(['auth.pengunjung'])->group(function () {
    Route::get('/wisata', [PengunjungController::class, 'wisata'])->name('pengunjung.wisata');
    Route::get('/booking', [PengunjungController::class, 'booking'])->name('pengunjung.booking');
    Route::post('/pembayaran/proses', [PengunjungController::class, 'prosesPembayaran'])->name('pengunjung.pembayaran.proses');
    Route::get('/tiket', [PengunjungController::class, 'tiket'])->name('pengunjung.tiket');
    Route::get('/status-tiket', [PengunjungController::class, 'statusTiket'])->name('pengunjung.status'); // A
    Route::get('/api/check-status', [PengunjungController::class, 'checkStatus'])->name('api.check-status');
});

// ==========================================
// 5. LOGIN PANEL (ADMIN & PENGELOLA)  [A & B identik]
// ==========================================
Route::get('/{role}/login', [PanelAuthController::class, 'showLogin'])
    ->whereIn('role', ['admin', 'pengelola'])
    ->name('panel.login');

Route::post('/{role}/login', [PanelAuthController::class, 'login'])
    ->whereIn('role', ['admin', 'pengelola'])
    ->middleware('throttle:5,1')
    ->name('panel.login.post');

// BENTROK URL: A '/logout', B '/panel/logout' (nama sama 'panel.logout'). Dipakai B.
Route::post('/panel/logout', [PanelAuthController::class, 'logout'])->name('panel.logout');

// ==========================================
// 6. KHUSUS ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');          // B
    Route::get('/wisata', [AdminController::class, 'wisata'])->name('wisata');
    Route::get('/penginapan', [AdminController::class, 'penginapan'])->name('penginapan');

    // ---- Booking: halaman, verifikasi, tolak [A] ----
    Route::get('/booking', [AdminBookingController::class, 'booking'])->name('booking');
    Route::post('/booking/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('booking.confirm');
    // BENTROK: A & B sama-sama punya POST /booking/{id}/cancel bernama 'booking.cancel'. Dipakai A
    // (view admin/booking A memakainya). AdminController::cancelBooking (B) tetap ada tetapi tidak dirutekan.
    Route::post('/booking/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('booking.cancel');
    Route::post('/bookings/{booking}/verify', [AdminBookingController::class, 'verifyBooking'])->name('bookings.verify');
    // [B] tetap disediakan agar view admin/booking milik B bisa dipulihkan
    Route::post('/booking/{id}/verify', [AdminController::class, 'verifyBooking'])->name('booking.verify');

    // [A] riwayat, detail, cetak, export, verify/reject (PATCH)
    Route::get('/booking/riwayat', [BookingController::class, 'riwayat'])->name('booking.riwayat');
    Route::get('/booking/{id}/detail', [BookingController::class, 'detail'])->name('booking.detail');
    Route::get('/booking/{id}/cetak', [BookingController::class, 'cetak'])->name('booking.cetak');
    Route::get('/booking/riwayat/export', [BookingController::class, 'export'])->name('booking.riwayat.export');
    // BENTROK NAMA: PATCH verify memakai nama 'booking.verify' milik rute B di atas -> diganti 'booking.verify.patch'
    Route::patch('/booking/{id}/verify', [BookingController::class, 'verify'])->name('booking.verify.patch');
    Route::patch('/booking/{id}/reject', [BookingController::class, 'reject'])->name('booking.reject');

    // ---- Pengelola (akun) [B: ada update] ----
    Route::get('/pengelola', [AdminController::class, 'pengelola'])->name('pengelola');
    Route::post('/pengelola', [AdminController::class, 'storePengelola'])->name('pengelola.store');
    Route::delete('/pengelola/{user}', [AdminController::class, 'destroyPengelola'])->name('pengelola.destroy');
    Route::put('/pengelola/{user}', [AdminController::class, 'updatePengelola'])->name('pengelola.update');

    // ---- [B] CRUD Paket Wisata ----
    Route::get('/paket', [AdminController::class, 'paketIndex'])->name('paket.index');
    Route::get('/paket/create', [AdminController::class, 'paketCreate'])->name('paket.create');
    Route::post('/paket', [AdminController::class, 'paketStore'])->name('paket.store');
    Route::get('/paket/{id}/edit', [AdminController::class, 'paketEdit'])->name('paket.edit');
    Route::put('/paket/{id}', [AdminController::class, 'paketUpdate'])->name('paket.update');
    Route::delete('/paket/{id}', [AdminController::class, 'paketDestroy'])->name('paket.destroy');

    // ---- [B] Edit Informasi (/info) ----
    Route::get('/info/edit', [AdminController::class, 'editInfo'])->name('info.edit');
    Route::post('/info/update', [AdminController::class, 'updateInfo'])->name('info.update');

    // ---- [B] Edit Dashboard (/) ----
    Route::get('/dashboard/edit', [AdminController::class, 'editDashboard'])->name('dashboard.edit');
    Route::post('/dashboard/hero', [AdminController::class, 'updateDashboardHero'])->name('dashboard.updateHero');
    Route::post('/dashboard/photo-spot', [AdminController::class, 'addDashboardPhotoSpot'])->name('dashboard.addPhotoSpot');
    Route::post('/dashboard/photo-spot/{index}/delete', [AdminController::class, 'deleteDashboardPhotoSpot'])->name('dashboard.deletePhotoSpot');
    Route::post('/dashboard/hotel', [AdminController::class, 'addDashboardHotel'])->name('dashboard.addHotel');
    Route::post('/dashboard/hotel/{index}/delete', [AdminController::class, 'deleteDashboardHotel'])->name('dashboard.deleteHotel');
    Route::post('/dashboard/gallery', [AdminController::class, 'addDashboardGallery'])->name('dashboard.addGallery');
    Route::post('/dashboard/gallery/{index}/delete', [AdminController::class, 'deleteDashboardGallery'])->name('dashboard.deleteGallery');

    // [B] Test Upload Sederhana (dipertahankan apa adanya)
    Route::get('/test-upload', function() {
        return view('admin.test-upload');
    })->name('admin.test-upload');

    Route::post('/test-upload', function(\Illuminate\Http\Request $request) {
        if (!$request->hasFile('foto')) {
            return back()->with('error', 'File tidak terkirim. Cek enctype form!');
        }

        $file = $request->file('foto');
        $nama = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('hero'), $nama);

        return back()->with('success', 'Berhasil! File: ' . $nama);
    })->name('admin.test-upload.post');

    // [B] Manage Harga & Tips (dinamis)
    Route::get('/prices', [AdminController::class, 'managePrices'])->name('prices');
    Route::post('/prices', [AdminController::class, 'addPrice'])->name('prices.add');
    Route::post('/prices/{id}', [AdminController::class, 'updatePrice'])->name('prices.update');
    Route::post('/prices/{id}/delete', [AdminController::class, 'deletePrice'])->name('prices.delete');

    Route::get('/tips', [AdminController::class, 'manageTips'])->name('tips');
    Route::post('/tips', [AdminController::class, 'addTip'])->name('tips.add');
    Route::post('/tips/{id}', [AdminController::class, 'updateTip'])->name('tips.update');
    Route::post('/tips/{id}/delete', [AdminController::class, 'deleteTip'])->name('tips.delete');
});

// ==========================================
// 7. KHUSUS PENGELOLA
// ==========================================
Route::middleware(['auth', 'role:pengelola'])->prefix('pengelola')->name('pengelola.')->group(function () {
    Route::get('/', [PengelolaController::class, 'dashboard'])->name('dashboard');
    Route::get('/reservasi', [PengelolaController::class, 'reservasi'])->name('reservasi');                 // B (monitor booking online)
    Route::get('/reservasi-manual', [PengelolaController::class, 'reservasiManual'])->name('reservasi.manual'); // A (tabel reservasis) - URL baru
    Route::get('/operasional', [PengelolaController::class, 'operasional'])->name('operasional');
    Route::post('/operasional/update', [PengelolaController::class, 'updateOperasional'])->name('operasional.update');
    Route::get('/analitik', [PengelolaController::class, 'analitik'])->name('analitik');
    Route::get('/pengaturan', [PengelolaController::class, 'pengaturan'])->name('pengaturan');
    Route::post('/pengaturan', [PengelolaController::class, 'updatePengaturan'])->name('pengaturan.update');
    Route::post('/reservasi/{id}/verify', [PengelolaController::class, 'verifyReservasi'])->name('reservasi.verify');
    Route::post('/reservasi/{id}/cancel', [PengelolaController::class, 'cancelReservasi'])->name('reservasi.cancel');
    Route::post('/reservasi', [PengelolaController::class, 'storeReservasi'])->name('reservasi.store');      // handler = versi A (B hanya stub)
    Route::delete('/reservasi/{reservasi}', [PengelolaController::class, 'destroyReservasi'])->name('reservasi.destroy'); // handler = versi A
    Route::get('/cek-kode', [PengelolaController::class, 'cekKode'])->name('cek.kode');
    Route::post('/reservasi/{id}/pakai', [PengelolaController::class, 'tandaiDipakai'])->name('reservasi.pakai');
    Route::post('/reservasi/{id}/selesai', [PengelolaController::class, 'tandaiSelesai'])->name('reservasi.selesai');
    Route::post('/reservasi/{id}/sedang', [PengelolaController::class, 'tandaiSedang'])->name('reservasi.sedang');
});

// [A] rute uji halaman error
Route::get('/403-test', function () {
    abort(403, 'Forbidden');
});

Route::get('/500-test', function () {
    throw new \RuntimeException('Simulated server error for testing the branded 500 page.');
});
