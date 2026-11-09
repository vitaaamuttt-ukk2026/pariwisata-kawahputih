@extends('layouts.panel')
@section('title', 'Edit Dashboard')
@section('page-title', 'Kelola Dashboard Pengunjung')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', timer: 4000, showConfirmButton: false, toast: true, position: 'top-end' });
</script>
@endif

<div class="max-w-6xl mx-auto space-y-6 pb-10">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg">
        <h1 class="text-2xl font-bold flex items-center gap-3">
            <span class="material-symbols-outlined text-3xl">dashboard</span>
            Kelola Dashboard Pengunjung
        </h1>
        <p class="text-emerald-50 mt-2 text-sm">Ubah foto hero, hotel, spot foto, dan galeri yang tampil di halaman utama</p>
    </div>

    <!-- 1. FOTO HERO -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-emerald-50 px-6 py-4 border-b border-emerald-100">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">image</span>
                1. Foto Header (Hero)
            </h3>
        </div>
        <div class="p-6">
            @if($heroImage)
                <img src="{{ $heroImage }}" class="w-full h-64 object-cover rounded-xl mb-4 border">
            @endif
            
            <form method="POST" action="{{ route('admin.dashboard.updateHero') }}" enctype="multipart/form-data" id="heroForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Foto Baru (Maks 5MB)</label>
                    <input type="file" 
                           name="hero_image" 
                           id="hero_image"
                           accept="image/*" 
                           required 
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4 
                                  file:rounded-lg file:border-0 
                                  file:text-sm file:font-semibold 
                                  file:bg-emerald-50 file:text-emerald-700 
                                  hover:file:bg-emerald-100
                                  border border-gray-300 rounded-lg">
                </div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-6 rounded-lg">
                    Simpan Foto
                </button>
            </form>
        </div>
    </div>

    <!-- 2. SPOT FOTO -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-purple-50 px-6 py-4 border-b border-purple-100">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-purple-600">photo_camera</span>
                2. Spot Foto Favorit
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                @forelse($photoSpots as $index => $spot)
                <div class="relative rounded-xl overflow-hidden border border-gray-200 bg-white">
                    <img src="{{ $spot['image'] }}" class="w-full h-32 object-cover">
                    <div class="p-2">
                        <div class="font-bold text-sm text-gray-800">{{ $spot['name'] }}</div>
                        <div class="text-xs text-gray-500">{{ $spot['count'] }} Foto</div>
                    </div>
                    <form method="POST" action="{{ route('admin.dashboard.deletePhotoSpot', $index) }}" class="absolute top-2 right-2" onsubmit="return confirm('Hapus?')">
                        @csrf
                        <button class="bg-red-500 text-white rounded-full w-6 h-6 text-xs">×</button>
                    </form>
                </div>
                @empty
                <div class="col-span-full text-center py-8 bg-gray-50 rounded-xl text-gray-400 text-sm">Belum ada spot foto.</div>
                @endforelse
            </div>
            
            <form method="POST" action="{{ route('admin.dashboard.addPhotoSpot') }}" enctype="multipart/form-data" class="border-t pt-4 space-y-3">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <input type="text" name="spot_name" placeholder="Nama Spot" required class="border border-gray-300 rounded-lg p-2.5">
                    <input type="text" name="spot_count" placeholder="Jumlah (cth: 1.2k)" required class="border border-gray-300 rounded-lg p-2.5">
                    <input type="file" name="spot_image" accept="image/*" required class="border border-gray-300 rounded-lg p-2.5">
                </div>
                <button type="submit" class="bg-purple-600 text-white px-6 py-2.5 rounded-lg font-semibold">+ Tambah Spot Foto</button>
            </form>
        </div>
    </div>

    <!-- 3. HOTEL -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-600">hotel</span>
            3. Rekomendasi Penginapan
        </h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            @forelse($hotels as $index => $hotel)
            <div class="border rounded-xl overflow-hidden relative bg-white">
                <img src="{{ $hotel['image'] }}" class="w-full h-40 object-cover">
                <div class="p-3">
                    <div class="font-bold">{{ $hotel['name'] }}</div>
                    <div class="text-emerald-600 text-sm">{{ $hotel['price'] }}</div>
                    <div class="text-xs text-gray-500">{{ $hotel['desc'] }}</div>
                    @if(!empty($hotel['link']))
                        <a href="{{ $hotel['link'] }}" target="_blank" class="inline-block mt-2 text-xs text-blue-600 hover:underline font-medium">🔗 Lihat Detail</a>
                    @endif
                </div>
                <form method="POST" action="{{ route('admin.dashboard.deleteHotel', $index) }}" class="absolute top-2 right-2" onsubmit="return confirm('Hapus?')">
                    @csrf
                    <button class="bg-red-500 text-white rounded-full w-6 h-6 text-xs">×</button>
                </form>
            </div>
            @empty
            <div class="col-span-full text-center py-8 bg-gray-50 rounded-xl text-gray-400 text-sm">Belum ada hotel.</div>
            @endforelse
        </div>
        
        <form method="POST" action="{{ route('admin.dashboard.addHotel') }}" enctype="multipart/form-data" class="border-t pt-4 space-y-3">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <input type="text" name="hotel_name" placeholder="Nama Hotel" required class="border border-gray-300 rounded-lg p-2.5">
                <input type="text" name="hotel_price" placeholder="Harga (cth: Rp 350rb/malam)" required class="border border-gray-300 rounded-lg p-2.5">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <input type="url" name="hotel_link" placeholder="Link Website / Booking (Opsional - cth: https://traveloka.com/hotel123)" class="border border-gray-300 rounded-lg p-2.5">
                <input type="text" name="hotel_desc" placeholder="Deskripsi singkat fasilitas" class="border border-gray-300 rounded-lg p-2.5">
            </div>
            <div class="flex gap-3">
                <input type="file" name="hotel_image" accept="image/*" required class="flex-1 border border-gray-300 rounded-lg p-2.5">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold">+ Tambah Hotel</button>
            </div>
        </form>
    </div>
