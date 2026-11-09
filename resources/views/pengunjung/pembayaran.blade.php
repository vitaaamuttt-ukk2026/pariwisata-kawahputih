<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket Kawah Putih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 py-10">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Form Pemesanan Tiket</h2>
        <p class="text-sm text-gray-500 mb-6">Silakan isi data diri dan pilih paket wisata sebelum melanjutkan ke pembayaran.</p>

        <!-- Action diarahkan ke route Laravel yang benar -->
        <form action="{{ route('pengunjung.pembayaran.proses') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nama Lengkap *</label>
                <input type="text" name="nama_pengunjung" class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="Sesuai KTP / ID" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nomor WhatsApp / HP *</label>
                <input type="tel" name="no_hp" class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" placeholder="08xxxxxxxxxx" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Tanggal Kunjungan *</label>
                    <input type="date" name="tanggal_kunjungan" class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Jumlah Tiket *</label>
                    <input type="number" name="jumlah_tiket" min="1" value="1" class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" required>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Pilih Paket Wisata *</label>
                <select name="paket_wisata" class="w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none" required>
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

    <div class="flex flex-col gap-1">
    <label>Upload Bukti Pembayaran</label>
    <input type="file" name="foto_bukti" accept=".jpg,.jpeg,.png">
    @error('foto_bukti')
        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
    @enderror
    </div>
</body>
</html>