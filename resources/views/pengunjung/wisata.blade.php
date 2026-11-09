@extends('layouts.pengunjung')
@section('title', 'Pilihan Paket Wisata')

@section('content')
<section class="w-full max-w-7xl mx-auto px-4 py-8 pb-24">
  
  <!-- Hero Section - Hijau Kalem -->
  <div class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-green-50 to-teal-50 rounded-3xl mb-10 border border-emerald-100">
    <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-100/50 rounded-full blur-3xl -mr-32 -mt-32"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-100/50 rounded-full blur-3xl -ml-32 -mb-32"></div>
    
    <div class="relative z-10 px-8 md:px-12 py-12 md:py-16">
      <div class="inline-flex items-center gap-2 bg-emerald-100/70 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-semibold text-emerald-700 mb-4 border border-emerald-200">
        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
        Buka Setiap Hari 07.00 - 17.00 WIB
      </div>
      <h1 class="text-3xl md:text-5xl font-bold text-emerald-900 mb-3 leading-tight">
        Jelajahi Keindahan<br>
        <span class="text-emerald-600">Kawah Putih</span>
      </h1>
      <p class="text-sm md:text-base text-emerald-700/80 max-w-2xl mb-6">
        Nikmati pengalaman tak terlupakan di salah satu destinasi wisata terindah di Jawa Barat. Pilih paket wisata favoritmu dan buat kenangan indah bersama keluarga.
      </p>
      <div class="flex flex-wrap gap-3">
        <div class="bg-white/70 backdrop-blur-sm px-4 py-2 rounded-xl border border-emerald-100">
          <div class="text-xl font-bold text-emerald-800">⭐ 4.8</div>
          <div class="text-[10px] text-emerald-600">Rating Pengunjung</div>
        </div>
        <div class="bg-white/70 backdrop-blur-sm px-4 py-2 rounded-xl border border-emerald-100">
          <div class="text-xl font-bold text-emerald-800">🌿 50+</div>
          <div class="text-[10px] text-emerald-600">Aktivitas Seru</div>
        </div>
        <div class="bg-white/70 backdrop-blur-sm px-4 py-2 rounded-xl border border-emerald-100">
          <div class="text-xl font-bold text-emerald-800">👥 10K+</div>
          <div class="text-[10px] text-emerald-600">Pengunjung/Bulan</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Konten Paket Wisata -->
  @php
    $kategoriConfig = [
        'tiket_masuk' => [
            'title' => 'Tiket Masuk', 
            'icon' => 'badge',
            'bg' => 'bg-emerald-50',
            'text' => 'text-emerald-700',
            'border' => 'border-emerald-100',
            'btn' => 'bg-emerald-600 hover:bg-emerald-700 text-white',
            'price' => 'text-emerald-700'
        ],
        'paket_bundle' => [
            'title' => 'Paket Bundle', 
            'icon' => 'card_travel',
            'bg' => 'bg-teal-50',
            'text' => 'text-teal-700',
            'border' => 'border-teal-100',
            'btn' => 'bg-teal-600 hover:bg-teal-700 text-white',
            'price' => 'text-teal-700'
        ],
        'transportasi' => [
            'title' => 'Transportasi & Parkir', 
            'icon' => 'directions_bus',
            'bg' => 'bg-green-50',
            'text' => 'text-green-700',
            'border' => 'border-green-100',
            'btn' => 'bg-green-600 hover:bg-green-700 text-white',
            'price' => 'text-green-700'
        ],
        'wahana' => [
            'title' => 'Wahana & Aktivitas', 
            'icon' => 'sports_esports',
            'bg' => 'bg-lime-50',
            'text' => 'text-lime-700',
            'border' => 'border-lime-100',
            'btn' => 'bg-lime-600 hover:bg-lime-700 text-white',
            'price' => 'text-lime-700'
        ],
        'layanan' => [
            'title' => 'Layanan Tambahan', 
            'icon' => 'room_service',
            'bg' => 'bg-slate-50',
            'text' => 'text-slate-700',
            'border' => 'border-slate-200',
            'btn' => 'bg-slate-600 hover:bg-slate-700 text-white',
            'price' => 'text-slate-700'
        ],
    ];
  @endphp

  @foreach($kategoriConfig as $key => $config)
    @if(isset($groupedPakets[$key]) && $groupedPakets[$key]->count() > 0)
    <div class="mb-10">
      <!-- Header Kategori -->
      <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl {{ $config['bg'] }} {{ $config['text'] }} flex items-center justify-center">
          <span class="material-symbols-outlined text-xl">{{ $config['icon'] }}</span>
        </div>
        <h2 class="text-xl md:text-2xl font-bold text-gray-800">{{ $config['title'] }}</h2>
        <div class="flex-1 h-px bg-gray-200"></div>
        <span class="text-xs text-gray-500 font-medium">{{ $groupedPakets[$key]->count() }} paket</span>
      </div>

      <!-- Grid Kartu Paket -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($groupedPakets[$key] as $paket)
        <div class="group h-full bg-white rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-lg transition-all duration-300 overflow-hidden">
          
          <!-- Badge -->
          @if($paket->badge)
          <div class="px-5 pt-4 flex justify-end">
            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
              {{ $paket->badge }}
            </span>
          </div>
          @endif

          <!-- Konten Kartu -->
          <div class="flex h-full flex-col p-5">
            <div class="flex items-start gap-3 mb-3">
              <div class="w-11 h-11 rounded-xl {{ $config['bg'] }} {{ $config['text'] }} flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-xl">{{ $paket->icon ?? $config['icon'] }}</span>
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="min-h-10 font-bold text-gray-800 text-base leading-tight mb-1">{{ $paket->nama }}</h3>
                <p class="min-h-8 text-xs text-gray-500 line-clamp-2">{{ $paket->deskripsi ?? 'Nikmati pengalaman terbaik di Kawah Putih' }}</p>
              </div>
            </div>

            <!-- Harga -->
            <div class="{{ $config['bg'] }} rounded-xl p-3 mb-4 border {{ $config['border'] }} mt-auto">
              <div class="text-[10px] {{ $config['text'] }} opacity-70 mb-0.5">Harga</div>
              <div class="text-lg font-bold {{ $config['price'] }}">Rp {{ number_format($paket->harga, 0, ',', '.') }}</div>
            </div>

            <!-- Kontrol Quantity -->
            <div class="flex items-center justify-between bg-gray-50 rounded-xl p-2 mb-3 border border-gray-100">
              <button type="button" onclick="updateQty('qty-{{ $paket->id }}', -1)" class="w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-600 hover:bg-gray-100 transition-colors">
                <span class="material-symbols-outlined text-lg">remove</span>
              </button>
              <span id="qty-{{ $paket->id }}" class="text-lg font-bold text-gray-800 w-10 text-center">0</span>
              <button type="button" onclick="updateQty('qty-{{ $paket->id }}', 1)" class="w-9 h-9 rounded-lg {{ $config['btn'] }} flex items-center justify-center transition-colors shadow-sm">
                <span class="material-symbols-outlined text-lg">add</span>
              </button>
            </div>

            <!-- Tombol Tambah -->
            <button id="btn-{{ $paket->id }}" data-package-name="{{ $paket->nama }}" disabled aria-disabled="true" onclick="addToCart({{ $paket->id }}, this.dataset.packageName, {{ $paket->harga }}, 'qty-{{ $paket->id }}')" class="w-full py-2.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl font-semibold transition-all flex items-center justify-center gap-2 disabled:cursor-not-allowed enabled:bg-emerald-600 enabled:text-white enabled:border-emerald-600 enabled:hover:bg-emerald-700">
              <span class="material-symbols-outlined text-lg text-emerald-700">add_shopping_cart</span>
              <span>Tambah ke Keranjang</span>
            </button>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  @endforeach

  @if(!isset($groupedPakets) || collect($groupedPakets)->flatten()->isEmpty())
  <div class="text-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-200">
    <span class="material-symbols-outlined text-6xl text-gray-300 mb-3">storefront</span>
    <h3 class="text-xl font-bold text-gray-700 mb-1">Belum Ada Paket Wisata</h3>
    <p class="text-sm text-gray-500">Admin belum menambahkan paket wisata.</p>
  </div>
  @endif
</section>

<!-- Sticky Cart Bar -->
<div id="cart-bar" class="fixed bottom-0 left-0 right-0 md:left-64 bg-white border-t border-emerald-200 p-4 shadow-2xl z-50 transform translate-y-full transition-transform duration-300">
  <div class="max-w-7xl mx-auto flex items-center justify-between">
    <div class="flex items-center gap-3">
      <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
        <span class="material-symbols-outlined text-2xl">shopping_bag</span>
      </div>
      <div>
        <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Pesanan</div>
        <div class="flex items-baseline gap-2">
          <span id="cart-total-items" class="text-xl font-bold text-gray-800">0</span>
          <span class="text-gray-400 text-sm">item</span>
          <span class="text-gray-300 mx-1">•</span>
          <span id="cart-total-price" class="text-xl font-bold text-emerald-600">Rp 0</span>
        </div>
      </div>
    </div>
    <button onclick="goToBooking()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition-all flex items-center gap-2">
      <span class="text-sm">Lanjut ke Pembayaran</span>
      <span class="material-symbols-outlined text-lg">arrow_forward</span>
    </button>
  </div>
</div>

<script>
var CART_KEY = 'kawah_putih_cart';
var TRANSFER_KEY = 'kawah_putih_transfer';

var cart = [];
try {
    var savedCart = localStorage.getItem(CART_KEY);
    if (savedCart) {
        cart = JSON.parse(savedCart);
        if (!Array.isArray(cart)) {
            cart = [];
        }
    }
} catch (e) {
    cart = [];
}

function updateQty(qtyId, change) {
    var el = document.getElementById(qtyId);
    var val = parseInt(el.innerText) + change;
    if (val < 0) val = 0;
    el.innerText = val;
    
    var btnId = qtyId.replace('qty-', 'btn-');
    var btn = document.getElementById(btnId);
    if (btn) {
        btn.disabled = (val === 0);
        btn.setAttribute('aria-disabled', String(val === 0));
        if (val > 0) {
            btn.classList.remove('bg-emerald-50', 'text-emerald-800', 'border-emerald-200');
            btn.classList.add('bg-emerald-600', 'text-white', 'border-emerald-600', 'hover:bg-emerald-700');
            btn.querySelector('.material-symbols-outlined').classList.remove('text-emerald-700');
            btn.querySelector('.material-symbols-outlined').classList.add('text-white');
        } else {
            btn.classList.remove('bg-emerald-600', 'text-white', 'border-emerald-600', 'hover:bg-emerald-700');
            btn.classList.add('bg-emerald-50', 'text-emerald-800', 'border-emerald-200');
            btn.querySelector('.material-symbols-outlined').classList.remove('text-white');
            btn.querySelector('.material-symbols-outlined').classList.add('text-emerald-700');
        }
    }
}

function addToCart(id, name, price, qtyId) {
    var el = document.getElementById(qtyId);
    var qty = parseInt(el.innerText) || 0;
    if (qty <= 0) return;
    
    var existing = cart.find(function(item) { return item.id == id; });
    if (existing) {
        existing.qty += qty;
    } else {
        cart.push({ id: id, name: name, price: price, qty: qty });
    }
    
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    el.innerText = '0';
    updateQty(qtyId, 0);
    updateCartBar();
    
    // Animasi feedback pada tombol
    var btn = document.getElementById('btn-' + id);
    var originalHTML = btn.innerHTML;
    
    // Ubah tombol jadi hijau dengan ikon check
    btn.innerHTML = '<span class="material-symbols-outlined text-lg" style="vertical-align: middle;">check_circle</span> <span style="vertical-align: middle;">Berhasil!</span>';
    btn.classList.remove('bg-emerald-50', 'text-emerald-800', 'border-emerald-200');
    btn.classList.add('bg-emerald-500', 'text-white');
    btn.querySelector('.material-symbols-outlined').classList.remove('text-emerald-700');
    btn.querySelector('.material-symbols-outlined').classList.add('text-white');
    btn.disabled = true;
    
    // Kembalikan ke semula setelah 1.5 detik
    setTimeout(function() {
        btn.innerHTML = originalHTML;
        btn.classList.remove('bg-emerald-500', 'text-white');
        btn.classList.add('bg-emerald-50', 'text-emerald-800', 'border-emerald-200');
        btn.querySelector('.material-symbols-outlined').classList.remove('text-white');
        btn.querySelector('.material-symbols-outlined').classList.add('text-emerald-700');
        btn.disabled = true;
    }, 1500);
}

function updateCartBar() {
    var totalQty = 0, totalPrice = 0;
    cart.forEach(function(item) {
        totalQty += item.qty;
        totalPrice += (item.price * item.qty);
    });
    
    document.getElementById('cart-total-items').innerText = totalQty;
    document.getElementById('cart-total-price').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');
    
    var bar = document.getElementById('cart-bar');
    if (totalQty > 0) {
        bar.classList.remove('translate-y-full');
    } else {
        bar.classList.add('translate-y-full');
    }
}

// PERBAIKAN: Gunakan redirect GET biasa, HAPUS form submit POST
function goToBooking() {
    if (cart.length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }

    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    localStorage.setItem(TRANSFER_KEY, JSON.stringify(cart));

    window.location.href = "{{ route('pengunjung.booking') }}";
}

// Saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    updateCartBar();
});
</script>
@endsection