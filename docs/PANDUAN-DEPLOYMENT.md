# Panduan Deployment

Panduan ini menyiapkan aplikasi Laravel Kawah Putih untuk server Linux atau layanan hosting yang mendukung PHP. Deployment produksi belum dilakukan oleh panduan ini; sesuaikan perintah direktori dan konfigurasi dengan penyedia hosting.

## 1. Persyaratan server

- PHP 8.2+ dengan ekstensi Laravel yang diperlukan, termasuk `pdo_mysql` untuk MySQL/MariaDB.
- Composer 2.
- Node.js dan npm hanya diperlukan saat membangun aset.
- MySQL/MariaDB yang dapat diakses dari server aplikasi.
- Web server (Nginx/Apache) dengan document root mengarah ke direktori `public`.
- HTTPS, DNS, ruang penyimpanan untuk bukti pembayaran, serta proses backup database dan berkas.

## 2. Persiapan rilis

1. Ambil versi proyek yang sudah ditinjau dan pastikan `composer.lock` tersedia.
2. Pasang dependensi produksi:

   ```sh
   composer install --no-dev --prefer-dist --optimize-autoloader
   npm install
   npm run build
   ```

3. Buat `.env` di server (jangan menyalin kredensial lokal) dan isi setidaknya:

   ```dotenv
   APP_NAME="Wisata Kawah Putih"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://nama-domain-anda
   APP_KEY=

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=pengguna_aplikasi
   DB_PASSWORD=password_kuat_dari_secret_manager

   FILESYSTEM_DISK=public
   SESSION_DRIVER=database
   CACHE_STORE=database
   QUEUE_CONNECTION=database
   ```

   Gunakan kredensial database dengan hak minimum. Jangan memasukkan nilai contoh di atas apa adanya. Jika aplikasi sudah pernah berjalan, pertahankan `APP_KEY` yang ada; jangan menggantinya saat deployment biasa.

4. Buat key hanya untuk instalasi baru:

   ```sh
   php artisan key:generate
   ```

5. Siapkan direktori tulis Laravel (`storage` dan `bootstrap/cache`) agar dapat ditulis oleh akun proses PHP. Atur ownership/permission mengikuti kebijakan server; jangan memberi izin tulis global.
6. Sebelum migrasi, buat backup database dan berkas unggahan yang ada.
7. Jalankan migrasi serta seed paket idempoten:

   ```sh
   php artisan migrate --force
   php artisan db:seed --class="Database\Seeders\PaketSeeder" --force
   php artisan storage:link
   ```

8. Buat akun admin awal lewat prosedur administrasi yang aman. Seeder proyek tidak menyediakan akun admin demo.
9. Bersihkan cache lama dan optimalkan konfigurasi:

   ```sh
   php artisan optimize:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

10. Konfigurasikan Nginx/Apache agar hanya direktori `public` yang dapat diakses web. Pastikan HTTPS aktif dan direktori proyek lain (termasuk `.env`, `storage`, dan `vendor`) tidak dapat diakses langsung.

## 3. Berkas booking

Bukti pembayaran disimpan pada disk `public` di `storage/app/public/bukti_pembayaran`. Pastikan direktori penyimpanan persisten, akses tulis akun PHP tersedia, dan `public/storage` menunjuk ke `storage/app/public`. Uji unggah dan akses bukti melalui aplikasi setelah deploy. Tetapkan kebijakan retensi dan backup berkas; jangan mencadangkan bukti ke lokasi publik tanpa kontrol akses.

## 4. Pemeriksaan setelah rilis

- `APP_ENV=production` dan `APP_DEBUG=false`; tidak ada kredensial di repository.
- Domain HTTPS dan URL aset benar.
- `php artisan migrate:status` menunjukkan semua migrasi aktif.
- Login tiap role, katalog, pengajuan booking, unggahan bukti, dan verifikasi admin berfungsi.
- Reservasi manual, status operasional, pencarian, serta ekspor booking diperiksa.
- Halaman 403/404/500 tidak menampilkan detail teknis atau stack trace.
- Endpoint diagnostik `/403-test`, `/500-test`, dan `/admin/test-upload` tidak terdaftar pada lingkungan produksi.
- Log Laravel dan ruang disk dipantau; backup database dan berkas diuji pemulihannya.

Untuk kembali ke versi sebelumnya, pulihkan kode dan aset versi tersebut serta pulihkan backup database hanya jika perubahan skema/data memang mengharuskannya. Jangan menjalankan `migrate:rollback` atau menghapus data produksi tanpa rencana pemulihan yang diuji.
