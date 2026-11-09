@extends('layouts.panel')
@section('title', 'Edit Informasi')
@section('page-title', 'Edit Informasi Wisata')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Informasi Teks</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola sejarah, lokasi, harga, dan tips.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-3 rounded-lg mb-4">
            <p class="text-emerald-700 text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.info.update') }}" class="space-y-6">
        @csrf

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Sejarah & Deskripsi</h3>
            <textarea name="sejarah" rows="5" class="w-full border border-gray-300 rounded-lg p-3">{{ old('sejarah', $info['sejarah'] ?? '') }}</textarea>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Lokasi</h3>
            <textarea name="lokasi" rows="3" class="w-full border border-gray-300 rounded-lg p-3">{{ old('lokasi', $info['lokasi'] ?? '') }}</textarea>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Jam Operasional</h3>
            <textarea name="jam_operasional" rows="3" class="w-full border border-gray-300 rounded-lg p-3">{{ old('jam_operasional', $info['jam_operasional'] ?? '') }}</textarea>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Fasilitas (pisahkan dengan koma)</h3>
            <input type="text" name="fasilitas" value="{{ old('fasilitas', $info['fasilitas'] ?? '') }}" class="w-full border border-gray-300 rounded-lg p-3">
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Harga Tiket & Layanan</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tiket Domestik (Rp)</label>
                    <input type="number" name="tiket_domestik" value="{{ old('tiket_domestik', $info['tiket_domestik'] ?? 30000) }}" class="w-full border border-gray-300 rounded-lg p-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tiket Mancanegara (Rp)</label>
                    <input type="number" name="tiket_mancanegara" value="{{ old('tiket_mancanegara', $info['tiket_mancanegara'] ?? 80000) }}" class="w-full border border-gray-300 rounded-lg p-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Shuttle (Rp)</label>
                    <input type="number" name="shuttle_price" value="{{ old('shuttle_price', $info['shuttle_price'] ?? 25000) }}" class="w-full border border-gray-300 rounded-lg p-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parkir Motor (Rp)</label>
                    <input type="number" name="parkir_motor" value="{{ old('parkir_motor', $info['parkir_motor'] ?? 5000) }}" class="w-full border border-gray-300 rounded-lg p-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parkir Mobil (Rp)</label>
                    <input type="number" name="parkir_mobil" value="{{ old('parkir_mobil', $info['parkir_mobil'] ?? 20000) }}" class="w-full border border-gray-300 rounded-lg p-3">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Tips</h3>
            <div class="space-y-3">
                <input type="text" name="tips_1" value="{{ old('tips_1', $info['tips_1'] ?? '') }}" placeholder="Tips 1" class="w-full border border-gray-300 rounded-lg p-3">
                <input type="text" name="tips_2" value="{{ old('tips_2', $info['tips_2'] ?? '') }}" placeholder="Tips 2" class="w-full border border-gray-300 rounded-lg p-3">
                <input type="text" name="tips_3" value="{{ old('tips_3', $info['tips_3'] ?? '') }}" placeholder="Tips 3" class="w-full border border-gray-300 rounded-lg p-3">
                <input type="text" name="tips_4" value="{{ old('tips_4', $info['tips_4'] ?? '') }}" placeholder="Tips 4" class="w-full border border-gray-300 rounded-lg p-3">
            </div>
        </div>

        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl font-semibold">Simpan Perubahan Teks</button>
    </form>

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
        <p class="text-blue-800 text-sm">💡 Ingin mengubah <strong>Foto Header, Spot Foto, Hotel, atau Galeri</strong>? <br> Silakan klik menu <strong>"Edit Dashboard"</strong> di sidebar sebelah kiri.</p>
    </div>
</div>
@endsection