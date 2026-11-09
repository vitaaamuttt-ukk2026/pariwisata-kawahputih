<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kawah Putih Ciwidey Eco Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { poppins: ['Poppins', 'sans-serif'] },
                    colors: {
                        kawah: { 50:'#f0fdf4',100:'#dcfce7',200:'#bbf7d0',300:'#86efac',400:'#4ade80',500:'#52b788',600:'#40916c',700:'#2d6a4f',800:'#1b4332',900:'#081c15' }
                    }
                }
            }
        }
    </script>
    <style>body { font-family: 'Poppins', sans-serif; } .material-icons-round { font-family: 'Material Icons Round'; font-weight: normal; font-style: normal; display: inline-block; line-height: 1; }</style>
</head>
<body class="bg-gray-50 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 h-screen sticky top-0 flex flex-col hidden md:flex">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-kawah-500 rounded-lg flex items-center justify-center text-white">
                    <span class="material-icons-round">landscape</span>
                </div>
                <div>
                    <h1 class="font-bold text-gray-800">Kawah Putih</h1>
                    <p class="text-xs text-gray-500">Ciwidey Eco Portal</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('pengunjung.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-kawah-50 text-kawah-700 font-semibold transition">
                <span class="material-icons-round">space_dashboard</span> Dashboard
            </a>
            <a href="{{ route('pengunjung.wisata') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                <span class="material-icons-round">nature_people</span> Info Kawah Putih
            </a>
            <a href="{{ route('pengunjung.wisata') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                <span class="material-icons-round">explore</span> Pilihan Wisata
            </a>
            <a href="{{ route('pengunjung.booking') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                <span class="material-icons-round">shopping_cart</span> Booking & Pembayaran
            </a>
            <a href="{{ route('pengunjung.status') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-50 transition">
                <span class="material-icons-round">receipt_long</span> Status Tiket
            </a>
        </nav>
        <div class="p-4 border-t border-gray-100">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-red-500 hover:bg-red-50 transition text-sm">
                <span class="material-icons-round">logout</span> Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center sticky top-0 z-40">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <span class="material-icons-round text-base">home</span>
                <span>Portal Wisatawan</span>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-gray-400 hover:text-gray-600">
                    <span class="material-icons-round">shopping_cart</span>
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-kawah-500 text-white text-xs rounded-full flex items-center justify-center">0</span>
                </button>
                <div class="flex items-center gap-3 pl-4 border-l">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-800">Nita Puspitasari</p>
                        <p class="text-xs text-gray-500">Wisatawan</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-kawah-100 flex items-center justify-center text-kawah-700 font-bold">
                        <span class="material-icons-round">person</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-8 max-w-7xl mx-auto">
            <!-- Hero Section -->
            <div class="bg-gradient-to-br from-kawah-700 via-kawah-600 to-kawah-800 rounded-2xl p-8 text-white mb-8 relative overflow-hidden shadow-lg">
                <div class="absolute inset-0 opacity-20">
                    <img src="https://images.unsplash.com/photo-1604608672516-f1b9b1d1f1f3?w=1200&q=80" class="w-full h-full object-cover">
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-icons-round text-3xl">landscape</span>
                        <span class="text-sm font-medium">Destinasi Konservasi Belerang Alami • Buka 07:00 - 17:00 WIB</span>
                    </div>
                    <h1 class="text-4xl font-bold mb-3">Selamat Datang di Kawah Putih, Ciwidey</h1>
                    <p class="text-kawah-100 text-lg mb-6 max-w-2xl">Jelajahi keindahan kawah vulkanik belerang toska alami berketinggian 2.434 mdpl.</p>
                    <div class="flex gap-3 flex-wrap">
                        <a href="{{ route('pengunjung.booking') }}" class="bg-white text-kawah-700 px-6 py-3 rounded-lg font-semibold hover:bg-kawah-50 transition flex items-center gap-2">
                            <span class="material-icons-round">shopping_cart</span> Pesan Tiket Sekarang
                        </a>
                        <a href="{{ route('pengunjung.wisata') }}" class="bg-kawah-900/50 backdrop-blur text-white px-6 py-3 rounded-lg font-semibold hover:bg-kawah-900/70 transition border border-white/30 flex items-center gap-2">
                            <span class="material-icons-round">info</span> Pelajari Info Wisata
                        </a>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="material-icons-round text-kawah-600">foggy</span>
                        <span class="text-sm text-gray-500">Cuaca Terkini</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">19°C</p>
                    <p class="text-xs text-gray-500">Sejuk Berkabut</p>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="material-icons-round text-kawah-600">group</span>
                        <span class="text-sm text-gray-500">Kepadatan Hari Ini</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">Sedang</p>
                    <p class="text-xs text-gray-500">45% dari Daya Tampung</p>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="material-icons-round text-kawah-600">payments</span>
                        <span class="text-sm text-gray-500">Tarif Resmi</span>
                    </div>
                    <p class="text-lg font-bold text-gray-800">Rp 30.000 <span class="text-sm font-normal text-gray-500">/ Domestik</span></p>
                    <p class="text-xs text-gray-500">Rp 80.000 / Mancanegara</p>
                </div>
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="material-icons-round text-kawah-600">verified</span>
                        <span class="text-sm text-gray-500">Status Wahana</span>
                    </div>
                    <p class="text-2xl font-bold text-green-600">100% Aktif</p>
                    <p class="text-xs text-gray-500">Semua Jalur Dibuka</p>
                </div>
            </div>

            <!-- Destinasi Section -->
            <div class="mb-10">
                <div class="flex items-center gap-2 mb-6">
                    <span class="material-icons-round text-kawah-600 text-2xl">nature_people</span>
                    <h2 class="text-xl font-bold text-gray-800">Panduan Lengkap Destinasi</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition">
                        <img src="https://images.unsplash.com/photo-1604608672516-f1b9b1d1f1f3?w=800&q=80" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 mb-1">Kawah Utama Patuha</h3>
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">Danau kawah vulkanik aktif berwarna putih kehijauan (toska) akibat dominasi unsur belerang.</p>
                            <div class="flex justify-between items-center text-xs text-gray-600">
                                <span class="flex items-center gap-1"><span class="material-icons-round text-sm">schedule</span> 07:00 - 17.00</span>
                                <span class="font-semibold text-kawah-700">Rp 30.000</span>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition">
                        <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=800&q=80" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 mb-1">Puncak Sunan Ibu</h3>
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">Titik tertinggi (2.223 mdpl). Menawarkan panorama sunrise yang memukau dengan latar belakang lautan awan.</p>
                            <div class="flex justify-between items-center text-xs text-gray-600">
                                <span class="flex items-center gap-1"><span class="material-icons-round text-sm">schedule</span> 05:00 - 08.00</span>
                                <span class="font-semibold text-kawah-700">Rp 10.000</span>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition">
                        <img src="https://images.unsplash.com/photo-1528127269322-539801943592?w=800&q=80" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 mb-1">Jembatan Ponton & Skywalk</h3>
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">Jembatan kayu apung yang memungkinkan pengunjung mendekati permukaan air kawah.</p>
                            <div class="flex justify-between items-center text-xs text-gray-600">
                                <span class="flex items-center gap-1"><span class="material-icons-round text-sm">warning</span> Wajib pelampung</span>
                                <span class="font-semibold text-kawah-700">Rp 15.000</span>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition">
                        <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&q=80" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 mb-1">Hutan Cantigi Purba</h3>
                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">Hutan endemik dengan pohon cantigi yang berusia ratusan tahun. Udara sejuk dan suasana mistis.</p>
                            <div class="flex justify-between items-center text-xs text-gray-600">
                                <span class="flex items-center gap-1"><span class="material-icons-round text-sm">schedule</span> 07:00 - 16.30</span>
                                <span class="font-semibold text-green-600">Gratis</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paket Tiket Section -->
            <div class="mb-10">
                <div class="flex items-center gap-2 mb-6">
                    <span class="material-icons-round text-kawah-600 text-2xl">travel_explore</span>
                    <h2 class="text-xl font-bold text-gray-800">Pilihan Tiket & Paket Wisata</h2>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-kawah-50/50 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-gray-800 flex items-center gap-2"><span class="material-icons-round text-kawah-600">volcano</span> Paket Lengkap Kawah Putih</h3>
                            <p class="text-sm text-gray-500">Bundle: Tiket Domestik + Shuttle PP + Jembatan Ponton. Hemat Rp 5.000!</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-kawah-700">Rp 65.000</p>
                            <p class="text-xs text-gray-400 line-through">Normal Rp 70.000</p>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <div class="p-4 flex justify-between items-center hover:bg-gray-50">
                            <div class="flex items-center gap-3">
                                <span class="material-icons-round text-gray-400">badge</span>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">Tiket Masuk (Domestik)</p>
                                    <p class="text-xs text-gray-500">Akses gerbang utama kawah belerang toska ikonik Patuha.</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-semibold text-gray-800">Rp 30.000</span>
                                <a href="{{ route('pengunjung.booking') }}" class="bg-kawah-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-kawah-700 flex items-center gap-1">
                                    <span class="material-icons-round text-sm">add_shopping_cart</span> Tambah
                                </a>
                            </div>
                        </div>
                        <div class="p-4 flex justify-between items-center hover:bg-gray-50">
                            <div class="flex items-center gap-3">
                                <span class="material-icons-round text-gray-400">directions_bus</span>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">Shuttle Ontang-Anting</p>
                                    <p class="text-xs text-gray-500">Transportasi resmi dari parkir bawah ke kawah (PP).</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-semibold text-gray-800">Rp 25.000</span>
                                <a href="{{ route('pengunjung.booking') }}" class="bg-kawah-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-kawah-700 flex items-center gap-1">
                                    <span class="material-icons-round text-sm">add_shopping_cart</span> Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>