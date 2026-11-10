# Panduan Pengguna

Panduan ini menjelaskan penggunaan aplikasi booking wisata Kawah Putih. Nama menu dapat mengikuti versi antarmuka yang dipasang.

## 1. Pengunjung

### Membuat akun dan login

1. Buka halaman login pengunjung lalu pilih **Daftar** jika belum memiliki akun.
2. Isi nama, email, password, konfirmasi password, dan nomor HP bila diperlukan.
3. Login menggunakan email dan password. Jika gagal, pastikan data benar atau minta bantuan admin.
4. Gunakan menu **Logout** setelah selesai, terutama pada komputer bersama.

### Melihat paket dan membuat booking

1. Buka menu **Wisata** dan pilih paket yang diperlukan. Periksa nama dan harga setiap paket.
2. Masukkan paket ke keranjang dan periksa kembali jumlah serta totalnya.
3. Lanjut ke formulir booking. Isi nama, email, nomor HP, dan tanggal kunjungan (hari ini atau tanggal mendatang).
4. Pilih metode pembayaran yang tersedia (`qris`, `va`, atau `transfer`).
5. Unggah bukti pembayaran berformat JPG/JPEG/PNG dengan ukuran maksimal 2 MB.
6. Kirim pesanan. Simpan kode booking yang ditampilkan; booking baru berstatus menunggu verifikasi.

Jika formulir kembali menampilkan pesan kesalahan, perbaiki field yang disebutkan dan kirim ulang. Pastikan keranjang tidak kosong, jumlah total paling banyak 100 orang, tanggal tidak lampau, dan file bukti memenuhi format/ukuran.

### Melihat tiket dan status

1. Login dengan akun yang membuat booking.
2. Buka menu **Tiket** atau **Riwayat**.
3. Periksa kode booking dan status pembayaran. Status berubah setelah admin memeriksa bukti.
4. Hubungi pengelola jika kode tidak tampil atau status tidak sesuai.

## 2. Admin

### Login dan pengelolaan booking

1. Buka halaman login pada alamat `/admin/login`.
2. Login dengan akun admin yang disediakan oleh pengelola sistem.
3. Buka menu **Booking** untuk melihat booking baru.
4. Periksa data pengunjung, tanggal, jumlah, nilai booking, dan bukti pembayaran.
5. Pilih **Verifikasi** bila data dan pembayaran sesuai, atau **Tolak** bila tidak sesuai. Tindakan ini mengubah status booking.
6. Gunakan menu riwayat untuk melihat, mencetak, atau mengekspor booking sesuai izin akun.

### Pengelolaan aplikasi

- **Paket:** tambah, ubah, aktif/nonaktifkan, atau hapus paket sesuai kebijakan.
- **Akun pengelola:** buat atau perbarui akun operasional dari panel admin.
- **Konten:** perbarui informasi wisata dan bagian dashboard melalui menu yang tersedia.
- **Logout:** keluar dari panel setelah pekerjaan selesai.

## 3. Pengelola

1. Buka `/pengelola/login` dan login menggunakan akun role pengelola.
2. Gunakan dashboard untuk memantau operasional.
3. Buka **Reservasi** untuk mencari dan meninjau booking. Gunakan kolom pencarian dan pagination jika daftar panjang.
4. Buka **Reservasi Manual** untuk memeriksa atau mengelola reservasi yang dimasukkan langsung.
5. Perbarui status kunjungan hanya setelah memeriksa kode dan kondisi aktual.
6. Gunakan menu **Operasional**, **Analitik**, dan **Pengaturan** sesuai tanggung jawab.
7. Logout setelah selesai.

## 4. Pesan umum dan pemecahan masalah

| Kondisi | Tindakan |
|---|---|
| Email/password salah | Periksa email, password, dan halaman login sesuai role. |
| Tidak punya akses | Logout lalu login memakai akun dengan role yang tepat; minta admin memeriksa role bila perlu. |
| Tanggal atau jumlah ditolak | Pilih tanggal hari ini/mendatang dan jumlah antara 1–100. |
| Bukti pembayaran ditolak | Gunakan gambar JPG/JPEG/PNG maksimal 2 MB. |
| Booking tidak muncul | Pastikan login dengan akun/email yang sama dengan pemesan, lalu periksa riwayat. |
| Halaman tidak ditemukan (404) | Periksa URL atau kembali ke beranda. |
| Layanan sedang terganggu (500) | Coba lagi setelah beberapa saat; jangan mengirim ulang pembayaran berulang kali sebelum memeriksa status. |

Jangan membagikan password, tautan sesi, atau bukti pembayaran kepada orang yang tidak berwenang.

## 5. Tangkapan layar untuk versi final

Tambahkan tangkapan layar aktual dari aplikasi yang digunakan; jangan memakai gambar contoh sebagai bukti:

1. Login pengunjung dan dashboard.
2. Katalog paket dan formulir booking.
3. Riwayat tiket/status booking.
4. Dashboard admin dan detail/verifikasi booking.
5. Dashboard pengelola dan pencarian reservasi.

Sebelum membagikan screenshot, samarkan nama, email, nomor telepon, kode booking, dan bukti pembayaran milik orang nyata.
