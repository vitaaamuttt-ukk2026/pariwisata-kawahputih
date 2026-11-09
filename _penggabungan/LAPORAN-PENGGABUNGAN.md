# Laporan Penggabungan Proyek Kawah Putih

Sumber:
- **A** = `pariwisata-kawah-putih.zip`
- **B** = `pariwisata-kawah-putih1.zip`

Hasil: folder `pariwisata-kawah-putih/` (proyek gabungan). Dokumen ini menjelaskan **semua** yang diubah.

> **Penting:** PHP tidak tersedia di lingkungan saya, jadi aplikasi **belum dijalankan** dan tes belum dieksekusi.
> Yang sudah saya lakukan: pemeriksaan statis (semua nama rute yang dipakai terdaftar, semua method controller
> yang dirutekan ada, semua view yang direferensikan ada, kurung/direktif Blade seimbang).
> Mohon jalankan langkah di bagian 7, lalu `php artisan test`.

---

## 1. Aturan yang saya pakai

1. File yang **hanya ada di salah satu** folder → disalin **apa adanya** (tidak diubah sama sekali).
2. File yang **identik** → dipertahankan.
3. File yang **ada di keduanya tetapi berbeda (31 file)** → satu versi dipilih per area fitur, atau digabung.
   **Versi yang tidak dipakai TIDAK dibuang**: disimpan utuh di `_penggabungan/versi-tidak-dipakai/A/…` dan `…/B/…`
   dengan path yang sama seperti aslinya.
4. Dasar pemilihan: (a) versi yang lebih lengkap fiturnya di area itu, (b) versi yang lebih baru (tanggal modifikasi),
   (c) apakah A punya tes/laporan yang mengunci perilakunya.

Pola yang ditemukan dari tanggal modifikasi: kedua proyek bercabang ± 6 Nov 2026.
**A** lebih baru di: portal pengunjung (UI), verifikasi booking admin, halaman error, tes.
**B** lebih baru di: panel admin/pengelola, login panel, CMS (paket, info, hero, operasional).

Statistik: 23 file unik A, 67 file unik B, 97 file bersama (31 berbeda, sisanya identik).

---

## 2. Keputusan per file yang berbeda (31 file)

| File | Dipakai | Alasan |
|---|---|---|
| `.env` | **A** | B tersimpan di `versi-tidak-dipakai/B/.env`. Lihat 4.3 |
| `database/database.sqlite` | **A** | B berukuran 0 byte. A berisi skema (0 baris data) |
| `storage/logs/laravel.log` | **A**, log B disimpan sebagai `laravel-dari-B.log` | Kedua log dipertahankan |
| `app/Http/Controllers/AuthController.php` | A | Identik kecuali A memakai view yang benar (`auth.login`). Tidak dirutekan di keduanya |
| `app/Http/Controllers/PanelAuthController.php` | B | Lebih baru; semua tes login A tetap berlaku (redirect ke `/admin` dan `/pengelola`) |
| `app/Http/Controllers/PengelolaController.php` | **GABUNGAN** | Lihat 3.4 |
| `app/Http/Controllers/PengunjungController.php` | **GABUNGAN** | Lihat 3.3 |
| `app/Http/Controllers/TiketController.php` | A | Tidak dirutekan di kedua proyek; rute yang dirujuk A ada |
| `app/Http/Middleware/CheckRole.php` | A | Lebih baru. B: `abort(403)`; A: logout + redirect ke login panel |
| `app/Models/Booking.php` | **GABUNGAN** | Lihat 3.2 |
| `app/Models/User.php` | A | A = B + relasi `orders()` |
| `bootstrap/app.php` | **GABUNGAN** | Lihat 3.5 |
| `database/seeders/DatabaseSeeder.php` | B | A hanya bawaan Laravel (Test User) |
| `resources/css/app.css`, `resources/js/app.js` | A | Milik B masih bawaan Laravel; hanya dipakai layout tema A |
| `resources/views/admin/booking.blade.php` | A | Punya riwayat, filter status, cetak |
| `resources/views/admin/dashboard.blade.php` | A | A = B + `??` (lebih toleran terhadap data kosong) |
| `resources/views/admin/pengelola.blade.php` | B | Punya fitur ubah nama pengelola |
| `resources/views/auth/login.blade.php` | B | Lebih baru |
| `resources/views/layouts/panel.blade.php` | B (+1 menu) | Berisi menu CMS B. Lihat 3.6 |
| `resources/views/pengelola/analitik, operasional, pengaturan.blade.php` | B | Lebih baru; cocok dengan controller B |
| `resources/views/pengelola/reservasi.blade.php` | B (+penyesuaian status) | Versi A dipertahankan sebagai halaman baru, lihat 3.4 |
| `resources/views/layouts/pengunjung.blade.php` dan `pengunjung/{booking,dashboard,info,tiket,wisata}.blade.php` | **B aktif**, A di `resources/themes/a/` | Lihat 3.1 |
| `resources/views/pengunjung/index.blade.php` | A | Beda hanya nama rute tautan (`pengunjung.tiket`) |
| `routes/web.php` | **GABUNGAN** | Lihat 3.7 |
| `tests/Feature/ExampleTest.php` | A (+1 URL) | Lihat 3.8 |

---

## 3. Penjelasan detail perubahan

### 3.1 Dua tampilan portal pengunjung → saklar tema (file baru)
A dan B punya dua desain portal pengunjung yang berbeda total:
- **Tema B** (aktif secara bawaan): halaman wisata mengambil paket dari database, info/hero/spot foto dari CMS admin,
  dashboard menampilkan data operasional real-time dari pengelola. Semua halaman CMS admin B baru terlihat efeknya di tema ini.
- **Tema A**: desain baru (sidebar + navigasi bawah di HP, keranjang). Isi halamannya statis (harga ditulis langsung).

Karena keduanya tidak bisa dilebur otomatis tanpa merusak salah satunya, keduanya disimpan dan bisa dipilih:
- **Baru:** `config/portal.php` → `visitor_theme` dari `.env` `VISITOR_THEME` (bawaan `b`).
- **Diubah:** `app/Providers/AppServiceProvider.php` → di `boot()`, jika tema = `a`, folder `resources/themes/a` dicari lebih dulu.
- **Baru:** `resources/themes/a/` berisi 6 file A **tanpa diubah**: `layouts/pengunjung`, `pengunjung/{booking,dashboard,info,tiket,wisata}`.

Cara pakai tema A: tambahkan `VISITOR_THEME=a` di `.env`, jalankan `php artisan config:clear`, lalu `npm run dev`
(layout A memakai Vite). Kembali ke tema B: hapus baris itu.

### 3.2 `app/Models/Booking.php` (gabungan)
- `$fillable` = gabungan A + B (`wisata_id`, `items` dari A; `user_id`, `status_kunjungan`, `selesai` dari B).
- `$casts` = gabungan A + B.
- Relasi `wisata()`, `verifiedBy()`, `rejectedBy()` dan scope `pending`/`verified` dari A dipertahankan.
- **Baru:** konstanta `STATUS_*`, scope `lunas()` / `batal()`, method `isLunas()` / `isBatal()`.

**Masalah inti yang diselesaikan: kosakata status berbeda.** A memakai `pending / verified / rejected`,
B memakai `pending / paid / cancelled`. Keputusan:
- Nilai yang **ditulis** ke database: kosakata **A** (`verified`, `rejected`).
- Nilai yang **dibaca**: menerima keduanya (`verified` atau `paid`; `rejected` atau `cancelled`), sehingga data lama tetap terbaca.

Akibat pilihan ini, file B berikut disesuaikan (hanya bagian status):
- `AdminController.php` (B): statistik dashboard memakai `lunas()`/`batal()`; `verifyBooking` menulis `verified`; `cancelBooking` menulis `rejected`.
- `PengelolaController.php`: semua pengecekan `paid`/`cancelled` → `lunas()`/`batal()`; verify → `verified`; cancel → `rejected`.
- `pengunjung/tiket.blade.php` (B): `status === 'paid'` → `isLunas()` (3 tempat), `'cancelled'` → `isBatal()` (1).
- `pengelola/reservasi.blade.php` (B): 4 pengecekan serupa.

