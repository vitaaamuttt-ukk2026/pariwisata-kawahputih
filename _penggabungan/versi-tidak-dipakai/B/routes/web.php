<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengelolaController;
use App\Http\Controllers\PanelAuthController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PengunjungAuthController;
use App\Models\OperasionalSetting;

// ==========================================
// 1. FALLBACK LOGIN
// ==========================================
Route::get('/login', function () {
    return redirect()->route('panel.login', ['role' => 'admin']);
})->name('login');

// ==========================================
// 2. ROUTE PENGUNJUNG (PUBLIK)
// ==========================================
Route::get('/', [PengunjungController::class, 'dashboard'])->name('pengunjung.dashboard');
Route::get('/info', [PengunjungController::class, 'info'])->name('pengunjung.info');
Route::get('/detail', [PengunjungController::class, 'detail'])->name('pengunjung.detail');

Route::get('/api/operasional', function() {
    return response()->json(OperasionalSetting::getSetting());
})->name('api.operasional');

// ==========================================
// 3. ROUTE AUTH PENGUNJUNG (LOGIN/REGISTER)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/pengunjung/login', [PengunjungAuthController::class, 'showLogin'])->name('pengunjung.login');
    Route::post('/pengunjung/login', [PengunjungAuthController::class, 'login']);
    Route::get('/pengunjung/register', [PengunjungAuthController::class, 'showRegister'])->name('pengunjung.register');
    Route::post('/pengunjung/register', [PengunjungAuthController::class, 'register']);
});
Route::post('/pengunjung/logout', [PengunjungAuthController::class, 'logout'])->name('pengunjung.logout');

// ==========================================
// 4. ROUTE PENGUNJUNG (PRIVAT - WAJIB LOGIN)
// ==========================================
Route::middleware(['auth.pengunjung'])->group(function () {
    Route::get('/wisata', [PengunjungController::class, 'wisata'])->name('pengunjung.wisata');
    Route::get('/booking', [PengunjungController::class, 'booking'])->name('pengunjung.booking');
    Route::post('/pembayaran/proses', [PengunjungController::class, 'prosesPembayaran'])->name('pengunjung.pembayaran.proses');
    Route::get('/tiket', [PengunjungController::class, 'tiket'])->name('pengunjung.tiket');
    Route::get('/api/check-status', [PengunjungController::class, 'checkStatus'])->name('api.check-status');
});

// ==========================================
// 5. ROUTE LOGIN PANEL (Admin & Pengelola)
// ==========================================
Route::get('/{role}/login', [PanelAuthController::class, 'showLogin'])
    ->whereIn('role', ['admin', 'pengelola'])
    ->name('panel.login');

Route::post('/{role}/login', [PanelAuthController::class, 'login'])
    ->whereIn('role', ['admin', 'pengelola'])
    ->middleware('throttle:5,1')
    ->name('panel.login.post');

Route::post('/panel/logout', [PanelAuthController::class, 'logout'])->name('panel.logout');

