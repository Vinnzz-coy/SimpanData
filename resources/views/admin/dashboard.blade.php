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
            <div class="flex flex-col justify-between gap-3 p-4 border-b border-gray-200 md:gap-4 md:p-5 sm:flex-row sm:items-center">
                <h2 class="text-base font-semibold text-gray-800 md:text-lg">Absensi</h2>

                <div class="flex gap-3">
                    <select
                        id="absensiFilter"
                        class="px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
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
            <div class="flex flex-col flex-shrink-0 gap-3 p-4 border-b border-gray-200 md:gap-4 md:p-5 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-base font-semibold text-gray-800 md:text-lg">
                    Daftar Peserta PKL & Magang
                </h2>

                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class='bx bx-search'></i>
                    </span>
                    <input
                        type="text"
                        id="searchPeserta"
                        placeholder="Cari nama peserta..."
                        class="w-full py-2 pl-10 pr-4 text-sm transition-all duration-200 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
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

        <div class="flex flex-col flex-1 p-4 md:p-5 space-y-3 md:space-y-4 overflow-y-auto min-h-0 max-h-[600px] feedback-scroll">
            @forelse ($feedbacks as $feedback)
                <div class="flex gap-3 p-3 border rounded-lg hover:bg-gray-50">
                    <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 font-bold text-indigo-600 bg-indigo-100 rounded-full">
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

