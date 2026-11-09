@php
    $currentRole = Auth::check() ? Auth::user()->role : 'admin';
    $isPengelola = $currentRole === 'pengelola';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', $isPengelola ? 'Dashboard Pengelola' : 'Dashboard Admin') - Kawah Putih</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .nav-link { transition: all 0.2s ease; }
        .nav-link:hover { transform: translateX(2px); }
    </style>
</head>
<body class="bg-slate-100 text-slate-800">
    <aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-slate-200 shadow-sm z-50">
        <div class="flex items-center gap-3 px-6 py-5 border-b border-slate-200">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-md">
                <span class="material-symbols-outlined">{{ $isPengelola ? 'manage_accounts' : 'admin_panel_settings' }}</span>
            </div>
            <div>
                <div class="text-lg font-extrabold text-slate-900">{{ $isPengelola ? 'Pengelola' : 'Admin' }}</div>
                <div class="text-[11px] uppercase tracking-wider text-slate-500">Kawah Putih</div>
            </div>
        </div>

        <nav class="p-4 space-y-1">
            @if($isPengelola)
                <a href="{{ route('pengelola.dashboard') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('pengelola.dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('pengelola.reservasi') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('pengelola.reservasi') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined">event_available</span>
                    <span>Reservasi</span>
                </a>
                <a href="{{ route('pengelola.operasional') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('pengelola.operasional') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined">build</span>
                    <span>Operasional</span>
                </a>
                <a href="{{ route('pengelola.analitik') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('pengelola.analitik') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined">analytics</span>
                    <span>Analitik</span>
                </a>
                <a href="{{ route('pengelola.pengaturan') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('pengelola.pengaturan') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span>Pengaturan</span>
                </a>
            @else
                <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.booking') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.booking') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <span>Kelola Booking</span>
                </a>
                <a href="{{ route('admin.wisata') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.wisata') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined">travel_explore</span>
                    <span>Kelola Wisata</span>
                </a>
                <a href="{{ route('admin.penginapan') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.penginapan') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined">hotel</span>
                    <span>Kelola Penginapan</span>
                </a>
                <a href="{{ route('admin.pengelola') }}" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.pengelola') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined">groups</span>
                    <span>Kelola Pengelola</span>
                </a>
            @endif
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-200">
            <form action="{{ route('panel.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 font-semibold">
                    <span class="material-symbols-outlined">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="ml-64 min-h-screen">
        <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-slate-200">
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-800">@yield('page-title', $isPengelola ? 'Dashboard Pengelola' : 'Dashboard Admin')</h1>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 bg-slate-100 rounded-full px-3 py-2 text-sm text-slate-600">
                        <span class="material-symbols-outlined text-base">person</span>
                        <span>{{ Auth::user()->name ?? ($isPengelola ? 'Pengelola' : 'Admin') }}</span>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
