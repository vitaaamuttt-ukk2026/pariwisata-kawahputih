@extends('layouts.panel')
@section('title', 'Kelola Booking')

@section('content')
<div class="flex flex-col gap-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Kelola Data Booking & Verifikasi Tiket</h1>
            <p class="text-body-sm text-on-surface-variant mt-1">Validasi bukti transfer, pelunasan, dan penerbitan tiket barcode loket</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            <span class="text-sm text-on-surface-variant">Live Gateway</span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-surface-container-lowest p-4 rounded-xl border border-surface-container-high">
            <div class="text-sm text-on-surface-variant mb-1">Total Booking</div>
            <div class="text-2xl font-bold text-on-surface">{{ $bookings->count() }}</div>
        </div>
        <div class="bg-surface-container-lowest p-4 rounded-xl border border-surface-container-high">
            <div class="text-sm text-on-surface-variant mb-1">Menunggu Verifikasi</div>
            <div class="text-2xl font-bold text-amber-600">{{ $bookings->where('status', 'pending')->count() }}</div>
        </div>
        <div class="bg-surface-container-lowest p-4 rounded-xl border border-surface-container-high">
            <div class="text-sm text-on-surface-variant mb-1">Lunas</div>
            <div class="text-2xl font-bold text-green-600">{{ $bookings->where('status', 'paid')->count() }}</div>
        </div>
        <div class="bg-surface-container-lowest p-4 rounded-xl border border-surface-container-high">
            <div class="text-sm text-on-surface-variant mb-1">Dibatalkan</div>
            <div class="text-2xl font-bold text-red-600">{{ $bookings->where('status', 'cancelled')->count() }}</div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-surface-container-lowest rounded-xl border border-surface-container-high overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-surface-container-low border-b border-surface-container-high">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-on-surface-variant uppercase">Booking ID</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-on-surface-variant uppercase">Nama Pemesan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-on-surface-variant uppercase">Tanggal</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-on-surface-variant uppercase">Detail Paket</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-on-surface-variant uppercase">Total</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-on-surface-variant uppercase">Bukti Bayar</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-on-surface-variant uppercase">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-on-surface-variant uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container-high">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-mono text-xs font-bold text-primary">{{ $booking->booking_code }}</div>
                            <div class="text-[10px] text-on-surface-variant">{{ $booking->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-semibold text-sm text-on-surface">{{ $booking->nama_lengkap }}</div>
                            <div class="text-[10px] text-on-surface-variant">{{ $booking->email }}</div>
                            <div class="text-[10px] text-on-surface-variant">{{ $booking->no_hp }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-on-surface">{{ $booking->tanggal_kunjungan->format('d M Y') }}</div>
                            <div class="text-[10px] text-on-surface-variant">{{ $booking->jumlah_pengunjung }} Orang</div>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                // Coba decode JSON, jika gagal tampilkan teks biasa
                                $detailPaket = json_decode($booking->paket, true);
                            @endphp
                            
                            @if(is_array($detailPaket))
                                <div class="space-y-1">
                                    @foreach($detailPaket as $item)
                                        <div class="text-xs text-on-surface flex justify-between gap-4">
                                            <span>{{ $item['nama'] }} <span class="text-on-surface-variant">x{{ $item['qty'] }}</span></span>
                                            <span class="font-semibold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-sm text-on-surface">{{ $booking->paket }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-primary">Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</div>
                            <div class="text-[10px] text-on-surface-variant">{{ ucfirst($booking->metode_pembayaran) }}</div>
                        </td>
                        <td>
                            @if($booking->bukti_pembayaran)
                                @php
                                $paths = [
                                    'storage/' . $booking->bukti_pembayaran,
                                    $booking->bukti_pembayaran,
                                    'bukti_pembayaran/' . basename($booking->bukti_pembayaran),
                                ];
            
                                $foundPath = null;
                                foreach($paths as $path) {
                                    if (file_exists(public_path($path))) {
                                        $foundPath = asset($path);
                                        break;
                                    }
                                }
                                @endphp
        
        @if($foundPath)
            <a href="{{ $foundPath }}" target="_blank" class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1 rounded text-sm font-medium">
                <span>📄</span> Lihat
            </a>
        @else
            <span class="text-red-500 text-xs">File hilang</span>
        @endif
    @else
        <span class="text-gray-400">-</span>
    @endif
</td>
                        <td class="px-4 py-3">
                            @if($booking->status === 'pending')
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 text-amber-700 text-[11px] font-bold rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Menunggu
                                </span>
                            @elseif($booking->status === 'paid')
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-700 text-[11px] font-bold rounded-full">
                                    <span class="material-symbols-outlined text-[12px]">check_circle</span>
                                    Lunas
                                </span>
                            @elseif($booking->status === 'cancelled')
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 text-[11px] font-bold rounded-full">
                                    <span class="material-symbols-outlined text-[12px]">cancel</span>
                                    Dibatalkan
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                @if($booking->status === 'pending')
                                    <form action="{{ route('admin.booking.verify', $booking->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">check</span>
                                            Verifikasi
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.booking.cancel', $booking->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1" onclick="return confirm('Yakin ingin membatalkan booking ini?')">
                                            <span class="material-symbols-outlined text-[14px]">close</span>
                                            Batal
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-on-surface-variant">✓ Selesai</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl opacity-30 block mb-2">inbox</span>
                            Belum ada data booking
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black/80 z-50 hidden flex items-center justify-center p-4" onclick="closeImageModal()">
    <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-w-full max-h-[90vh] rounded-lg">
</div>

<script>
function showImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}
</script>
@endsection