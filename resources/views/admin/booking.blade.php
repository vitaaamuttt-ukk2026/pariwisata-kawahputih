@extends('layouts.panel')

@section('title', 'Kelola Booking')
@section('page-title', 'Kelola Booking')

@section('content')
<section class="flex flex-col gap-space-md ml-space-md mr-space-md">

    {{-- Header Section --}}
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-space-md">
        <div class="flex items-center gap-space-sm">
            <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary-600">receipt_long</span>
            </div>
            <div class="flex flex-col">
                <div class="flex items-center gap-space-xs">
                    <h2 class="font-headline-md text-headline-md text-on-surface">Kelola Booking</h2>
                </div>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Validasi dan riwayat pemesanan pengunjung</span>
            </div>
        </div>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
            <div class="flex items-center gap-space-sm">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
            <div class="flex items-center gap-space-sm">
                <span class="material-symbols-outlined text-red-600">error</span>
                <span class="text-red-800 font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="bg-surface rounded-xl border border-surface-container-high p-space-md">
        <div class="flex flex-wrap items-center gap-2">
            @php
                $statuses = [
                    'all' => 'Semua',
                    'pending' => 'Pending',
                    'verified' => 'Terverifikasi',
                    'rejected' => 'Ditolak',
                ];
            @endphp

            @foreach($statuses as $key => $label)
                <a href="{{ route('admin.booking', ['status' => $key]) }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium border transition-colors {{ $status === $key ? 'bg-primary text-on-primary border-primary' : 'bg-surface-container-low text-on-surface border-surface-container-high hover:bg-surface-container' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Tabel Booking Pending --}}
    @php
        $statusTitleMap = [
            'all' => 'Semua Booking',
            'pending' => 'Booking Pending (Butuh Validasi)',
            'verified' => 'Booking Terverifikasi',
            'rejected' => 'Booking Ditolak',
        ];
    @endphp

    <div class="bg-surface rounded-xl border border-surface-container-high p-space-md">
        <div class="flex items-center justify-between mb-space-md">
            <h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $statusTitleMap[$status] ?? 'Booking' }}</h3>
            <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-body-sm font-medium">
                {{ $bookings->count() }} Data
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-container-high">
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">No. Booking</th>
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">Nama Pengunjung</th>
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">Wisata</th>
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">Tanggal</th>
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">Jumlah</th>
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">Total</th>
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">Bukti Bayar</th>
                        <th class="py-3.5 px-4 font-semibold text-right text-body-sm text-on-surface-variant">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container-high font-body-sm text-body-sm text-on-surface">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-surface-container/40 transition-colors align-middle">
                        <td class="py-3.5 px-4 font-mono font-bold text-secondary">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-sm text-secondary">receipt_long</span>
                                {{ $booking->booking_code }}
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div>
                                <div class="font-medium text-on-surface">{{ $booking->nama_lengkap }}</div>
                                <div class="text-on-surface-variant text-xs">{{ $booking->email }}</div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">{{ $booking->wisata->nama ?? '-' }}</td>
                        <td class="py-3.5 px-4">{{ \Carbon\Carbon::parse($booking->tanggal_kunjungan)->format('d M Y') }}</td>
                        <td class="py-3.5 px-4 font-medium">{{ $booking->jumlah_pengunjung }}</td>
                        <td class="py-3.5 px-4 font-semibold text-primary">Rp {{ number_format($booking->total_bayar, 0, ',', '.') }}</td>
                        <td class="py-3.5 px-4">
                            @if(!empty($booking->bukti_pembayaran) && Storage::disk('public')->exists($booking->bukti_pembayaran))
                                <a href="{{ asset('storage/' . $booking->bukti_pembayaran) }}" target="_blank" class="inline-flex items-center gap-1 text-primary underline text-xs font-medium">
                                    <span class="material-symbols-outlined text-sm">image</span>
                                    Lihat Bukti
                                </a>
                            @else
                                <span class="text-xs text-on-surface-variant">Belum upload</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center justify-end gap-space-xs">
                                <form method="POST" action="{{ route('admin.booking.confirm', $booking->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                        ✓ Verifikasi
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.booking.cancel', $booking->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menolak booking ini?')">
                                    @csrf
                                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                        ✕ Tolak
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-on-surface-variant">
                            <div class="flex flex-col items-center gap-space-sm">
                                <span class="material-symbols-outlined text-4xl text-on-surface-variant/40">inbox</span>
                                <span>Tidak ada booking pending</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tabel Riwayat Booking --}}
    <div class="bg-surface rounded-xl border border-surface-container-high p-space-md">
        <div class="flex items-center justify-between mb-space-md">
            <h3 class="font-headline-sm text-headline-sm text-on-surface">Riwayat Booking Terverifikasi</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-surface-container-high">
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">No. Booking</th>
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">Nama</th>
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">Wisata</th>
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">Tanggal</th>
                        <th class="py-3.5 px-4 font-semibold text-left text-body-sm text-on-surface-variant">Diverifikasi</th>
                        <th class="py-3.5 px-4 font-semibold text-right text-body-sm text-on-surface-variant">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container-high font-body-sm text-body-sm text-on-surface">
                    @forelse($riwayatBookings as $booking)
                    <tr class="hover:bg-surface-container/40 transition-colors align-middle">
                        <td class="py-3.5 px-4 font-mono font-bold text-secondary">{{ $booking->booking_code }}</td>
                        <td class="py-3.5 px-4">{{ $booking->nama_lengkap }}</td>
                        <td class="py-3.5 px-4">{{ $booking->wisata->nama ?? '-' }}</td>
                        <td class="py-3.5 px-4">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                        <td class="py-3.5 px-4">
                            <div>
                                <div class="font-medium">{{ $booking->verifiedBy->name ?? 'Admin' }}</div>
                                <div class="text-xs text-on-surface-variant">{{ \Carbon\Carbon::parse($booking->paid_at)->format('d M Y, H:i') }}</div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center justify-end gap-space-xs">
                                <a href="{{ route('admin.booking.cetak', $booking->id) }}" target="_blank" class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                    🖨 Cetak
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-on-surface-variant">
                            <div class="flex flex-col items-center gap-space-sm">
                                <span class="material-symbols-outlined text-4xl text-on-surface-variant/40">history</span>
                                <span>Belum ada riwayat booking</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-space-md">
            {{ $riwayatBookings->links() }}
        </div>
    </div>

</section>
@endsection