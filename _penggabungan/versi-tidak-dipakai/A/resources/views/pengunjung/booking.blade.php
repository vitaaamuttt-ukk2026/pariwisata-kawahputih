@extends('layouts.pengunjung')
@section('title', 'Booking & Pembayaran')

@section('content')
<section class="page-shell flex flex-col gap-space-lg w-full mb-space-xl">
  <div class="glass-panel p-5 md:p-6">
    <div class="flex items-center gap-space-xs text-primary font-label-sm text-label-sm uppercase tracking-wider mb-2">
      <span class="material-symbols-outlined text-[16px]">shopping_cart</span>
      <span>Booking & Pembayaran</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-on-surface font-bold">Review Pesanan & Checkout</h2>
    <p class="text-body-md text-on-surface-variant mt-1">Lengkapi data diri, lakukan pembayaran, dan unggah bukti transfer untuk memproses tiket Anda.</p>
  </div>

  <form id="booking-form" action="{{ route('pengunjung.pembayaran.proses') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-space-lg items-start">
    @csrf
    
    <div class="lg:col-span-5 flex flex-col gap-space-lg">
      <div class="soft-card p-space-lg flex flex-col gap-space-md">
        <div class="flex items-center gap-space-xs">
          <span class="material-symbols-outlined text-primary text-[20px]">person</span>
          <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Data Pengunjung</h3>
        </div>
        
        <div class="flex flex-col gap-1">
          <label class="font-label-sm text-label-sm text-on-surface font-semibold">Nama Lengkap *</label>
          <div class="flex items-center bg-surface-container-low px-3 py-2.5 rounded-xl gap-2 focus-within:ring-2 focus-within:ring-primary border border-transparent focus-within:border-primary">
            <span class="material-symbols-outlined text-outline text-[18px]">badge</span>
            <input type="text" name="nama_pengunjung" value="{{ auth()->user()->name ?? '' }}" required class="bg-transparent text-body-md text-on-surface outline-none w-full" placeholder="Sesuai KTP">
          </div>
        </div>

        <div class="flex flex-col gap-1">
          <label class="font-label-sm text-label-sm text-on-surface font-semibold">Email *</label>
          <div class="flex items-center bg-surface-container-low px-3 py-2.5 rounded-xl gap-2 focus-within:ring-2 focus-within:ring-primary border border-transparent focus-within:border-primary">
            <span class="material-symbols-outlined text-outline text-[18px]">mail</span>
            <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" required class="bg-transparent text-body-md text-on-surface outline-none w-full" placeholder="email@contoh.com">
          </div>
        </div>

        <div class="flex flex-col gap-1">
          <label class="font-label-sm text-label-sm text-on-surface font-semibold">Nomor HP / WhatsApp *</label>
          <div class="flex items-center bg-surface-container-low px-3 py-2.5 rounded-xl gap-2 focus-within:ring-2 focus-within:ring-primary border border-transparent focus-within:border-primary">
            <span class="material-symbols-outlined text-outline text-[18px]">phone</span>
            <input type="tel" name="no_hp" value="{{ auth()->user()->no_hp ?? '' }}" required class="bg-transparent text-body-md text-on-surface outline-none w-full" placeholder="08xxxxxxxxxx">
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col gap-1">
            <label class="font-label-sm text-label-sm text-on-surface font-semibold">Tanggal Kunjungan *</label>
            <input type="date" name="tanggal_kunjungan" required min="{{ date('Y-m-d') }}" class="w-full p-3 border border-surface-container-high rounded-xl focus:ring-2 focus:ring-primary outline-none bg-surface-container-low font-body-md text-on-surface">
            </div>
            <div class="flex flex-col gap-1">
            <label class="font-label-sm text-label-sm text-on-surface font-semibold">Jumlah Orang *</label>
            <div class="flex items-center bg-surface-container-low px-3 py-2.5 rounded-xl gap-2 border border-surface-container-high">
                <span class="material-symbols-outlined text-outline text-[18px]">group</span>
                <input type="number" name="jumlah_tiket" id="jumlah_tiket_input" min="1" value="1" required class="bg-transparent text-body-md text-on-surface font-semibold outline-none w-full">
            </div>
            </div>
        </div>
      </div>
    </div>

    <div class="lg:col-span-7 flex flex-col gap-space-lg">
      <div class="soft-card p-space-lg flex flex-col gap-space-md">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-space-xs">
            <span class="material-symbols-outlined text-primary text-[20px]">receipt_long</span>
            <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Rincian Tiket Dipilih</h3>
          </div>
        </div>
        
        <input type="hidden" name="cart_data" id="cart-data-input">
        
        <div id="cart-items-container" class="flex flex-col gap-2 max-h-[300px] overflow-y-auto pr-1">
            <div class="text-center py-8 text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl mb-2 opacity-50 block">shopping_cart</span>
                <p class="text-sm">Memuat data keranjang...</p>
            </div>
        </div>
      </div>

      <div class="soft-card p-space-lg flex flex-col gap-space-md">
        <div class="flex items-center gap-space-xs">
          <span class="material-symbols-outlined text-primary text-[20px]">credit_card</span>
          <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">1. Pilih Metode Pembayaran</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <label class="relative flex flex-col p-3 rounded-xl bg-surface-container-low cursor-pointer border-2 border-primary transition-all">
            <input class="sr-only" name="metode_pembayaran" value="qris" type="radio" checked onchange="showPaymentDetail('qris')"/>
            <div class="flex items-center gap-2 mb-1">
              <div class="w-6 h-6 rounded bg-primary/20 text-primary flex items-center justify-center font-bold text-[10px]">QR</div>
              <span class="font-label-md font-bold text-on-surface">QRIS</span>
            </div>
          </label>
          
          <label class="relative flex flex-col p-3 rounded-xl bg-surface-container-low cursor-pointer border-2 border-transparent hover:border-primary/50 transition-all">
            <input class="sr-only" name="metode_pembayaran" value="va" type="radio" onchange="showPaymentDetail('va')"/>
            <div class="flex items-center gap-2 mb-1">
              <div class="w-6 h-6 rounded bg-secondary/20 text-secondary flex items-center justify-center font-bold text-[10px]">VA</div>
              <span class="font-label-md font-bold text-on-surface">Virtual Account</span>
            </div>
          </label>

          <label class="relative flex flex-col p-3 rounded-xl bg-surface-container-low cursor-pointer border-2 border-transparent hover:border-primary/50 transition-all">
            <input class="sr-only" name="metode_pembayaran" value="transfer" type="radio" onchange="showPaymentDetail('transfer')"/>
            <div class="flex items-center gap-2 mb-1">
              <div class="w-6 h-6 rounded bg-tertiary/20 text-tertiary flex items-center justify-center font-bold text-[10px]">TF</div>
              <span class="font-label-md font-bold text-on-surface">Transfer Bank</span>
            </div>
          </label>
        </div>

        <div id="detail-qris" class="payment-detail-box bg-blue-50 border border-blue-200 p-4 rounded-xl flex flex-col items-center text-center">
            <p class="font-bold text-blue-800 mb-2">Scan QRIS di bawah ini:</p>
            <div class="bg-white p-3 rounded-lg shadow-sm mb-2">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=PembayaranKawahPutih" alt="QRIS" class="w-32 h-32">
            </div>
            <p class="text-xs text-blue-600">A.N. PT. Kawah Putih Ciwidey</p>
        </div>

        <div id="detail-va" class="payment-detail-box hidden bg-purple-50 border border-purple-200 p-4 rounded-xl">
            <p class="font-bold text-purple-800 mb-2">Transfer ke Virtual Account:</p>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between bg-white p-2 rounded border border-purple-100">
                    <span>BCA Virtual Account</span>
                    <span class="font-mono font-bold text-purple-700">8806081234567890</span>
                </div>
                <div class="flex justify-between bg-white p-2 rounded border border-purple-100">
                    <span>Mandiri Virtual Account</span>
                    <span class="font-mono font-bold text-purple-700">8901234567890123</span>
                </div>
            </div>
        </div>

        <div id="detail-transfer" class="payment-detail-box hidden bg-green-50 border border-green-200 p-4 rounded-xl">
            <p class="font-bold text-green-800 mb-2">Transfer ke Rekening Berikut:</p>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between bg-white p-2 rounded border border-green-100">
                    <span>Bank BCA</span>
                    <span class="font-mono font-bold text-green-700">123-456-7890 (A.N. Kawah Putih)</span>
                </div>
                <div class="flex justify-between bg-white p-2 rounded border border-green-100">
                    <span>Bank Mandiri</span>
                    <span class="font-mono font-bold text-green-700">098-765-4321 (A.N. Kawah Putih)</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-1 mt-2 pt-4 border-t border-surface-container-high">
          <label class="font-label-sm text-label-sm text-on-surface font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-[18px]">upload_file</span>
            2. Upload Bukti Pembayaran (Screenshot) *
          </label>
          <div class="flex items-center bg-surface-container-low px-3 py-3 rounded-xl gap-2 border-2 border-dashed border-surface-container-high hover:border-primary transition-colors">
            <input type="file" name="bukti_pembayaran" accept="image/jpeg,image/png,image/jpg" required class="bg-transparent text-body-sm text-on-surface outline-none w-full file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
          </div>
          <span class="text-[11px] text-outline">Format: JPG, PNG. Maksimal 2MB. Pastikan nominal dan tanggal terlihat jelas.</span>
          @error('bukti_pembayaran')
              <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
          @enderror
        </div>

        <div class="bg-surface-container-low p-4 rounded-xl flex flex-col md:flex-row justify-between items-center gap-4 mt-2">
            <div>
                <span class="text-xs text-on-surface-variant uppercase">Total Tagihan</span>
                <div id="cart-total-display" class="font-display text-2xl text-primary font-bold">Rp 0</div>
            </div>
            <button type="submit" class="w-full md:w-auto bg-primary hover:bg-primary-container text-on-primary px-8 py-3 rounded-xl font-headline-sm font-semibold flex items-center justify-center gap-2 shadow-md hover:shadow-xl transition-all">
                <span class="material-symbols-outlined">check_circle</span>
                <span>Ajukan Booking & Verifikasi</span>
            </button>
        </div>
      </div>
    </div>
  </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function() {
            const cartValue = document.getElementById('cart-data-input')?.value;
            if (cartValue) {
                localStorage.setItem('kawah_putih_transfer', cartValue);
            }
        });
    }

    console.log("=== HALAMAN BOOKING DIMUAT ===");

    const transferData = localStorage.getItem('kawah_putih_transfer') || localStorage.getItem('kawah_putih_cart') || localStorage.getItem('cart');
    console.log("Data dari LocalStorage:", transferData);

    const container = document.getElementById('cart-items-container');
    const totalDisplay = document.getElementById('cart-total-display');
    const jumlahTiketInput = document.getElementById('jumlah_tiket_input');
    const cartInput = document.getElementById('cart-data-input');

    if (transferData) {
        try {
            const cartItems = JSON.parse(transferData);
            console.log("Data berhasil di-parse:", cartItems);

            cartInput.value = transferData;
            container.innerHTML = '';

            let grandTotal = 0;
            let totalQty = 0;

            cartItems.forEach(function(item) {
                const subtotal = item.price * item.qty;
                grandTotal += subtotal;
                totalQty += item.qty;

                const html = '<div class="flex justify-between items-center p-3 bg-surface-container-low rounded-xl mb-2">' +
                    '<div>' +
                        '<div class="font-semibold text-on-surface text-sm">' + item.name + '</div>' +
                        '<div class="text-xs text-on-surface-variant">Qty: ' + item.qty + ' x Rp ' + item.price.toLocaleString('id-ID') + '</div>' +
                    '</div>' +
                    '<div class="font-bold text-primary text-sm">Rp ' + subtotal.toLocaleString('id-ID') + '</div>' +
                '</div>';
                container.innerHTML += html;
            });

            totalDisplay.innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
            if (jumlahTiketInput) {
                jumlahTiketInput.value = totalQty;
            }
            if (cartInput) {
                cartInput.value = JSON.stringify(cartItems);
            }

            console.log("Berhasil menampilkan rincian!");

        } catch (error) {
            console.error("Gagal memproses data:", error);
            container.innerHTML = '<p class="text-red-500 text-center">Error memuat data keranjang.</p>';
        }
    } else {
        console.log("TIDAK ADA DATA. Menampilkan keadaan kosong.");
        
        // SOLUSI: Simpan URL Blade ke variabel dulu, baru gabungkan ke string JS
        // Ini mencegah error backslash (\) dari Blade compiler
        const wisataUrl = "{{ route('pengunjung.wisata') }}";
        
        container.innerHTML = '<div class="text-center py-6 text-on-surface-variant">' +
            '<span class="material-symbols-outlined text-4xl mb-2 opacity-50 block">shopping_cart</span>' +
            '<p class="text-sm mb-3">Belum ada tiket yang dipilih.</p>' +
            '<a href="' + wisataUrl + '" class="inline-block bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-semibold">Pilih Tiket Dulu</a>' +
        '</div>';
    }
});

function showPaymentDetail(method) {
    document.querySelectorAll('.payment-detail-box').forEach(function(el) { 
        el.classList.add('hidden'); 
    });
    document.getElementById('detail-' + method).classList.remove('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    showPaymentDetail('qris');
});
</script>
@endsection