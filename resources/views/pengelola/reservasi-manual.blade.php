@extends('layouts.panel')
@section('title', 'Reservasi')
@section('page-title', 'Kelola Reservasi')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Reservasi Wisata</h2>
                <p class="text-sm text-slate-500 mt-1">Pantau daftar tamu yang telah melakukan reservasi dan status pemesanan.</p>
            </div>
            <button type="button" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <span class="material-symbols-outlined text-base">add</span>
                Tambah Reservasi
            </button>
        </div>

        <form method="GET" action="{{ route('pengelola.reservasi.manual') }}" class="mb-6">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="flex-1">
                    <label for="search" class="sr-only">Cari reservasi</label>
                    <input id="search" type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama, status, atau tanggal..." class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-slate-800 text-white px-4 py-2.5 rounded-lg hover:bg-slate-900 transition">
                    <span class="material-symbols-outlined text-base">search</span>
                    Cari
                </button>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-600">Total</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $reservasi->total() }}</p>
                    </div>
                    <span class="material-symbols-outlined text-3xl text-blue-600">groups</span>
                </div>
            </div>
            <div class="bg-green-50 border border-green-100 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-green-600">Approved</p>
                        <p class="text-2xl font-bold text-green-700">{{ \App\Models\Reservasi::where('status', 'approved')->count() }}</p>
                    </div>
                    <span class="material-symbols-outlined text-3xl text-green-600">check_circle</span>
                </div>
            </div>
            <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-amber-600">Pending</p>
                        <p class="text-2xl font-bold text-amber-700">{{ \App\Models\Reservasi::where('status', 'pending')->count() }}</p>
                    </div>
                    <span class="material-symbols-outlined text-3xl text-amber-600">schedule</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Nama Tamu</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Jumlah</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reservasi as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">{{ $item->nama_tamu }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $item->jumlah_pax }} pax</td>
                            <td class="px-4 py-3 text-slate-600">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusClass = match($item->status) {
                                        'approved' => 'bg-green-100 text-green-700',
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <button type="button" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Detail</button>
                                    <button type="button" class="js-submit-btn text-green-600 hover:text-green-700 text-sm font-medium">Setujui</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-slate-500">
                                Belum ada data reservasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reservasi->hasPages())
            <div class="mt-6 flex items-center justify-between gap-3 flex-wrap">
                <div class="text-sm text-slate-500">
                    Menampilkan {{ $reservasi->firstItem() ?? 0 }}-{{ $reservasi->lastItem() ?? 0 }} dari {{ $reservasi->total() }} data
                </div>
                <div class="pagination-links">
                    {{ $reservasi->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.js-submit-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                const originalText = button.textContent;
                button.disabled = true;
                button.textContent = 'Memproses...';
                button.classList.add('opacity-70', 'cursor-not-allowed');

                setTimeout(function () {
                    button.disabled = false;
                    button.textContent = originalText;
                    button.classList.remove('opacity-70', 'cursor-not-allowed');
                }, 1200);
            });
        });
    });
</script>
@endsection