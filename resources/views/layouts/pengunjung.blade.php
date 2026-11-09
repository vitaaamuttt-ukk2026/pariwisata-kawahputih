<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Kawah Putih</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { 
            display: flex; 
            align-items: center; 
            gap: 0.75rem; 
            padding: 0.65rem 0.85rem; 
            border-radius: 0.5rem; 
            color: #4b5563; 
            transition: all 0.2s;
            text-decoration: none;
            white-space: nowrap;
        }
        .sidebar-link:hover { 
            background-color: #f3f4f6; 
            color: #1f2937;
        }
        .sidebar-link.active { 
            background-color: #ecfdf5; 
            color: #059669; 
            font-weight: 600;
        }
        .sidebar-link .link-text {
            transition: opacity 0.2s;
        }
        .sidebar-collapsed .link-text,
        .sidebar-collapsed .menu-label,
        .sidebar-collapsed .sidebar-footer-text,
        .sidebar-collapsed .user-info {
            display: none;
        }
        .sidebar-collapsed .sidebar-link {
            justify-content: center;
            padding: 0.65rem;
        }
        .sidebar-collapsed {
            width: 5rem !important;
        }
        .sidebar-collapsed .logo-text {
            display: none;
        }
        .material-symbols-outlined {
            font-size: 22px;
        }
        #main-content {
            transition: margin-left 0.3s ease;
        }
        body { background: linear-gradient(135deg, #f1fbf6 0%, #f5f8ff 58%, #fff8f1 100%); }
        #sidebar { background: linear-gradient(180deg, #ffffff 0%, #f7fcfa 100%); border-color: #dcebe4; box-shadow: 8px 0 28px rgba(16, 86, 66, 0.05); }
        #sidebar > div:first-child { border-color: #e4eee9; }
        .sidebar-link { border-radius: .85rem; padding: .75rem .9rem; }
        .sidebar-link:hover { background: linear-gradient(110deg, #effcf5, #eef8ff); color: #087c59; transform: translateX(3px); }
        .sidebar-link.active { background: linear-gradient(115deg, #d9fae9, #e5f5ff); color: #087c59; box-shadow: inset 3px 0 #10a66d; }
        #main-content > header { background: rgba(255,255,255,.86); border-color: #e2ece7; box-shadow: 0 8px 24px rgba(25, 58, 46, .06); backdrop-filter: blur(14px); }
        #main-content > main { background: radial-gradient(ellipse at 92% 0%, rgba(52, 211, 153, .08), transparent 34%), transparent; }
        #main-content > main .bg-white.rounded-2xl { box-shadow: 0 12px 30px rgba(29, 78, 60, .07); transition: transform .2s ease, box-shadow .2s ease; }
        #main-content > main .bg-white.rounded-2xl:hover { box-shadow: 0 18px 34px rgba(29, 78, 60, .11); }
        #main-content > main .grid > .bg-white.rounded-2xl { border-top: 3px solid #bcebd5; }
        #main-content > main .grid > .bg-white.rounded-2xl:nth-child(4n+2) { border-top-color: #bde6fb; }
        #main-content > main .grid > .bg-white.rounded-2xl:nth-child(4n+3) { border-top-color: #ffe0a6; }
        #main-content > main .grid > .bg-white.rounded-2xl:nth-child(4n) { border-top-color: #f9c8d4; }
        #main-content > main .grid > .bg-white.rounded-2xl .material-symbols-outlined { filter: drop-shadow(0 2px 3px rgba(15, 23, 42, .12)); }
        #main-content > main .grid > .bg-white.rounded-2xl:nth-child(4n+1) .material-symbols-outlined { color: #059669; }
        #main-content > main .grid > .bg-white.rounded-2xl:nth-child(4n+2) .material-symbols-outlined { color: #0284c7; }
        #main-content > main .grid > .bg-white.rounded-2xl:nth-child(4n+3) .material-symbols-outlined { color: #d97706; }
        #main-content > main .grid > .bg-white.rounded-2xl:nth-child(4n) .material-symbols-outlined { color: #db2777; }
        #main-content > main button[id^="btn-"]:disabled { opacity: 1; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        #main-content > main button[id^="btn-"]:disabled .material-symbols-outlined { color: #047857; opacity: 1; }
        @media (max-width: 640px) {
            #main-content > header { padding-left: 1rem; padding-right: 1rem; }
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-gray-200 flex flex-col transition-all duration-300 shrink-0">
            <!-- Logo -->
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-9 h-9 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-white text-xl">landscape</span>
                    </div>
                    <div class="logo-text">
                        <h1 class="font-bold text-gray-800 text-sm">Kawah Putih</h1>
                        <p class="text-[10px] text-gray-500">CIWIDEY ECO PORTAL</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-500">
                    <span class="material-symbols-outlined text-xl">menu_open</span>
                </button>
            </div>

            <!-- Menu Navigasi -->
            <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
                <p class="menu-label text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-2 px-3">Menu</p>
                
                <a href="{{ route('pengunjung.dashboard') }}" class="sidebar-link {{ request()->routeIs('pengunjung.dashboard') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">home</span>
                    <span class="link-text">Dashboard</span>
                </a>
                <a href="{{ route('pengunjung.info') }}" class="sidebar-link {{ request()->routeIs('pengunjung.info') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">info</span>
                    <span class="link-text">Info</span>
                </a>
                <a href="{{ route('pengunjung.wisata') }}" class="sidebar-link {{ request()->routeIs('pengunjung.wisata') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">travel_explore</span>
                    <span class="link-text">Wisata</span>
                </a>
                <a href="{{ route('pengunjung.booking') }}" class="sidebar-link {{ request()->routeIs('pengunjung.booking') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">shopping_cart</span>
                    <span class="link-text">Booking</span>
                </a>
                <a href="{{ route('pengunjung.tiket') }}" class="sidebar-link {{ request()->routeIs('pengunjung.tiket') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">confirmation_number</span>
                    <span class="link-text">Tiket</span>
                </a>
            </nav>

            <!-- Footer Sidebar -->
            <div class="p-3 border-t border-gray-200">
                @auth
                <div class="sidebar-footer-text bg-emerald-50 rounded-lg p-2.5 mb-2 border border-emerald-100">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-[10px] font-medium text-emerald-700">Jaringan Cagar Biosfer</span>
                    </div>
                    <p class="text-[10px] text-emerald-600 mt-0.5">Aktif</p>
                </div>
                @endauth
                
                @auth
                <form action="{{ route('pengunjung.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link text-red-600 hover:bg-red-50 w-full">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="link-text">Keluar</span>
                    </button>
                </form>
                @else
                <a href="{{ route('pengunjung.login') }}" class="sidebar-link text-emerald-600 hover:bg-emerald-50 w-full">
                    <span class="material-symbols-outlined">login</span>
                    <span class="link-text">Login</span>
                </a>
                @endauth
            </div>
        </aside>

        <!-- Main Content -->
        <div id="main-content" class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 px-6 py-3">
                <div class="flex items-center justify-between">
                    <!-- Breadcrumb -->
                    <div class="flex items-center gap-2 text-sm">
                        <button onclick="toggleSidebar()" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-500 mr-2">
                            <span class="material-symbols-outlined text-xl">menu</span>
                        </button>
                        <span class="text-gray-500">Portal Wisatawan</span>
                        <span class="text-gray-400">›</span>
                        <span class="font-semibold text-gray-800">@yield('page-title', 'Dashboard')</span>
                    </div>

                    <!-- Status & User Info -->
                    <div class="flex items-center gap-4">
                        <div class="hidden md:flex items-center gap-2 text-xs">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            <span class="text-gray-600">Sistem Live</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="relative p-2 text-gray-400 hover:text-gray-600">
                                <span class="material-symbols-outlined text-xl">notifications</span>
                                <span class="absolute top-1 right-1 w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                            </button>
                            
                            @auth
                            <div class="flex items-center gap-2 pl-3 border-l border-gray-200">
                                <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-full flex items-center justify-center text-white font-semibold text-xs">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="user-info">
                                    <p class="text-xs font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] text-gray-500">Tamu</p>
                                </div>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                @if(session('success'))
                    <div class="mx-6 mt-4 bg-emerald-50 border-l-4 border-emerald-500 p-3 rounded-lg">
                        <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mx-6 mt-4 bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                        <p class="text-red-700 text-sm">{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('sidebar-collapsed'));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('sidebar-collapsed');
            }
        });
    </script>
</body>
</html>