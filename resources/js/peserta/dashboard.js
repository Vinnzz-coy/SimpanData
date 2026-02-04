document.addEventListener('DOMContentLoaded', function() {
    let attendanceChart;
    const ctxAttendance = document.getElementById('attendanceChart')?.getContext('2d');
    const loadingOverlay = document.getElementById('chartLoading');

    if (!ctxAttendance) return;

    function initChart(labels, data) {
        const attGradient = ctxAttendance.createLinearGradient(0, 0, 0, 400);
        attGradient.addColorStop(0, 'rgba(16, 54, 125, 0.2)');
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
                    tension: 0.4, // Smoother curve
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10367D',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#10367D',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.9)',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `Kehadiran: ${context.parsed.y} Sesi`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: { size: 11, weight: '600' },
                            color: '#64748B'
                        },
                        grid: {
                            color: '#F1F5F9',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 11, weight: '600' },
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

    // Initial load from window data (passed from blade)
    if (window.attendanceData) {
        initChart(window.attendanceData.labels, window.attendanceData.data);
    }

    // AJAX Filtering Logic
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');

            // Update UI active state
            filterButtons.forEach(b => {
                b.classList.remove('bg-white', 'text-primary', 'shadow-sm', 'border-gray-100');
                b.classList.add('text-slate-500', 'hover:text-slate-700');
            });
            this.classList.add('bg-white', 'text-primary', 'shadow-sm', 'border-gray-100');
            this.classList.remove('text-slate-500', 'hover:text-slate-700');

            // Show loading
            if (loadingOverlay) loadingOverlay.classList.remove('hidden');

            // Fetch data
            fetch(`${window.routes.dashboard}?filter=${filter}`, {
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
        });
    });

    // Speedometer Chart
    const ctxGauge = document.getElementById('gaugeChart')?.getContext('2d');
    if (ctxGauge && window.performanceScore !== undefined) {
        const score = window.performanceScore;
        
        // Dynamic color based on score
        const getScoreColor = (s) => {
            if (s >= 80) return '#10B981'; // green-500
            if (s >= 60) return '#3B82F6'; // blue-500
            if (s >= 40) return '#F59E0B'; // amber-500
            return '#EF4444'; // red-500
        };

        new Chart(ctxGauge, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [score, Math.max(0, 100 - score)],
                    backgroundColor: [getScoreColor(score), '#F1F5F9'],
                    borderWidth: 0,
                    circumference: 180,
                    rotation: -90,
                    cutout: '85%',
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: { enabled: false }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }
});
