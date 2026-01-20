<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard PKL')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-100 font-inter">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="hidden md:flex w-64 flex-col bg-gradient-to-b from-indigo-600 to-indigo-800 text-white">
        <div class="p-6 border-b border-indigo-500">
            <h1 class="text-xl font-bold">PKL & Magang</h1>
            <p class="text-xs text-indigo-200">Sistem Pendataan</p>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white/10">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10">
                <i class="fas fa-users"></i> Peserta
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10">
                <i class="fas fa-building"></i> Perusahaan
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10">
                <i class="fas fa-file-alt"></i> Laporan
            </a>
        </nav>

        <div class="p-4 border-t border-indigo-500">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name=Admin"
                     class="w-9 h-9 rounded-full">
                <div>
                    <p class="text-sm font-semibold">Admin</p>
                    <p class="text-xs text-indigo-200">Administrator</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- CONTENT --}}
    <div class="flex flex-col flex-1">

        {{-- TOPBAR --}}
        <header class="flex items-center justify-between px-6 py-4 bg-white shadow">
            <h2 class="text-lg font-semibold text-gray-700">@yield('title')</h2>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>

</div>

@yield('scripts')
</body>
</html>
