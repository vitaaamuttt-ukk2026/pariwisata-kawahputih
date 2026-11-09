@extends('layouts.panel')
@section('title', 'Kelola Data Reservasi')
@section('page-title', 'Kelola Data Reservasi')

@section('content')
<div class="flex flex-col gap-6">
    <!-- Header & Stats -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Kelola Data Reservasi</h1>
            <p class="text-body-sm text-on-surface-variant mt-1">Validasi bukti transfer, pelunasan, dan penerbitan tiket barcode loket</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            <span class="text-sm text-on-surface-variant">Live Gateway</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">groups</span>
                </div>
                <div>
                    <p class="text-sm text-blue-600 font-semibold">Total Reservasi</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $reservasi->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-green-50 p-4 rounded-xl border border-green-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">verified</span>
                </div>
                <div>
                    <p class="text-sm text-green-600 font-semibold">Terverifikasi</p>
                    <p class="text-2xl font-bold text-green-700">{{ $reservasi->filter(fn($b) => $b->isLunas())->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-amber-50 p-4 rounded-xl border border-amber-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[24px]">pending_actions</span>
                </div>
                <div>
                    <p class="text-sm text-amber-600 font-semibold">Perlu Verifikasi</p>
                    <p class="text-2xl font-bold text-amber-700">{{ $reservasi->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white p-4 rounded-xl border border-gray-200">
        <form method="GET" action="{{ route('pengelola.reservasi') }}" class="flex gap-3">
            <div class="flex-1 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search ?? '' }}" 
                    placeholder="Cari berdasarkan nama, email, nomor HP, atau kode booking..." 
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-sm"
                >
            </div>
            <button type="submit" class="bg-primary hover:bg-primary-container text-on-primary px-6 py-2.5 rounded-lg font-semibold transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">search</span>
                Cari
            </button>
            @if($search)
            <a href="{{ route('pengelola.reservasi') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg font-semibold transition-colors">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode Booking</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Tamu</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Pax</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Kunjungan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Paket Wisata</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Bayar</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($reservasi as $booking)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-mono text-xs font-bold text-primary">{{ $booking->booking_code }}</div>
                            <div class="text-[10px] text-gray-500">{{ $booking->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-semibold text-sm text-gray-800">{{ $booking->nama_lengkap }}</div>
                            <div class="text-[10px] text-gray-500">{{ $booking->email }}</div>
                            <div class="text-[10px] text-gray-500">{{ $booking->no_hp }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-700">{{ $booking->jumlah_pengunjung }} Orang</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-700">{{ $booking->tanggal_kunjungan->format('d M Y') }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-xs text-gray-700 max-w-xs">
                                @php
                                    // Decode JSON paket jika ada
                                    $detailPaket = json_decode($booking->paket, true);
                                @endphp
                                
                                @if(is_array($detailPaket))
                                    @foreach($detailPaket as $item)
                                        <div class="flex justify-between gap-2 mb-1">
                                            <span>{{ $item['nama'] }} <span class="text-gray-500">x{{ $item['qty'] }}</span></span>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-gray-600">{{ $booking->paket }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-primary text-sm">Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</div>
                            <div class="text-[10px] text-gray-500">{{ ucfirst($booking->metode_pembayaran) }}</div>
                        </td>
                        <td class="px-4 py-3">
                            @if($booking->status === 'pending')
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 text-amber-700 text-[11px] font-bold rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Menunggu
                                </span>
                            @elseif($booking->isLunas())
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 text-[11px] font-bold rounded-full">
                                    <span class="material-symbols-outlined text-[12px]">check_circle</span>
                                    Terverifikasi
                                </span>
                            @elseif($booking->isBatal())
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 text-[11px] font-bold rounded-full">
                                    <span class="material-symbols-outlined text-[12px]">cancel</span>
                                    Dibatalkan
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
    <div class="flex items-center gap-2">
        @if($booking->isLunas())
            @if($booking->status_kunjungan === 'selesai')
                <span class="text-xs text-gray-500 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px] text-green-600">check_circle</span>
                    Selesai
                </span>
            @elseif($booking->status_kunjungan === 'sedang')
                <form action="{{ route('pengelola.reservasi.selesai', $booking->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">event_available</span>
                        Tandai Selesai
                    </button>
                </form>
            @else
                @if($booking->tanggal_kunjungan->isToday() || $booking->tanggal_kunjungan->isPast())
                    <form action="{{ route('pengelola.reservasi.sedang', $booking->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">login</span>
                            Check-In
                        </button>
                    </form>
                @else
                    <span class="text-xs text-gray-400">Belum Tanggal Kunjungan</span>
                @endif
            @endif
        @else
            <span class="text-xs text-gray-400">-</span>
        @endif
    </div>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                            <span class="material-symbols-outlined text-4xl opacity-30 block mb-2">inbox</span>
                            <p class="text-sm">Tidak ada data reservasi</p>
                            @if($search)
                                <p class="text-xs mt-1">Coba kata kunci pencarian lain</p>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection