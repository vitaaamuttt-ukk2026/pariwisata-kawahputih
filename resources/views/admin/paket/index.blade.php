@extends('layouts.panel')
@section('title', 'Kelola Paket Wisata')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Kelola Paket Wisata</h1>
        <p class="text-body-sm text-on-surface-variant mt-1">Tambah, ubah, atau hapus paket wisata yang tampil di halaman pengunjung.</p>
    </div>
    <a href="{{ route('admin.paket.create') }}" class="bg-primary text-on-primary px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 hover:bg-primary-container transition-colors no-underline">
        <span class="material-symbols-outlined text-[18px]">add</span>
        Tambah Paket
    </a>
</div>

@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg mb-4">
    <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
</div>
@endif

<div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-surface-container-high overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-surface-container-low border-b border-surface-container-high">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-on-surface">Nama Paket</th>
                    <th class="text-left px-4 py-3 font-semibold text-on-surface">Kategori</th>
                    <th class="text-left px-4 py-3 font-semibold text-on-surface">Harga</th>
                    <th class="text-left px-4 py-3 font-semibold text-on-surface">Status</th>
                    <th class="text-left px-4 py-3 font-semibold text-on-surface">Urutan</th>
                    <th class="text-right px-4 py-3 font-semibold text-on-surface">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-high">
                @forelse($pakets as $paket)
                <tr class="hover:bg-surface-container-low/50 transition-colors">
                    <td class="px-4 py-3">
                        <div class="font-semibold text-on-surface">{{ $paket->nama }}</div>
                        @if($paket->badge)
                        <span class="text-xs text-on-surface-variant">{{ $paket->badge }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 bg-surface-container-low text-on-surface-variant text-xs rounded-md">
                            {{ str_replace('_', ' ', ucfirst($paket->kategori)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 font-bold text-primary">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        @if($paket->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">Aktif</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full font-semibold">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-on-surface-variant">{{ $paket->urutan }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.paket.edit', $paket->id) }}" class="text-primary hover:bg-primary/10 p-1.5 rounded-lg transition-colors no-underline" title="Edit Paket">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            
                            <!-- FORM HAPUS DENGAN KONFIRMASI -->
                            <form action="{{ route('admin.paket.destroy', $paket->id) }}" method="POST" class="inline" onsubmit="return confirm('⚠️ Yakin ingin menghapus paket wisata ini?\n\nTindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-colors" title="Hapus Paket">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                            
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl opacity-30 block mb-2">inventory_2</span>
                        Belum ada paket wisata. Klik "Tambah Paket" untuk memulai.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection