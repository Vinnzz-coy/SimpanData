<!DOCTYPE html>
<html lang="id">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard PKL')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind --}}
    @vite('resources/css/app.css')

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - @yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary: #4f46e5;
            --secondary: #6b7280;
            --success: #10b981;
            --info: #0ea5e9;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f9fafb;
            --dark: #111827;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--primary) 0%, #3730a3 100%);
        }

        .nav-link {
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            border: 1px solid #e5e7eb;
        }

        .stat-card {
            border-left-width: 4px;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .progress-bar {
            background-color: #e5e7eb;
            border-radius: 9999px;
            overflow: hidden;
        }

        .progress-fill {
            background-color: var(--primary);
            height: 100%;
            border-radius: 9999px;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">

    {{-- ========== SIDEBAR ========== --}}
    <aside class="hidden w-64 bg-white shadow-lg md:block">
        <div class="p-6 border-b">
            <h1 class="text-xl font-bold text-indigo-600">PKL & Magang</h1>
            <p class="text-xs text-gray-500">Sistem Pendataan</p>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <div class="flex-col flex-shrink-0 hidden w-64 sidebar md:flex">
            <div class="p-6 border-b border-indigo-700">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center w-8 h-8 bg-white rounded-lg">
                        <i class="text-indigo-600 fas fa-chart-bar"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Dashboard</span>
                </div>
            </div>

            <div class="flex-1 p-4 overflow-y-auto">
                <nav class="space-y-1">
                    <a href="#" class="flex items-center px-4 py-3 text-white rounded-lg nav-link bg-white/10">
                        <i class="w-5 h-5 mr-3 fas fa-home"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 rounded-lg nav-link text-white/80 hover:text-white hover:bg-white/5">
                        <i class="w-5 h-5 mr-3 fas fa-users"></i>
                        <span class="font-medium">Users</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 rounded-lg nav-link text-white/80 hover:text-white hover:bg-white/5">
                        <i class="w-5 h-5 mr-3 fas fa-chart-line"></i>
                        <span class="font-medium">Analytics</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 rounded-lg nav-link text-white/80 hover:text-white hover:bg-white/5">
                        <i class="w-5 h-5 mr-3 fas fa-shopping-cart"></i>
                        <span class="font-medium">Sales</span>
                    </a>

                    <a href="#" class="flex items-center px-4 py-3 rounded-lg nav-link text-white/80 hover:text-white hover:bg-white/5">
                        <i class="w-5 h-5 mr-3 fas fa-cog"></i>
                        <span class="font-medium">Settings</span>
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-indigo-700">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 bg-indigo-800 rounded-full">
                        <i class="text-white fas fa-user"></i>
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-white">John Smith</p>
                        <p class="text-sm text-indigo-200">Admin</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="flex items-center justify-between px-4 py-3 bg-white border-b border-gray-200 md:hidden">
                <button id="sidebarToggle" class="p-2 text-gray-600 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex items-center space-x-4">
                    <span class="text-lg font-bold text-gray-800">Dashboard</span>
                </div>
                <div class="w-8"></div>
            </header>

            <main class="flex-1 p-4 overflow-y-auto md:p-6">
                @yield('content')
            </main>
        </div>
    </div>

        <nav class="p-4 space-y-2">

            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50">
                📊 <span>Dashboard</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50">
                👨‍🎓 <span>Data Siswa</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50">
                🏢 <span>Data Perusahaan</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-indigo-50">
                📋 <span>Laporan</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 text-red-600 rounded-lg hover:bg-red-50">
                🚪 <span>Logout</span>
            </a>

        </nav>
    </aside>

    {{-- ========== MAIN CONTENT ========== --}}
    <div class="flex flex-col flex-1">

        {{-- ========== TOPBAR ========== --}}
        <header class="flex items-center justify-between px-6 py-4 bg-white shadow">
            <h2 class="text-lg font-semibold text-gray-700">@yield('title')</h2>

            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">Admin</span>
                <img src="https://ui-avatars.com/api/?name=Admin" class="rounded-full w-9 h-9">
    <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50"></div>

    <div id="mobileSidebar" class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 ease-in-out transform -translate-x-full bg-indigo-800 md:hidden">
        <div class="p-6 border-b border-indigo-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center w-8 h-8 bg-white rounded-lg">
                        <i class="text-indigo-600 fas fa-chart-bar"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Dashboard</span>
                </div>
                <button id="closeSidebar" class="p-2 text-white rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </header>

        {{-- ========== PAGE CONTENT ========== --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        </div>

        <div class="p-4">
            <nav class="space-y-2">
                <a href="#" class="block px-4 py-3 text-white rounded-lg bg-white/10">
                    <i class="inline-block w-5 h-5 mr-3 fas fa-home"></i>
                    <span>Dashboard</span>
                </a>

                <a href="#" class="block px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-white/5">
                    <i class="inline-block w-5 h-5 mr-3 fas fa-users"></i>
                    <span>Users</span>
                </a>

                <a href="#" class="block px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-white/5">
                    <i class="inline-block w-5 h-5 mr-3 fas fa-chart-line"></i>
                    <span>Analytics</span>
                </a>

                <a href="#" class="block px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-white/5">
                    <i class="inline-block w-5 h-5 mr-3 fas fa-shopping-cart"></i>
                    <span>Sales</span>
                </a>

                <a href="#" class="block px-4 py-3 rounded-lg text-white/80 hover:text-white hover:bg-white/5">
                    <i class="inline-block w-5 h-5 mr-3 fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </nav>
        </div>
    </div>

</div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const closeSidebar = document.getElementById('closeSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mobileSidebar = document.getElementById('mobileSidebar');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    mobileSidebar.classList.remove('-translate-x-full');
                    sidebarOverlay.classList.remove('hidden');
                });
            }

            if (closeSidebar) {
                closeSidebar.addEventListener('click', function() {
                    mobileSidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    mobileSidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
</html>
