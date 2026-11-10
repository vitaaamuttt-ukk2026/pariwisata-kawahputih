# Sistem Booking dan Informasi Wisata Kawah Putih

Aplikasi web Laravel untuk informasi wisata, pemesanan tiket/paket, verifikasi pembayaran, pengelolaan reservasi, dan pengaturan operasional Kawah Putih. Antarmuka menggunakan Blade dan aset frontend dibangun dengan Vite.

## Fitur

- **Pengunjung:** registrasi/login, melihat informasi dan paket, membuat booking, mengunggah bukti pembayaran, serta melihat tiket dan riwayat booking.
- **Admin:** dashboard, verifikasi/penolakan booking, pengelolaan paket dan akun pengelola, serta pengaturan konten.
- **Pengelola:** dashboard operasional, pencarian reservasi, pembaruan status kunjungan, pengaturan, dan analitik.
- Validasi formulir, pembatasan akses berbasis role, dan halaman error yang ramah pengguna.

## Teknologi dan persyaratan

- PHP 8.2 atau lebih baru dan ekstensi PHP yang dibutuhkan Laravel (termasuk PDO untuk database yang dipilih).
- Composer.
- Node.js dan npm untuk membangun aset frontend.
- SQLite untuk pengembangan lokal, atau MySQL/MariaDB untuk lingkungan bersama/produksi.
- Web server yang document root-nya mengarah ke folder `public`.

## Menjalankan secara lokal

Dari direktori proyek:

1. Pasang dependensi PHP dan frontend:

   ```sh
   composer install
   npm install
   ```

2. Salin `.env.example` menjadi `.env`, lalu atur `APP_URL` dan koneksi database. Untuk SQLite, pastikan file `database/database.sqlite` tersedia dan gunakan:

   ```dotenv
   DB_CONNECTION=sqlite
   DB_DATABASE=C:/path/ke/proyek/database/database.sqlite
   ```

   Untuk MySQL/MariaDB, gunakan `DB_CONNECTION=mysql` dan isi `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, serta `DB_PASSWORD`.

3. Buat application key dan jalankan migrasi:

   ```sh
   php artisan key:generate
   php artisan migrate
   php artisan db:seed --class=Database\\Seeders\\PaketSeeder
   php artisan storage:link
   ```

4. Bangun aset dan jalankan server pengembangan:

   ```sh
   npm run build
   php artisan serve
   ```

   Buka URL yang ditampilkan oleh `artisan serve`. Saat mengembangkan tampilan, `npm run dev` dapat dijalankan di terminal terpisah.

### Akun dan akses

- Pengunjung dapat membuat akun melalui halaman registrasi.
- Akun admin awal tidak dibuat otomatis oleh seeder. Buat akun admin melalui proses administrasi yang tepercaya sebelum aplikasi dipakai, lalu buat akun pengelola dari panel admin.
- Jangan menaruh password demo atau kredensial produksi di repository. Untuk presentasi, siapkan akun dan data demo lokal yang aman.

## Pengujian

Jalankan seluruh tes otomatis:

```sh
php artisan test
```

Tes mencakup alur login berbasis role, pencarian reservasi, booking pengunjung, katalog paket, dan halaman error.

## Rilis dan dokumentasi

- [Panduan deployment](docs/PANDUAN-DEPLOYMENT.md)
- [Dokumentasi API dan endpoint JSON](docs/API.md)
- [Panduan pengguna](docs/PANDUAN-PENGGUNA.md)
- [Bahan presentasi Sprint 4](docs/PRESENTASI-SPRINT-4.md)
- [Skenario latihan demo dan kontribusi tim](docs/REHEARSAL-SPRINT-4.md)

Untuk produksi, gunakan `APP_ENV=production`, `APP_DEBUG=false`, HTTPS, database yang dikelola dengan aman, dan web root `public`. Lihat panduan deployment sebelum membuka aplikasi ke publik.
