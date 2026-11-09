@extends('layouts.pengunjung')
@section('title', 'Detail Kawah Putih')

@section('content')
<section class="w-full max-w-7xl mx-auto px-4 md:px-6 py-6 md:py-10">
  
  <!-- 1. HERO GALLERY -->
  <div class="relative rounded-2xl md:rounded-3xl overflow-hidden mb-8 shadow-lg group">
    <img src="https://images.unsplash.com/photo-1604608672516-f1b9b1d1f1f3?w=1200&q=80" 
         alt="Kawah Putih" class="w-full h-[300px] md:h-[500px] object-cover group-hover:scale-105 transition-transform duration-700">
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
    <div class="absolute bottom-0 left-0 p-6 md:p-10 text-white">
      <div class="flex items-center gap-2 mb-2">
        <span class="bg-primary text-on-primary px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Destinasi Populer</span>
        <div class="flex items-center gap-1 text-amber-400 text-sm font-bold">
          <span class="material-symbols-outlined text-[18px]">star</span> 4.8 (2.1k Review)
        </div>
      </div>
      <h1 class="text-3xl md:text-5xl font-bold mb-2">Kawah Putih Ciwidey</h1>
      <div class="flex items-center gap-2 text-white/90 text-sm md:text-base">
        <span class="material-symbols-outlined text-[20px]">location_on</span>
        <span>Ciwidey, Kabupaten Bandung, Jawa Barat</span>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- 2. KOLOM KIRI: INFORMASI LENGKAP -->
    <div class="lg:col-span-2 flex flex-col gap-8">
      
      <!-- Deskripsi -->
      <div class="bg-surface-container-lowest p-6 rounded-2xl border border-surface-container-high">
        <h2 class="text-xl font-bold text-on-surface mb-4 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">info</span> Tentang Destinasi
        </h2>
        <p class="text-body-md text-on-surface-variant leading-relaxed mb-4">
          Kawah Putih adalah sebuah tempat wisata di Jawa Barat yang terletak di kawasan Gunung Patuha, Ciwidey. 
          Kawah ini terbentuk dari letusan Gunung Patuha pada abad ke-10. Keunikan utamanya adalah danau kawah 
          yang berwarna putih kehijauan (toska) akibat dominasi unsur belerang. Warna airnya bisa berubah-ubah 
          tergantung pada suhu, cuaca, dan kandungan belerang saat itu.
        </p>
        
        <!-- Fasilitas -->
        <h3 class="text-lg font-bold text-on-surface mb-3 mt-6">Fasilitas Tersedia</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
          <div class="flex items-center gap-2 text-sm text-on-surface-variant">
            <span class="material-symbols-outlined text-primary text-[20px]">local_parking</span> Area Parkir Luas
          </div>
          <div class="flex items-center gap-2 text-sm text-on-surface-variant">
            <span class="material-symbols-outlined text-primary text-[20px]">directions_bus</span> Shuttle Ontang-anting
          </div>
          <div class="flex items-center gap-2 text-sm text-on-surface-variant">
            <span class="material-symbols-outlined text-primary text-[20px]">wc</span> Toilet Umum & Musholla
          </div>
          <div class="flex items-center gap-2 text-sm text-on-surface-variant">
            <span class="material-symbols-outlined text-primary text-[20px]">restaurant</span> Warung Makan & Cafe
          </div>
          <div class="flex items-center gap-2 text-sm text-on-surface-variant">
            <span class="material-symbols-outlined text-primary text-[20px]">photo_camera</span> Spot Foto Instagramable
          </div>
          <div class="flex items-center gap-2 text-sm text-on-surface-variant">
            <span class="material-symbols-outlined text-primary text-[20px]">medical_services</span> Pos P3K
          </div>
        </div>
      </div>

      <!-- Peta Lokasi -->
      <div class="bg-surface-container-lowest p-6 rounded-2xl border border-surface-container-high">
        <h2 class="text-xl font-bold text-on-surface mb-4 flex items-center gap-2">
          <span class="material-symbols-outlined text-primary">map</span> Lokasi & Rute
        </h2>
        <div class="rounded-xl overflow-hidden border border-surface-container-high h-64 md:h-80">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.399882837248!2d107.4083923147728!3d-7.166899999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e13799215209%3A0x6b44c8c8c8c8c8c8!2sKawah%20Putih!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid" 
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>

    </div>

    <!-- 3. KOLOM KANAN: WIDGET BOOKING STICKY -->
    <div class="lg:col-span-1">
      <div class="sticky top-6 bg-surface-container-lowest p-6 rounded-2xl border border-surface-container-high shadow-xl">
        <h3 class="text-xl font-bold text-on-surface mb-1">Pilih Tiket Masuk</h3>
        <p class="text-sm text-on-surface-variant mb-6">Mulai dari <span class="text-2xl font-bold text-primary">Rp 31.000</span> /orang</p>

        <div class="flex flex-col gap-4 mb-6">
          <!-- Opsi 1 -->
          <div class="flex items-center justify-between p-3 rounded-xl border border-surface-container-high hover:border-primary transition-colors cursor-pointer" onclick="selectTicket('wni', 31000)">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                <span class="material-symbols-outlined">person</span>
              </div>
              <div>
                <div class="font-semibold text-sm text-on-surface">Tiket Masuk WNI</div>
                <div class="text-xs text-on-surface-variant">Termasuk akses area kawah</div>
              </div>
            </div>
            <div class="font-bold text-primary">Rp 31.000</div>
          </div>

          <!-- Opsi 2 -->
          <div class="flex items-center justify-between p-3 rounded-xl border border-surface-container-high hover:border-primary transition-colors cursor-pointer" onclick="selectTicket('bundle', 63000)">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-lg bg-secondary/10 text-secondary flex items-center justify-center">
                <span class="material-symbols-outlined">card_travel</span>
              </div>
              <div>
                <div class="font-semibold text-sm text-on-surface">Paket WNI + Ontang-anting</div>
                <div class="text-xs text-on-surface-variant">Tiket + Shuttle PP (Best Value)</div>
              </div>
            </div>
            <div class="font-bold text-secondary">Rp 63.000</div>
          </div>
        </div>

        <!-- Kontrol Jumlah -->
        <div class="flex items-center justify-between bg-surface-container-low p-3 rounded-xl mb-6">
          <span class="text-sm font-semibold text-on-surface">Jumlah Pengunjung</span>
          <div class="flex items-center gap-3">
            <button type="button" onclick="updateDetailQty(-1)" class="w-8 h-8 rounded-lg bg-surface-container-lowest flex items-center justify-center hover:bg-surface-container-high transition-colors">
              <span class="material-symbols-outlined text-[18px]">remove</span>
            </button>
            <span id="detail-qty" class="text-lg font-bold text-on-surface w-6 text-center">1</span>
            <button type="button" onclick="updateDetailQty(1)" class="w-8 h-8 rounded-lg bg-primary text-on-primary flex items-center justify-center hover:opacity-90 transition-opacity">
              <span class="material-symbols-outlined text-[18px]">add</span>
            </button>
          </div>
        </div>

        <!-- Total & Tombol -->
        <div class="border-t border-surface-container-high pt-4">
          <div class="flex justify-between items-center mb-4">
            <span class="text-sm text-on-surface-variant">Total Estimasi</span>
            <span id="detail-total" class="text-2xl font-bold text-primary">Rp 31.000</span>
          </div>
          <button onclick="goToBookingFromDetail()" class="w-full bg-primary hover:bg-primary-container text-on-primary py-3.5 rounded-xl font-bold text-base flex items-center justify-center gap-2 shadow-lg shadow-primary/20 transition-all active:scale-95">
            <span class="material-symbols-outlined">shopping_cart</span>
            Pesan Sekarang
          </button>
          <p class="text-[11px] text-center text-on-surface-variant mt-3">
            <span class="material-symbols-outlined text-[14px] align-middle">shield</span> 
            Pembayaran aman & terverifikasi
          </p>
        </div>
      </div>
    </div>

  </div>
</section>

<script>
// Logika Pemilihan Tiket Sederhana untuk Halaman Detail
let selectedPrice = 31000;
let selectedName = "Tiket Masuk WNI";
let qty = 1;

function selectTicket(type, price) {
    selectedPrice = price;
    selectedName = type === 'wni' ? "Tiket Masuk WNI" : "Paket WNI + Ontang-anting PP";
    updateTotal();
    
    // Visual feedback (opsional: tambahkan class border-primary pada elemen yang diklik)
    alert("Anda memilih: " + selectedName);
}

function updateDetailQty(change) {
    qty += change;
    if (qty < 1) qty = 1;
    document.getElementById('detail-qty').innerText = qty;
    updateTotal();
}

function updateTotal() {
    const total = selectedPrice * qty;
    document.getElementById('detail-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
}

function goToBookingFromDetail() {
    // Siapkan data sesuai format yang diharapkan oleh halaman booking
    const cartData = [{
        id: 1, // ID dummy, bisa disesuaikan
        name: selectedName,
        price: selectedPrice,
        qty: qty
    }];

    // Simpan ke localStorage dengan key yang sama seperti di wisata.blade.php
    localStorage.setItem('kawah_putih_transfer', JSON.stringify(cartData));
    
    // Redirect ke halaman booking
    window.location.href = "{{ route('pengunjung.booking') }}";
}
</script>
@endsection