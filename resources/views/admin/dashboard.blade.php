@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="mb-4 md:mb-6 card">
        <div class="p-4 border-b border-gray-200 md:p-5">
            <h2 class="text-base font-semibold text-gray-800 md:text-lg">
                Statistik Peserta
            </h2>
        </div>

        <div class="p-4 md:p-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-indigo-500 to-purple-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">PKL</p>
                                <h3 class="text-3xl font-bold text-white">{{ $totalPkl }}</h3>
                                <p class="mt-1 text-xs text-white/70">Peserta</p>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-white/20">
                                    <i class='text-2xl text-white bx bx-book'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-blue-500 to-indigo-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Magang</p>
                                <h3 class="text-3xl font-bold text-white">{{ $totalMagang }}</h3>
                                <p class="mt-1 text-xs text-white/70">Peserta</p>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-white/20">
                                    <i class='text-2xl text-white bx bx-briefcase-alt'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-emerald-500 to-teal-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Aktif</p>
                                <h3 class="text-3xl font-bold text-white">{{ $aktif }}</h3>
                                <p class="mt-1 text-xs text-white/70">Peserta</p>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-white/20">
                                    <i class='text-2xl text-white bx bx-time-five'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-lg shadow-sm bg-gradient-to-br from-amber-500 to-orange-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="mb-1 text-xs font-semibold tracking-wider uppercase text-white/80">Selesai</p>
                                <h3 class="text-3xl font-bold text-white">{{ $selesai }}</h3>
                                <p class="mt-1 text-xs text-white/70">Peserta</p>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-white/20">
                                    <i class='text-2xl text-white bx bx-check-double'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 mb-4 md:gap-6 md:mb-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="h-full card">
                <div
                    class="flex flex-col justify-between gap-3 p-4 border-b border-gray-200 md:gap-4 md:p-5 sm:flex-row sm:items-center">
                    <h2 class="text-base font-semibold text-gray-800 md:text-lg">Absensi</h2>

                    <div class="flex gap-3">
                        <select id="absensiFilter"
                            class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="hari">Hari</option>
                            <option value="minggu">Minggu</option>
                            <option value="bulan">Bulan</option>
                        </select>
                    </div>
                </div>

                <div class="p-4 md:p-5">
                    <div class="chart-container h-[250px] md:h-[300px]">
                        <canvas id="absensiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="h-full card">
                <div class="p-4 border-b border-gray-200 md:p-5">
                    <h2 class="text-base font-semibold text-gray-800 md:text-lg">Peserta</h2>
                </div>
                <div class="p-4 md:p-5">
                    <div class="mb-6 chart-container">
                        <canvas id="salesPieChart"></canvas>
                    </div>
                    <div class="text-center">
                        <h3 class="mb-3 font-medium text-gray-700">Perbandingan Peserta PKL dan Magang</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="flex flex-col h-full card">
                <div
                    class="flex flex-col flex-shrink-0 gap-3 p-4 border-b border-gray-200 md:gap-4 md:p-5 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-base font-semibold text-gray-800 md:text-lg">
                        Daftar Peserta PKL & Magang
                    </h2>

                    <div class="flex flex-col w-full gap-3 sm:w-auto sm:flex-row sm:items-center">
                        <form method="GET" class="w-full sm:w-64">
                            <div class="relative">
                                <select name="asal_sekolah_universitas" onchange="this.form.submit()"
                                    class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 appearance-none bg-white pr-10">
                                    <option value="">Semua Sekolah/Universitas</option>
                                    @foreach ($sekolahs as $item)
                                        <option value="{{ $item->asal_sekolah_universitas }}"
                                            {{ $asal == $item->asal_sekolah_universitas ? 'selected' : '' }}>
                                            {{ $item->asal_sekolah_universitas }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class='absolute text-gray-400 transform -translate-y-1/2 right-3 top-1/2 bx bx-chevron-down'></i>
                            </div>
                        </form>

                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class='bx bx-search'></i>
                            </span>
                            <input type="text" id="searchPeserta" placeholder="Cari nama peserta..."
                                class="w-full py-2 pl-10 pr-4 text-sm transition-all duration-200 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col flex-1 min-h-0">
                    <div class="flex-1 min-h-0 p-4 overflow-x-auto overflow-y-auto md:p-5 table-scroll">
                        <table class="min-w-full text-sm text-left">
                            <thead>
                                <tr class="text-gray-600 border-b">
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Nama Peserta</th>
                                    <th class="px-4 py-3">Jenis</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody id="pesertaTableBody" class="divide-y">
                                @include('admin.partials.peserta-rows', ['peserta' => $peserta])
                            </tbody>
                        </table>
                    </div>

                    <div class="flex-shrink-0 px-4 pt-2 pb-4 border-t border-gray-200 md:px-5" id="pesertaPagination">
                        {{ $peserta->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="flex flex-col h-full card">
                <div class="flex items-center flex-shrink-0 gap-2 p-4 border-b border-gray-200 md:p-5">
                    <i class='text-xl text-indigo-500 md:text-2xl bx bx-message'></i>
                    <h2 class="text-base font-semibold text-gray-800 md:text-lg">
                        Feedback Peserta
                    </h2>
                </div>

                <div
                    class="flex flex-col flex-1 p-4 md:p-5 space-y-3 md:space-y-4 overflow-y-auto min-h-0 max-h-[600px] feedback-scroll">
                    @forelse ($feedbacks as $feedback)
                        <div class="flex gap-3 p-3 border rounded-lg hover:bg-gray-50">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-10 h-10 font-bold text-indigo-600 bg-indigo-100 rounded-full">
                                {{ strtoupper(substr($feedback->peserta->nama, 0, 1)) }}
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $feedback->peserta->nama }}
                                </p>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-3">
                                    {{ $feedback->pesan }}
                                </p>
                                <p class="mt-1 text-xs text-gray-400">
                                    {{ $feedback->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-center text-gray-500">
                            Belum ada feedback peserta
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    @vite('resources/css/admin/dashboard.css')
@endpush

@section('scripts')
    <script>
        window.dashboardData = {
            absensiHari: @json($absensiDataHari),
            absensiMinggu: @json($absensiDataMinggu),
            absensiBulan: @json($absensiDataBulan),
            totalPkl: {{ $totalPkl }},
            totalMagang: {{ $totalMagang }}
        };
    </script>
    @vite('resources/js/admin/dashboard.js')
@endsection
