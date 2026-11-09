@extends('layouts.panel')
@section('title', 'Tambah Paket Wisata')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <a href="{{ route('admin.paket.index') }}" class="text-primary text-sm font-semibold flex items-center gap-1 hover:underline mb-2 no-underline">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Daftar Paket
        </a>
        <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold">Tambah Paket Wisata Baru</h1>
        <p class="text-body-sm text-on-surface-variant mt-1">Isi detail paket wisata yang akan ditampilkan di halaman pengunjung.</p>
    </div>
</div>

<div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-surface-container-high p-6 max-w-3xl">
    <form action="{{ route('admin.paket.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Nama Paket -->
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm text-on-surface font-semibold">Nama Paket *</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Tiket Masuk WNI" 
                    class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                @error('nama') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Harga -->
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm text-on-surface font-semibold">Harga (Rp) *</label>
                <input type="number" name="harga" value="{{ old('harga') }}" required min="0" placeholder="Contoh: 31000" 
                    class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                @error('harga') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Kategori -->
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm text-on-surface font-semibold">Kategori *</label>
                <select name="kategori" required class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="tiket_masuk" {{ old('kategori') == 'tiket_masuk' ? 'selected' : '' }}>Tiket Masuk</option>
                    <option value="paket_bundle" {{ old('kategori') == 'paket_bundle' ? 'selected' : '' }}>Paket Bundle</option>
                    <option value="transportasi" {{ old('kategori') == 'transportasi' ? 'selected' : '' }}>Transportasi & Parkir</option>
                    <option value="wahana" {{ old('kategori') == 'wahana' ? 'selected' : '' }}>Wahana & Aktivitas</option>
                    <option value="layanan" {{ old('kategori') == 'layanan' ? 'selected' : '' }}>Layanan Tambahan</option>
                </select>
                @error('kategori') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Urutan Tampil -->
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm text-on-surface font-semibold">Urutan Tampil</label>
                <input type="number" name="urutan" value="{{ old('urutan', 0) }}" min="0" placeholder="0 (Paling Atas)" 
                    class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                <span class="text-xs text-on-surface-variant mt-1">Semakin kecil angkanya, semakin atas posisinya.</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Icon -->
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm text-on-surface font-semibold">Nama Icon</label>
                <input type="text" name="icon" value="{{ old('icon', 'badge') }}" placeholder="badge" 
                    class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                <span class="text-xs text-on-surface-variant mt-1">Gunakan nama dari <a href="https://fonts.google.com/icons" target="_blank" class="text-primary hover:underline">Material Symbols</a>.</span>
            </div>

            <!-- Badge Label -->
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm text-on-surface font-semibold">Label Badge (Opsional)</label>
                <input type="text" name="badge" value="{{ old('badge') }}" placeholder="Contoh: Best Value, Wajib" 
                    class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <!-- Warna Badge -->
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm text-on-surface font-semibold">Warna Badge</label>
                <select name="badge_color" class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="primary" {{ old('badge_color', 'primary') == 'primary' ? 'selected' : '' }}>Primary (Hijau)</option>
                    <option value="secondary" {{ old('badge_color') == 'secondary' ? 'selected' : '' }}>Secondary (Biru)</option>
                    <option value="tertiary" {{ old('badge_color') == 'tertiary' ? 'selected' : '' }}>Tertiary (Oranye)</option>
                </select>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="flex flex-col gap-1">
            <label class="font-label-sm text-label-sm text-on-surface font-semibold">Deskripsi Singkat</label>
            <textarea name="deskripsi" rows="3" placeholder="Jelaskan secara singkat apa yang termasuk dalam paket ini..." 
                class="w-full p-3 border border-surface-container-high rounded-xl bg-surface-container-low text-on-surface outline-none focus:ring-2 focus:ring-primary focus:border-transparent resize-none">{{ old('deskripsi') }}</textarea>
        </div>

        <!-- Status Aktif -->
        <div class="flex items-center gap-3 p-3 bg-surface-container-low rounded-xl border border-surface-container-high">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 text-primary rounded border-surface-container-high focus:ring-primary cursor-pointer">
            <label for="is_active" class="text-sm font-semibold text-on-surface cursor-pointer">
                Aktifkan Paket Ini <span class="text-on-surface-variant font-normal">(Paket akan langsung tampil di halaman pengunjung)</span>
            </label>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center gap-3 pt-4 border-t border-surface-container-high">
            <button type="submit" class="bg-primary text-on-primary px-6 py-3 rounded-xl font-semibold hover:bg-primary-container transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">save</span>
                Simpan Paket Wisata
            </button>
            <a href="{{ route('admin.paket.index') }}" class="bg-surface-container-high text-on-surface px-6 py-3 rounded-xl font-semibold hover:bg-surface-container-highest transition-colors no-underline">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection