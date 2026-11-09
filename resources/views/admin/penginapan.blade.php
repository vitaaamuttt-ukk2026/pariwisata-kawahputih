@extends('layouts.panel')
@section('title', 'Kelola Penginapan')
@section('page-title', 'Kelola Penginapan')

@section('content')
<section class="flex flex-col gap-space-md mb-space-xl">
    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-space-md">
        <div class="flex items-center gap-space-sm">
            <div class="w-10 h-10 rounded-xl bg-secondary-fixed text-secondary flex items-center justify-center"><span class="material-symbols-outlined text-2xl">cottage</span></div>
            <div class="flex flex-col">
                <div class="flex items-center gap-space-xs"><h2 class="font-headline-md text-headline-md text-on-surface">Kelola Data Penginapan & Villa</h2><span class="px-2.5 py-0.5 rounded-full bg-surface-container-high text-secondary font-label-sm text-label-sm font-bold">28 Unit Aktif</span></div>
                <span class="font-body-sm text-body-sm text-on-surface-variant">Alokasi kamar, sinkronisasi ketersediaan real-time, dan manajemen tarif</span>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-space-sm">
            <button class="inline-flex items-center gap-space-xs px-4 py-2 bg-secondary hover:bg-on-secondary-container text-on-secondary font-label-md text-label-md font-semibold rounded-xl shadow-sm transition-all" type="button"><span class="material-symbols-outlined text-lg">add_home</span><span>+ Tambah Penginapan Baru</span></button>
        </div>
    </div>
    
    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead><tr class="bg-surface-container-low text-on-surface-variant font-label-md text-label-md uppercase tracking-wider"><th class="py-3.5 px-4 font-semibold">Nama Penginapan & Unit</th><th class="py-3.5 px-4 font-semibold">Fasilitas Utama</th><th class="py-3.5 px-4 font-semibold">Tarif per Malam</th><th class="py-3.5 px-4 font-semibold">Status Ketersediaan</th><th class="py-3.5 px-4 font-semibold text-right">Aksi</th></tr></thead>
                <tbody class="divide-y divide-surface-container-high font-body-sm text-body-sm text-on-surface">
                    <tr class="hover:bg-surface-container/40 transition-colors">
                        <td class="py-3.5 px-4"><div class="flex items-center gap-space-sm"><div class="w-12 h-12 rounded-xl bg-primary-fixed/50 flex items-center justify-center text-primary flex-shrink-0"><span class="material-symbols-outlined text-2xl">hotel</span></div><div class="flex flex-col"><span class="font-headline-sm text-headline-sm text-on-surface font-semibold">Eztu Glamping Lakefront</span><span class="font-label-sm text-label-sm text-on-surface-variant">Tipe: Safari Tent Mewah • Kapasitas 4 Dewasa</span></div></div></td>
                        <td class="py-3.5 px-4"><div class="flex flex-wrap gap-1 max-w-xs"><span class="px-2 py-0.5 rounded-full bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm">WiFi Cepat</span><span class="px-2 py-0.5 rounded-full bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm">Water Heater</span></div></td>
                        <td class="py-3.5 px-4"><span class="font-headline-sm text-headline-sm text-primary font-bold">Rp 1.450.000</span></td>
                        <td class="py-3.5 px-4"><span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed font-label-sm text-label-sm font-bold"><span class="material-symbols-outlined text-xs">check_circle</span> Tersedia</span></td>
                        <td class="py-3.5 px-4 text-right"><div class="inline-flex items-center gap-1 justify-end"><button class="w-8 h-8 rounded-lg bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center hover:opacity-80 transition-opacity" type="button"><span class="material-symbols-outlined text-base">visibility</span></button><button class="w-8 h-8 rounded-lg bg-primary-fixed text-on-primary-fixed flex items-center justify-center hover:opacity-80 transition-opacity" type="button"><span class="material-symbols-outlined text-base">edit</span></button></div></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection