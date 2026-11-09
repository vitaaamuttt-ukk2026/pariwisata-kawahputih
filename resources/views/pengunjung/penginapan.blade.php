<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kawah Putih - Daftar Penginapan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { 
                extend: { 
                    fontFamily: { poppins: ['Poppins', 'sans-serif'] },
                    colors: { 
                        kawah: { 50:'#f0fdf4',100:'#dcfce7',500:'#52b788',700:'#2d6a4f',800:'#1b4332',900:'#081c15' } 
                    } 
                } 
            }
        }
    </script>
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('pengunjung.index') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-kawah-500 rounded-lg flex items-center justify-center text-white"><i class="fas fa-mountain"></i></div>
                <div><h1 class="font-bold text-gray-800">Kawah Putih</h1><p class="text-xs text-gray-500">ISLAGEST ECO SYSTEM</p></div>
            </a>
            <div class="flex gap-6">
                <a href="{{ route('pengunjung.index') }}" class="text-gray-600 hover:text-kawah-700">Beranda</a>
                <a href="{{ route('pengunjung.wisata') }}" class="text-gray-600 hover:text-kawah-700">Wisata</a>
                <a href="{{ route('pengunjung.penginapan') }}" class="text-kawah-700 font-semibold">Penginapan</a>
                <a href="{{ route('pengunjung.booking') }}" class="text-gray-600 hover:text-kawah-700">Booking</a>
            </div>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <div class="max-w-7xl mx-auto px-4 py-16 text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Daftar Penginapan & Villa</h1>
        <p class="text-gray-500 max-w-2xl mx-auto">Temukan berbagai pilihan akomodasi nyaman mulai dari glamping, cabin kayu, hingga villa eksklusif di sekitar Kawah Putih.</p>
        <a href="{{ route('pengunjung.index') }}" class="inline-block mt-8 px-6 py-3 bg-kawah-700 text-white rounded-lg hover:bg-kawah-800 transition">← Kembali ke Beranda</a>
    </div>
</body>
</html>