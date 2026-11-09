@extends('layouts.pengunjung')
@section('title', 'Riwayat Tiket')

@section('content')
<section class="flex flex-col gap-space-lg w-full mb-space-xl">
  <div class="bg-primary/5 p-6 rounded-2xl border border-primary/10">
    <div class="flex items-center gap-space-xs text-primary font-label-sm text-label-sm uppercase tracking-wider mb-2">
      <span class="material-symbols-outlined text-[16px]">confirmation_number</span>
      <span>Riwayat Tiket</span>
    </div>
    <h2 class="font-headline-lg text-headline-lg text-on-surface font-bold">Tiket & E-Tiket Anda</h2>
    <p class="text-body-md text-on-surface-variant mt-1">Pantau status pemesanan dan tunjukkan E-Tiket ini saat berkunjung.</p>
  </div>

  @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg">
      <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
    </div>
  @endif

  <div class="flex flex-col gap-4">
    @forelse($bookings as $booking)
      @php
          $visitDate = \Carbon\Carbon::parse($booking->tanggal_kunjungan);
          $isPast = $visitDate->isPast() || $visitDate->isToday();
          
          // LOGIKA PINTAR: Cek apakah data paket berupa JSON (format lama) atau String (format baru)
          $paketData = json_decode($booking->paket, true);
          if (is_array($paketData)) {
              $paketItems = array_map(function($item) {
                  return ($item['nama'] ?? 'Paket') . ' (x' . ($item['qty'] ?? 1) . ')';
              }, $paketData);
              $paketDisplay = implode(', ', $paketItems);
          } else {
              $paketDisplay = $booking->paket;
          }

          // Prioritas status: selesai > sedang > berdasarkan status payment
          if (isset($booking->status_kunjungan) && $booking->status_kunjungan === 'selesai') {
              $statusText = 'Telah Selesai Berkunjung';
              $statusColor = 'bg-gray-100 text-gray-700 border-gray-200';
              $icon = 'celebration';
          } elseif (isset($booking->status_kunjungan) && $booking->status_kunjungan === 'sedang') {
              $statusText = 'Sedang Berkunjung';
              $statusColor = 'bg-blue-100 text-blue-700 border-blue-200';
              $icon = 'directions_walk';
          } elseif ($booking->status === 'pending') {
              $statusText = 'Menunggu Verifikasi';
              $statusColor = 'bg-yellow-100 text-yellow-700 border-yellow-200';
              $icon = 'pending_actions';
          } elseif ($booking->isLunas()) {
              if ($isPast) {
                  $statusText = 'Siap Digunakan (Belum Check-In)';
                  $statusColor = 'bg-amber-100 text-amber-700 border-amber-200';
                  $icon = 'qr_code';
              } else {
                  $statusText = 'Terverifikasi / Siap Digunakan';
                  $statusColor = 'bg-green-100 text-green-700 border-green-200';
                  $icon = 'verified';
              }
          } elseif ($booking->isBatal()) {
              $statusText = 'Dibatalkan';
              $statusColor = 'bg-red-100 text-red-700 border-red-200';
              $icon = 'cancel';
          } else {
              $statusText = ucfirst($booking->status);
              $statusColor = 'bg-gray-100 text-gray-700 border-gray-200';
              $icon = 'info';
          }
      @endphp

      <div class="bg-surface-container-lowest p-4 md:p-6 rounded-2xl shadow-sm border border-surface-container-high flex flex-col md:flex-row gap-4 md:gap-6 transition-all duration-500" data-booking-id="{{ $booking->id }}" id="card-{{ $booking->id }}">
        <div class="w-full md:w-48 h-32 md:h-auto bg-primary/10 rounded-xl flex flex-col items-center justify-center border-2 border-dashed border-primary/30 shrink-0">
          <span class="material-symbols-outlined text-4xl text-primary mb-1">qr_code_2</span>
          <span class="font-mono text-xs md:text-sm font-bold text-primary tracking-wider">{{ $booking->booking_code }}</span>
        </div>

        <div class="flex-1 flex flex-col gap-3">
          <div class="flex flex-wrap items-start justify-between gap-2">
            <div>
              <!-- MENGGUNAKAN $paketDisplay YANG SUDAH diformat rapi -->
              <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">{{ $paketDisplay }}</h3>
              <p class="text-sm text-on-surface-variant flex items-center gap-1 mt-1">
                <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                {{ $visitDate->translatedFormat('d F Y') }}
              </p>
            </div>
            
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border {{ $statusColor }}">
              <span class="material-symbols-outlined text-[16px]">{{ $icon }}</span>
              {{ $statusText }}
            </span>
          </div>

          <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm mt-2">
            <div>
              <span class="text-on-surface-variant text-xs block">Jumlah</span>
              <span class="font-semibold text-on-surface">{{ $booking->jumlah_pengunjung }} Orang</span>
            </div>
            <div>
              <span class="text-on-surface-variant text-xs block">Total Bayar</span>
              <span class="font-bold text-primary">Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</span>
            </div>
            <div>
              <span class="text-on-surface-variant text-xs block">Metode</span>
              <span class="font-semibold text-on-surface uppercase">{{ $booking->metode_pembayaran }}</span>
            </div>
            <div>
              <span class="text-on-surface-variant text-xs block">Status Kunjungan</span>
              @if(isset($booking->status_kunjungan) && $booking->status_kunjungan === 'selesai' && isset($booking->selesai_at) && $booking->selesai_at)
                <span class="font-semibold text-on-surface">{{ \Carbon\Carbon::parse($booking->selesai_at)->format('d M Y H:i') }}</span>
              @else
                <span class="font-semibold text-on-surface-variant">-</span>
              @endif
            </div>
          </div>

          <div class="flex flex-wrap gap-2 mt-2 pt-3 border-t border-surface-container-high">
            @if(isset($booking->status_kunjungan) && $booking->status_kunjungan === 'selesai')
              <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold border border-gray-200">
                <span class="material-symbols-outlined text-[18px]">celebration</span>
                Kunjungan Selesai
              </span>
            @elseif(isset($booking->status_kunjungan) && $booking->status_kunjungan === 'sedang')
              <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm font-semibold border border-blue-200">
                <span class="material-symbols-outlined text-[18px]">directions_walk</span>
                Sedang Berkunjung
              </span>
            @elseif($booking->isLunas() && !$isPast)
              <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-on-primary rounded-lg text-sm font-semibold">
                <span class="material-symbols-outlined text-[18px]">verified</span>
                Tunjukkan E-Tiket saat berkunjung
              </span>
            @elseif($booking->isLunas() && $isPast && (!isset($booking->status_kunjungan) || $booking->status_kunjungan === 'belum'))
              <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-50 text-amber-700 rounded-lg text-sm font-semibold border border-amber-200">
                <span class="material-symbols-outlined text-[18px]">qr_code</span>
                Belum Check-In
              </span>
            @elseif($booking->status === 'pending')
              <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-yellow-50 text-yellow-700 rounded-lg text-sm font-semibold border border-yellow-200">
                <span class="material-symbols-outlined text-[18px]">pending</span>
                Menunggu Verifikasi Admin
              </span>
            @endif
          </div>
        </div>
      </div>
    @empty
      <div class="text-center py-12 bg-surface-container-lowest rounded-2xl border border-surface-container-high border-dashed">
        <span class="material-symbols-outlined text-6xl text-on-surface-variant opacity-30 mb-4">confirmation_number</span>
        <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold mb-1">Belum Ada Tiket</h3>
        <p class="text-body-sm text-on-surface-variant mb-4">Anda belum memiliki riwayat pemesanan tiket.</p>
        <a href="{{ route('pengunjung.wisata') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-on-primary rounded-xl text-sm font-semibold hover:bg-primary-container transition-colors">
          <span class="material-symbols-outlined text-[18px]">add</span>
          Pesan Tiket Sekarang
        </a>
      </div>
    @endforelse
  </div>
</section>
<!-- SCRIPT AUTO-UPDATE REAL-TIME -->
<script>
// Simpan status awal saat halaman pertama kali dimuat
const initialStatuses = {};
document.querySelectorAll('[data-booking-id]').forEach(card => {
    const id = card.getAttribute('data-booking-id');
    const badge = card.querySelector('.inline-flex.rounded-full'); // Ambil elemen badge status
    initialStatuses[id] = badge ? badge.innerText.trim() : 'unknown';
});

// Fungsi untuk mengecek status setiap 5 detik
setInterval(async function() {
    try {
        const response = await fetch("{{ route('api.check-status') }}");
        const data = await response.json();
        
        let hasChanged = false;

        // Bandingkan status di server dengan status di layar
        for (const [id, newStatus] of Object.entries(data)) {
            if (initialStatuses[id] && initialStatuses[id] !== newStatus) {
                hasChanged = true;
                initialStatuses[id] = newStatus; // Update status lokal
                
                // Efek visual: Kedipkan kartu yang berubah
                const card = document.getElementById('card-' + id);
                if (card) {
                    card.classList.add('ring-4', 'ring-emerald-300', 'bg-emerald-50');
                    setTimeout(() => {
                        card.classList.remove('ring-4', 'ring-emerald-300', 'bg-emerald-50');
                    }, 2000);
                }
            }
        }

        // Jika ada perubahan, tampilkan notifikasi dan refresh halaman dengan mulus
        if (hasChanged) {
            showNotification("🎉 Status tiket Anda diperbarui!");
            setTimeout(() => {
                window.location.reload();
            }, 1500); // Refresh setelah 1.5 detik agar user melihat notifikasi
        }

    } catch (error) {
        console.log("Gagal mengecek status (normal jika offline)");
    }
}, 5000); // Cek setiap 5000ms (5 detik)

// Fungsi untuk menampilkan notifikasi toast yang cantik
function showNotification(message) {
    const toast = document.createElement('div');
    toast.className = 'fixed top-5 right-5 bg-emerald-600 text-white px-6 py-3 rounded-xl shadow-2xl z-50 flex items-center gap-2 animate-bounce';
    toast.innerHTML = `<span class="material-symbols-outlined">check_circle</span> <span class="font-semibold">${message}</span>`;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 2000);
}
</script>
@endsection