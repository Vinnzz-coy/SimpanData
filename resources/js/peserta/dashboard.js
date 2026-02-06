document.addEventListener('DOMContentLoaded', function() {
    let attendanceChart;
    const ctxAttendance = document.getElementById('attendanceChart')?.getContext('2d');
    const loadingOverlay = document.getElementById('chartLoading');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const weekSelector = document.getElementById('weekSelector');

    if (!ctxAttendance) return;

    function initChart(labels, data) {
        const attGradient = ctxAttendance.createLinearGradient(0, 0, 0, 400);
        attGradient.addColorStop(0, 'rgba(16, 54, 125, 0.1)');
        attGradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

        if (attendanceChart) {
            attendanceChart.destroy();
        }

        attendanceChart = new Chart(ctxAttendance, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sesi Kehadiran',
                    data: data,
                    borderColor: '#10367D',
                    borderWidth: 3,
                    backgroundColor: attGradient,
                    fill: true,
                    tension: 0.1,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10367D',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11,
                                weight: '600'
                            },
                            color: '#64748B'
                        },
                        grid: {
                            color: '#F1F5F9'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 11,
                                weight: 'bold'
                            },
                            color: '#64748B'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Initial load
    if (window.attendanceData) {
        initChart(window.attendanceData.labels, window.attendanceData.data);
    }

    function toggleWeekSelector(filter) {
        if (weekSelector) {
            if (filter === 'minggu') {
                weekSelector.classList.remove('hidden');
            } else {
                weekSelector.classList.add('hidden');
            }
        }
    }

    if (window.initialFilter) {
        toggleWeekSelector(window.initialFilter);
    }

    function fetchData(filter, week = null) {
        if (loadingOverlay) loadingOverlay.classList.remove('hidden');

        let url = `${window.routes.dashboard}?filter=${filter}`;
        if (filter === 'minggu' && week) {
            url += `&week=${week}`;
        }

        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                initChart(data.labels, data.data);
                if (loadingOverlay) loadingOverlay.classList.add('hidden');
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
                if (loadingOverlay) loadingOverlay.classList.add('hidden');
            });
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');

            filterButtons.forEach(b => {
                b.classList.remove('bg-white', 'text-primary', 'shadow-sm',
                    'border', 'border-gray-100');
                b.classList.add('text-slate-400', 'hover:text-slate-600');
            });
            this.classList.add('bg-white', 'text-primary', 'shadow-sm', 'border',
                'border-gray-100');
            this.classList.remove('text-slate-400', 'hover:text-slate-600');

            toggleWeekSelector(filter);

            let weekVal = null;
            if (filter === 'minggu' && weekSelector) {
                weekVal = weekSelector.value;
            }
            fetchData(filter, weekVal);
        });
    });

    if (weekSelector) {
        weekSelector.addEventListener('change', function() {
            fetchData('minggu', this.value);
        });
    }

    // Gauge Chart
    const ctxGauge = document.getElementById('gaugeChart')?.getContext('2d');
    if (ctxGauge && window.performanceScore !== undefined) {
        new Chart(ctxGauge, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [window.performanceScore, Math.max(0, 100 - window.performanceScore)],
                    backgroundColor: ['#10367D', '#F1F5F9'],
                    borderWidth: 0,
                    circumference: 180,
                    rotation: -90,
                    cutout: '80%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        enabled: false
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }
});

