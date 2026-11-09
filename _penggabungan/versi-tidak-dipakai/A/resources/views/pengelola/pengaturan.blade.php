@extends('layouts.panel')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Akun')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Profil Pengelola</h2>
        <p class="text-sm text-slate-500 mb-6">Kelola data diri dan preferensi akun untuk operasional harian.</p>

        <form class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" value="{{ Auth::user()->name ?? 'Pengelola Kawah Putih' }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" value="{{ Auth::user()->email ?? 'pengelola@kawahputih.test' }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
                    <input type="text" value="0812-3456-7890" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jabatan</label>
                    <input type="text" value="Supervisor Operasional" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Preferensi</h3>
            <div class="space-y-4">
                <label class="flex items-center justify-between gap-3">
                    <span class="text-sm text-slate-600">Notifikasi email</span>
                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 rounded">
                </label>
                <label class="flex items-center justify-between gap-3">
                    <span class="text-sm text-slate-600">Notifikasi WhatsApp</span>
                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 rounded">
                </label>
                <label class="flex items-center justify-between gap-3">
                    <span class="text-sm text-slate-600">Mode siaran operasional</span>
                    <input type="checkbox" checked class="h-4 w-4 text-blue-600 rounded">
                </label>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-3">Keamanan</h3>
            <button type="button" class="w-full text-left border border-slate-200 rounded-lg px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 transition">
                Ubah Kata Sandi
            </button>
        </div>
    </div>
</div>
@endsection