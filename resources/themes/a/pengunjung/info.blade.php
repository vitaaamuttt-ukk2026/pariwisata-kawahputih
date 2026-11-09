@extends('layouts.pengunjung')
@section('title', 'Info Kawah Putih')

@section('content')
<section class="page-shell flex flex-col gap-space-xl w-full mb-space-xl">
  
  <!-- HEADER SECTION -->
  <div class="glass-panel p-5 md:p-6 flex flex-col gap-1">
    <div class="section-heading">
      <span class="material-symbols-outlined text-[16px]">info</span><span>Panduan Lengkap Destinasi</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-on-surface">Informasi Wisata Kawah Putih</h2>
    <p class="text-body-md text-on-surface-variant max-w-3xl">Kenali lebih dalam keindahan Kawah Putih, dari sejarah, fasilitas, hingga tips perjalanan agar liburan Anda sempurna.</p>
  </div>

  <!-- 1. DESKRIPSI & SEJARAH SINGKAT -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-space-lg items-center">
    <div class="soft-card p-5 md:p-6 flex flex-col gap-space-md">
      <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
        <span class="material-symbols-outlined text-primary">history_edu</span> Sejarah & Deskripsi
      </h3>
      <p class="text-body-md text-on-surface-variant leading-relaxed">
        <strong class="text-on-surface">Kawah Putih</strong> adalah sebuah tempat wisata di Jawa Barat yang terletak di kawasan Gunung Patuha, Ciwidey, Bandung. Kawah ini terbentuk dari letusan Gunung Patuha pada abad ke-10. 
      </p>
      <p class="text-body-md text-on-surface-variant leading-relaxed">
        Keunikan utama Kawah Putih adalah danau kawahnya yang berwarna putih kehijauan (toska) akibat dominasi unsur belerang. Warna airnya bisa berubah-ubah tergantung pada suhu, cuaca, dan kandungan belerang saat itu. Kawasan ini dikelola oleh Perum Perhutani dan merupakan bagian dari Cagar Alam Gunung Patuha.
      </p>
    </div>
    <div class="relative h-64 lg:h-full min-h-[300px] rounded-2xl overflow-hidden shadow-md group soft-card p-0">
      <img src="https://images.unsplash.com/photo-1604608672516-f1b9b1d1f1f3?w=800&q=80" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Kawah Putih">
      <div class="absolute inset-0 bg-gradient-to-t from-on-surface/60 to-transparent"></div>
      <div class="absolute bottom-4 left-4 text-white">
        <span class="font-label-sm text-label-sm bg-primary px-2 py-1 rounded-md">Cagar Alam Gunung Patuha</span>
      </div>
    </div>
  </div>

  <!-- 2. INFORMASI PRAKTIS (Lokasi, Jam, Fasilitas) -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
    <!-- Lokasi -->
    <div class="soft-card p-space-lg flex flex-col gap-space-sm">
      <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
        <span class="material-symbols-outlined text-[24px]">location_on</span>
      </div>
      <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold">Lokasi</h4>
      <p class="text-body-sm text-on-surface-variant">Jl. Raya Soreang-Ciwidey KM 25, Sugihmukti, Kec. Pasirjambu, Kabupaten Bandung, Jawa Barat 40973.</p>
      <a href="https://maps.app.goo.gl/kawahputih" target="_blank" class="text-primary font-label-sm text-label-sm font-semibold flex items-center gap-1 hover:underline mt-auto">
        <span class="material-symbols-outlined text-[16px]">map</span> Buka di Google Maps
      </a>
    </div>

    <!-- Jam Operasional -->
    <div class="soft-card p-space-lg flex flex-col gap-space-sm">
      <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center">
        <span class="material-symbols-outlined text-[24px]">schedule</span>
      </div>
      <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold">Jam Operasional</h4>
      <ul class="text-body-sm text-on-surface-variant space-y-1">
        <li class="flex justify-between"><span>Senin - Jumat:</span> <span class="font-semibold text-on-surface">07:00 - 17:00</span></li>
        <li class="flex justify-between"><span>Sabtu - Minggu:</span> <span class="font-semibold text-on-surface">07:00 - 17:00</span></li>
        <li class="flex justify-between"><span>Hari Libur:</span> <span class="font-semibold text-on-surface">07:00 - 17:00</span></li>
      </ul>
    </div>

    <!-- Fasilitas -->
    <div class="soft-card p-space-lg flex flex-col gap-space-sm">
      <div class="w-10 h-10 rounded-xl bg-tertiary/10 text-tertiary flex items-center justify-center">
        <span class="material-symbols-outlined text-[24px]">room_service</span>
      </div>
      <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold">Fasilitas</h4>
      <div class="flex flex-wrap gap-2">
        <span class="px-2 py-1 bg-surface-container-low text-on-surface-variant text-[11px] font-semibold rounded-md flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">local_parking</span> Parkir Luas</span>
        <span class="px-2 py-1 bg-surface-container-low text-on-surface-variant text-[11px] font-semibold rounded-md flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">wc</span> Toilet Umum</span>
        <span class="px-2 py-1 bg-surface-container-low text-on-surface-variant text-[11px] font-semibold rounded-md flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">mosque</span> Musholla</span>
        <span class="px-2 py-1 bg-surface-container-low text-on-surface-variant text-[11px] font-semibold rounded-md flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">directions_bus</span> Shuttle Ontang-anting</span>
        <span class="px-2 py-1 bg-surface-container-low text-on-surface-variant text-[11px] font-semibold rounded-md flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">restaurant</span> Warung Makan</span>
        <span class="px-2 py-1 bg-surface-container-low text-on-surface-variant text-[11px] font-semibold rounded-md flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">photo_camera</span> Spot Foto</span>
      </div>
    </div>
  </div>

  <!-- 3. HARGA TIKET & WAHANA -->
  <div class="flex flex-col gap-space-md">
    <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
      <span class="material-symbols-outlined text-primary">payments</span> Harga Tiket & Wahana
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
      <!-- Tiket Masuk -->
      <div class="soft-card p-space-md relative border-2 border-primary">
        <div class="absolute -top-3 right-4 bg-primary text-on-primary text-[10px] font-bold px-2 py-1 rounded-full uppercase">Wajib</div>
        <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold mb-1">Tiket Masuk</h4>
        <p class="text-body-sm text-on-surface-variant mb-3">Akses masuk kawasan Kawah Putih.</p>
        <div class="space-y-2">
          <div class="flex justify-between text-sm"><span class="text-on-surface-variant">Domestik (WNI)</span><span class="font-bold text-primary">Rp 30.000</span></div>
          <div class="flex justify-between text-sm"><span class="text-on-surface-variant">Mancanegara (WNA)</span><span class="font-bold text-primary">Rp 80.000</span></div>
        </div>
      </div>
      <!-- Shuttle -->
      <div class="soft-card p-space-md">
        <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold mb-1">Shuttle Ontang-anting</h4>
        <p class="text-body-sm text-on-surface-variant mb-3">Transportasi PP dari parkir ke kawah.</p>
        <div class="flex justify-between text-sm mt-4"><span class="text-on-surface-variant">Per Orang</span><span class="font-bold text-on-surface">Rp 25.000</span></div>
      </div>
      <!-- Jembatan Ponton -->
      <div class="bg-surface-container-lowest p-space-md rounded-2xl shadow-sm border border-surface-container-high">
        <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold mb-1">Jembatan Ponton</h4>
        <p class="text-body-sm text-on-surface-variant mb-3">Jembatan apung di atas danau kawah.</p>
        <div class="flex justify-between text-sm mt-4"><span class="text-on-surface-variant">Per Orang</span><span class="font-bold text-on-surface">Rp 15.000</span></div>
      </div>
      <!-- Parkir -->
      <div class="bg-surface-container-lowest p-space-md rounded-2xl shadow-sm border border-surface-container-high">
        <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold mb-1">Area Parkir</h4>
        <p class="text-body-sm text-on-surface-variant mb-3">Parkir kendaraan di area bawah.</p>
        <div class="space-y-2 mt-2">
          <div class="flex justify-between text-sm"><span class="text-on-surface-variant">Motor</span><span class="font-bold text-on-surface">Rp 5.000</span></div>
          <div class="flex justify-between text-sm"><span class="text-on-surface-variant">Mobil</span><span class="font-bold text-on-surface">Rp 20.000</span></div>
        </div>
      </div>
    </div>
  </div>

  <!-- 4. HAL YANG HARUS DISIAPKAN -->
  <div class="bg-primary/5 border border-primary/20 rounded-2xl p-space-lg">
    <h3 class="font-headline-sm text-headline-sm text-primary font-bold mb-4 flex items-center gap-2">
      <span class="material-symbols-outlined">checklist</span> Hal yang Harus Disiapkan
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <ul class="space-y-3">
        <li class="flex items-start gap-3 text-body-sm text-on-surface-variant">
          <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
          <span><strong class="text-on-surface">Pakaian Hangat:</strong> Suhu di Kawah Putih bisa sangat dingin (10°C - 20°C), bawa jaket atau sweater.</span>
        </li>
        <li class="flex items-start gap-3 text-body-sm text-on-surface-variant">
          <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
          <span><strong class="text-on-surface">Masker:</strong> Sangat disarankan karena aroma belerang yang cukup menyengat di area kawah.</span>
        </li>
        <li class="flex items-start gap-3 text-body-sm text-on-surface-variant">
          <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
          <span><strong class="text-on-surface">Uang Tunai / QRIS:</strong> Untuk membayar tiket wahana tambahan, parkir, atau jajan di warung sekitar.</span>
        </li>
      </ul>
      <ul class="space-y-3">
        <li class="flex items-start gap-3 text-body-sm text-on-surface-variant">
          <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
          <span><strong class="text-on-surface">Sepatu Nyaman:</strong> Gunakan sepatu olahraga atau sandal yang nyaman untuk berjalan di area yang tidak rata.</span>
        </li>
        <li class="flex items-start gap-3 text-body-sm text-on-surface-variant">
          <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
          <span><strong class="text-on-surface">Tabir Surya & Kacamata:</strong> Lindungi kulit dan mata dari paparan sinar UV yang tinggi di dataran tinggi.</span>
        </li>
        <li class="flex items-start gap-3 text-body-sm text-on-surface-variant">
          <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">check_circle</span>
          <span><strong class="text-on-surface">Kantung Plastik:</strong> Untuk menyimpan pakaian basah atau sampah pribadi Anda (jangan buang di lokasi).</span>
        </li>
      </ul>
    </div>
  </div>

  <!-- 5. GALERI FOTO -->
  <div class="flex flex-col gap-space-md">
    <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
      <span class="material-symbols-outlined text-primary">photo_library</span> Galeri Foto Kawah Putih
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-space-sm">
      <div class="relative h-48 md:h-64 rounded-2xl overflow-hidden group cursor-pointer">
        <img src="https://images.unsplash.com/photo-1604608672516-f1b9b1d1f1f3?w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Kawah">
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
      </div>
      <div class="relative h-48 md:h-64 rounded-2xl overflow-hidden group cursor-pointer">
        <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Sunrise">
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
      </div>
      <div class="relative h-48 md:h-64 rounded-2xl overflow-hidden group cursor-pointer">
        <img src="https://images.unsplash.com/photo-1528127269322-539801943592?w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Jembatan">
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
      </div>
      <div class="relative h-48 md:h-64 rounded-2xl overflow-hidden group cursor-pointer">
        <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600&q=80" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Hutan">
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
      </div>
    </div>
  </div>

</section>
@endsection