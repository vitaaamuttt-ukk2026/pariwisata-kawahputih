@extends('layouts.panel')
@section('title', 'Analitik')
@section('page-title', 'Analitik & Laporan')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-blue-500">shopping_cart</span>
            <span class="text-xs font-semibold text-gray-500 uppercase">Total Booking</span>
        </div>
        <div class="text-3xl font-bold text-gray-800">{{ $stats['total_booking'] }}</div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-emerald-500">payments</span>
            <span class="text-xs font-semibold text-gray-500 uppercase">Total Pendapatan</span>
        </div>
        <div class="text-2xl font-bold text-emerald-600">Rp {{ number_format($stats['total_pendapatan'], 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-amber-500">groups</span>
            <span class="text-xs font-semibold text-gray-500 uppercase">Total Pengunjung</span>
        </div>
        <div class="text-3xl font-bold text-gray-800">{{ $stats['pengunjung_total'] }}</div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-purple-500">check_circle</span>
            <span class="text-xs font-semibold text-gray-500 uppercase">Booking Lunas</span>
        </div>
        <div class="text-3xl font-bold text-purple-600">{{ $stats['booking_lunas'] }}</div>
    </div>
</div>

<!-- Grafik -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-emerald-500">trending_up</span>
            Pendapatan 7 Hari Terakhir
        </h3>
        <canvas id="revenueChart"></canvas>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-500">bar_chart</span>
            Jumlah Booking 7 Hari Terakhir
        </h3>
        <canvas id="bookingChart"></canvas>
    </div>
</div>

<!-- Status Booking & Top Paket -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-500">pie_chart</span>
            Status Booking
        </h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-lg">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                    <span class="text-sm font-medium">Lunas</span>
                </div>
                <span class="font-bold text-emerald-700">{{ $stats['booking_lunas'] }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                    <span class="text-sm font-medium">Pending</span>
                </div>
                <span class="font-bold text-amber-700">{{ $stats['booking_pending'] }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-sm font-medium">Dibatalkan</span>
                </div>
                <span class="font-bold text-red-700">{{ $stats['booking_cancel'] }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-purple-500">emoji_events</span>
            Paket Terpopuler
        </h3>
        <div class="space-y-3">
            @forelse($topPakets as $index => $paket)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center font-bold text-sm">{{ $index + 1 }}</span>
                    <div>
                        <div class="text-sm font-semibold text-gray-800">{{ Str::limit($paket->paket, 40) }}</div>
                        <div class="text-xs text-gray-500">{{ $paket->total }} pengunjung</div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-400 text-sm">Belum ada data booking.</div>
            @endforelse
        </div>
    </div>
</div>

<script>
const labels = @json($labels);
const revenueData = @json($revenueData);
const bookingData = @json($bookingData);

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: revenueData,
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});

new Chart(document.getElementById('bookingChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Jumlah Booking',
            data: bookingData,
            backgroundColor: '#3b82f6',
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } }
    }
});
</script>
@endsection