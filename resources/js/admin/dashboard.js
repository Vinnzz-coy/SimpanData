document.addEventListener('DOMContentLoaded', function() {
    const data = window.dashboardData || {};

    const ctx = document.getElementById('absensiChart').getContext('2d');

    const absensiData = {
        hari: {
            labels: data.absensiHari?.labels || [],
            hadir: data.absensiHari?.Hadir || [],
            izin: data.absensiHari?.Izin || [],
            sakit: data.absensiHari?.Sakit || [],
        },
        minggu: {
            labels: data.absensiMinggu?.labels || [],
            hadir: data.absensiMinggu?.Hadir || [],
            izin: data.absensiMinggu?.Izin || [],
            sakit: data.absensiMinggu?.Sakit || [],
        },
        bulan: {
            labels: data.absensiBulan?.labels || [],
            hadir: data.absensiBulan?.Hadir || [],
            izin: data.absensiBulan?.Izin || [],
            sakit: data.absensiBulan?.Sakit || [],
        }
    };

    const createGradient = (ctx, color1, color2) => {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, color1);
        gradient.addColorStop(1, color2);
        return gradient;
    };

    const gradientHadir = createGradient(ctx, 'rgba(16, 185, 129, 0.2)', 'rgba(16, 185, 129, 0)');
    const gradientIzin = createGradient(ctx, 'rgba(245, 158, 11, 0.2)', 'rgba(245, 158, 11, 0)');
    const gradientSakit = createGradient(ctx, 'rgba(239, 68, 68, 0.2)', 'rgba(239, 68, 68, 0)');

    let chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: absensiData.hari.labels,
            datasets: [
                {
                    label: 'Hadir',
                    data: absensiData.hari.hadir,
                    borderColor: '#10b981',
                    backgroundColor: gradientHadir,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2,
                    pointHoverBackgroundColor: '#10b981',
                    pointHoverBorderColor: '#fff',
                },
                {
                    label: 'Izin',
                    data: absensiData.hari.izin,
                    borderColor: '#f59e0b',
                    backgroundColor: gradientIzin,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#f59e0b',
                    pointBorderWidth: 2,
                    pointHoverBackgroundColor: '#f59e0b',
                    pointHoverBorderColor: '#fff',
                },
                {
                    label: 'Sakit',
                    data: absensiData.hari.sakit,
                    borderColor: '#ef4444',
                    backgroundColor: gradientSakit,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#ef4444',
                    pointBorderWidth: 2,
                    pointHoverBackgroundColor: '#ef4444',
                    pointHoverBorderColor: '#fff',
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
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: {
                            family: "'Inter', sans-serif",
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1f2937',
                    bodyColor: '#4b5563',
                    padding: 12,
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    cornerRadius: 8,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            return ` ${context.dataset.label}: ${context.parsed.y} Orang`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.03)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { size: 11 },
                        stepSize: 1
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            },
            animations: {
                radius: {
                    duration: 400,
                    easing: 'linear',
                    loop: (context) => context.active
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

    const salesPieChartElement = document.getElementById('salesPieChart');
    if (salesPieChartElement) {
        const salesPieCtx = salesPieChartElement.getContext('2d');

        const leaderLinesPlugin = {
            id: 'leaderLines',
            afterDraw: (chart) => {
                const { ctx, data, chartArea: { top, bottom, left, right, width, height } } = chart;

                data.datasets.forEach((dataset, i) => {
                    chart.getDatasetMeta(i).data.forEach((datapoint, index) => {
                        const { x, y } = datapoint.tooltipPosition();

                        if (dataset.data[index] === 0) return;

                        const label = data.labels[index];
                        const value = dataset.data[index];
                        const color = dataset.backgroundColor[index];

                        const halfwidth = width / 2;
                        const halfheight = height / 2;
                        const xCenter = datapoint.x;
                        const yCenter = datapoint.y;

                        const dx = x - xCenter;
                        const dy = y - yCenter;
                        const angle = Math.atan2(dy, dx);

                        const lineLength = 30;
                        const endX = x + Math.cos(angle) * lineLength;
                        const endY = y + Math.sin(angle) * lineLength;

                        const textX = endX + (x > xCenter ? 5 : -5);
                        const textAlign = x > xCenter ? 'left' : 'right';

                        ctx.beginPath();
                        ctx.moveTo(x, y);
                        ctx.lineTo(endX, endY);
                        ctx.strokeStyle = color;
                        ctx.lineWidth = 2;
                        ctx.stroke();

                        const text = `${label}: ${value}`;
                        ctx.font = 'bold 12px Inter';
                        const textWidth = ctx.measureText(text).width;

                        ctx.fillStyle = textAlign === 'left' ? 'rgba(255, 255, 255, 0.8)' : 'rgba(255, 255, 255, 0.8)';

                        ctx.textAlign = textAlign;
                        ctx.textBaseline = 'middle';
                        ctx.fillStyle = '#1f2937';
                        ctx.fillText(text, textX, endY);
                    });
                });
            }
        };

        const salesPieChart = new Chart(salesPieCtx, {
            type: 'doughnut',
            data: {
                labels: ['PKL', 'Magang'],
                datasets: [{
                    data: [data.totalPkl || 0, data.totalMagang || 0],
                    backgroundColor: [
                        '#4f46e5',
                        '#f59e0b'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                layout: {
                    padding: 30
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#1f2937',
                        bodyColor: '#4b5563',
                        borderColor: '#e5e7eb',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            },
            plugins: [leaderLinesPlugin]
        });
    }
});
