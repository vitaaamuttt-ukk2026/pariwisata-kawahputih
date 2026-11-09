@extends('layouts.panel')
@section('title', 'Edit Paket Wisata')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.paket.index') }}" class="text-primary text-sm font-semibold flex items-center gap-1 hover:underline no-underline mb-2">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
    </a>
    <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Edit Paket Wisata</h1>
</div>

<div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-surface-container-high p-6 max-w-2xl">
    <form action="{{ route('admin.paket.update', $paket->id) }}" method="POST" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <div>
            <label class="font-label-sm text-label-sm text-on-surface font-semibold block mb-1">Nama Paket *</label>
            <input type="text" name="nama" value="{{ old('nama', $paket->nama) }}" required class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary">
            @error('nama') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="font-label-sm text-label-sm text-on-surface font-semibold block mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary">{{ old('deskripsi', $paket->deskripsi) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-label-sm text-label-sm text-on-surface font-semibold block mb-1">Harga (Rp) *</label>
                <input type="number" name="harga" value="{{ old('harga', $paket->harga) }}" required min="0" class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary">
                @error('harga') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface font-semibold block mb-1">Kategori *</label>
                <select name="kategori" required class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary">
                    <option value="tiket_masuk" {{ old('kategori', $paket->kategori) == 'tiket_masuk' ? 'selected' : '' }}>Tiket Masuk</option>
                    <option value="paket_bundle" {{ old('kategori', $paket->kategori) == 'paket_bundle' ? 'selected' : '' }}>Paket Bundle</option>
                    <option value="transportasi" {{ old('kategori', $paket->kategori) == 'transportasi' ? 'selected' : '' }}>Transportasi</option>
                    <option value="wahana" {{ old('kategori', $paket->kategori) == 'wahana' ? 'selected' : '' }}>Wahana</option>
                    <option value="layanan" {{ old('kategori', $paket->kategori) == 'layanan' ? 'selected' : '' }}>Layanan</option>
                </select>
                @error('kategori') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="font-label-sm text-label-sm text-on-surface font-semibold block mb-1">Icon</label>
                <input type="text" name="icon" value="{{ old('icon', $paket->icon) }}" class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface font-semibold block mb-1">Badge Label</label>
                <input type="text" name="badge" value="{{ old('badge', $paket->badge) }}" class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface font-semibold block mb-1">Warna Badge</label>
                <select name="badge_color" class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary">
                    <option value="primary" {{ old('badge_color', $paket->badge_color) == 'primary' ? 'selected' : '' }}>Primary</option>
                    <option value="secondary" {{ old('badge_color', $paket->badge_color) == 'secondary' ? 'selected' : '' }}>Secondary</option>
                    <option value="tertiary" {{ old('badge_color', $paket->badge_color) == 'tertiary' ? 'selected' : '' }}>Tertiary</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-label-sm text-label-sm text-on-surface font-semibold block mb-1">Urutan Tampil</label>
                <input type="number" name="urutan" value="{{ old('urutan', $paket->urutan) }}" min="0" class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="font-label-sm text-label-sm text-on-surface font-semibold block mb-1">Status</label>
                <div class="flex items-center gap-2 mt-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $paket->is_active) ? 'checked' : '' }} class="w-4 h-4 text-primary rounded">
                    <label for="is_active" class="text-sm text-on-surface">Paket Aktif</label>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-4 border-t border-surface-container-high">
            <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-xl font-semibold hover:bg-primary-container transition-colors">
                Update Paket
            </button>
            <a href="{{ route('admin.paket.index') }}" class="bg-surface-container-high text-on-surface px-6 py-2.5 rounded-xl font-semibold hover:bg-surface-container-highest transition-colors no-underline">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection