@extends('layouts.panel')
@section('title', 'Operasional')
@section('page-title', 'Operasional Lapangan')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', timer: 3000, showConfirmButton: false, toast: true, position: 'top-end' });
</script>
@endif

<form method="POST" action="{{ route('pengelola.operasional.update') }}" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kondisi Cuaca -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-500">wb_sunny</span>
                    Kondisi Cuaca
                </h3>
                <span class="text-xs text-emerald-600 font-semibold">Siaran Langsung</span>
            </div>
            
            <div class="bg-amber-50 rounded-xl p-4 mb-4">
                <div class="text-3xl font-bold text-gray-800">{{ $setting->suhu ?? '28' }}°C</div>
                <div class="text-sm text-gray-600">{{ $setting->kondisi_cuaca ?? 'Cerah' }}</div>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Suhu</label>
                    <input type="text" name="suhu" value="{{ $setting->suhu ?? '28' }}" class="w-full border border-gray-300 rounded-lg p-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Cuaca</label>
                    <input type="text" name="kondisi_cuaca" value="{{ $setting->kondisi_cuaca ?? 'Cerah' }}" class="w-full border border-gray-300 rounded-lg p-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Angin</label>
                    <input type="text" name="status_angin" value="{{ $setting->status_angin ?? 'Tenang' }}" class="w-full border border-gray-300 rounded-lg p-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Siaran</label>
                    <select name="status_siaran" class="w-full border border-gray-300 rounded-lg p-2.5">
                        <option value="Normal / Cerah" {{ ($setting->status_siaran ?? '') == 'Normal / Cerah' ? 'selected' : '' }}>Normal / Cerah</option>
                        <option value="Waspada" {{ ($setting->status_siaran ?? '') == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                        <option value="Bahaya" {{ ($setting->status_siaran ?? '') == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Kuota Pengunjung -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-500">groups</span>
                    Kuota Pengunjung
                </h3>
                <span class="bg-gray-800 text-white text-xs px-2 py-1 rounded-full">
                    {{ $setting->pengunjung_aktif ?? 0 }} / {{ $setting->kuota_maksimal ?? 1200 }}
                </span>
            </div>

            <div class="mb-4">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Batas Wilayah Suaka</span>
                    <span class="font-semibold">{{ number_format((($setting->pengunjung_aktif ?? 0) / ($setting->kuota_maksimal ?? 1200)) * 100, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ min(100, (($setting->pengunjung_aktif ?? 0) / ($setting->kuota_maksimal ?? 1200)) * 100) }}%"></div>
                </div>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Maksimal</label>
                    <input type="number" name="kuota_maksimal" value="{{ $setting->kuota_maksimal ?? 1200 }}" class="w-full border border-gray-300 rounded-lg p-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pengunjung Aktif Saat Ini</label>
                    <input type="number" name="pengunjung_aktif" value="{{ $setting->pengunjung_aktif ?? 0 }}" class="w-full border border-gray-300 rounded-lg p-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Gerbang</label>
                    <select name="status_gerbang" class="w-full border border-gray-300 rounded-lg p-2.5">
                        <option value="Buka Normal" {{ ($setting->status_gerbang ?? '') == 'Buka Normal' ? 'selected' : '' }}>Buka Normal</option>
                        <option value="Kuota Hampir Penuh" {{ ($setting->status_gerbang ?? '') == 'Kuota Hampir Penuh' ? 'selected' : '' }}>Kuota Hampir Penuh</option>
                        <option value="Tutup Sementara" {{ ($setting->status_gerbang ?? '') == 'Tutup Sementara' ? 'selected' : '' }}>Tutup Sementara</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Arahan Petugas -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-800 flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-blue-500">campaign</span>
                Arahan Petugas Lapangan
            </h3>

            <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-3 mb-4">
                <div class="text-sm font-semibold text-emerald-900">Buletin Lapangan Aktif</div>
                <div class="text-sm text-emerald-700 mt-1">{{ $setting->buletin_lapangan ?? 'Belum ada buletin.' }}</div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buletin / Arahan Baru</label>
                <textarea name="buletin_lapangan" rows="4" class="w-full border border-gray-300 rounded-lg p-2.5" placeholder="Tulis arahan untuk petugas lapangan...">{{ $setting->buletin_lapangan ?? '' }}</textarea>
            </div>
        </div>
    </div>

    <!-- Update Kunjungan -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-500">hiking</span>
                Update Kunjungan (Pembaharuan Arus Pengunjung Langsung)
            </h3>
            <span class="text-xs bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full">Siaran Masuk Langsung</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pintu Masuk & Dermaga -->
            <div class="border border-gray-200 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-semibold text-gray-800 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500">anchor</span>
                        Pintu Masuk & Dermaga
                    </h4>
                    <span class="text-xs text-gray-500">Pembaruan Live</span>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Dermaga</label>
                        <select name="status_dermaga" class="w-full border border-gray-300 rounded-lg p-2.5">
                            <option value="Aktif - Selesai Boarding" {{ ($setting->status_dermaga ?? '') == 'Aktif - Selesai Boarding' ? 'selected' : '' }}>Aktif - Selesai Boarding</option>
                            <option value="Boarding Berlangsung" {{ ($setting->status_dermaga ?? '') == 'Boarding Berlangsung' ? 'selected' : '' }}>Boarding Berlangsung</option>
                            <option value="Tutup" {{ ($setting->status_dermaga ?? '') == 'Tutup' ? 'selected' : '' }}>Tutup</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Info Dermaga</label>
                        <input type="text" name="info_dermaga" value="{{ $setting->info_dermaga ?? '' }}" class="w-full border border-gray-300 rounded-lg p-2.5" placeholder="Contoh: Kapal Ferry Sentosa (142 penumpang tiba)">
                    </div>
                </div>
            </div>

            <!-- Distribusi Zona -->
            <div class="border border-gray-200 rounded-xl p-4">
                <h4 class="font-semibold text-gray-800 flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-emerald-500">map</span>
                    Distribusi Zona Aktif
                </h4>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700">Zona Terumbu Karang</span>
                            <span class="font-semibold">{{ $setting->zona_terumbu_karang ?? 320 }} / {{ $setting->zona_terumbu_kapasitas ?? 400 }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="zona_terumbu_karang" value="{{ $setting->zona_terumbu_karang ?? 320 }}" class="border border-gray-300 rounded-lg p-2" placeholder="Aktif">
                            <input type="number" name="zona_terumbu_kapasitas" value="{{ $setting->zona_terumbu_kapasitas ?? 400 }}" class="border border-gray-300 rounded-lg p-2" placeholder="Kapasitas">
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700">Hutan Mangrove & Kayak</span>
                            <span class="font-semibold">{{ $setting->zona_mangrove ?? 180 }} / {{ $setting->zona_mangrove_kapasitas ?? 250 }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="zona_mangrove" value="{{ $setting->zona_mangrove ?? 180 }}" class="border border-gray-300 rounded-lg p-2" placeholder="Aktif">
                            <input type="number" name="zona_mangrove_kapasitas" value="{{ $setting->zona_mangrove_kapasitas ?? 250 }}" class="border border-gray-300 rounded-lg p-2" placeholder="Kapasitas">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-8 rounded-xl flex items-center gap-2">
            <span class="material-symbols-outlined">campaign</span>
            Perbarui & Siarkan Sekarang
        </button>
    </div>
</form>
@endsection