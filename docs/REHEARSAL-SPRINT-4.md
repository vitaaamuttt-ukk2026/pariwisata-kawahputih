# Latihan Demo dan Kesiapan Kontribusi Sprint 4

## 1. Persiapan sebelum demo

- Jalankan aplikasi dan pastikan database serta aset frontend siap.
- Jalankan `php artisan test`; periksa log bila ada kegagalan.
- Seed paket pada lingkungan demo bila katalog kosong:

  ```sh
  php artisan db:seed --class="Database\\Seeders\\PaketSeeder"
  ```

- Siapkan akun pengunjung, admin, dan pengelola yang dapat login. Jangan memakai password produksi atau data pribadi nyata.
- Siapkan paket yang konsisten, bukti pembayaran demo yang tidak memuat data sensitif, serta satu booking yang sudah menunggu verifikasi.
- Periksa ruang disk unggahan, tautan `storage`, koneksi database, dan URL aplikasi.
- Siapkan screenshot/video lokal sebagai cadangan; pastikan tidak memuat data nyata.

## 2. Urutan demo (sekitar 7–10 menit)

1. Buka halaman aplikasi dan jelaskan tujuan sistem.
2. Login sebagai pengunjung.
3. Tampilkan katalog dan informasi paket.
4. Buat booking menggunakan data demo, pilih metode pembayaran, dan unggah bukti demo.
5. Tampilkan kode booking dan riwayat/status pengunjung.
6. Logout; login sebagai admin.
7. Tampilkan booking baru, periksa detail, lalu verifikasi bukti demo.
8. Tampilkan perubahan status/riwayat dan, bila tersedia, contoh cetak/ekspor.
9. Logout; login sebagai pengelola.
10. Tampilkan pencarian reservasi, status operasional, dan analitik.
11. Tutup dengan ringkasan hasil tes, batasan sistem, dan rencana pengembangan.

Jika alur aktual menu berbeda pada lingkungan presentasi, gunakan nama menu di aplikasi yang dipasang dan jangan memaksakan langkah yang tidak tersedia.

## 3. Pembagian peran dan kontribusi

Isi sesuai pekerjaan yang benar-benar dilakukan; jangan mengklaim kontribusi yang tidak dikerjakan.

| Anggota | Bagian yang dikerjakan | Bukti yang ditunjukkan | Penjelasan yang harus dikuasai |
|---|---|---|---|
| `[Nama]` | `[UI/UX dan halaman...]` | `[file/halaman/commit aktual]` | Struktur halaman, validasi frontend, integrasi form |
| `[Nama]` | `[Controller, auth, atau alur booking...]` | `[file/tes/commit aktual]` | Validasi server, status booking, akses role |
| `[Nama]` | `[Skema database/deployment...]` | `[migrasi/konfigurasi aktual]` | Relasi, migrasi, penyimpanan bukti, environment |

Sesuaikan jumlah baris untuk seluruh anggota. Tunjukkan kode, tes, tangkapan layar, atau riwayat kerja yang mendukung kontribusi masing-masing.

## 4. Pertanyaan yang perlu dilatih

- Mengapa aplikasi menggunakan Laravel dan Blade?
- Apa perbedaan role pengunjung, admin, dan pengelola?
- Bagaimana booking dibuat, divalidasi, dan diverifikasi?
- Bagaimana bukti pembayaran disimpan?
- Tes apa yang sudah berjalan, dan apa yang belum diuji?
- Apa perbedaan endpoint JSON dengan route formulir web di aplikasi ini?
- Apa langkah aman sebelum deploy dan bagaimana memulihkan backup?

## 5. Rencana cadangan

- Jika server demo mati, gunakan screenshot/video aktual dan jelaskan bahwa alur tidak berjalan langsung.
- Jika akun gagal login, gunakan akun demo cadangan yang telah diuji; jangan menampilkan password di slide.
- Jika booking tidak muncul, periksa akun/email pemesan, database, dan status koneksi sebelum membuat transaksi baru.
- Jika unggahan gagal, periksa format/ukuran gambar dan izin tulis storage.
- Hentikan demo bila data nyata atau kredensial sensitif muncul di layar.

## 6. Checklist akhir

- [ ] Setiap anggota memahami kontribusi dan alur aplikasi.
- [ ] Akun tiap role telah diuji pada mesin demo.
- [ ] Data demo aman, konsisten, dan dapat direset.
- [ ] Rute utama dan unggahan telah dicoba.
- [ ] Screenshot aktual sudah disamarkan dan disiapkan.
- [ ] Urutan dan durasi demo sudah dilatih.
- [ ] Hasil tes serta batasan yang belum diuji dijelaskan apa adanya.
