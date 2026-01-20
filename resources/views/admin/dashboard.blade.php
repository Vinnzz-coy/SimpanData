@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 p-6 text-white shadow-lg">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white/10 rounded-full"></div>

        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold">
                    Dashboard
                </h1>
                <p class="text-indigo-100 mt-1 text-sm md:text-base">
                    Ringkasan data peserta PKL dan Magang hari ini
                </p>
            </div>

            <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-white/20 backdrop-blur">
                <i class="fas fa-chart-line text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="card mb-6">
    <div class="p-5 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">
            Statistik Peserta
        </h2>
    </div>

    <div class="p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-gradient-to-br from-indigo-500 to-purple-500 text-white rounded-xl p-5 shadow flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide opacity-80">PKL</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $totalPkl }}</h3>
                </div>
                <svg class="w-10 h-10 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6 10v4a6 6 0 0012 0v-4" />
                </svg>
            </div>

            <div class="bg-gradient-to-br from-blue-500 to-indigo-500 text-white rounded-xl p-5 shadow flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide opacity-80">Magang</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $totalMagang }}</h3>
                </div>
                <svg class="w-10 h-10 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 12a4 4 0 100-8 4 4 0 000 8z" />
                    <rect x="3" y="13" width="18" height="8" rx="2" />
                </svg>
            </div>

            <div class="bg-gradient-to-br from-emerald-500 to-teal-500 text-white rounded-xl p-5 shadow flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide opacity-80">Aktif</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $aktif }}</h3>
                </div>
                <svg class="w-10 h-10 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 7v5l3 3" />
                </svg>
            </div>

            <div class="bg-gradient-to-br from-amber-500 to-orange-500 text-white rounded-xl p-5 shadow flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wide opacity-80">Selesai</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $selesai }}</h3>
                </div>
                <svg class="w-10 h-10 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4" />
                </svg>
            </div>

        </div>
    </div>
</div>



<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="lg:col-span-2">
        <div class="card h-full">
            <div class="p-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-gray-800">Absensi</h2>

                <div class="flex gap-3">
                    <select
                        id="absensiFilter"
                        class="border border-gray-300 rounded-lg px-4 py-2
                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    >
                        <option value="hari">Hari</option>
                        <option value="minggu">Minggu</option>
                        <option value="bulan">Bulan</option>
                    </select>
                </div>
            </div>

            <div class="p-5">
                <div class="chart-container h-[300px]">
                    <canvas id="absensiChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="card h-full">
            <div class="p-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Peserta</h2>
            </div>
            <div class="p-5">
                <div class="chart-container mb-6">
                    <canvas id="salesPieChart"></canvas>
                </div>
                <div class="text-center">
                    <h3 class="font-medium text-gray-700 mb-3">Perbandingan Peserta PKL dan Magang</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card">
            <div class="p-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    Daftar Peserta PKL & Magang
                </h2>

                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input
                        type="text"
                        placeholder="Cari nama peserta..."
                        class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg
                        focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                    >
                </div>
            </div>

            <div class="p-5 overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr class="text-gray-600 border-b">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Nama Peserta</th>
                            <th class="py-3 px-4">Jenis</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4 font-medium text-gray-800">
                                Andi Pratama
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                    PKL
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    Aktif
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button
                                        class="p-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200"
                                        title="Edit"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        class="p-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-200"
                                        title="Hapus"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">2</td>
                            <td class="py-3 px-4 font-medium text-gray-800">
                                Siti Aisyah
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-700">
                                    Magang
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                    Selesai
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button
                                        class="p-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        class="p-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-200"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<div class="lg:col-span-1">
    <div class="card h-full">
        <div class="p-5 border-b border-gray-200 flex items-center gap-2">
            <i class="fas fa-comments text-indigo-500"></i>
            <h2 class="text-lg font-semibold text-gray-800">
                Feedback Peserta
            </h2>
        </div>

        <div class="p-5 space-y-4 max-h-[420px] overflow-y-auto">
            @forelse ($feedbacks as $feedback)
                <div class="flex gap-3 p-3 rounded-lg border hover:bg-gray-50">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100
                                text-indigo-600 flex items-center justify-center font-bold">
                        {{ strtoupper(substr($feedback->peserta->nama, 0, 1)) }}
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-800">
                            {{ $feedback->peserta->nama }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1 line-clamp-3">
                            {{ $feedback->pesan }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $feedback->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center">
                    Belum ada feedback peserta
                </p>
            @endforelse
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('absensiChart').getContext('2d');
        const absensiData = {
            hari: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
                hadir: [30, 28, 32, 29, 31],
                izin: [3, 2, 1, 3, 2],
                sakit: [1, 2, 2, 1, 1],
            },
            minggu: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                hadir: [150, 145, 160, 155],
                izin: [12, 10, 8, 9],
                sakit: [5, 7, 6, 4],
            },
            bulan: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                hadir: [620, 610, 640, 630, 650, 660],
                izin: [45, 40, 38, 42, 39, 36],
                sakit: [18, 22, 20, 19, 17, 15],
            }
        };

        let chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: absensiData.hari.labels,
                datasets: [
                    {
                        label: 'Hadir',
                        data: absensiData.hari.hadir,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16,185,129,0.15)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    },
                    {
                        label: 'Izin',
                        data: absensiData.hari.izin,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245,158,11,0.15)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    },
                    {
                        label: 'Sakit',
                        data: absensiData.hari.sakit,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239,68,68,0.15)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { drawBorder: false }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        document.getElementById('absensiFilter').addEventListener('change', function () {
            const value = this.value;

            chart.data.labels = absensiData[value].labels;
            chart.data.datasets[0].data = absensiData[value].hadir;
            chart.data.datasets[1].data = absensiData[value].izin;
            chart.data.datasets[2].data = absensiData[value].sakit;
            chart.update();
        });

        const salesPieCtx = document.getElementById('salesPieChart').getContext('2d');
        const salesPieChart = new Chart(salesPieCtx, {
            type: 'doughnut',
            data: {
                labels: ['PKL', 'Magang'],
                datasets: [{
                    data: [45, 25],
                    backgroundColor: [
                        '#4f46e5',
                        '#f59e0b'
                    ],
                    borderWidth: 0,
                    spacing: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection