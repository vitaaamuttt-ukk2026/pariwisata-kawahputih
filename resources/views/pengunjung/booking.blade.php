@extends('layouts.pengunjung')
@section('title', 'Booking & Pembayaran')

@section('content')
<section class="flex flex-col gap-6 w-full max-w-7xl mx-auto px-4 py-8">
  
  <!-- Header -->
  <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-100">
    <h1 class="text-2xl font-bold text-emerald-900">Review Pesanan & Checkout</h1>
    <p class="text-sm text-emerald-700 mt-1">Lengkapi data diri, tinjau pesanan, dan lakukan pembayaran.</p>
  </div>

  <form action="{{ route('pengunjung.pembayaran.proses') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    @csrf

    @if($errors->any())
      <div class="lg:col-span-2 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700" role="alert">
        <p class="font-semibold">Booking belum tersimpan. Periksa kembali:</p>
        <ul class="mt-2 list-disc space-y-1 pl-5">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    @if(session('error'))
      <div class="lg:col-span-2 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700" role="alert">
        {{ session('error') }}
      </div>
    @endif
    
    <!-- Hidden input untuk cart data (akan diupdate otomatis oleh JavaScript) -->
    <input type="hidden" name="cart_data" id="cart-data-input" value="{{ old('cart_data') }}">

    <!-- KOLOM KIRI: Data Pengunjung -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 space-y-4">
      <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">person</span>
        Data Pengunjung
      </h2>
      
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap *</label>
        <input type="text" name="nama_pengunjung" value="{{ old('nama_pengunjung', auth()->user()->name ?? '') }}" required class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
      </div>
      
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
        <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
      </div>
      
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor HP / WhatsApp *</label>
        <input type="tel" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp ?? '') }}" required class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
      </div>
      
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Kunjungan *</label>
          <input type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan') }}" required min="{{ date('Y-m-d') }}" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Orang *</label>
          <!-- PERBAIKAN: Hapus 'readonly' dan 'bg-gray-50' agar bisa diedit -->
          <input type="number" name="jumlah_tiket" id="jumlah_tiket_input" min="1" value="{{ old('jumlah_tiket', 1) }}" required class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
          <p class="text-xs text-gray-500 mt-1">*Sesuaikan dengan jumlah tiket yang dipesan</p>
        </div>
      </div>
    </div>

    <!-- KOLOM KANAN: Rincian & Pembayaran -->
    <div class="space-y-6">
      
      <!-- Rincian Tiket -->
      <div class="bg-white p-6 rounded-2xl border border-gray-200">
        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-4">
          <span class="material-symbols-outlined text-emerald-600">receipt_long</span>
          Rincian Tiket Dipilih
        </h2>
        
        <div id="cart-items-container" class="space-y-3">
          <div class="text-center py-8 text-gray-400">
            <span class="material-symbols-outlined text-5xl block mb-2">shopping_cart</span>
            <p>Memuat data keranjang...</p>
          </div>
        </div>

        <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between items-center">
          <span class="text-sm text-gray-600 font-semibold">Total Tagihan:</span>
          <span id="cart-total-display" class="text-2xl font-bold text-emerald-600">Rp 0</span>
        </div>
      </div>

      <!-- Metode Pembayaran -->
      <div class="bg-white p-6 rounded-2xl border border-gray-200">
        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2 mb-4">
          <span class="material-symbols-outlined text-emerald-600">credit_card</span>
          Metode Pembayaran
        </h2>
        
        <div class="grid grid-cols-3 gap-3 mb-4">
          <label class="border-2 border-emerald-500 bg-emerald-50 rounded-xl p-3 cursor-pointer text-center transition-all">
            <input type="radio" name="metode_pembayaran" value="qris" @checked(old('metode_pembayaran', 'qris') === 'qris') class="hidden" onchange="showPaymentDetail('qris')">
            <div class="font-semibold text-sm text-emerald-800">QRIS</div>
          </label>
          <label class="border-2 border-gray-200 rounded-xl p-3 cursor-pointer text-center hover:border-emerald-300 transition-all">
            <input type="radio" name="metode_pembayaran" value="va" @checked(old('metode_pembayaran') === 'va') class="hidden" onchange="showPaymentDetail('va')">
            <div class="font-semibold text-sm text-gray-700">Virtual Account</div>
          </label>
          <label class="border-2 border-gray-200 rounded-xl p-3 cursor-pointer text-center hover:border-emerald-300 transition-all">
            <input type="radio" name="metode_pembayaran" value="transfer" @checked(old('metode_pembayaran') === 'transfer') class="hidden" onchange="showPaymentDetail('transfer')">
            <div class="font-semibold text-sm text-gray-700">Transfer Bank</div>
          </label>
        </div>

        <div id="detail-qris" class="payment-detail-box bg-blue-50 border border-blue-200 p-4 rounded-xl text-center">
          <p class="font-bold text-blue-800 mb-2">Scan QRIS:</p>
          <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=PembayaranKawahPutih" class="w-32 h-32 mx-auto mb-2 rounded-lg">
          <p class="text-xs text-blue-600">A.N. PT. Kawah Putih Ciwidey</p>
        </div>

        <div id="detail-va" class="payment-detail-box hidden bg-purple-50 border border-purple-200 p-4 rounded-xl text-center">
          <p class="font-bold text-purple-800 mb-2">Virtual Account:</p>
          <p class="font-mono text-sm text-purple-700">BCA: 8806081234567890</p>
          <p class="font-mono text-sm text-purple-700">Mandiri: 8901234567890123</p>
        </div>

        <div id="detail-transfer" class="payment-detail-box hidden bg-green-50 border border-green-200 p-4 rounded-xl text-center">
          <p class="font-bold text-green-800 mb-2">Transfer Bank:</p>
          <p class="text-sm text-green-700">BCA: 123-456-7890 (A.N. Kawah Putih)</p>
          <p class="text-sm text-green-700">Mandiri: 098-765-4321 (A.N. Kawah Putih)</p>
        </div>
      </div>

      <!-- Upload Bukti -->
      <div class="bg-white p-6 rounded-2xl border border-gray-200">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Bukti Pembayaran *</label>
        <input type="file" name="bukti_pembayaran" accept="image/jpeg,image/png,image/jpg" required class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
      </div>

      <!-- Tombol Submit -->
      <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-emerald-200 transition-all flex items-center justify-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>
        Ajukan Booking & Verifikasi
      </button>
    </div>
  </form>
</section>

<script>
// Fungsi untuk menampilkan detail pembayaran
function showPaymentDetail(method) {
    document.querySelectorAll('.payment-detail-box').forEach(function(el) {
        el.classList.add('hidden');
    });
    document.getElementById('detail-' + method).classList.remove('hidden');
    
    // Update border active state pada radio button
    document.querySelectorAll('input[name="metode_pembayaran"]').forEach(function(radio) {
        var label = radio.parentElement;
        if (radio.value === method) {
            label.classList.remove('border-gray-200');
            label.classList.add('border-emerald-500', 'bg-emerald-50');
            label.querySelector('div').classList.remove('text-gray-700');
            label.querySelector('div').classList.add('text-emerald-800');
        } else {
            label.classList.add('border-gray-200');
            label.classList.remove('border-emerald-500', 'bg-emerald-50');
            label.querySelector('div').classList.add('text-gray-700');
            label.querySelector('div').classList.remove('text-emerald-800');
        }
    });
}

// Fungsi utama: Memuat data keranjang dari localStorage
function loadCartFromStorage() {
    var cartInput = document.getElementById('cart-data-input');
    var transferData = cartInput.value
        || localStorage.getItem('kawah_putih_transfer')
        || localStorage.getItem('kawah_putih_cart')
        || localStorage.getItem('cart');
    var container = document.getElementById('cart-items-container');
    var submitButton = document.querySelector('form[action="{{ route('pengunjung.pembayaran.proses') }}"] button[type="submit"]');
    
    if (!transferData || transferData === '[]') {
        container.innerHTML = '<div class="text-center py-8 text-gray-400">' +
            '<span class="material-symbols-outlined text-5xl block mb-2">shopping_cart</span>' +
            '<p class="mb-3">Keranjang masih kosong. Silakan pilih paket wisata sebelum mengajukan booking.</p>' +
            '<a href="/wisata" class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold no-underline transition-colors">Pilih Tiket Dulu</a>' +
            '</div>';
        cartInput.value = '';
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.title = 'Pilih paket wisata terlebih dahulu.';
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
        return;
    }
    
    try {
        var cartItems = JSON.parse(transferData);
        if (!Array.isArray(cartItems) || cartItems.length === 0) {
            throw new Error('Data keranjang kosong.');
        }
        
        // Simpan ke hidden input untuk dikirim ke server
        cartInput.value = JSON.stringify(cartItems);
        localStorage.setItem('kawah_putih_cart', cartInput.value);
        localStorage.setItem('kawah_putih_transfer', cartInput.value);
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.title = '';
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        
        // Render items ke layar
        renderCartItems(cartItems);
        
    } catch (error) {
        container.innerHTML = '<p class="text-red-500 text-center">Error memuat data keranjang.</p>';
        cartInput.value = '';
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.title = 'Data keranjang tidak valid. Pilih ulang paket wisata.';
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }
}

// Fungsi untuk merender item keranjang ke HTML
function renderCartItems(cartItems) {
    var container = document.getElementById('cart-items-container');
    var totalDisplay = document.getElementById('cart-total-display');
    var jumlahInput = document.getElementById('jumlah_tiket_input');
    var cartInput = document.getElementById('cart-data-input');
    
    container.innerHTML = '';
    var grandTotal = 0;
    var totalQty = 0;
    
    cartItems.forEach(function(item, index) {
        var subtotal = item.price * item.qty;
        grandTotal += subtotal;
        totalQty += item.qty;
        
        var html = '<div class="cart-item flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 bg-gray-50 rounded-xl border border-gray-200 gap-3" data-index="' + index + '">' +
            '<div class="flex-1 min-w-0">' +
                '<div class="font-semibold text-gray-800 text-sm mb-1">' + item.name + '</div>' +
                '<div class="text-xs text-gray-500">Harga: Rp ' + item.price.toLocaleString('id-ID') + '</div>' +
            '</div>' +
            '<div class="flex items-center gap-3 w-full sm:w-auto">' +
                '<div class="flex items-center gap-2 bg-white rounded-lg border border-gray-200 p-1">' +
                    '<button type="button" onclick="updateCartItem(' + index + ', -1)" class="w-7 h-7 rounded-md bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 transition-colors">' +
                        '<span class="material-symbols-outlined text-sm">remove</span>' +
                    '</button>' +
                    '<span class="item-qty text-sm font-bold text-gray-800 w-6 text-center">' + item.qty + '</span>' +
                    '<button type="button" onclick="updateCartItem(' + index + ', 1)" class="w-7 h-7 rounded-md bg-emerald-500 hover:bg-emerald-600 flex items-center justify-center text-white transition-colors">' +
                        '<span class="material-symbols-outlined text-sm">add</span>' +
                    '</button>' +
                '</div>' +
                '<div class="item-subtotal font-bold text-emerald-600 text-sm min-w-[80px] text-right">Rp ' + subtotal.toLocaleString('id-ID') + '</div>' +
            '</div>' +
        '</div>';
        container.innerHTML += html;
    });
    
    totalDisplay.innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
    
    // Set nilai awal jumlah orang dari keranjang, TAPI BISA DIEDIT PENGUNJUNG
    if (jumlahInput) {
        jumlahInput.value = totalQty;
    }
    
    // Simpan kembali ke hidden input agar data terbaru terkirim ke database
    cartInput.value = JSON.stringify(cartItems);
}

// Fungsi untuk update quantity item di cart (+ dan -)
function updateCartItem(index, change) {
    var cartInput = document.getElementById('cart-data-input');
    var cartItems = JSON.parse(cartInput.value);
    
    var newQty = cartItems[index].qty + change;
    if (newQty < 1) {
        alert('Jumlah minimal adalah 1. Jika ingin menghapus, silakan kembali ke halaman wisata.');
        return;
    }
    
    cartItems[index].qty = newQty;
    cartInput.value = JSON.stringify(cartItems);
    localStorage.setItem('kawah_putih_cart', cartInput.value);
    localStorage.setItem('kawah_putih_transfer', cartInput.value);
    
    // Render ulang tampilan dan update total
    renderCartItems(cartItems);
}

// Jalankan saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    loadCartFromStorage();
    showPaymentDetail('qris');
});
</script>
@endsection