// ==========================================
// 6. ROUTE KHUSUS ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/wisata', [AdminController::class, 'wisata'])->name('wisata');
    Route::get('/penginapan', [AdminController::class, 'penginapan'])->name('penginapan');
    Route::get('/booking', [AdminController::class, 'booking'])->name('booking');
    
    Route::post('/booking/{id}/verify', [AdminController::class, 'verifyBooking'])->name('booking.verify');
    Route::post('/booking/{id}/cancel', [AdminController::class, 'cancelBooking'])->name('booking.cancel');
    
    Route::get('/pengelola', [AdminController::class, 'pengelola'])->name('pengelola');
    Route::post('/pengelola', [AdminController::class, 'storePengelola'])->name('pengelola.store');
    Route::delete('/pengelola/{user}', [AdminController::class, 'destroyPengelola'])->name('pengelola.destroy');
    Route::put('/pengelola/{user}', [AdminController::class, 'updatePengelola'])->name('pengelola.update');
    
    // CRUD Paket Wisata
    Route::get('/paket', [AdminController::class, 'paketIndex'])->name('paket.index');
    Route::get('/paket/create', [AdminController::class, 'paketCreate'])->name('paket.create');
    Route::post('/paket', [AdminController::class, 'paketStore'])->name('paket.store');
    Route::get('/paket/{id}/edit', [AdminController::class, 'paketEdit'])->name('paket.edit');
    Route::put('/paket/{id}', [AdminController::class, 'paketUpdate'])->name('paket.update');
    Route::delete('/paket/{id}', [AdminController::class, 'paketDestroy'])->name('paket.destroy');
    
    // ==========================================
    // A. EDIT INFORMASI (KHUSUS HALAMAN /info)
    // ==========================================
    Route::get('/info/edit', [AdminController::class, 'editInfo'])->name('info.edit');
    Route::post('/info/update', [AdminController::class, 'updateInfo'])->name('info.update');
    
    // ==========================================
    // B. EDIT DASHBOARD (KHUSUS HALAMAN UTAMA /)
    // ==========================================
    Route::get('/dashboard/edit', [AdminController::class, 'editDashboard'])->name('dashboard.edit');
    Route::post('/dashboard/hero', [AdminController::class, 'updateDashboardHero'])->name('dashboard.updateHero');
    Route::post('/dashboard/photo-spot', [AdminController::class, 'addDashboardPhotoSpot'])->name('dashboard.addPhotoSpot');
    Route::post('/dashboard/photo-spot/{index}/delete', [AdminController::class, 'deleteDashboardPhotoSpot'])->name('dashboard.deletePhotoSpot');
    Route::post('/dashboard/hotel', [AdminController::class, 'addDashboardHotel'])->name('dashboard.addHotel');
    Route::post('/dashboard/hotel/{index}/delete', [AdminController::class, 'deleteDashboardHotel'])->name('dashboard.deleteHotel');
    Route::post('/dashboard/gallery', [AdminController::class, 'addDashboardGallery'])->name('dashboard.addGallery');
    Route::post('/dashboard/gallery/{index}/delete', [AdminController::class, 'deleteDashboardGallery'])->name('dashboard.deleteGallery');
    // Test Upload Sederhana
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

    // Manage Harga & Tips (Dinamis)
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
// 7. ROUTE KHUSUS PENGELOLA
// ==========================================
Route::middleware(['auth', 'role:pengelola'])->prefix('pengelola')->name('pengelola.')->group(function () {
    Route::get('/', [PengelolaController::class, 'dashboard'])->name('dashboard');
    Route::get('/reservasi', [PengelolaController::class, 'reservasi'])->name('reservasi');
    Route::get('/operasional', [PengelolaController::class, 'operasional'])->name('operasional');
    Route::post('/operasional/update', [PengelolaController::class, 'updateOperasional'])->name('operasional.update');
    Route::get('/analitik', [PengelolaController::class, 'analitik'])->name('analitik');
    Route::get('/pengaturan', [PengelolaController::class, 'pengaturan'])->name('pengaturan');
    Route::post('/pengaturan', [PengelolaController::class, 'updatePengaturan'])->name('pengaturan.update');
    Route::post('/reservasi/{id}/verify', [PengelolaController::class, 'verifyReservasi'])->name('reservasi.verify');
    Route::post('/reservasi/{id}/cancel', [PengelolaController::class, 'cancelReservasi'])->name('reservasi.cancel');
    Route::post('/reservasi', [PengelolaController::class, 'storeReservasi'])->name('reservasi.store');
    Route::delete('/reservasi/{reservasi}', [PengelolaController::class, 'destroyReservasi'])->name('reservasi.destroy');
    Route::get('/cek-kode', [PengelolaController::class, 'cekKode'])->name('cek.kode');
    Route::post('/reservasi/{id}/pakai', [PengelolaController::class, 'tandaiDipakai'])->name('reservasi.pakai');
    Route::post('/reservasi/{id}/selesai', [PengelolaController::class, 'tandaiSelesai'])->name('reservasi.selesai');
    Route::post('/reservasi/{id}/sedang', [PengelolaController::class, 'tandaiSedang'])->name('reservasi.sedang');
});