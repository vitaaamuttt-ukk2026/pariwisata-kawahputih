<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Dasbor') - IslaGest Pengelola</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
            colors: {
              brand: { 50: '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0', 500: '#10b981', 600: '#059669', 700: '#047857', 800: '#065f46', 900: '#064e3b' }
            }
          }
        }
      }
    </script>
    <style>
      @layer base { html, body { margin: 0; padding: 0; } body { overscroll-behavior: none; } }
      ::-webkit-scrollbar { display: none; }
      .nav-link { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
      .nav-link:hover:not(.bg-emerald-50) { transform: translateX(4px); }
    </style>
</head>
<body class="bg-[#f6f9fc] text-slate-800 font-sans antialiased text-sm selection:bg-emerald-100 selection:text-emerald-900">

<!-- Left Sidebar -->
<aside class="fixed left-0 top-0 h-screen w-72 bg-white border-r border-slate-200/80 z-50 flex flex-col justify-between py-6 shadow-sm">
  <div class="flex flex-col gap-7 px-6">
    <div class="flex items-center gap-3 px-2">
      <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-700 via-emerald-600 to-teal-400 flex items-center justify-center shadow-md shadow-emerald-600/20 text-white">
        <span class="material-symbols-outlined text-[24px]">forest</span>
      </div>
      <div class="flex flex-col">
        <div class="flex items-center gap-1.5">
          <span class="text-lg text-slate-900 font-extrabold tracking-tight">IslaGest</span>
          <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">PRO</span>
        </div>
        <span class="text-[11px] text-slate-400 tracking-wider uppercase font-semibold">Kawasan Suaka Ekowisata</span>
      </div>
    </div>
    
    <nav class="flex flex-col gap-1.5">
      <a href="{{ route('pengelola.dashboard') }}" class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('pengelola.dashboard') ? 'bg-emerald-50 text-emerald-700 font-bold shadow-sm border border-emerald-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('pengelola.dashboard') ? 'text-emerald-600' : 'text-slate-400' }}">grid_view</span>
        <span class="text-sm font-semibold">Dasbor</span>
      </a>
      <a href="{{ route('pengelola.reservasi') }}" class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('pengelola.reservasi') ? 'bg-emerald-50 text-emerald-700 font-bold shadow-sm border border-emerald-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('pengelola.reservasi') ? 'text-emerald-600' : 'text-slate-400' }}">calendar_month</span>
        <span class="text-sm font-semibold">Reservasi</span>
      </a>
      <a href="{{ route('pengelola.operasional') }}" class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('pengelola.operasional') ? 'bg-emerald-50 text-emerald-700 font-bold shadow-sm border border-emerald-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('pengelola.operasional') ? 'text-emerald-600' : 'text-slate-400' }}">kayaking</span>
        <span class="text-sm font-semibold">Operasional</span>
      </a>
      <a href="{{ route('pengelola.analitik') }}" class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('pengelola.analitik') ? 'bg-emerald-50 text-emerald-700 font-bold shadow-sm border border-emerald-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('pengelola.analitik') ? 'text-emerald-600' : 'text-slate-400' }}">monitoring</span>
        <span class="text-sm font-semibold">Analitik</span>
      </a>
      <a href="{{ route('pengelola.pengaturan') }}" class="nav-link flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all {{ request()->routeIs('pengelola.pengaturan') ? 'bg-emerald-50 text-emerald-700 font-bold shadow-sm border border-emerald-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('pengelola.pengaturan') ? 'text-emerald-600' : 'text-slate-400' }}">tune</span>
        <span class="text-sm font-semibold">Pengaturan</span>
      </a>
    </nav>
  </div>
  
  <div class="px-6">
    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-200/70 rounded-2xl p-4 flex items-center justify-between shadow-sm mb-4">
      <div class="flex items-center gap-3">
        <span class="relative flex h-3 w-3">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
        </span>
        <div class="flex flex-col">
          <span class="text-xs text-slate-900 font-bold">Pusat Hub Terhubung</span>
          <span class="text-[11px] text-emerald-700 font-medium">Sinkronisasi Realtime</span>
        </div>
      </div>
      <span class="material-symbols-outlined text-emerald-600 text-[20px]">verified</span>
    </div>
    <form method="POST" action="{{ route('panel.logout') }}" class="w-full">
        @csrf
        <button type="submit" class="w-full flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors font-semibold text-sm">
            <span class="material-symbols-outlined text-[20px]">logout</span> Keluar Sistem
        </button>
    </form>
  </div>
</aside>

<!-- Main Container Area -->
<div class="pl-72">
  <!-- Top Header Bar -->
  <header class="fixed top-0 left-72 right-0 h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 z-40 px-8 flex items-center justify-between shadow-sm">
    <div class="flex items-center gap-4">
      <div class="flex items-center gap-2 text-slate-700">
        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center">
          <span class="material-symbols-outlined text-[18px]">nature_people</span>
        </div>
        <span class="text-xs uppercase tracking-wider font-bold text-slate-600">Operasional Wisata &amp; Cagar Alam</span>
      </div>
      <span class="text-slate-300">/</span>
      <div class="flex items-center gap-2 bg-sky-50 border border-sky-100 text-sky-800 px-3 py-1 rounded-full text-xs font-semibold">
        <span class="material-symbols-outlined text-[16px] text-sky-600">wb_sunny</span>
        <span>28°C Cerah • Pasang Surut Rendah</span>
      </div>
    </div>
    <div class="flex items-center gap-4">
      <div class="flex items-center gap-2 bg-slate-100 border border-slate-200/70 px-3 py-1 rounded-full text-slate-700">
        <span class="material-symbols-outlined text-[16px] text-slate-500">schedule</span>
        <span class="text-xs font-semibold">{{ now()->format('H:i') }} WIB • {{ now()->translatedFormat('D, d M') }}</span>
      </div>
      <button class="relative p-2 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition-colors">
        <span class="material-symbols-outlined text-[20px] block">notifications</span>
        <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-emerald-500 ring-2 ring-white"></span>
      </button>
      <div class="h-6 w-px bg-slate-200"></div>
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full ring-2 ring-emerald-500/30 overflow-hidden bg-emerald-100 flex items-center justify-center font-bold text-xs text-emerald-800 shadow-sm">
          <span class="material-symbols-outlined text-[20px]">person</span>
        </div>
        <div class="flex flex-col text-left">
          <span class="text-xs text-slate-900 font-bold">{{ Auth::user()->name ?? 'Pengelola' }}</span>
          <span class="text-[11px] text-emerald-700 font-medium capitalize">{{ Auth::user()->role ?? 'Direktur Operasional' }}</span>
        </div>
      </div>
    </div>
  </header>

  <!-- Page Main Content -->
  <main class="w-full pt-20 pb-16 px-8 min-h-screen bg-[#f6f9fc]">
    <div class="flex flex-col w-full gap-8 max-w-7xl mx-auto">
        @yield('content')
    </div>
  </main>
</div>

</body>
</html>