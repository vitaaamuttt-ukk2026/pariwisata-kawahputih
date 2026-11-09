@extends('layouts.panel')
@section('title', 'Dashboard Pengelola')
@section('page-title', 'Dashboard Pengelola')

@section('content')
<div class="mb-6 overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-700 via-blue-600 to-teal-500 px-6 py-6 text-white shadow-lg shadow-blue-900/10">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-1 text-xs font-bold uppercase tracking-[0.18em] text-blue-100">Operasional harian</p>
            <h1 class="text-2xl font-extrabold tracking-tight sm:text-3xl">Dashboard Pengelola</h1>
            <p class="mt-1 text-sm text-white/80">Ringkasan kunjungan dan verifikasi untuk membantu aktivitas di lapangan.</p>
        </div>
        <a href="{{ route('pengelola.reservasi') }}" class="inline-flex w-fit items-center gap-2 rounded-xl border border-white/25 bg-white/15 px-4 py-2 text-sm font-semibold text-white no-underline backdrop-blur transition hover:bg-white/25">
            <span class="material-symbols-outlined text-lg">book_online</span>
            Lihat reservasi
        </a>
    </div>
</div>

<!-- 1. KARTU RINGKASAN HARI INI -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">groups</span>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Booking Hari Ini</p>
            <p class="text-xl font-bold text-gray-800">{{ $stats['total_hari_ini'] }} Orang</p>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">verified</span>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Sudah Terverifikasi</p>
            <p class="text-xl font-bold text-gray-800">{{ $stats['sudah_verifikasi'] }} Orang</p>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">pending_actions</span>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Perlu Verifikasi</p>
            <p class="text-xl font-bold text-gray-800">{{ $stats['belum_verifikasi'] }} Orang</p>
        </div>
    </div>
</div>

<!-- 2. AREA GRAFIK PENGELOLA -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-indigo-600">show_chart</span> Tren Jumlah Pengunjung (7 Hari Terakhir)
    </h3>
    <div class="relative h-80">
        <canvas id="visitorChart"></canvas>
    </div>
</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($chartLabels);
    const visitorData = @json($chartVisitors);

    const ctxVisitor = document.getElementById('visitorChart').getContext('2d');
    
    // Buat gradien warna agar terlihat lebih premium
    const gradient = ctxVisitor.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.5)'); // Indigo
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

    new Chart(ctxVisitor, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pengunjung',
                data: visitorData,
                backgroundColor: gradient,
                borderColor: '#6366f1',
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#6366f1',
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                tension: 0.4 // Membuat garis melengkung halus
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { 
                y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { stepSize: 1 } }, 
                x: { grid: { display: false } } 
            }
        }
    });
</script>
@endsection