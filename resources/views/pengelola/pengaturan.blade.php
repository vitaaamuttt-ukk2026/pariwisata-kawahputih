@extends('layouts.panel')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Akun')

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

<div class="max-w-3xl mx-auto space-y-6">
    <!-- Info Akun -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-emerald-500">person</span>
            Informasi Akun
        </h3>
        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-2xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div class="font-bold text-gray-800">{{ $user->name }}</div>
                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                <span class="inline-block mt-1 px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs rounded-full font-semibold">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Form Update Profil -->
    <form method="POST" action="{{ route('pengelola.pengaturan.update') }}" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-4">
        @csrf
        <h3 class="font-bold text-gray-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-500">edit</span>
            Edit Profil
        </h3>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-gray-300 rounded-lg p-2.5">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-300 rounded-lg p-2.5">
        </div>

        <div class="border-t pt-4">
            <h4 class="font-semibold text-gray-700 mb-3">Ubah Password (Opsional)</h4>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" class="w-full border border-gray-300 rounded-lg p-2.5" placeholder="Kosongkan jika tidak ingin mengubah">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg p-2.5">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-lg">
            Simpan Perubahan
        </button>
    </form>

    <!-- Info Sistem -->
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6">
        <h3 class="font-bold text-blue-900 mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-600">info</span>
            Informasi Sistem
        </h3>
        <div class="space-y-2 text-sm text-blue-800">
            <div class="flex justify-between">
                <span>Versi Aplikasi</span>
                <span class="font-semibold">1.0.0</span>
            </div>
            <div class="flex justify-between">
                <span>Terakhir Login</span>
                <span class="font-semibold">{{ now()->format('d M Y, H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Status Akun</span>
                <span class="font-semibold text-emerald-600">Aktif</span>
            </div>
        </div>
    </div>
</div>
@endsection