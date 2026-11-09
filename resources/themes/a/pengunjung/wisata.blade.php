@extends('layouts.pengunjung')
@section('title', 'Pilihan Wisata')

@section('content')
<section class="page-shell flex flex-col gap-3 md:gap-space-lg w-full mb-6 md:mb-space-xl pb-40 md:pb-52">
  <div class="glass-panel p-4 md:p-5">
    <div class="flex flex-wrap items-end justify-between gap-2 md:gap-space-sm border-b border-surface-container-high pb-3 md:pb-4">
      <div class="flex flex-col gap-1">
        <div class="section-heading">
          <span class="material-symbols-outlined text-[16px]">travel_explore</span>
          <span>Paket & Tiket</span>
        </div>
        <h2 class="text-lg md:font-headline-lg md:text-headline-lg text-on-surface font-bold">Daftar Harga Wisata</h2>
        <p class="text-xs md:text-body-md text-on-surface-variant">Pilih tiket atau wahana, lalu tambahkan ke keranjang.</p>
      </div>
    </div>
  </div>

  <!-- KATEGORI 1: TIKET MASUK -->
  <div class="flex flex-col gap-3 md:gap-space-md">
    <h3 class="text-sm md:font-headline-sm md:text-headline-sm text-on-surface font-bold flex items-center gap-2">
      <span class="material-symbols-outlined text-primary text-[18px] md:text-[24px]">badge</span> Tiket Masuk
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
      <!-- Tiket WNI -->
      <div class="soft-card p-2 md:p-space-md flex flex-col justify-between reveal">
        <div class="flex flex-col gap-2 md:gap-3">
          <div class="flex items-center justify-between">
            <div class="w-8 h-8 md:w-11 md:h-11 rounded-lg md:rounded-xl bg-primary/10 text-primary flex items-center justify-center"><span class="material-symbols-outlined text-[18px] md:text-[24px]">person</span></div>
            <span class="px-1.5 md:px-2.5 py-0.5 rounded-full text-[9px] md:text-[11px] font-bold bg-primary-fixed/50 uppercase">Wajib</span>
          </div>
          <div>
            <h3 class="text-xs md:text-base font-bold text-on-surface">Tiket Masuk (WNI)</h3>
            <p class="text-[10px] md:text-body-sm text-on-surface-variant mt-0.5 md:mt-1">Wisatawan Indonesia.</p>
          </div>
          <div class="p-1.5 md:p-2.5 bg-surface-container-low/70 rounded-lg md:rounded-xl">
            <div class="flex justify-between items-center text-xs md:text-body-sm"><span class="text-on-surface-variant">Harga:</span><span class="font-bold text-primary">Rp 31.000</span></div>
          </div>
          <div class="flex items-center justify-between bg-surface-container-low rounded-lg md:rounded-xl p-1">
            <button type="button" onclick="updateCardQty('qty-wni', -1)" class="w-7 h-7 md:w-9 md:h-9 rounded-md md:rounded-lg bg-surface-container-lowest flex items-center justify-center"><span class="material-symbols-outlined text-[16px] md:text-[18px]">remove</span></button>
            <span id="qty-wni" class="text-xs md:font-headline-sm font-bold text-on-surface w-6 md:w-8 text-center">0</span>
            <button type="button" onclick="updateCardQty('qty-wni', 1)" class="w-7 h-7 md:w-9 md:h-9 rounded-md md:rounded-lg bg-primary flex items-center justify-center text-on-primary"><span class="material-symbols-outlined text-[16px] md:text-[18px]">add</span></button>
          </div>
        </div>
        <button id="btn-wni" disabled onclick="addCardToCart('tiket-wni', 'Tiket Masuk (WNI)', 31000, 'qty-wni')" class="mt-2 md:mt-3 w-full py-2 md:py-2.5 px-2 md:px-3 bg-surface-container-high text-on-surface-variant text-center rounded-lg md:rounded-xl text-xs md:text-label-md transition-all flex items-center justify-center gap-1 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
          <span class="material-symbols-outlined text-[16px] md:text-[18px]">add_shopping_cart</span><span class="hidden md:inline">Tambah ke Keranjang</span><span class="md:hidden">Tambah</span>
        </button>
      </div>

      <!-- Tiket WNA -->
      <div class="soft-card p-2 md:p-space-md flex flex-col justify-between reveal">
        <div class="flex flex-col gap-2 md:gap-3">
          <div class="flex items-center justify-between">
            <div class="w-8 h-8 md:w-11 md:h-11 rounded-lg md:rounded-xl bg-secondary/10 text-secondary flex items-center justify-center"><span class="material-symbols-outlined text-[18px] md:text-[24px]">passport</span></div>
            <span class="px-1.5 md:px-2.5 py-0.5 rounded-full text-[9px] md:text-[11px] font-bold bg-secondary-fixed uppercase">Wajib</span>
          </div>
          <div>
            <h3 class="text-xs md:text-base font-bold text-on-surface">Tiket Masuk (WNA)</h3>
            <p class="text-[10px] md:text-body-sm text-on-surface-variant mt-0.5 md:mt-1">Wisatawan Asing.</p>
          </div>
          <div class="p-1.5 md:p-2.5 bg-surface-container-low/70 rounded-lg md:rounded-xl">
            <div class="flex justify-between items-center text-xs md:text-body-sm"><span class="text-on-surface-variant">Harga:</span><span class="font-bold text-secondary">Rp 90.000</span></div>
          </div>
          <div class="flex items-center justify-between bg-surface-container-low rounded-lg md:rounded-xl p-1">
            <button type="button" onclick="updateCardQty('qty-wna', -1)" class="w-7 h-7 md:w-9 md:h-9 rounded-md md:rounded-lg bg-surface-container-lowest flex items-center justify-center"><span class="material-symbols-outlined text-[16px] md:text-[18px]">remove</span></button>
            <span id="qty-wna" class="text-xs md:font-headline-sm font-bold text-on-surface w-6 md:w-8 text-center">0</span>
            <button type="button" onclick="updateCardQty('qty-wna', 1)" class="w-7 h-7 md:w-9 md:h-9 rounded-md md:rounded-lg bg-secondary flex items-center justify-center text-on-secondary"><span class="material-symbols-outlined text-[16px] md:text-[18px]">add</span></button>
          </div>
        </div>
        <button id="btn-wna" disabled onclick="addCardToCart('tiket-wna', 'Tiket Masuk (WNA)', 90000, 'qty-wna')" class="mt-2 md:mt-3 w-full py-2 md:py-2.5 px-2 md:px-3 bg-surface-container-high text-on-surface-variant text-center rounded-lg md:rounded-xl text-xs md:text-label-md transition-all flex items-center justify-center gap-1 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
          <span class="material-symbols-outlined text-[16px] md:text-[18px]">add_shopping_cart</span><span class="hidden md:inline">Tambah ke Keranjang</span><span class="md:hidden">Tambah</span>
        </button>
      </div>
    </div>
  </div>

  <!-- KATEGORI 2: PAKET BUNDLE -->
  <div class="flex flex-col gap-3 md:gap-space-md">
    <h3 class="text-sm md:font-headline-sm md:text-headline-sm text-on-surface font-bold flex items-center gap-2">
      <span class="material-symbols-outlined text-primary text-[18px] md:text-[24px]">volcano</span> Paket Bundle
    </h3>
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 md:gap-space-md">
      <!-- Paket WNI + Ontang-anting -->
      <div class="bg-surface-container-lowest p-2 md:p-space-md rounded-xl md:rounded-2xl shadow-sm border-2 border-primary flex flex-col justify-between relative overflow-hidden">
        <div class="absolute top-0 right-0 bg-primary text-on-primary text-[8px] md:text-[10px] font-bold uppercase px-2 md:px-3 py-1 rounded-bl-xl">Best Value</div>
        <div class="flex flex-col gap-2 md:gap-3">
          <div class="flex items-center justify-between">
            <div class="w-8 h-8 md:w-11 md:h-11 rounded-lg md:rounded-xl bg-primary text-on-primary flex items-center justify-center"><span class="material-symbols-outlined text-[18px] md:text-[24px]">directions_bus</span></div>
            <span class="px-1.5 md:px-2.5 py-0.5 rounded-full text-[9px] md:text-[11px] font-bold bg-primary text-on-primary uppercase">Paket</span>
          </div>
          <div>
            <h3 class="text-xs md:text-base font-bold text-on-surface">WNI + Ontang-anting</h3>
            <p class="text-[10px] md:text-body-sm text-on-surface-variant mt-0.5 md:mt-1">Tiket masuk + Shuttle PP.</p>
          </div>
          <div class="p-1.5 md:p-2.5 bg-primary/5 rounded-lg md:rounded-xl">
            <div class="flex justify-between items-center text-xs md:text-body-sm"><span class="text-on-surface-variant">Harga:</span><span class="font-bold text-primary">Rp 63.000</span></div>
          </div>
          <div class="flex items-center justify-between bg-surface-container-low rounded-lg md:rounded-xl p-1">
            <button type="button" onclick="updateCardQty('qty-wni-ontang', -1)" class="w-7 h-7 md:w-9 md:h-9 rounded-md md:rounded-lg bg-surface-container-lowest flex items-center justify-center"><span class="material-symbols-outlined text-[16px] md:text-[18px]">remove</span></button>
            <span id="qty-wni-ontang" class="text-xs md:font-headline-sm font-bold text-on-surface w-6 md:w-8 text-center">0</span>
            <button type="button" onclick="updateCardQty('qty-wni-ontang', 1)" class="w-7 h-7 md:w-9 md:h-9 rounded-md md:rounded-lg bg-primary flex items-center justify-center text-on-primary"><span class="material-symbols-outlined text-[16px] md:text-[18px]">add</span></button>
          </div>
        </div>
        <button id="btn-wni-ontang" disabled onclick="addCardToCart('paket-wni-ontang', 'Tiket WNI + Ontang-anting PP', 63000, 'qty-wni-ontang')" class="mt-2 md:mt-3 w-full py-2 md:py-2.5 px-2 md:px-3 bg-surface-container-high text-on-surface-variant text-center rounded-lg md:rounded-xl text-xs md:text-label-md transition-all flex items-center justify-center gap-1 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
          <span class="material-symbols-outlined text-[16px] md:text-[18px]">add_shopping_cart</span><span class="hidden md:inline">Tambah ke Keranjang</span><span class="md:hidden">Tambah</span>
        </button>
      </div>

      <!-- Paket WNA + Ontang-anting -->
      <div class="bg-surface-container-lowest p-2 md:p-space-md rounded-xl md:rounded-2xl shadow-sm border-2 border-secondary flex flex-col justify-between relative overflow-hidden">
        <div class="absolute top-0 right-0 bg-secondary text-on-secondary text-[8px] md:text-[10px] font-bold uppercase px-2 md:px-3 py-1 rounded-bl-xl">Best Value</div>
        <div class="flex flex-col gap-2 md:gap-3">
          <div class="flex items-center justify-between">
            <div class="w-8 h-8 md:w-11 md:h-11 rounded-lg md:rounded-xl bg-secondary text-on-secondary flex items-center justify-center"><span class="material-symbols-outlined text-[18px] md:text-[24px]">directions_bus</span></div>
            <span class="px-1.5 md:px-2.5 py-0.5 rounded-full text-[9px] md:text-[11px] font-bold bg-secondary text-on-secondary uppercase">Paket</span>
          </div>
          <div>
            <h3 class="text-xs md:text-base font-bold text-on-surface">WNA + Ontang-anting</h3>
            <p class="text-[10px] md:text-body-sm text-on-surface-variant mt-0.5 md:mt-1">Tiket WNA + Shuttle PP.</p>
          </div>
          <div class="p-1.5 md:p-2.5 bg-secondary/5 rounded-lg md:rounded-xl">
            <div class="flex justify-between items-center text-xs md:text-body-sm"><span class="text-on-surface-variant">Harga:</span><span class="font-bold text-secondary">Rp 122.000</span></div>
          </div>
          <div class="flex items-center justify-between bg-surface-container-low rounded-lg md:rounded-xl p-1">
            <button type="button" onclick="updateCardQty('qty-wna-ontang', -1)" class="w-7 h-7 md:w-9 md:h-9 rounded-md md:rounded-lg bg-surface-container-lowest flex items-center justify-center"><span class="material-symbols-outlined text-[16px] md:text-[18px]">remove</span></button>
            <span id="qty-wna-ontang" class="text-xs md:font-headline-sm font-bold text-on-surface w-6 md:w-8 text-center">0</span>
            <button type="button" onclick="updateCardQty('qty-wna-ontang', 1)" class="w-7 h-7 md:w-9 md:h-9 rounded-md md:rounded-lg bg-secondary flex items-center justify-center text-on-secondary"><span class="material-symbols-outlined text-[16px] md:text-[18px]">add</span></button>
          </div>
        </div>
        <button id="btn-wna-ontang" disabled onclick="addCardToCart('paket-wna-ontang', 'Tiket WNA + Ontang-anting PP', 122000, 'qty-wna-ontang')" class="mt-2 md:mt-3 w-full py-2 md:py-2.5 px-2 md:px-3 bg-surface-container-high text-on-surface-variant text-center rounded-lg md:rounded-xl text-xs md:text-label-md transition-all flex items-center justify-center gap-1 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
          <span class="material-symbols-outlined text-[16px] md:text-[18px]">add_shopping_cart</span><span class="hidden md:inline">Tambah ke Keranjang</span><span class="md:hidden">Tambah</span>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- STICKY CART BAR -->
<div id="wisata-cart-bar" class="fixed bottom-16 md:bottom-0 left-0 md:left-64 right-0 bg-surface-container-lowest/95 backdrop-blur-xl border-t border-surface-container-high p-3 md:p-4 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] z-40 transform translate-y-full transition-transform duration-300 pb-[calc(env(safe-area-inset-bottom)+0.5rem)] md:pb-4">
  <div class="max-w-[1440px] mx-auto flex items-center justify-between gap-2">
    <div class="flex flex-col">
      <span class="font-label-sm text-label-sm text-on-surface-variant text-xs">Total di Keranjang</span>
      <div class="flex items-baseline gap-1">
        <span id="wisata-cart-total-items" class="font-headline-md text-headline-md text-on-surface font-bold text-sm">0</span>
        <span class="text-outline text-xs">•</span>
        <span id="wisata-cart-total-price" class="font-headline-md text-headline-md text-primary font-bold text-sm">Rp 0</span>
      </div>
    </div>
    <button onclick="goToBooking()" class="bg-primary text-on-primary px-4 py-2 md:px-6 md:py-3 rounded-xl font-label-md text-label-md hover:bg-primary-container shadow-md transition-all flex items-center gap-2 text-xs md:text-sm">
      <span class="material-symbols-outlined text-[18px] md:text-[20px]">shopping_cart</span><span>Lanjut Booking</span>
    </button>
  </div>
</div>

<script>
const CART_KEY = 'kawah_putih_cart';
const TRANSFER_KEY = 'kawah_putih_transfer';

let cart = JSON.parse(localStorage.getItem(CART_KEY)) || [];

function updateCardQty(qtyId, change) {
    const el = document.getElementById(qtyId);
    let val = parseInt(el.innerText) + change;
    if (val < 0) val = 0;
    el.innerText = val;

    const btnId = qtyId.replace('qty-', 'btn-');
    const btn = document.getElementById(btnId);
    if (btn) {
        btn.disabled = (val === 0);
        if (val > 0) btn.classList.remove('opacity-50', 'cursor-not-allowed');
        else btn.classList.add('opacity-50', 'cursor-not-allowed');
    }
}

function addCardToCart(code, name, price, qtyId) {
    const el = document.getElementById(qtyId);
    const qty = parseInt(el.innerText) || 0;
    if (qty <= 0) return;

    const existing = cart.find(function(item) { return item.code === code; });
    if (existing) {
        existing.qty += qty;
    } else {
        cart.push({ code: code, name: name, price: price, qty: qty });
    }

    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    el.innerText = '0';
    updateCardQty(qtyId, 0);
    updateBottomBar();
}

function updateBottomBar() {
    let totalQty = 0, totalPrice = 0;
    cart.forEach(function(item) {
        totalQty += item.qty;
        totalPrice += (item.price * item.qty);
    });

    document.getElementById('wisata-cart-total-items').innerText = totalQty;
    document.getElementById('wisata-cart-total-price').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');

    const bar = document.getElementById('wisata-cart-bar');
    if (totalQty > 0) {
        bar.classList.remove('translate-y-full');
    } else {
        bar.classList.add('translate-y-full');
    }
}

function goToBooking() {
    let totalQty = 0;
    cart.forEach(function(item) {
        totalQty += item.qty;
    });

    if (totalQty === 0) {
        alert("Keranjang masih kosong! Silakan pilih tiket terlebih dahulu.");
        return;
    }

    localStorage.setItem(TRANSFER_KEY, JSON.stringify(cart));
    window.location.href = "{{ route('pengunjung.booking') }}";
}

document.addEventListener('DOMContentLoaded', function() {
    updateBottomBar();
});
</script>
@endsection