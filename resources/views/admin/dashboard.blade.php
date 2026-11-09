@extends('layouts.panel')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="mb-6 overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-700 via-teal-600 to-sky-600 px-6 py-6 text-white shadow-lg shadow-emerald-900/10">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-1 text-xs font-bold uppercase tracking-[0.18em] text-emerald-100">Pusat kendali</p>
            <h1 class="text-2xl font-extrabold tracking-tight sm:text-3xl">Ringkasan Kawah Putih</h1>
            <p class="mt-1 text-sm text-white/80">Pantau booking, verifikasi pembayaran, dan aktivitas wisata hari ini.</p>
        </div>
        <div class="inline-flex w-fit items-center gap-2 rounded-full border border-white/20 bg-white/15 px-3 py-1.5 text-xs font-semibold backdrop-blur">
            <span class="h-2 w-2 rounded-full bg-lime-300 shadow-[0_0_0_4px_rgba(190,242,100,.18)]"></span>
            Sistem beroperasi
        </div>
    </div>
</div>

<!-- 1. KARTU RINGKASAN (SUMMARY CARDS) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Pendapatan -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">payments</span>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Pendapatan</p>
            <p class="text-xl font-bold text-gray-800">Rp {{ number_format($stats['pendapatan'] ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>
    <!-- Lunas -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">check_circle</span>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Booking Lunas</p>
            <p class="text-xl font-bold text-gray-800">{{ $stats['lunas'] ?? $stats['verified'] ?? 0 }} Tiket</p>
        </div>
    </div>
    <!-- Pending -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">hourglass_top</span>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Menunggu Verifikasi</p>
            <p class="text-xl font-bold text-gray-800">{{ $stats['pending'] ?? $stats['belum_verifikasi'] ?? 0 }} Tiket</p>
        </div>
    </div>
    <!-- Dibatalkan -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">cancel</span>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Dibatalkan</p>
            <p class="text-xl font-bold text-gray-800">{{ $stats['dibatalkan'] ?? $stats['rejected'] ?? 0 }} Tiket</p>
        </div>
    </div>
</div>

<!-- 2. AREA GRAFIK (CHARTS) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Grafik Batang: Pendapatan 7 Hari Terakhir -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-2">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-600">bar_chart</span> Pendapatan 7 Hari Terakhir
        </h3>
        <div class="relative h-72">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Grafik Donat: Status Booking -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-purple-600">donut_large</span> Status Booking
        </h3>
        <div class="relative h-64 flex justify-center">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<!-- Script Chart.js (CDN, Tidak perlu npm install) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari Laravel Controller
    const labels = @json($chartLabels ?? []);
    const revenueData = @json($chartRevenue ?? []);
    const statusData = @json($statusCounts ?? ['paid' => 0, 'pending' => 0, 'cancelled' => 0]);

    // 1. Konfigurasi Grafik Pendapatan (Bar Chart)
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: revenueData,
                backgroundColor: 'rgba(59, 130, 246, 0.7)', // Warna Biru
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, grid: { color: '#f3f4f6' } }, x: { grid: { display: false } } }
        }
    });

    // 2. Konfigurasi Grafik Status (Doughnut Chart)
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Lunas', 'Pending', 'Dibatalkan'],
            datasets: [{
                data: [Number(statusData.paid ?? 0), Number(statusData.pending ?? 0), Number(statusData.cancelled ?? 0)],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'], // Hijau, Kuning, Merah
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } 
            }
        }
    });
</script>
@endsection