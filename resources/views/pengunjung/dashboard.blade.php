@extends('layouts.pengunjung')
@section('title', 'Dashboard')

@section('content')
@php
    // LANGSUNG AMBIL DATA DARI DATABASE UNTUK MEMASTIKAN TAMPIL
    $heroImage = \App\Models\InfoContent::get('hero_image', '');
    $photoSpots = json_decode(\App\Models\InfoContent::get('photo_spots', '[]'), true) ?: [];
    $moodRecommendations = json_decode(\App\Models\InfoContent::get('mood_recommendations', '[]'), true) ?: [];
    
    // Data default jika admin belum mengedit mood
    if (empty($moodRecommendations)) {
        $moodRecommendations = [
            ['title' => 'Santai', 'subtitle' => 'Tenang & Sejuk', 'icon' => '🌴', 'color' => 'bg-emerald-50'],
            ['title' => 'Petualangan', 'subtitle' => 'Trekking & Sunrise', 'icon' => '🥾', 'color' => 'bg-orange-50'],
            ['title' => 'Romantis', 'subtitle' => 'Spot Foto Pasangan', 'icon' => '💕', 'color' => 'bg-pink-50'],
            ['title' => 'Keluarga', 'subtitle' => 'Aman untuk Anak', 'icon' => '👨‍👩‍👧', 'color' => 'bg-blue-50'],
        ];
    }
@endphp

<section class="w-full">
    <!-- Hero dengan Gambar Dinamis -->
    <div class="relative h-80 md:h-96 overflow-hidden rounded-b-3xl">
        @if(!empty($heroImage) && $heroImage !== '/storage/hero/default.jpg')
            <img src="{{ $heroImage }}" class="w-full h-full object-cover" alt="Kawah Putih">
        @else
            <img src="https://images.unsplash.com/photo-1596401057633-54a8fe8ef3b0?q=80&w=1600" class="w-full h-full object-cover" alt="Kawah Putih">
        @endif
        
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
        <div class="absolute bottom-0 left-0 p-6 md:p-10 text-white max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold mb-3 border border-white/30">
                <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                Buka 07:00 - 17:00 WIB
            </div>
            <h1 class="text-3xl md:text-5xl font-bold mb-2 leading-tight">Selamat Datang di Kawah Putih</h1>
            <p class="text-sm md:text-base text-white/90 mb-4">Jelajahi keindahan kawah vulkanik belerang tosca alami.</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('pengunjung.wisata') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">confirmation_number</span>
                    Pesan Tiket
                </a>
                <a href="{{ route('pengunjung.info') }}" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all flex items-center gap-2 border border-white/30">
                    <span class="material-symbols-outlined text-lg">info</span>
                    Detail & Info
                </a>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="max-w-7xl mx-auto px-4 md:px-6 -mt-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 md:p-5">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-amber-500 text-xl">wb_sunny</span>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cuaca</span>
                </div>
                <div class="text-2xl md:text-3xl font-bold text-gray-800" id="live-suhu">{{ $setting->suhu ?? '28°C' }}</div>
                <div class="text-sm text-gray-600 mt-1" id="live-cuaca">{{ $setting->kondisi_cuaca ?? 'Cerah' }}</div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 md:p-5">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-emerald-500 text-xl">groups</span>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Kepadatan</span>
                </div>
                <div class="text-2xl md:text-3xl font-bold text-gray-800" id="live-kepadatan">Sedang</div>
                <div class="text-sm text-gray-600 mt-1" id="live-kuota">0 / 1200</div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 md:p-5">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-blue-500 text-xl">payments</span>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tarif</span>
                </div>
                <div class="text-lg md:text-xl font-bold text-gray-800">Rp 31rb <span class="text-xs font-normal text-gray-500">/ WNI</span></div>
                <div class="text-sm text-gray-600 mt-1">Rp 90rb <span class="text-xs font-normal text-gray-500">/ WNA</span></div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 md:p-5">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-purple-500 text-xl">attractions</span>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Wahana</span>
                </div>
                <div class="text-2xl md:text-3xl font-bold text-emerald-600">100%</div>
                <div class="text-sm text-gray-600 mt-1">Aktif</div>
            </div>
        </div>

        <!-- Status Gerbang Banner -->
        <div id="live-gerbang-banner" class="mt-4 bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-600 text-2xl">door_front</span>
                <div>
                    <div class="text-sm font-semibold text-emerald-900">Status Gerbang</div>
                    <div class="text-xs text-emerald-700" id="live-gerbang">{{ $setting->status_gerbang ?? 'Buka Normal' }}</div>
                </div>
            </div>
            <div class="hidden md:flex items-center gap-2 text-xs text-emerald-700">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                Live Update
            </div>
        </div>

        <!-- Buletin Lapangan -->
        @if(!empty($setting->buletin_lapangan))
        <div class="mt-4 bg-amber-50 border border-amber-200 rounded-2xl p-4">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-amber-600 text-2xl">campaign</span>
                <div>
                    <div class="text-sm font-semibold text-amber-900 mb-1">Pengumuman Lapangan</div>
                    <div class="text-sm text-amber-800 leading-relaxed" id="live-buletin">{{ $setting->buletin_lapangan }}</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Rekomendasi Berdasarkan Mood (DINAMIS DARI ADMIN) -->
        <div class="mt-8">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">psychology</span>
                Rekomendasi Berdasarkan Mood
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach($moodRecommendations as $mood)
                <div class="{{ $mood['color'] ?? 'bg-white' }} border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all cursor-pointer">
                    <div class="text-2xl mb-2">{{ $mood['icon'] }}</div>
                    <div class="font-bold text-gray-800 text-sm">{{ $mood['title'] }}</div>
                    <div class="text-xs text-gray-500">{{ $mood['subtitle'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Spot Foto Favorit (DINAMIS DARI ADMIN) -->
        <div class="mt-8 mb-10">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">photo_camera</span>
                Spot Foto Favorit
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @forelse($photoSpots as $spot)
                <div class="relative rounded-xl overflow-hidden aspect-square group cursor-pointer">
                    <img src="{{ $spot['image'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="absolute bottom-3 left-3 text-white">
                        <div class="font-bold text-sm">{{ $spot['name'] }}</div>
                        <div class="text-xs text-white/80">{{ $spot['count'] }} Foto</div>
                    </div>
                </div>
                @empty
                <!-- Tampilan Default jika admin belum menambahkan -->
                <div class="col-span-full text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">photo_library</span>
                    <p class="text-gray-500 text-sm">Belum ada spot foto yang ditambahkan oleh admin.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Script Auto-Update Real-time dari Pengelola -->
<script>
async function loadOperasional() {
    try {
        const response = await fetch("{{ route('api.operasional') }}");
        const data = await response.json();
        
        if (data.suhu) document.getElementById('live-suhu').innerText = data.suhu;
        if (data.kondisi_cuaca) document.getElementById('live-cuaca').innerText = data.kondisi_cuaca;
        if (data.pengunjung_aktif && data.kuota_pengunjung) {
            const persen = (data.pengunjung_aktif / data.kuota_pengunjung) * 100;
            let kepadatan = 'Sepi';
            if (persen > 70) kepadatan = 'Padat';
            else if (persen > 40) kepadatan = 'Sedang';
            document.getElementById('live-kepadatan').innerText = kepadatan;
            document.getElementById('live-kuota').innerText = data.pengunjung_aktif + ' / ' + data.kuota_pengunjung;
        }
        if (data.status_gerbang) {
            document.getElementById('live-gerbang').innerText = data.status_gerbang;
            const banner = document.getElementById('live-gerbang-banner');
            if (data.status_gerbang === 'Tutup Sementara') {
                banner.className = 'mt-4 bg-red-50 border border-red-200 rounded-2xl p-4 flex items-center justify-between';
                banner.querySelector('.text-emerald-900').className = 'text-sm font-semibold text-red-900';
                banner.querySelector('.text-emerald-700').className = 'text-xs text-red-700';
            } else if (data.status_gerbang === 'Kuota Hampir Penuh') {
                banner.className = 'mt-4 bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-center justify-between';
            }
        }
        if (data.buletin_lapangan) {
            const buletinEl = document.getElementById('live-buletin');
            if (buletinEl) buletinEl.innerText = data.buletin_lapangan;
        }
    } catch (error) {
        console.log('Gagal memuat data operasional');
    }
}

loadOperasional();
setInterval(loadOperasional, 10000);
</script>
@endsection