</div>

    <!-- 4. GALERI -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-amber-50 px-6 py-4 border-b border-amber-100">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-600">gallery_thumbnail</span>
                4. Galeri Foto
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                @forelse($gallery as $index => $img)
                <div class="relative rounded-xl overflow-hidden aspect-square border border-gray-200">
                    <img src="{{ $img }}" class="w-full h-full object-cover">
                    <form method="POST" action="{{ route('admin.dashboard.deleteGallery', $index) }}" class="absolute top-2 right-2" onsubmit="return confirm('Hapus?')">
                        @csrf
                        <button class="bg-red-500 text-white rounded-full w-6 h-6 text-xs">×</button>
                    </form>
                </div>
                @empty
                <div class="col-span-full text-center py-8 bg-gray-50 rounded-xl text-gray-400 text-sm">Belum ada galeri.</div>
                @endforelse
            </div>
            
            <form method="POST" action="{{ route('admin.dashboard.addGallery') }}" enctype="multipart/form-data" class="border-t pt-4 flex gap-3">
                @csrf
                <input type="file" name="gallery_image" accept="image/*" required class="flex-1 border border-gray-300 rounded-lg p-2.5">
                <button type="submit" class="bg-amber-600 text-white px-6 py-2.5 rounded-lg font-semibold">+ Tambah Foto</button>
            </form>
        </div>
    </div>

</div>

<script>
// Debug: Cek apakah form memiliki enctype yang benar
document.addEventListener('DOMContentLoaded', function() {
    const heroForm = document.getElementById('heroForm');
    if (heroForm) {
        console.log('Form enctype:', heroForm.enctype);
        console.log('Form action:', heroForm.action);
        console.log('Form method:', heroForm.method);
    }
});
</script>
@endsection