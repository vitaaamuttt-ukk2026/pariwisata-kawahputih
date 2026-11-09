@extends('layouts.panel')
@section('title', 'Akun Pengelola')
@section('page-title', 'Akun Pengelola')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ===== FORM TAMBAH ===== --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-kawah-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Tambah Pengelola
                </h3>
                <form method="POST" action="{{ route('admin.pengelola.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-kawah-500 focus:border-kawah-500 outline-none"
                               placeholder="Nama petugas">
                        @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-kawah-500 focus:border-kawah-500 outline-none"
                               placeholder="petugas@kawahputih.test">
                        @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                        <input type="password" name="password" required minlength="8"
                               class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-kawah-500 focus:border-kawah-500 outline-none"
                               placeholder="Min. 8 karakter">
                        @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Sandi</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-kawah-500 focus:border-kawah-500 outline-none"
                               placeholder="Ulangi kata sandi">
                    </div>
                    <button type="submit"
                            class="w-full mt-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-sm transition duration-200">
                        Simpan Akun
                    </button>
                </form>
            </div>
        </div>

        {{-- ===== DAFTAR AKUN ===== --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-3">
                    <h3 class="font-semibold text-gray-800">Daftar Pengelola ({{ $pengelola->count() }})</h3>
                    <button type="button" onclick="document.querySelector('form[action=\'{{ route('admin.pengelola.store') }}\'] input[name=\'name\']').focus();" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                        <span class="material-symbols-outlined text-base">add</span>
                        Tambah
                    </button>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($pengelola as $p)
                        <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-kawah-100 text-kawah-700 flex items-center justify-center font-semibold text-sm">
                                    {{ strtoupper(substr($p->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 text-sm">{{ $p->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $p->email }}</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('admin.pengelola.destroy', $p) }}"
                                  onsubmit="return confirm('Hapus akun {{ $p->name }}? Tindakan ini tidak bisa dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1.5 text-xs rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="px-5 py-10 text-center text-gray-400 text-sm">Belum ada akun pengelola.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection