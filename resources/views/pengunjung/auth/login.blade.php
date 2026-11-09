@extends('layouts.pengunjung')
@section('title', 'Login Pengunjung')

@section('content')
<div class="flex items-center justify-center min-h-[calc(100vh-8rem)] py-8">
    <div class="w-full max-w-md bg-surface-container-lowest p-6 md:p-8 rounded-2xl shadow-lg border border-surface-container-high">
        
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-14 h-14 rounded-full bg-primary/10 text-primary flex items-center justify-center mx-auto mb-3">
                <span class="material-symbols-outlined text-[32px]">login</span>
            </div>
            <h2 class="font-headline-md text-headline-md text-on-surface font-bold">Masuk ke Akun Anda</h2>
            <p class="text-body-sm text-on-surface-variant mt-1">Lanjutkan pemesanan tiket Kawah Putih dengan mudah.</p>
        </div>

        <!-- Form Login -->
        <form action="{{ route('pengunjung.login') }}" method="POST" class="flex flex-col gap-4">
            @csrf

            <!-- Email -->
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm text-on-surface font-semibold">Email</label>
                <div class="flex items-center bg-surface-container-low px-3 py-2.5 rounded-xl gap-2 focus-within:ring-2 focus-within:ring-primary border border-transparent focus-within:border-primary transition-all">
                    <span class="material-symbols-outlined text-outline text-[20px]">mail</span>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="bg-transparent text-body-md text-on-surface outline-none w-full placeholder:text-on-surface-variant/50" 
                        placeholder="contoh@email.com">
                </div>
                @error('email')
                    <span class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1">
                <label class="font-label-sm text-label-sm text-on-surface font-semibold">Kata Sandi</label>
                <div class="flex items-center bg-surface-container-low px-3 py-2.5 rounded-xl gap-2 focus-within:ring-2 focus-within:ring-primary border border-transparent focus-within:border-primary transition-all">
                    <span class="material-symbols-outlined text-outline text-[20px]">lock</span>
                    <input type="password" name="password" required 
                        class="bg-transparent text-body-md text-on-surface outline-none w-full placeholder:text-on-surface-variant/50" 
                        placeholder="••••••••">
                </div>
                @error('password')
                    <span class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                @enderror
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="w-full bg-primary text-on-primary py-3 px-4 rounded-xl font-label-md text-label-md font-semibold hover:bg-primary-container transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 mt-2">
                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                <span>Masuk Sekarang</span>
            </button>
        </form>

        <!-- Footer Links -->
        <div class="mt-6 text-center space-y-3">
            <p class="text-body-sm text-on-surface-variant">
                Belum punya akun? 
                <a href="{{ route('pengunjung.register') }}" class="text-primary font-semibold hover:underline">Daftar di sini</a>
            </p>
            <a href="{{ route('pengunjung.dashboard') }}" class="inline-flex items-center gap-1 text-xs text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection