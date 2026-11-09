<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <title>@yield('title', 'Kawah Putih') - Ciwidey Eco Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <style>
        @layer base{html,body{margin:0;padding:0;}body{overscroll-behavior:none;}}::-webkit-scrollbar{display:none;}
        .nav-link { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .nav-link:hover:not(.bg-primary-container) { transform: translateX(4px); }
        #toast-container { position: fixed; top: 80px; right: 24px; z-index: 100; display: flex; flex-direction: column; gap: 8px; }
        .toast { background: #131b2e; color: #ffffff; padding: 12px 16px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 500; transform: translateX(120%); transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
        .toast.show { transform: translateX(0); }
        .toast .material-symbols-outlined { color: #85f8c4; font-size: 20px; }
        .toast.error .material-symbols-outlined { color: #ff6b6b; }
        .modal-overlay { position: fixed; inset: 0; background: rgba(19, 27, 46, 0.6); backdrop-filter: blur(4px); z-index: 200; display: none; align-items: center; justify-content: center; padding: 20px; }
        .modal-overlay.show { display: flex; animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes modalSlide { from { transform: translateY(30px) scale(0.95); opacity: 0; } to { transform: translateY(0) scale(1); opacity: 1; } }
        .modal-content { background: white; border-radius: 24px; padding: 32px; max-width: 480px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: modalSlide 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        #sidebar { background: linear-gradient(180deg, #fff, #f3fbf7); box-shadow: 8px 0 28px rgba(16, 86, 66, .05); }
        #main-content > header { background: rgba(255,255,255,.88); box-shadow: 0 8px 24px rgba(25,58,46,.06); backdrop-filter: blur(14px); }
        .stat-card, .panel-section, .soft-card, .ticket-card { border: 1px solid rgba(192,225,210,.8); }
        .stat-card { background: linear-gradient(145deg, rgba(255,255,255,.96), rgba(237,250,244,.82)); }
        .stat-card:nth-child(4n+2) { background: linear-gradient(145deg, #fff, #ecf7ff); }
        .stat-card:nth-child(4n+3) { background: linear-gradient(145deg, #fff, #fff8e7); }
        .stat-card:nth-child(4n) { background: linear-gradient(145deg, #fff, #ffeff4); }
        .stat-card .icon-wrap { box-shadow: inset 0 0 0 1px rgba(11,122,75,.08); }
        .panel-section, .ticket-card, .soft-card { transition: transform .2s ease, box-shadow .2s ease; }
        .panel-section:hover, .ticket-card:hover, .soft-card:hover { transform: translateY(-2px); box-shadow: 0 18px 42px rgba(11,122,75,.16); }
        #main-content button[id^="btn-"]:disabled { opacity: 1 !important; background: #e8f8ef !important; border: 1px solid #bcebd5 !important; color: #176b4c !important; }
        #main-content button[id^="btn-"]:disabled .material-symbols-outlined { color: #087c59 !important; opacity: 1 !important; }
    </style>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = { darkMode: "class", theme: { extend: { "colors": { "on-error-container": "#93000a", "on-surface-variant": "#3d4a42", "primary": "#006948", "on-secondary-fixed-variant": "#004b73", "secondary-fixed-dim": "#93ccff", "on-surface": "#131b2e", "tertiary-container": "#00855b", "background": "#faf8ff", "outline-variant": "#bccac0", "primary-fixed-dim": "#68dba9", "on-tertiary-container": "#f5fff6", "surface-container-low": "#f2f3ff", "surface": "#faf8ff", "error-container": "#ffdad6", "on-error": "#ffffff", "on-tertiary": "#ffffff", "on-secondary": "#ffffff", "on-tertiary-fixed-variant": "#005236", "surface-dim": "#d2d9f4", "secondary-fixed": "#cce5ff", "inverse-on-surface": "#eef0ff", "on-secondary-container": "#00476e", "on-secondary-fixed": "#001d31", "tertiary": "#006947", "outline": "#6d7a72", "primary-fixed": "#85f8c4", "surface-tint": "#006c4a", "on-primary-fixed-variant": "#005137", "error": "#ba1a1a", "inverse-primary": "#68dba9", "on-primary-fixed": "#002114", "tertiary-fixed": "#6ffbbe", "on-primary": "#ffffff", "inverse-surface": "#283044", "on-primary-container": "#f5fff7", "surface-variant": "#dae2fd", "surface-container-lowest": "#ffffff", "secondary": "#006398", "on-tertiary-fixed": "#002113", "on-background": "#131b2e", "surface-container": "#eaedff", "tertiary-fixed-dim": "#4edea3", "surface-container-high": "#e2e7ff", "surface-container-highest": "#dae2fd", "secondary-container": "#5bb8fe", "primary-container": "#00855d", "surface-bright": "#faf8ff" }, "borderRadius": { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" }, "spacing": { "margin-mobile": "1rem", "space-sm": "0.5rem", "space-lg": "1.5rem", "space-xl": "2rem", "space-xs": "0.25rem", "gutter": "1.5rem", "gutter-mobile": "0.75rem", "margin": "2rem", "space-md": "1rem" }, "fontFamily": { "headline-md": ["Plus Jakarta Sans"], "headline-lg": ["Plus Jakarta Sans"], "metric-numeral": ["Plus Jakarta Sans"], "body-lg": ["Plus Jakarta Sans"], "body-sm": ["Plus Jakarta Sans"], "label-md": ["Plus Jakarta Sans"], "label-sm": ["Plus Jakarta Sans"], "headline-lg-mobile": ["Plus Jakarta Sans"], "headline-sm": ["Plus Jakarta Sans"], "body-md": ["Plus Jakarta Sans"], "display": ["Plus Jakarta Sans"] }, "fontSize": { "headline-md": ["20px", {"lineHeight": "28px", "letterSpacing": "-0.015em", "fontWeight": "600"}], "headline-lg": ["28px", {"lineHeight": "36px", "letterSpacing": "-0.025em", "fontWeight": "700"}], "metric-numeral": ["32px", {"lineHeight": "36px", "letterSpacing": "-0.03em", "fontWeight": "700"}], "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}], "body-sm": ["12px", {"lineHeight": "16px", "fontWeight": "400"}], "label-md": ["13px", {"lineHeight": "16px", "letterSpacing": "0.01em", "fontWeight": "600"}], "label-sm": ["11px", {"lineHeight": "14px", "letterSpacing": "0.04em", "fontWeight": "600"}], "headline-lg-mobile": ["22px", {"lineHeight": "28px", "letterSpacing": "-0.02em", "fontWeight": "700"}], "headline-sm": ["16px", {"lineHeight": "24px", "letterSpacing": "-0.01em", "fontWeight": "600"}], "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "400"}], "display": ["36px", {"lineHeight": "44px", "letterSpacing": "-0.03em", "fontWeight": "700"}] } } } }
    </script>
</head>
<body class="bg-surface font-body-md text-body-md text-on-surface antialiased min-h-screen">

<div id="toast-container"></div>

<!-- MODAL PEMBAYARAN -->
<div id="payment-modal" class="modal-overlay">
  <div class="modal-content">
    <div id="payment-step-1">
      <div class="flex items-center gap-3 mb-4">
        <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center"><span class="material-symbols-outlined text-[28px]">credit_card</span></div>
        <div><h3 class="font-headline-md text-headline-md text-on-surface font-bold">Konfirmasi Pembayaran</h3><p class="text-body-sm text-on-surface-variant">Periksa kembali pesanan Anda</p></div>
      </div>
      <div class="bg-surface-container-low rounded-xl p-4 mb-4">
        <div class="flex justify-between items-center mb-2"><span class="text-body-sm text-on-surface-variant">Total Pembayaran:</span><span id="modal-total-amount" class="font-headline-md text-headline-md text-primary font-bold">Rp 0</span></div>
        <div class="flex justify-between items-center mb-2"><span class="text-body-sm text-on-surface-variant">Metode:</span><span id="modal-payment-method" class="font-label-md text-label-md text-on-surface font-semibold">QRIS Instan</span></div>
        <div class="flex justify-between items-center"><span class="text-body-sm text-on-surface-variant">Tanggal Kunjungan:</span><span id="modal-visit-date" class="font-label-md text-label-md text-on-surface font-semibold">-</span></div>
      </div>
      <div class="bg-primary/5 border border-primary/20 rounded-xl p-3 mb-4 flex items-start gap-2">
        <span class="material-symbols-outlined text-primary text-[20px] mt-0.5">info</span>
        <p class="text-body-sm text-on-surface-variant">Setelah klik "Bayar Sekarang", sistem akan memproses pembayaran Anda. E-Tiket akan diterbitkan otomatis.</p>
      </div>
      <div class="flex gap-3">
        <button onclick="closePaymentModal()" class="flex-1 py-3 px-4 rounded-xl bg-surface-container text-on-surface font-label-md text-label-md hover:bg-surface-container-high transition-colors">Batal</button>
        <button onclick="processPayment()" class="flex-1 py-3 px-4 rounded-xl bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-container transition-colors flex items-center justify-center gap-2"><span class="material-symbols-outlined text-[20px]">lock</span><span>Bayar Sekarang</span></button>
      </div>
    </div>
    <div id="payment-step-2" style="display:none;">
      <div class="flex flex-col items-center justify-center py-8">
        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4"><div class="w-10 h-10 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div></div>
        <h3 class="font-headline-md text-headline-md text-on-surface font-bold mb-2">Memproses Pembayaran...</h3>
        <p class="text-body-sm text-on-surface-variant text-center">Mohon tunggu, sistem sedang memverifikasi transaksi Anda</p>
      </div>
    </div>
    <div id="payment-step-3" style="display:none;">
      <div class="flex flex-col items-center justify-center py-4">
        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4"><span class="material-symbols-outlined text-primary text-[48px]">check_circle</span></div>
        <h3 class="font-headline-md text-headline-md text-on-surface font-bold mb-2">Pembayaran Berhasil!</h3>
        <p class="text-body-sm text-on-surface-variant text-center mb-4">E-Tiket Anda telah diterbitkan.</p>
        <a href="{{ route('pengunjung.tiket') }}" class="w-full py-3 px-4 rounded-xl bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-container transition-colors flex items-center justify-center gap-2 text-center no-underline"><span>Lihat E-Tiket Saya</span><span class="material-symbols-outlined text-[20px]">arrow_forward</span></a>
      </div>
    </div>
  </div>
</div>

<!-- APP SHELL: SIDEBAR (Hanya muncul di Desktop: md:flex) -->
<aside class="sidebar-panel fixed left-0 top-0 h-full w-64 z-50 hidden md:flex flex-col justify-between py-space-lg">
  <div class="flex flex-col gap-space-lg">
    <div class="px-space-lg flex items-center gap-space-sm">
      <div class="h-10 w-10 shrink-0 rounded-xl overflow-hidden shadow-sm flex items-center justify-center bg-primary"><span class="material-symbols-outlined text-white text-[24px]">landscape</span></div>
      <div class="flex flex-col"><span class="font-headline-sm text-headline-sm text-on-surface leading-tight font-bold">Kawah Putih</span><span class="font-label-sm text-label-sm text-outline tracking-wider uppercase">Ciwidey Eco Portal</span></div>
    </div>
    <nav class="flex flex-col gap-space-xs px-space-md">
      @php $routes = ['dashboard' => 'pengunjung.dashboard', 'info' => 'pengunjung.info', 'wisata' => 'pengunjung.wisata', 'booking' => 'pengunjung.booking', 'tiket' => 'pengunjung.tiket']; @endphp
      @foreach($routes as $key => $routeName)
        <a href="{{ route($routeName) }}" class="nav-link flex items-center gap-space-sm px-space-md py-space-sm rounded-2xl transition-all group {{ request()->routeIs($routeName) ? 'bg-primary-container text-on-primary-container font-semibold shadow-[0_2px_8px_rgba(0,105,72,0.12)] active' : 'text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' }}">
          <span class="material-symbols-outlined text-[20px] transition-transform group-hover:scale-110 {{ request()->routeIs($routeName) ? 'text-white' : '' }}">
            @if($key === 'dashboard') space_dashboard @elseif($key === 'info') nature_people @elseif($key === 'wisata') explore @elseif($key === 'booking') shopping_cart @else receipt_long @endif
          </span>
          <span class="font-label-md text-label-md">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
        </a>
      @endforeach
    </nav>
  </div>
  <div class="px-space-md flex flex-col gap-space-sm">
    <div class="h-px w-full bg-surface-container-high"></div>
    <form action="{{ route('panel.logout') }}" method="POST" class="w-full">
        @csrf
        <button type="submit" class="w-full flex items-center gap-space-sm px-space-md py-space-sm rounded-xl text-on-surface-variant hover:bg-error-container hover:text-on-error-container transition-all group cursor-pointer text-left bg-transparent border-0">
            <span class="material-symbols-outlined text-[20px] text-error transition-transform group-hover:-translate-x-1">logout</span><span class="font-label-md text-label-md">Keluar</span>
        </button>
    </form>
  </div>
</aside>

<!-- MAIN CONTENT AREA -->
<!-- Sidebar fixed di kiri, jadi konten harus memiliki margin-left agar tidak tertutup -->
<div class="md:ml-64 flex flex-col min-h-screen">
  
  <!-- HEADER -->
  <!-- PERBAIKAN: left-0 md:left-64 agar di HP full width, di desktop sesuai sidebar -->
  <header class="topbar-glass fixed top-0 left-0 md:left-64 right-0 h-16 z-40 px-4 md:px-space-lg flex items-center justify-between rounded-b-2xl">
    <div class="flex items-center gap-space-md">
      <div class="flex items-center gap-space-xs text-outline font-label-md text-label-md">
        <span class="material-symbols-outlined text-[18px]">home</span><span class="hidden sm:inline">/</span><span class="text-on-surface font-semibold text-sm sm:text-base">Portal Wisatawan</span>
      </div>
    </div>
    <div class="flex items-center gap-space-md">
      <a href="{{ route('pengunjung.booking') }}" class="flex items-center gap-space-xs bg-surface-container-low px-3 py-1.5 rounded-full cursor-pointer hover:bg-surface-container-high transition-colors no-underline">
        <span class="material-symbols-outlined text-[18px] text-secondary">shopping_cart</span>
        <span id="header-cart-count" class="font-label-sm text-label-sm text-on-surface font-bold">0</span>
      </a>
      <div class="flex items-center gap-space-sm pl-space-xs">
        <div class="relative">
          <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center ring-1 ring-primary/20">
            <span class="material-symbols-outlined text-primary text-[18px]">person</span>
          </div>
          <span class="absolute bottom-0 right-0 w-2 h-2 bg-primary rounded-full ring-1 ring-surface-container-lowest"></span>
        </div>
        <div class="hidden lg:flex flex-col text-left">
          <span class="font-label-md text-label-md text-on-surface leading-tight">Wisatawan</span>
          <span class="font-label-sm text-label-sm text-primary font-semibold">Tamu</span>
        </div>
      </div>
    </div>
  </header>

  <!-- MAIN -->
  <!-- PERBAIKAN: px-4 md:px-space-lg dan pb-20 md:pb-16 agar tidak tertutup menu HP -->
  <main class="relative pt-16 bg-surface flex-1 w-full max-w-[1440px] mx-auto px-4 md:px-space-lg pb-28 md:pb-32">
    <div class="flex flex-col w-full pb-8 md:pb-12">
      @yield('content')
    </div>
  </main>

  <!-- MOBILE BOTTOM NAVIGATION (Hanya muncul di HP: md:hidden) -->
  <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-surface-container-lowest border-t border-surface-container-high z-50 flex justify-around py-2 px-2 pb-2">
    <a href="{{ route('pengunjung.dashboard') }}" class="flex flex-col items-center gap-1 p-2 rounded-lg {{ request()->routeIs('pengunjung.dashboard') ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-[22px]">space_dashboard</span>
      <span class="text-[10px] font-semibold">Home</span>
    </a>
    <a href="{{ route('pengunjung.wisata') }}" class="flex flex-col items-center gap-1 p-2 rounded-lg {{ request()->routeIs('pengunjung.wisata') ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-[22px]">explore</span>
      <span class="text-[10px] font-semibold">Tiket</span>
    </a>
    <a href="{{ route('pengunjung.booking') }}" class="flex flex-col items-center gap-1 p-2 rounded-lg {{ request()->routeIs('pengunjung.booking') ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-[22px]">shopping_cart</span>
      <span class="text-[10px] font-semibold">Booking</span>
    </a>
    <a href="{{ route('pengunjung.tiket') }}" class="flex flex-col items-center gap-1 p-2 rounded-lg {{ request()->routeIs('pengunjung.tiket') ? 'text-primary' : 'text-on-surface-variant' }}">
      <span class="material-symbols-outlined text-[22px]">receipt_long</span>
      <span class="text-[10px] font-semibold">E-Tiket</span>
    </a>
  </nav>

</div>

<!-- SCRIPTS -->
<script>
let cart = JSON.parse(localStorage.getItem('cart') || '[]');

function saveCart() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

function updateCardQty(id, change) {
  let el = document.getElementById(id);
  if (!el) return;
  let val = parseInt(el.innerText) || 0;
  val += change;
  if (val < 0) val = 0;
  el.innerText = val;
  
  let btn = document.getElementById(id.replace('qty-', 'btn-'));
  if (btn) {
    if (val > 0) {
      btn.disabled = false;
      btn.classList.remove('bg-surface-container-high', 'text-on-surface-variant');
      btn.classList.add('bg-primary', 'text-on-primary');
      btn.querySelector('span:last-child').innerText = `Tambah ${val} ke Keranjang`;
    } else {
      btn.disabled = true;
      btn.classList.add('bg-surface-container-high', 'text-on-surface-variant');
      btn.classList.remove('bg-primary', 'text-on-primary');
      btn.querySelector('span:last-child').innerText = 'Tambah ke Keranjang';
    }
  }
}

function addCardToCart(id, name, price, qtyId) {
  let qtyEl = document.getElementById(qtyId);
  if (!qtyEl) return;
  let qty = parseInt(qtyEl.innerText) || 0;
  
  if (qty > 0) {
    let item = cart.find(i => i.id === id);
    if (item) item.qty += qty;
    else cart.push({ id, name, price, qty });
    saveCart();
    
    qtyEl.innerText = '0';
    updateCardQty(qtyId, 0);
    refreshAll();
    showToast(`${qty}x ${name} ditambahkan!`);
  }
}

function updateBookingQty(id, change) {
  let item = cart.find(i => i.id === id);
  if (item) {
    item.qty += change;
    if (item.qty <= 0) cart = cart.filter(i => i.id !== id);
    saveCart();
    refreshAll();
  }
}

function clearCart() {
  if (confirm('Yakin kosongkan keranjang?')) {
    cart = [];
    saveCart();
    refreshAll();
  }
}

function refreshAll() {
  let total = cart.reduce((s, i) => s + i.qty, 0);
  let totalHarga = cart.reduce((s, i) => s + (i.price * i.qty), 0);
  
  let headerEl = document.getElementById('header-cart-count');
  if (headerEl) headerEl.innerText = `${total}`;
  
  let bar = document.getElementById('wisata-cart-bar');
  if (bar) {
    let itemsEl = document.getElementById('wisata-cart-total-items');
    let priceEl = document.getElementById('wisata-cart-total-price');
    if (total > 0) {
      bar.classList.remove('translate-y-full');
      if (itemsEl) itemsEl.innerText = `${total}`;
      if (priceEl) priceEl.innerText = `Rp ${totalHarga.toLocaleString('id-ID')}`;
    } else {
      bar.classList.add('translate-y-full');
    }
  }
  
  let container = document.getElementById('cart-items-container');
  if (container) {
    if (cart.length === 0) {
      container.innerHTML = `<div class="text-center py-8 text-on-surface-variant"><span class="material-symbols-outlined text-4xl mb-2 opacity-50">shopping_cart</span><p class="font-body-sm">Keranjang masih kosong.</p><a href="/wisata" class="mt-4 text-primary font-semibold hover:underline text-sm inline-block">Pilih Tiket Dulu</a></div>`;
      let totalEl = document.getElementById('cart-total-display');
      if (totalEl) totalEl.innerText = 'Rp 0';
      let btn = document.getElementById('checkout-btn');
      if (btn) btn.disabled = true;
      let input = document.getElementById('cart-data-input');
      if (input) input.value = '';
    } else {
      let html = '';
      let total = 0;
      let totalQty = 0;
      cart.forEach(item => {
        let sub = item.price * item.qty;
        total += sub;
        totalQty += item.qty;
        html += `<div class="flex items-center justify-between p-3 bg-surface-container-low/60 rounded-xl mb-2">
          <div class="flex flex-col flex-1 pr-2">
            <span class="font-label-md text-label-md text-on-surface font-semibold">${item.name}</span>
            <span class="font-label-sm text-label-sm text-on-surface-variant">Rp ${item.price.toLocaleString('id-ID')} × ${item.qty}</span>
            <span class="font-label-md text-label-md text-primary font-bold">Rp ${sub.toLocaleString('id-ID')}</span>
          </div>
          <div class="flex items-center gap-2">
            <button type="button" onclick="updateBookingQty('${item.id}', -1)" class="w-7 h-7 rounded-full bg-surface-container-lowest hover:bg-surface-container flex items-center justify-center"><span class="material-symbols-outlined text-[16px]">remove</span></button>
            <span class="font-headline-sm font-bold w-5 text-center">${item.qty}</span>
            <button type="button" onclick="updateBookingQty('${item.id}', 1)" class="w-7 h-7 rounded-full bg-primary hover:bg-primary-container flex items-center justify-center text-on-primary"><span class="material-symbols-outlined text-[16px]">add</span></button>
          </div>
        </div>`;
      });
      container.innerHTML = html;
      let totalEl = document.getElementById('cart-total-display');
      if (totalEl) totalEl.innerText = `Rp ${total.toLocaleString('id-ID')}`;
      let jmlInput = document.getElementById('jumlah-tiket-input');
      if (jmlInput && !jmlInput.dataset.edited) jmlInput.value = totalQty;
      let btn = document.getElementById('checkout-btn');
      if (btn) btn.disabled = false;
      let input = document.getElementById('cart-data-input');
      if (input) input.value = JSON.stringify(cart);
    }
  }
}

function showToast(msg, err = false) {
  let c = document.getElementById('toast-container');
  if (!c) return;
  let t = document.createElement('div');
  t.className = 'toast' + (err ? ' error' : '');
  t.innerHTML = `<span class="material-symbols-outlined">${err ? 'error' : 'check_circle'}</span><span>${msg}</span>`;
  c.appendChild(t);
  requestAnimationFrame(() => t.classList.add('show'));
  setTimeout(() => {
    t.classList.remove('show');
    setTimeout(() => { if (t.parentNode) t.parentNode.removeChild(t); }, 300);
  }, 3000);
}

document.addEventListener('DOMContentLoaded', () => {
  refreshAll();
  let jmlInput = document.getElementById('jumlah-tiket-input');
  if (jmlInput) {
    jmlInput.addEventListener('input', () => jmlInput.dataset.edited = 'true');
  }
});
</script>
</body>
</html>