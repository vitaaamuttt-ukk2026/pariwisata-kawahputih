@extends('layouts.panel')
@section('title', 'Analitik')
@section('page-title', 'Analitik & Laporan')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total Reservasi</p>
            <p class="mt-2 text-3xl font-bold text-slate-800">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-5 shadow-sm">
            <p class="text-sm text-emerald-700">Terverifikasi</p>
            <p class="mt-2 text-3xl font-bold text-emerald-800">{{ $stats['verified'] }}</p>
        </div>
        <div class="bg-amber-50 border border-amber-100 rounded-xl p-5 shadow-sm">
            <p class="text-sm text-amber-700">Menunggu</p>
            <p class="mt-2 text-3xl font-bold text-amber-800">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-sky-50 border border-sky-100 rounded-xl p-5 shadow-sm">
            <p class="text-sm text-sky-700">Hari Ini</p>
            <p class="mt-2 text-3xl font-bold text-sky-800">{{ $stats['today'] }}</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Tren Kunjungan 7 Hari</h3>
                <p class="text-sm text-slate-500">Perkembangan pengunjung selama seminggu terakhir.</p>
            </div>
        </div>
        <div class="h-80">
            <canvas id="pengunjungChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <h4 class="text-lg font-bold text-slate-800 mb-3">Status Reservasi</h4>
            <ul class="space-y-3">
                <li class="flex justify-between">
                    <span class="text-slate-600">Approved</span>
                    <span class="font-semibold text-slate-800">{{ $chartStatus['approved'] }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-slate-600">Pending</span>
                    <span class="font-semibold text-slate-800">{{ $chartStatus['pending'] }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-slate-600">Cancelled</span>
                    <span class="font-semibold text-slate-800">{{ $chartStatus['cancelled'] }}</span>
                </li>
            </ul>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm lg:col-span-2">
            <h4 class="text-lg font-bold text-slate-800 mb-4">Catatan Singkat</h4>
            <div class="space-y-3">
                <div class="rounded-lg bg-slate-50 p-3">
                    <p class="text-sm font-medium text-slate-700">Puncak kunjungan terjadi pada hari Jumat dengan jumlah 27 reservasi.</p>
                </div>
                <div class="rounded-lg bg-slate-50 p-3">
                    <p class="text-sm font-medium text-slate-700">Persentase reservasi yang disetujui masih berada dalam target operasional harian.</p>
                </div>
                <div class="rounded-lg bg-slate-50 p-3">
                    <p class="text-sm font-medium text-slate-700">Perlu pengawasan tambahan pada jadwal hari Minggu karena tren naik.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($chartLabels);
    const visitors = @json($chartVisitors);

    const ctx = document.getElementById('pengunjungChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.45)');
    gradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pengunjung',
                data: visitors,
                borderColor: '#2563eb',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.35,
                pointRadius: 4,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#2563eb'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection