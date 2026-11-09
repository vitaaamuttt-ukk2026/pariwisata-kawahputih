# Laporan Error Handling – Sistem Kawah Putih

Tanggal: 2026-11-06

## 1. Tujuan
Dokumen ini dibuat untuk menilai apakah aplikasi sudah menangani kesalahan dengan benar sesuai checklist berikut:

- Validasi input kosong
- Validasi format dan panjang data
- Menangani data yang tidak ditemukan
- Menangani kegagalan koneksi database
- Menampilkan pesan yang mudah dipahami
- Mencatat detail error di log server tanpa membocorkan informasi sensitif ke pengguna

---

## 2. Ringkasan hasil

| No | Item | Status | Keterangan |
|---|---|---|---|
| 1 | Validasi input kosong | ✅ Sesuai | Form login menolak input kosong |
| 2 | Validasi format dan panjang data | ✅ Sesuai | Aturan validasi Laravel sudah diterapkan |
| 3 | Menangani data yang tidak ditemukan | ✅ Sesuai | 404 custom ditampilkan |
| 4 | Menangani kegagalan koneksi database | ✅ Sesuai | 500 custom ditampilkan |
| 5 | Menampilkan pesan yang mudah dipahami | ✅ Sesuai | User melihat pesan yang ramah dan jelas |
| 6 | Logging aman tanpa bocor data sensitif | ✅ Sebagian sesuai | Password hash dan Laravel log aman; logging custom masih bisa ditingkatkan |

---

## 3. Bukti browser dan source code

### 3.1. Validasi input kosong

#### SS View Browser
URL yang diuji: http://127.0.0.1:8000/admin/login

Hasil yang terlihat:
- The email field is required.
- The password field is required.

#### Source code
File yang relevan:
- [resources/views/auth/login.blade.php](resources/views/auth/login.blade.php)
- [app/Http/Controllers/PanelAuthController.php](app/Http/Controllers/PanelAuthController.php)

```php
$credentials = $request->validate([
    'email' => 'required|email',
    'password' => 'required',
]);
```

```blade
@if($errors->has('email'))
  <div class="alert show" role="alert">
      {{ $errors->first('email') }}
  </div>
@endif
```

#### Kesimpulan
Sistem sudah menangani input kosong dengan benar dan menampilkan notifikasi yang jelas.

---

### 3.2. Validasi format dan panjang data

#### Source code
File yang relevan:
- [app/Http/Controllers/PengelolaController.php](app/Http/Controllers/PengelolaController.php)
- [app/Http/Controllers/Admin/AdminController.php](app/Http/Controllers/Admin/AdminController.php)
- [app/Http/Controllers/PanelAuthController.php](app/Http/Controllers/PanelAuthController.php)

```php
$request->validate([
    'nama_tamu' => 'required|string|max:255',
    'jumlah_pax' => 'required|integer|min:1',
    'tanggal' => 'required|date',
]);
```

```php
$request->validate([
    'email' => 'required|email',
    'password' => 'required|min:6',
]);
```

#### Kesimpulan
Validasi format dan panjang data sudah diterapkan sesuai kebutuhan aplikasi, misalnya email, tanggal, integer, min, dan max.

---

### 3.3. Menangani data yang tidak ditemukan (404)

#### SS View Browser
URL yang diuji: http://127.0.0.1:8000/route-yang-tidak-ada

Hasil yang terlihat:
- Halaman Tidak Ditemukan
- Tampilan custom, bukan error biasa Laravel

#### Source code
File yang relevan:
- [bootstrap/app.php](bootstrap/app.php)
- [resources/views/errors/404.blade.php](resources/views/errors/404.blade.php)

```php
if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
    return response()->view('errors.404', [], 404);
}
```

```blade
<h1>404</h1>
<p>Halaman tidak ditemukan</p>
```

#### Kesimpulan
Sistem sudah menangani halaman yang tidak ada dengan halaman 404 yang lebih ramah dan profesional.

---

### 3.4. Menangani akses ditolak (403)

#### SS View Browser
URL yang diuji: http://127.0.0.1:8000/403-test

Hasil yang terlihat:
- Akses Ditolak
- Halaman custom menampilkan pesan yang jelas untuk pengguna

#### Source code
File yang relevan:
- [bootstrap/app.php](bootstrap/app.php)
- [resources/views/errors/403.blade.php](resources/views/errors/403.blade.php)
- [app/Http/Middleware/CheckRole.php](app/Http/Middleware/CheckRole.php)

```php
if ($e instanceof \Illuminate\Auth\Access\AuthorizationException ||
    ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException && $e->getStatusCode() === 403) ||
    $e instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
    return response()->view('errors.403', [], 403);
}
```

```php
if (!in_array(Auth::user()->role, $roles)) {
    abort(403, 'Anda tidak memiliki akses');
}
```

#### Kesimpulan
Akses yang tidak sesuai role sudah ditangani secara benar. User tidak melihat error raw dan tidak dibawa ke halaman kosong.

---

### 3.5. Menangani server error (500)

#### SS View Browser
URL yang diuji: http://127.0.0.1:8000/500-test

Hasil yang terlihat:
- Server Sedang Bermasalah
- Halaman custom tampil dengan bahasa yang aman dan tidak menampilkan detail teknis

#### Source code
File yang relevan:
- [bootstrap/app.php](bootstrap/app.php)
- [resources/views/errors/500.blade.php](resources/views/errors/500.blade.php)

```php
if ($e instanceof \PDOException ||
    $e instanceof \Illuminate\Database\QueryException) {
    return response()->view('errors.500', ['message' => 'Saat ini layanan kami sedang mengalami gangguan teknis. Silakan coba beberapa saat lagi.'], 500);
}

return response()->view('errors.500', [], 500);
```

```blade
<h1>500</h1>
<p>Layanan sedang terganggu</p>
<p>Tim kami sedang menanganinya. Mohon coba kembali beberapa saat lagi.</p>
```

#### Kesimpulan
Server error sudah ditangani dengan halaman custom yang aman, rapi, dan mudah dipahami oleh pelanggan maupun admin.

---

### 3.6. Mencatat detail error di log server tanpa membocorkan informasi sensitif

#### Source code
File yang relevan:
- [app/Models/User.php](app/Models/User.php)
- [bootstrap/app.php](bootstrap/app.php)

```php
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```

#### Kesimpulan
Password disimpan dalam bentuk hash, sehingga data sensitif tidak langsung terekspos. Laravel juga mencatat error ke log server, sehingga informasi sensitif tidak ditampilkan ke user.

---

## 4. Kesimpulan akhir
Secara umum, aplikasi sudah memenuhi sebagian besar checklist error handling dengan baik. 404, 403, dan 500 telah dibuat dengan halaman custom yang user-friendly. Validasi input dan password hash juga sudah diterapkan dengan benar. Poin yang masih dapat ditingkatkan adalah logging custom yang lebih terstruktur untuk lingkungan produksi.

---

## 5. Catatan laporan pekerjaan
Halaman error custom yang sudah dibuat memberi dampak positif pada pengalaman pengguna, karena:
- pelanggan tidak melihat error mentah Laravel
- admin tidak kebingungan saat terjadi access denied atau server error
- sistem lebih profesional untuk kebutuhan presentasi dan laporan tugas

---

## 6. Penutup
Dokumen ini dibuat berdasarkan hasil pengecekan langsung terhadap aplikasi dan bukti browser yang telah dijalankan pada URL test masing-masing error. Dengan demikian, laporan ini siap digunakan sebagai lampiran pekerjaan atau dokumen presentasi akhir.