@section('scripts')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Custom Pagination Styles */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .pagination > * {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .pagination > *:hover:not(.disabled):not(.active) {
        background-color: #f3f4f6;
        border-color: #d1d5db;
        color: #1f2937;
    }

    .pagination .active {
        background-color: #4f46e5;
        border-color: #4f46e5;
        color: #ffffff;
    }

    .pagination .disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination span {
        color: #6b7280;
    }

    /* Custom Scrollbar untuk Feedback Peserta */
    .feedback-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .feedback-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .feedback-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .feedback-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Custom Scrollbar untuk Tabel Peserta */
    .table-scroll::-webkit-scrollbar {
        height: 6px;
        width: 6px;
    }

    .table-scroll::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .table-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .table-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Pastikan grid items memiliki tinggi yang sama */
    .grid > div {
        display: flex;
        flex-direction: column;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('absensiChart').getContext('2d');

        const absensiData = {
            hari: {
                labels: @json($absensiDataHarian['labels']),
                hadir: @json($absensiDataHarian['Hadir']),
                izin: @json($absensiDataHarian['Izin']),
                sakit: @json($absensiDataHarian['Sakit']),
            },
            minggu: {
                labels: @json($absensiDataBulanan['labels']),
                hadir: @json($absensiDataBulanan['Hadir']),
                izin: @json($absensiDataBulanan['Izin']),
                sakit: @json($absensiDataBulanan['Sakit']),
            },
            bulan: {
                labels: @json($absensiDataTahunan['labels']),
                hadir: @json($absensiDataTahunan['Hadir']),
                izin: @json($absensiDataTahunan['Izin']),
                sakit: @json($absensiDataTahunan['Sakit']),
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
                        backgroundColor: 'rgba(16,185,129,0.1)',
                        fill: true,
                        tension: 0.5,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: '#059669',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3,
                        cubicInterpolationMode: 'monotone',
                        animation: {
                            duration: 2000,
                            easing: 'easeInOutQuart'
                        }
                    },
                    {
                        label: 'Izin',
                        data: absensiData.hari.izin,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245,158,11,0.1)',
                        fill: true,
                        tension: 0.5,
                        borderWidth: 3,
                        borderDash: [5, 5],
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: '#d97706',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3,
                        cubicInterpolationMode: 'monotone',
                        animation: {
                            duration: 2000,
                            delay: 200,
                            easing: 'easeInOutQuart'
                        }
                    },
                    {
                        label: 'Sakit',
                        data: absensiData.hari.sakit,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239,68,68,0.1)',
                        fill: true,
                        tension: 0.5,
                        borderWidth: 3,
                        borderDash: [10, 5],
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: '#ef4444',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointHoverBackgroundColor: '#dc2626',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3,
                        cubicInterpolationMode: 'monotone',
                        animation: {
                            duration: 2000,
                            delay: 400,
                            easing: 'easeInOutQuart'
                        }
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        display: true,
                        align: 'center',
                        labels: {
                            padding: 20,
                            usePointStyle: false,
                            boxWidth: 16,
                            boxHeight: 16,
                            boxPadding: 6,
                            font: {
                                size: 13,
                                weight: '500',
                                family: 'system-ui, -apple-system, sans-serif'
                            },
                            color: '#374151',
                            generateLabels: function(chart) {
                                const original = Chart.defaults.plugins.legend.labels.generateLabels;
                                const labels = original.call(this, chart);
                                labels.forEach((label, index) => {
                                    const dataset = chart.data.datasets[index];
                                    if (dataset) {
                                        label.fillStyle = dataset.borderColor;
                                        label.strokeStyle = dataset.borderColor;
                                        label.lineWidth = 0;
                                    }
                                });
                                return labels;
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' orang';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });

        document.getElementById('absensiFilter').addEventListener('change', function () {
            const value = this.value;

            chart.data.labels = absensiData[value].labels;
            chart.data.datasets[0].data = absensiData[value].hadir;
            chart.data.datasets[1].data = absensiData[value].izin;
            chart.data.datasets[2].data = absensiData[value].sakit;

            chart.update('active', {
                duration: 700,
                easing: 'easeInOutQuart'
            });
        });

        const searchInput = document.getElementById('searchPeserta');
        const tableBody = document.getElementById('pesertaTableBody');
        const paginationWrapper = document.getElementById('pesertaPagination');

        let pesertaRows = document.querySelectorAll('.peserta-row');
        let noDataRow = document.getElementById('noDataRow');
        let paginationContainer = paginationWrapper ? paginationWrapper.querySelector('.pagination') : null;

        const refreshTableReferences = () => {
            pesertaRows = document.querySelectorAll('.peserta-row');
            noDataRow = document.getElementById('noDataRow');
            paginationContainer = paginationWrapper ? paginationWrapper.querySelector('.pagination') : null;
        };

        const applySearchFilter = () => {
            if (!searchInput) {
                return;
            }

            const searchTerm = searchInput.value.toLowerCase().trim();
            let hasVisibleRow = false;

            pesertaRows.forEach((row, index) => {
                const nama = row.getAttribute('data-nama');
                if (nama.includes(searchTerm) || searchTerm === '') {
                    row.style.display = '';
                    row.style.opacity = '0';
                    row.style.transform = 'translateY(-5px)';

                    setTimeout(() => {
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '1';
                        row.style.transform = 'translateY(0)';
                    }, index * 30);

                    hasVisibleRow = true;
                } else {
                    row.style.transition = 'all 0.2s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateY(-5px)';
                    setTimeout(() => {
                        row.style.display = 'none';
                    }, 200);
                }
            });

            if (paginationContainer) {
                paginationContainer.style.display = searchTerm !== '' ? 'none' : 'flex';
            }

            if (noDataRow) {
                if (hasVisibleRow || searchTerm === '') {
                    noDataRow.style.display = 'none';
                } else {
                    noDataRow.style.display = '';
                    noDataRow.style.opacity = '0';
                    noDataRow.style.animation = 'fadeIn 0.3s ease-in forwards';
                    noDataRow.innerHTML = '<td colspan="4" class="px-4 py-8 text-center text-gray-500">Tidak ada data yang ditemukan untuk "<strong>' + searchInput.value + '</strong>"</td>';
                }
            }
        };

        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    refreshTableReferences();
                    applySearchFilter();
                }, 300);
            });
        }

        const bindPaginationLinks = () => {
            if (!paginationWrapper) {
                return;
            }

            paginationWrapper.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();

                    const url = link.getAttribute('href');
                    if (!url) {
                        return;
                    }

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (tableBody) {
                                tableBody.innerHTML = data.rows;
                            }
                            if (paginationWrapper) {
                                paginationWrapper.innerHTML = data.pagination;
                            }

                            refreshTableReferences();
                            bindPaginationLinks();
                            applySearchFilter();
                        })
                        .catch((error) => {
                            console.error('Pagination fetch error:', error);
                        });
                });
            });
        };

        bindPaginationLinks();

        const salesPieCtx = document.getElementById('salesPieChart').getContext('2d');
        const salesPieChart = new Chart(salesPieCtx, {
            type: 'doughnut',
            data: {
                labels: ['PKL', 'Magang'],
                datasets: [{
                    data: [{{ $totalPkl }}, {{ $totalMagang }}],
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