Catatan efek cast: `tanggal_kunjungan` kini bertipe tanggal (dari B). Akibatnya CSV export A akan menampilkan jam;
untuk menjaga format lama saya mengubah **1 baris** di `Admin/BookingController.php::export()` menjadi `->format('Y-m-d')`
(asli tersimpan di cadangan A).

### 3.3 `app/Http/Controllers/PengunjungController.php` (gabungan)
Memuat gabungan method kedua proyek, setiap method diberi label asal:
- Dari **B**: `dashboard`, `info`, `detail`, `wisata`, `checkStatus`.
- Dari **A**: `penginapan`, `pembayaran`, `prosesLogin`, `prosesLogout`, alias `index()` dan `statusTiket()`.
- **Digabung:**
  - `dashboard()` mengisi `$orders` (milik dashboard tema A) hanya jika tema A aktif.
  - `tiket()` mencari booking berdasarkan `user_id` (B) **atau** email (A), sehingga booking lama tanpa `user_id` tetap muncul.
  - `prosesPembayaran()`:
    - Validasi: bukti pembayaran & data keranjang wajib (B); tanggal tidak boleh lampau, no. HP min 10 digit, jumlah tiket maks 100 (A).
    - Disimpan: `user_id` (B); kolom `items` berisi JSON keranjang (A); `paket` berisi teks "Nama (xQty), …" (terbaca di kedua tema);
      kode booking gaya A (`KP-YmdHis-nnn`); bukti disimpan gaya B (path relatif disk `public`, agar bisa dibaca halaman admin A).
    - Perilaku **A yang dilepas**: jika keranjang kosong, A membuat item default "Tiket Kawah Putih" Rp65.000. Sekarang ditolak dengan pesan error (perilaku B).

### 3.4 `PengelolaController.php` dan Reservasi
- Dasar: **B** (monitor booking online, operasional, pengaturan profil, tandai dipakai/selesai).
- B memiliki `storeReservasi` (tidak menyimpan apa-apa) dan `destroyReservasi` (akan error). Keduanya diganti implementasi **A** yang berfungsi (tabel `reservasis`).
- **Baru:** `reservasiManual()` (daftar + pencarian + paginasi milik A) di URL **`/pengelola/reservasi-manual`**
  (nama rute `pengelola.reservasi.manual`), karena `/pengelola/reservasi` dipakai halaman B.
- **Baru:** `resources/views/pengelola/reservasi-manual.blade.php` = view A, hanya nama rute pada form pencarian diganti.
- **Diubah:** `layouts/panel.blade.php` ditambah 1 menu sidebar "Reservasi Manual" (khusus pengelola).

### 3.5 `bootstrap/app.php` (gabungan)
Alias middleware: `admin` & `role` (A) + `auth.pengunjung` (B). Blok halaman error 404/403/500 milik A dipertahankan.
Efeknya berlaku juga untuk kode B: semua exception tak tertangani (termasuk `findOrFail` yang tidak ketemu) tampil sebagai halaman 500 ramah A,
dan halaman debug Laravel tidak tampil. Lihat `storage/logs/laravel.log` untuk detail error.

### 3.6 `database/migrations/2026_10_20_033624_add_bukti_pembayaran_to_bookings_table.php`
Migrasi B ini menambah kolom `bukti_pembayaran` tanpa pengecekan, padahal database A **sudah punya** kolom itu
(dibuat migrasi A `2026_11_07_000001`). Tanpa perbaikan, `php artisan migrate` pada database A gagal "duplicate column".
Saya tambahkan `Schema::hasColumn` di `up()` dan `down()`. Pada database baru, hasilnya sama seperti sebelumnya.
Semua migrasi lain tidak diubah dan berurutan tanpa bentrok.

### 3.7 `routes/web.php` (gabungan)
Semua rute A dan B digabung dan diberi label `[A]`/`[B]`. Bentrokan dan penyelesaiannya:

| Bentrokan | Penyelesaian |
|---|---|
| `GET /` : A wajib login, B publik | Perilaku **A** (ada tes & laporan A; tes B hanyalah contoh bawaan Laravel). Tamu diarahkan ke `/login` → halaman login B. Untuk membuka `/` bagi tamu: hapus blok `if (!Auth::check())` |
| `/login` | Versi A (mengarahkan sesuai role) |
| `panel.logout`: A `/logout`, B `/panel/logout` | `/panel/logout` (B). Nama rute sama, jadi tak ada view yang rusak |
| Login pengunjung: nama `pengunjung.login` / `pengunjung.logout` dipakai kedua sisi | Nama B dipakai untuk `/pengunjung/login`, `/pengunjung/logout` (+register). Rute A tetap hidup di `/login-pengunjung` dengan nama `pengunjung.login.a`, `pengunjung.logout.a` (`pengunjung.login.post` tetap) |
| `POST /admin/booking/{id}/cancel` bernama `admin.booking.cancel` di keduanya | Versi **A** (view admin booking A memakainya). `AdminController::cancelBooking` milik B tetap ada tetapi tidak dirutekan |
| `admin.booking.verify`: B (POST) dan A (PATCH) | B tetap `admin.booking.verify`; A diganti nama `admin.booking.verify.patch` (tidak dipakai view mana pun) |
| `/wisata`, `/booking`, `/tiket` publik di A, wajib login di B | Wajib login (B); `/status-tiket` (A) ditambahkan di grup yang sama |
| Middleware admin `admin:admin` (A) vs `role:admin` (B) | `role:admin` / `role:pengelola` (alias yang sama) |

Rute unik A yang tetap ada: `/penginapan`, `/pembayaran`, `/login-pengunjung`, `/status-tiket`, `confirm`, `bookings.verify`,
riwayat/detail/cetak/export/verify/reject, `/403-test`, `/500-test`.
Rute unik B yang tetap ada: seluruh CMS (paket, info, dashboard, harga, tips), operasional, pengaturan, `/detail`, `/api/*`, register, tandai dipakai/selesai, `test-upload`.

### 3.8 Tes (`tests/Feature/ExampleTest.php`)
Dipakai versi A (9 tes). Satu perubahan: tes pencarian reservasi kini memanggil `/pengelola/reservasi-manual?search=Rizki`
(bukan `/pengelola/reservasi?search=Rizki`), mengikuti pemindahan URL di 3.4. Belum dijalankan.

---

## 4. Hal yang perlu keputusan/perhatian Anda

1. **Tema pengunjung** (3.1): bawaan B. Pilih A jika itu yang diinginkan.
2. **Kosakata status** (3.2): bila Anda lebih suka `paid/cancelled`, cukup ubah konstanta di `Booking.php` dan 3 baris penulisan status.
3. **`.env`:** A memakai **SQLite**; B memakai **MySQL** (`pariwisata_kawah_putih`) dan data CMS B kemungkinan ada di MySQL lokal Anda, bukan di zip.
   Saya mempertahankan `.env` A. Jika ingin memakai data B, salin `DB_CONNECTION`/`DB_DATABASE` dari `_penggabungan/versi-tidak-dipakai/B/.env`,
   lalu jalankan `php artisan migrate` agar tabel A (wisatas, orders, kolom verifikasi) ikut dibuat di MySQL tersebut.
   `APP_KEY` kedua `.env` sama.
4. **Cache view terkompilasi tidak disertakan** (`storage/framework/views/*.php`, 64 file B + 1 file A). Itu cache, bukan data, dan
   berisiko menampilkan tampilan versi lama karena Laravel membandingkan waktu file.
5. `vendor/`: dari A. Hanya 3 file `composer/autoload_*` yang berbeda antar proyek; classmap A tetap valid karena seluruh file unik A dipertahankan, dan class baru B dimuat lewat PSR-4.

---

## 5. Dipertahankan tanpa perubahan
- **Hanya di A (23):** `Admin/AdminController`, `Admin/BookingController` (kecuali 1 baris di 3.2), `AdminMiddleware`, `Order`, `Wisata`, 5 migrasi (verifikasi, orders, wisata_id, wisatas, booking details), 5 dokumen laporan `.md`, view `errors/403|404|500`, `auth/login-pengunjung`, `admin/booking/cetak`, pintasan `resources/views - Shortcut.lnk`, `.phpunit.result.cache`, 1 bukti pembayaran.
- **Hanya di B (67, tanpa cache view):** `AdminPaketController`, `ContentController`, `PengunjungAuthController`, `VisitorAuthController`, `AuthPengunjung`, model `Paket/OperasionalSetting/InfoContent/WebsiteContent`, 8 migrasi, `AdminSeeders`, semua view CMS/paket/register/riwayat/detail/visitor, ± 10 gambar `public/` dan `storage/`, 15 bukti pembayaran.

---

## 6. Temuan di kode asli yang TIDAK saya ubah (agar Anda tahu)
Ini sudah ada sebelum penggabungan; saya tidak memperbaikinya karena di luar permintaan.

1. `Admin/BookingController` tidak punya method `riwayat`, tetapi rutenya (`admin.booking.riwayat`) ada → membuka rutenya menghasilkan halaman 500.
2. `admin/booking/cetak.blade.php` (A) berukuran 0 byte → tombol Cetak menampilkan halaman kosong.
3. `Booking::$fillable` tidak memuat `verified_by`, `verified_at`, `rejected_by`, `rejected_at`, jadi pencatatan siapa yang memverifikasi **tidak tersimpan** (diabaikan diam-diam).
4. `User::$fillable` tidak memuat `no_hp`, jadi nomor HP dari form registrasi B tidak tersimpan.
5. `database/seeders/AdminSeeders.php` berisi class `AdminSeeder` (nama file tidak cocok dengan nama class), sehingga `db:seed --class=AdminSeeder` kemungkinan gagal dimuat.
6. B: `updateOperasional` memvalidasi nama field (`status_siaran`, `kuota_maksimal`, `zona_terumbu_kapasitas`, …) yang berbeda dari kolom model (`status_suaran`, `kuota_pengunjung`, `zona_terumbu_max`, …), sehingga sebagian input operasional tidak tersimpan.
7. B: route `pengelola.cek.kode` memanggil view `pengelola.cek-kode` yang tidak ada. `ContentController` merujuk rute `admin.contents.*` yang tidak ada; `VisitorAuthController` merujuk `visitor.*`; keduanya tidak dirutekan.
8. B: rute `test-upload` berada di dalam grup `admin.` sehingga namanya menjadi `admin.admin.test-upload`, sedangkan view-nya memanggil `admin.test-upload.post`.
9. A: layout pengunjung dan halaman wisata sama-sama mendeklarasikan `let cart` (tema A) → skrip layout bisa error "already declared" di browser.
10. A: tema A memakai Vite (`@vite`) tetapi tidak ada `public/build`; jalankan `npm run dev`/`npm run build`.

---

## 7. Langkah setelah menggabung
```bash
cd pariwisata-kawah-putih
php artisan view:clear
php artisan config:clear
php artisan migrate            # menambah tabel/kolom B ke database A (SQLite)
php artisan storage:link       # agar bukti pembayaran & gambar storage bisa dibuka
php artisan test
```
Database belum punya user. Buat akun uji lewat tinker:
```bash
php artisan tinker --execute="App\Models\User::create(['name'=>'Admin','email'=>'admin@kawahputih.test','password'=>'admin123','role'=>'admin']);"
php artisan tinker --execute="App\Models\User::create(['name'=>'Pengelola','email'=>'pengelola@kawahputih.test','password'=>'pengelola123','role'=>'pengelola']);"
```
(Pengunjung mendaftar sendiri lewat `/pengunjung/register`.) Login panel: `/admin/login` dan `/pengelola/login`.

Alur uji yang disarankan: daftar pengunjung → pilih paket di `/wisata` → booking + unggah bukti → admin buka `/admin/booking` dan verifikasi →
pengelola buka `/pengelola/reservasi` dan tandai dipakai/selesai → status tampil di `/tiket` pengunjung.

## 8. Cara mengembalikan versi yang tidak dipakai
Salin file dari `_penggabungan/versi-tidak-dipakai/{A|B}/<path>` ke `<path>` di proyek. Untuk file gabungan (routes, bootstrap, PengunjungController,
PengelolaController, Booking) tersedia **kedua** versi asli. Folder `_penggabungan` aman dihapus bila sudah tidak diperlukan.
