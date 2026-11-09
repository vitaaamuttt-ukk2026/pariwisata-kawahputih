@extends('layouts.pengunjung')
@section('title', 'Riwayat Tiket')

@section('content')
<section class="page-shell flex flex-col gap-space-lg w-full mb-space-xl">
  <div class="glass-panel p-5 md:p-6">
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
          
          if ($booking->status === 'pending') {
              $statusText = 'Menunggu Verifikasi';
              $statusColor = 'bg-yellow-100 text-yellow-700 border-yellow-200';
              $icon = 'pending_actions';
          } elseif ($booking->status === 'verified') {
              if ($isPast) {
                  $statusText = 'Telah Dipakai';
                  $statusColor = 'bg-gray-100 text-gray-700 border-gray-200';
                  $icon = 'check_circle';
              } else {
                  $statusText = 'Terverifikasi / Siap Digunakan';
                  $statusColor = 'bg-green-100 text-green-700 border-green-200';
                  $icon = 'verified';
              }
          } elseif ($booking->status === 'rejected') {
              $statusText = 'Dibatalkan';
              $statusColor = 'bg-red-100 text-red-700 border-red-200';
              $icon = 'cancel';
          } else {
              $statusText = ucfirst($booking->status);
              $statusColor = 'bg-gray-100 text-gray-700 border-gray-200';
              $icon = 'info';
          }
      @endphp

      <div class="soft-card p-4 md:p-6 flex flex-col md:flex-row gap-4 md:gap-6 reveal">
        <div class="w-full md:w-48 h-32 md:h-auto bg-primary/10 rounded-xl flex flex-col items-center justify-center border-2 border-dashed border-primary/30 shrink-0">
          <span class="material-symbols-outlined text-4xl text-primary mb-1">qr_code_2</span>
          <span class="font-mono text-xs md:text-sm font-bold text-primary tracking-wider">{{ $booking->booking_code }}</span>
        </div>

        <div class="flex-1 flex flex-col gap-3">
          <div class="flex flex-wrap items-start justify-between gap-2">
            <div>
              <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">{{ $booking->paket }}</h3>
              <p class="text-sm text-on-surface-variant flex items-center gap-1 mt-1">
                <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                {{ $visitDate->translatedFormat('d F Y') }}
              </p>
            </div>
            
            <span class="status-pill {{ $booking->status === 'pending' ? 'pending' : ($booking->status === 'verified' ? 'verified' : ($booking->status === 'rejected' ? 'rejected' : 'pending')) }}">
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
              <span class="text-on-surface-variant text-xs block">Tanggal Booking</span>
              <span class="font-semibold text-on-surface">{{ $booking->created_at->format('d M Y') }}</span>
            </div>
          </div>

          <div class="flex flex-wrap gap-2 mt-2 pt-3 border-t border-surface-container-high">
            @if($booking->status === 'verified' && !$isPast)
              <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-on-primary rounded-lg text-sm font-semibold">
                <span class="material-symbols-outlined text-[18px]">verified</span>
                Tunjukkan E-Tiket saat berkunjung
              </span>
            @elseif($booking->status === 'verified' && $isPast)
              <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-50 text-gray-600 rounded-lg text-sm font-semibold border border-gray-200">
                <span class="material-symbols-outlined text-[18px]">archive</span>
                Kunjungan Selesai
              </span>
            @elseif($booking->status === 'pending')
              <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-yellow-50 text-yellow-700 rounded-lg text-sm font-semibold border border-yellow-200">
                <span class="material-symbols-outlined text-[18px]">pending</span>
                Menunggu Verifikasi Admin
              </span>
            @elseif($booking->status === 'rejected')
              <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-50 text-red-700 rounded-lg text-sm font-semibold border border-red-200">
                <span class="material-symbols-outlined text-[18px]">cancel</span>
                Booking Ditolak
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
@endsection