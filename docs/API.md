# Dokumentasi API dan Endpoint

## Cakupan

Aplikasi ini terutama menggunakan halaman Blade dan formulir web, bukan REST API penuh. Route terdaftar melalui `routes/web.php` (middleware web/session/CSRF). Endpoint yang mengembalikan JSON secara langsung saat ini adalah tiga endpoint berikut. URL, aturan akses, dan respons di bawah mengikuti implementasi saat dokumentasi dibuat.

Base URL contoh: `https://nama-domain-anda`

### 1. Data operasional

| Atribut | Nilai |
|---|---|
| Method dan URL | `GET /api/operasional` |
| Tujuan | Mengambil satu baris pengaturan operasional wisata |
| Akses | Publik |
| Parameter | Tidak ada |
| Respons sukses | `200 OK`, objek pengaturan operasional |

Contoh respons (nilai dapat berubah):

```json
{
  "id": 1,
  "suhu": "28°C",
  "kondisi_cuaca": "Cerah",
  "status_angin": "Tenang",
  "peringatan_cuaca": "Normal",
  "kuota_pengunjung": 1200,
  "pengunjung_aktif": 0,
  "status_suaran": "Normal",
  "buletin_lapangan": null,
  "status_gerbang": "Buka Normal",
  "zona_terumbu_karang": 320,
  "zona_terumbu_max": 400,
  "zona_mangrove": 180,
  "zona_mangrove_max": 250,
  "status_dermaga": "Aktif",
  "info_dermaga": null,
  "created_at": "2026-11-09T00:00:00.000000Z",
  "updated_at": "2026-11-09T00:00:00.000000Z"
}
```

Jika tabel pengaturan belum berisi data, model membuat nilai awal lalu mengembalikannya. Kegagalan server/database menghasilkan status error server; respons detail teknis tidak ditampilkan pada mode produksi.

### 2. Status booking pengunjung

| Atribut | Nilai |
|---|---|
| Method dan URL | `GET /api/check-status` |
| Tujuan | Mengambil status booking milik pengunjung yang sedang login |
| Akses | Login dengan role `pengunjung` |
| Parameter | Tidak ada |
| Respons sukses | `200 OK`, objek dengan ID booking sebagai key dan status pembayaran sebagai value |

Contoh:

```json
{
  "12": "pending",
  "15": "verified"
}
```

Objek kosong `{}` berarti tidak ada booking milik akun tersebut. Role yang tidak sesuai atau sesi login yang tidak tersedia diarahkan ke halaman login pengunjung oleh middleware web (redirect, bukan respons API `401`).

### 3. Detail booking admin

| Atribut | Nilai |
|---|---|
| Method dan URL | `GET /admin/booking/{id}/detail` |
| Tujuan | Mengambil ringkasan detail booking untuk panel admin |
| Akses | Login dan role `admin` |
| Parameter path | `id` — ID booking |
| Respons sukses | `200 OK`, objek detail booking |

Contoh respons:

```json
{
  "booking_code": "KP-20261109123000-123",
  "visitor_name": "Nama Pengunjung",
  "phone": "081234567890",
  "email": "pengunjung@example.test",
  "wisata": "-",
  "booking_date": "10 Nov 2026",
  "quantity": 2,
  "total_price": "60000.00",
  "status": "pending"
}
```

Booking yang tidak ditemukan menghasilkan `404`. Pengguna tanpa autentikasi diarahkan ke login; role selain admin menerima `403`.

## Pengajuan booking (formulir web, bukan JSON API)

`POST /pembayaran/proses` dipakai formulir pengunjung dan menerima `multipart/form-data` dengan token CSRF:

| Field | Aturan utama |
|---|---|
| `nama_pengunjung` | Wajib, teks, maksimum 255 karakter |
| `email` | Wajib, format email, maksimum 255 karakter |
| `no_hp` | Wajib, teks 10–20 karakter |
| `tanggal_kunjungan` | Wajib, tanggal hari ini atau setelahnya |
| `jumlah_tiket` | Wajib, integer 1–100 |
| `metode_pembayaran` | Wajib: `qris`, `va`, atau `transfer` |
| `cart_data` | String JSON berisi array item; setiap item memerlukan nama, harga, dan jumlah (`qty` atau `quantity`) |
| `bukti_pembayaran` | Wajib, JPEG/PNG/JPG, maksimum 2 MB |

Formulir memvalidasi isi keranjang dan membatasi total kuantitas menjadi 100. Berhasil: booking berstatus `pending` dibuat dan browser diarahkan ke halaman `/tiket`. Gagal validasi: browser kembali ke formulir dengan pesan validasi. Endpoint ini bukan endpoint JSON dan mengandalkan sesi web/CSRF.

## Status dan penanganan kegagalan

- Booking pembayaran menggunakan `pending`, `verified`, atau `rejected` sebagai status yang ditulis oleh alur aktif.
- Request formulir yang tidak valid dikembalikan ke halaman sebelumnya dengan error validasi.
- Route yang membutuhkan sesi menggunakan perilaku redirect middleware Laravel; route admin membatasi akses berdasarkan role.
- Jangan mengirim atau menyimpan password, token sesi, bukti pembayaran, atau kredensial database di contoh request publik.

## Batasan saat ini

Tidak ada route terpisah di `routes/api.php`, dan belum ada kontrak JSON untuk CRUD paket, registrasi, pembayaran, atau perubahan status. Route admin/pengelola lainnya adalah formulir web yang menggunakan sesi dan CSRF; jangan menganggapnya sebagai API publik. Jika API eksternal ditambahkan, dokumentasi autentikasi, validasi, error schema, dan versi API perlu dibuat bersama implementasinya.
