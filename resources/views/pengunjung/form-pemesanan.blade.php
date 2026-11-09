<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Tiket Kawah Putih</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 py-10">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Form Pemesanan Tiket</h2>
        <p class="text-sm text-gray-500 mb-6">Silakan isi data diri dan pilih paket wisata sebelum melanjutkan ke pembayaran.</p>

        <form action="/proses-tiket" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nama Lengkap *</label>
                <input type="text" name="nama_pengunjung" class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-emerald-500" placeholder="Sesuai KTP / ID" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nomor WhatsApp / HP *</label>
                <input type="tel" name="no_hp" class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-emerald-500" placeholder="08xxxxxxxxxx" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Tanggal Kunjungan *</label>
                    <input type="date" name="tanggal_kunjungan" class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-emerald-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Jumlah Tiket *</label>
                    <input type="number" name="jumlah_tiket" min="1" value="1" class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-emerald-500" required>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Pilih Paket Wisata *</label>
                <select name="paket_wisata" class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-emerald-500" required>
                    <option value="">-- Pilih Paket --</option>
                    <option value="Reguler">Paket Reguler (Rp 30.000 / orang)</option>
                    <option value="Terusan">Paket Terusan Wahana (Rp 50.000 / orang)</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg transition mt-4">
                Lanjut ke Pembayaran QRIS
            </button>
        </form>
    </div>
</body>
</html>