@extends('layouts.panel')
@section('title', 'Kelola Wisata')
@section('page-title', 'Kelola Wisata')

@section('content')
<section class="flex flex-col gap-space-md mb-space-xl">
    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-space-md">
        <div class="flex items-center gap-space-sm">
            <div class="w-10 h-10 rounded-xl bg-primary-fixed text-primary flex items-center justify-center"><span class="material-symbols-outlined text-2xl">nature_people</span></div>
            <div class="flex flex-col">
                <div class="flex items-center gap-space-xs"><h2 class="font-headline-md text-headline-md text-on-surface">Kelola Data Wisata & Destinasi</h2><span class="px-2.5 py-0.5 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm font-bold">12 Terdaftar</span></div>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Pengaturan inventaris wahana konservasi, zonasi kawah, dan kuota harian tiket</span>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-space-sm">
            <button class="inline-flex items-center gap-space-xs px-4 py-2 bg-primary hover:bg-primary-container text-on-primary font-label-md text-label-md font-semibold rounded-xl shadow-sm transition-all" type="button"><span class="material-symbols-outlined text-lg">add_circle</span><span>+ Tambah Data Wisata Baru</span></button>
        </div>
    </div>
    
    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead><tr class="bg-surface-container-low text-on-surface-variant font-label-md text-label-md uppercase tracking-wider"><th class="py-3.5 px-4 font-semibold">Wisata & Foto</th><th class="py-3.5 px-4 font-semibold">Deskripsi & Wilayah</th><th class="py-3.5 px-4 font-semibold">Tarif Tiket Masuk</th><th class="py-3.5 px-4 font-semibold">Status Operasional</th><th class="py-3.5 px-4 font-semibold text-right">Aksi Manajemen</th></tr></thead>
                <tbody class="divide-y divide-surface-container-high font-body-sm text-body-sm text-on-surface">
                    <tr class="hover:bg-surface-container/40 transition-colors">
                        <td class="py-3.5 px-4"><div class="flex items-center gap-space-sm"><img class="w-14 h-14 rounded-xl object-cover shadow-sm flex-shrink-0" src="https://images.unsplash.com/photo-1604608672516-f1b9b1d1f1f3?w=200&q=80"/><div class="flex flex-col"><span class="font-headline-sm text-headline-sm text-on-surface font-semibold">Kawah Putih Ciwidey</span><span class="font-label-sm text-label-sm text-primary font-medium">ID: #DST-KP-001 • Vulkanik Alami</span></div></div></td>
                        <td class="py-3.5 px-4 max-w-xs"><p class="text-on-surface-variant line-clamp-2">Danau kawah belerang toska alami di ketinggian 2.434 mdpl.</p></td>
                        <td class="py-3.5 px-4"><div class="flex flex-col"><span class="font-medium text-on-surface">Dom: Rp 28.000</span><span class="text-on-surface-variant font-label-sm text-label-sm">Mancanegara: Rp 81.000</span></div></td>
                        <td class="py-3.5 px-4"><span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed font-label-sm text-label-sm font-bold w-max"><span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Buka Normal</span></td>
                        <td class="py-3.5 px-4 text-right"><div class="inline-flex items-center gap-1 justify-end"><button class="w-8 h-8 rounded-lg bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center hover:opacity-80 transition-opacity" title="Lihat" type="button"><span class="material-symbols-outlined text-base">visibility</span></button><button class="w-8 h-8 rounded-lg bg-primary-fixed text-on-primary-fixed flex items-center justify-center hover:opacity-80 transition-opacity" title="Edit" type="button"><span class="material-symbols-outlined text-base">edit</span></button></div></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection