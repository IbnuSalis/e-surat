<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Dashboard') — E-Surat | Sistem Informasi Manajemen Surat Desa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        navy: {
                            50:  '#eef2ff',
                            100: '#e0e8ff',
                            200: '#c7d4fa',
                            300: '#a5b8f7',
                            400: '#8094f2',
                            500: '#5e6fea',
                            600: '#4452df',
                            700: '#3840c5',
                            800: '#3137a0',
                            900: '#002147',
                            950: '#000a1e',
                        },
                        gold: {
                            50:  '#fffde7',
                            100: '#fff9c4',
                            200: '#fff176',
                            300: '#ffee58',
                            400: '#ffca28',
                            500: '#e9c349',
                            600: '#fed65b',
                            700: '#f9a825',
                            800: '#f57f17',
                            900: '#e65100',
                        },
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'inter':   ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft':   '0 4px 12px rgba(0, 33, 71, 0.06)',
                        'medium': '0 8px 24px rgba(0, 33, 71, 0.10)',
                        'strong': '0 16px 40px rgba(0, 33, 71, 0.15)',
                        'card':   '0 2px 8px rgba(0,0,0,0.04), 0 8px 24px rgba(0,33,71,0.06)',
                    },
                }
            }
        }
    </script>
    <style>
        :root {
            --sidebar-width: 260px;
            --topnav-height: 64px;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f4ff; }
        h1, h2, h3, h4, h5, .font-heading { font-family: 'Poppins', sans-serif; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(175deg, #001632 0%, #002147 40%, #002d60 100%);
            transition: transform 0.3s ease;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 10px;
            color: rgba(174, 199, 246, 0.80);
            font-size: 14px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .sidebar-link:hover {
            background: rgba(255,255,255,0.10);
            color: #ffffff;
        }
        .sidebar-link.active {
            background: #fed65b;
            color: #001632;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(254,214,91,0.30);
        }
        .sidebar-link.active .material-symbols-outlined {
            font-variation-settings: 'FILL' 1;
        }
        .sidebar-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(174,199,246,0.45);
            padding: 16px 16px 6px;
            font-family: 'Inter', sans-serif;
        }

        /* Cards */
        .card { background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04), 0 8px 24px rgba(0,33,71,0.06); }
        .stat-card { border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04), 0 8px 24px rgba(0,33,71,0.06); overflow: hidden; position: relative; }

        /* Badges */
        .badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 20px; font-family: 'Inter', sans-serif; letter-spacing: 0.02em; }
        .badge-umum    { background: #dbeafe; color: #1e40af; }
        .badge-penting { background: #fef3c7; color: #92400e; }
        .badge-rahasia { background: #fee2e2; color: #991b1b; }
        .badge-masuk   { background: #d1fae5; color: #065f46; }
        .badge-keluar  { background: #ede9fe; color: #5b21b6; }
        .badge-upcoming  { background: #dbeafe; color: #1e40af; }
        .badge-ongoing   { background: #d1fae5; color: #065f46; }
        .badge-completed { background: #f3f4f6; color: #374151; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-draft    { background: #f3f4f6; color: #374151; }
        .badge-final    { background: #dbeafe; color: #1e40af; }
        .badge-approved { background: #d1fae5; color: #065f46; }
        .badge-admin { background: #fef3c7; color: #92400e; }
        .badge-staff { background: #ede9fe; color: #5b21b6; }
        .badge-active   { background: #d1fae5; color: #065f46; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }

        /* Toast */
        .toast-container { position: fixed; top: 80px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 8px; }
        .toast { display: flex; align-items: center; gap: 12px; padding: 14px 18px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); min-width: 280px; max-width: 400px; font-size: 14px; font-family: 'Inter', sans-serif; animation: slideInRight 0.3s ease; }
        .toast-success { background: #fff; border-left: 4px solid #10b981; color: #065f46; }
        .toast-error   { background: #fff; border-left: 4px solid #ef4444; color: #991b1b; }
        .toast-info    { background: #fff; border-left: 4px solid #3b82f6; color: #1e40af; }
        @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOutRight { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }

        /* Table */
        .data-table th { background: #f8faff; color: #44474e; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; padding: 12px 16px; border-bottom: 1px solid #e5eeff; font-family: 'Inter', sans-serif; }
        .data-table td { padding: 14px 16px; border-bottom: 1px solid #f0f4ff; font-size: 14px; color: #0b1c30; vertical-align: middle; }
        .data-table tr:hover td { background: #f8faff; }
        .data-table tr:last-child td { border-bottom: none; }

        /* Input */
        .form-input { border: 1.5px solid #d3e4fe; border-radius: 10px; padding: 10px 14px; font-family: 'Inter', sans-serif; font-size: 14px; color: #0b1c30; background: #fff; transition: all 0.2s; width: 100%; }
        .form-input:focus { outline: none; border-color: #002147; box-shadow: 0 0 0 3px rgba(0,33,71,0.08); }
        .form-label { font-size: 13px; font-weight: 600; color: #0b1c30; margin-bottom: 6px; display: block; font-family: 'Inter', sans-serif; }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; font-family: 'Inter', sans-serif; }

        /* Buttons */
        .btn-primary { background: #002147; color: #fff; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-primary:hover { background: #001632; box-shadow: 0 4px 12px rgba(0,33,71,0.25); }
        .btn-secondary { background: #fff; color: #002147; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; border: 1.5px solid #d3e4fe; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-secondary:hover { background: #f0f4ff; }
        .btn-danger { background: #fee2e2; color: #991b1b; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; }
        .btn-danger:hover { background: #fecaca; }
        .btn-icon { width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s; font-size: 18px; }
        .btn-icon-edit { background: #eff4ff; color: #002147; }
        .btn-icon-edit:hover { background: #dce9ff; }
        .btn-icon-delete { background: #fee2e2; color: #dc2626; }
        .btn-icon-delete:hover { background: #fecaca; }
        .btn-icon-view { background: #f0fdf4; color: #166534; }
        .btn-icon-view:hover { background: #dcfce7; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f0f4ff; }
        ::-webkit-scrollbar-thumb { background: #c7d4fa; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #8094f2; }

        /* Overlay */
        #sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 39; }

        /* Notification dropdown */
        .notif-dropdown { position: absolute; right: 0; top: calc(100% + 8px); width: 360px; background: #fff; border-radius: 16px; box-shadow: 0 16px 40px rgba(0,33,71,0.15); border: 1px solid #e5eeff; z-index: 100; overflow: hidden; }
        .notif-item { display: flex; gap: 12px; padding: 14px 16px; border-bottom: 1px solid #f0f4ff; transition: background 0.15s; cursor: pointer; }
        .notif-item:hover { background: #f8faff; }
        .notif-item:last-child { border-bottom: none; }

        /* Profile dropdown */
        .profile-dropdown { position: absolute; right: 0; top: calc(100% + 8px); width: 220px; background: #fff; border-radius: 14px; box-shadow: 0 16px 40px rgba(0,33,71,0.15); border: 1px solid #e5eeff; z-index: 100; overflow: hidden; }

        /* Modal */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 200; align-items: center; justify-content: center; }
        .modal-overlay.active { display: flex; }
        .modal-box { background: #fff; border-radius: 20px; padding: 32px; width: 100%; max-width: 440px; box-shadow: 0 24px 64px rgba(0,33,71,0.20); }

        /* Drag & Drop */
        .dropzone { border: 2px dashed #d3e4fe; border-radius: 14px; padding: 40px; text-align: center; transition: all 0.2s; cursor: pointer; }
        .dropzone:hover, .dropzone.dragover { border-color: #002147; background: #f0f4ff; }

        /* Animation */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in-up { animation: fadeInUp 0.4s ease; }

        /* Mobile sidebar */
        @media (max-width: 767px) {
            .sidebar { position: fixed; top: 0; left: 0; height: 100vh; z-index: 40; transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            #sidebar-overlay.show { display: block; }
        }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen">

<!-- Sidebar Overlay (mobile) -->
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<nav class="sidebar fixed top-0 left-0 h-full flex flex-col py-6 px-3 z-40 overflow-y-auto" id="sidebar">
    <!-- Logo -->
    <div class="flex items-center gap-3 px-4 mb-8">
        <div class="w-10 h-10 bg-gold-500 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
            <span class="material-symbols-outlined text-navy-950 text-xl" style="font-variation-settings:'FILL' 1">account_balance</span>
        </div>
        <div>
            <h1 class="font-heading font-bold text-white text-base leading-tight">E-Surat</h1>
            <p class="text-xs" style="color: rgba(174,199,246,0.55); font-family: 'Inter'">Manajemen Surat Desa</p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="flex-1 flex flex-col gap-1">
        <p class="sidebar-section-label">Utama</p>
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="material-symbols-outlined text-xl">dashboard</span>
            <span>Dashboard</span>
        </a>

        <p class="sidebar-section-label">Surat</p>
        <a href="{{ route('surat.masuk') }}" class="sidebar-link {{ request()->routeIs('surat.masuk') ? 'active' : '' }}">
            <span class="material-symbols-outlined text-xl">mail</span>
            <span>Surat Masuk</span>
        </a>
        <a href="{{ route('surat.keluar') }}" class="sidebar-link {{ request()->routeIs('surat.keluar') ? 'active' : '' }}">
            <span class="material-symbols-outlined text-xl">send</span>
            <span>Surat Keluar</span>
        </a>
        <a href="{{ route('surat.rahasia') }}" class="sidebar-link {{ request()->routeIs('surat.rahasia') ? 'active' : '' }}">
            <span class="material-symbols-outlined text-xl">lock</span>
            <span>Surat Rahasia</span>
        </a>
        <a href="{{ route('surat.input') }}" class="sidebar-link {{ request()->routeIs('surat.input') ? 'active' : '' }}">
            <span class="material-symbols-outlined text-xl">edit_document</span>
            <span>Input Surat</span>
        </a>

        <p class="sidebar-section-label">Kegiatan</p>
        <a href="{{ route('agenda.index') }}" class="sidebar-link {{ request()->routeIs('agenda.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined text-xl">calendar_today</span>
            <span>Agenda Acara</span>
        </a>
        <a href="{{ route('berita-acara.index') }}" class="sidebar-link {{ request()->routeIs('berita-acara.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined text-xl">history_edu</span>
            <span>Berita Acara</span>
        </a>

        @if(auth()->user()->isAdmin())
        <p class="sidebar-section-label">Pengaturan</p>
        <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined text-xl">group</span>
            <span>Manajemen User</span>
        </a>
        <a href="{{ route('log-aktivitas.index') }}" class="sidebar-link {{ request()->routeIs('log-aktivitas.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined text-xl">manage_search</span>
            <span>Log Aktivitas</span>
        </a>
        @endif

        <p class="sidebar-section-label">Akun</p>
        <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
            <span class="material-symbols-outlined text-xl">person</span>
            <span>Profile</span>
        </a>
    </div>

    <!-- Logout -->
    <div class="border-t mt-4 pt-4" style="border-color: rgba(174,199,246,0.15)">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-link w-full text-left" style="color: #fca5a5;">
                <span class="material-symbols-outlined text-xl">logout</span>
                <span>Logout</span>
            </button>
        </form>
        <!-- User info -->
        <div class="flex items-center gap-3 mt-4 px-4">
            <div class="w-9 h-9 rounded-full bg-gold-500 flex items-center justify-center text-navy-950 font-bold text-sm flex-shrink-0 font-heading">
                {{ auth()->user()->initials }}
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-white truncate font-heading">{{ auth()->user()->name }}</p>
                <p class="text-xs truncate" style="color: rgba(174,199,246,0.55)">{{ auth()->user()->role_label }}</p>
            </div>
        </div>
    </div>
</nav>

<!-- Top Navbar -->
<header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-100 z-30 flex items-center justify-between px-4 md:pl-[276px] shadow-soft" style="box-shadow: 0 2px 8px rgba(0,33,71,0.06)">
    <!-- Left: Hamburger + Title -->
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" class="md:hidden w-9 h-9 rounded-lg flex items-center justify-center hover:bg-gray-100 transition-colors">
            <span class="material-symbols-outlined text-navy-900">menu</span>
        </button>
        <div>
            <h2 class="font-heading font-semibold text-navy-950 text-base leading-tight">@yield('page-title', 'Dashboard')</h2>
            <p class="text-xs text-gray-400 font-inter hidden md:block">@yield('page-subtitle', 'Sistem Informasi Manajemen Surat Desa')</p>
        </div>
    </div>

    <!-- Right: Search + Actions -->
    <div class="flex items-center gap-2">
        <!-- Search (desktop) -->
        <div class="hidden lg:flex items-center bg-gray-50 rounded-full px-4 py-2 border border-gray-200 focus-within:border-navy-900 focus-within:bg-white transition-all w-56">
            <span class="material-symbols-outlined text-gray-400 text-lg mr-2">search</span>
            <input type="text" placeholder="Cari surat..." class="bg-transparent border-none focus:ring-0 text-sm w-full text-gray-700 placeholder:text-gray-400 outline-none font-inter"/>
        </div>

        <!-- Notification -->
        <div class="relative" id="notif-container">
            <button onclick="toggleNotif()" class="w-9 h-9 rounded-lg flex items-center justify-center hover:bg-gray-100 transition-colors relative">
                <span class="material-symbols-outlined text-gray-500">notifications</span>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-gold-600 rounded-full"></span>
            </button>
            <!-- Notification Dropdown -->
            <div class="notif-dropdown hidden" id="notif-dropdown">
                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                    <h4 class="font-heading font-semibold text-navy-950 text-sm">Notifikasi</h4>
                    <span class="text-xs text-navy-900 font-semibold cursor-pointer hover:text-gold-600">Tandai semua</span>
                </div>
                <div class="max-h-72 overflow-y-auto">
                    <div class="notif-item">
                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-blue-600 text-lg" style="font-variation-settings:'FILL' 1">mail</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Surat masuk baru</p>
                            <p class="text-xs text-gray-500 mt-0.5">SM/2024/004 telah ditambahkan</p>
                            <p class="text-xs text-gray-400 mt-1">2 menit lalu</p>
                        </div>
                    </div>
                    <div class="notif-item">
                        <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-amber-600 text-lg" style="font-variation-settings:'FILL' 1">event</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Agenda besok</p>
                            <p class="text-xs text-gray-500 mt-0.5">Rapat Koordinasi jam 08:00</p>
                            <p class="text-xs text-gray-400 mt-1">1 jam lalu</p>
                        </div>
                    </div>
                    <div class="notif-item">
                        <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-green-600 text-lg" style="font-variation-settings:'FILL' 1">task_alt</span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Berita acara disetujui</p>
                            <p class="text-xs text-gray-500 mt-0.5">BA/2024/001 telah disetujui</p>
                            <p class="text-xs text-gray-400 mt-1">3 jam lalu</p>
                        </div>
                    </div>
                </div>
                <div class="text-center py-3 border-t border-gray-100">
                    <a href="#" class="text-xs text-navy-900 font-semibold hover:text-gold-600">Lihat semua notifikasi</a>
                </div>
            </div>
        </div>

        <!-- Profile -->
        <div class="relative" id="profile-container">
            <button onclick="toggleProfile()" class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-full hover:bg-gray-100 transition-colors">
                <div class="w-8 h-8 rounded-full bg-navy-900 flex items-center justify-center text-gold-500 font-bold text-sm font-heading">
                    {{ auth()->user()->initials }}
                </div>
                <span class="hidden md:block text-sm font-semibold text-gray-700 font-inter">{{ auth()->user()->name }}</span>
                <span class="material-symbols-outlined text-gray-400 text-base hidden md:block">expand_more</span>
            </button>
            <!-- Profile Dropdown -->
            <div class="profile-dropdown hidden" id="profile-dropdown">
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="font-heading font-semibold text-navy-950 text-sm">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ auth()->user()->email }}</p>
                    <span class="badge badge-{{ auth()->user()->role }} mt-1.5">{{ auth()->user()->role_label }}</span>
                </div>
                <div class="py-1">
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <span class="material-symbols-outlined text-gray-400 text-lg">person</span>
                        Profil Saya
                    </a>
                    <div class="border-t border-gray-100 mt-1 pt-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left">
                                <span class="material-symbols-outlined text-red-400 text-lg">logout</span>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="md:ml-[260px] pt-16 min-h-screen">
    <div class="p-5 md:p-8">
        @yield('content')
    </div>
</main>

<!-- Toast Notifications -->
<div class="toast-container" id="toast-container">
    @if(session('success'))
        <div class="toast toast-success" id="toast-success">
            <span class="material-symbols-outlined text-green-500" style="font-variation-settings:'FILL' 1">check_circle</span>
            <span>{!! session('success') !!}</span>
            <button onclick="closeToast('toast-success')" class="ml-auto text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined text-base">close</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="toast toast-error" id="toast-error">
            <span class="material-symbols-outlined text-red-500" style="font-variation-settings:'FILL' 1">error</span>
            <span>{!! session('error') !!}</span>
            <button onclick="closeToast('toast-error')" class="ml-auto text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined text-base">close</span>
            </button>
        </div>
    @endif
</div>

@yield('modals')

<script>
    // Sidebar toggle
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('sidebar-overlay').classList.toggle('show');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.remove('show');
    }

    // Notification dropdown
    function toggleNotif() {
        const dd = document.getElementById('notif-dropdown');
        const pd = document.getElementById('profile-dropdown');
        pd.classList.add('hidden');
        dd.classList.toggle('hidden');
    }

    // Profile dropdown
    function toggleProfile() {
        const dd = document.getElementById('profile-dropdown');
        const nd = document.getElementById('notif-dropdown');
        nd.classList.add('hidden');
        dd.classList.toggle('hidden');
    }

    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        if (!document.getElementById('notif-container').contains(e.target)) {
            document.getElementById('notif-dropdown').classList.add('hidden');
        }
        if (!document.getElementById('profile-container').contains(e.target)) {
            document.getElementById('profile-dropdown').classList.add('hidden');
        }
    });

    // Toast auto-close
    function closeToast(id) {
        const el = document.getElementById(id);
        if (el) { el.style.animation = 'slideOutRight 0.3s ease forwards'; setTimeout(() => el.remove(), 300); }
    }
    setTimeout(() => {
        ['toast-success','toast-error','toast-info'].forEach(id => {
            const el = document.getElementById(id);
            if (el) closeToast(id);
        });
    }, 5000);

    // Delete confirmation
    function confirmDelete(formId) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')) {
            document.getElementById(formId).submit();
        }
    }
</script>

@yield('scripts')
</body>
</html>
