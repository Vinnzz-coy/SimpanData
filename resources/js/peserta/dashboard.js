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

    const ctxDonut = document.getElementById('attendanceDonutChart')?.getContext('2d');
    if (ctxDonut && window.attendanceBreakdown) {
        const leaderLinesPlugin = {
            id: 'leaderLines',
            afterDatasetsDraw: (chart) => {
                const { ctx } = chart;
                chart.data.datasets.forEach((dataset, i) => {
                    chart.getDatasetMeta(i).data.forEach((datapoint, index) => {
                        const { x, y, startAngle, endAngle, outerRadius } = datapoint;
                        const value = chart.data.datasets[i].data[index];
                        if (value === 0) return; 
                        const midAngle = (startAngle + endAngle) / 2;
                        const isRightSide = Math.cos(midAngle) >= 0;
                        
                        const startX = x + Math.cos(midAngle) * outerRadius;
                        const startY = y + Math.sin(midAngle) * outerRadius;
                        
                        const bendX = x + Math.cos(midAngle) * (outerRadius + 20);
                        const bendY = y + Math.sin(midAngle) * (outerRadius + 20);
                        
                        const lineLength = 30;
                        const endX = bendX + (isRightSide ? lineLength : -lineLength);
                        const endY = bendY;

                        const color = dataset.backgroundColor[index];
                        ctx.strokeStyle = color;
                        ctx.lineWidth = 1.5;
                        ctx.lineCap = 'round';
                        ctx.lineJoin = 'round';

                        ctx.beginPath();
                        ctx.moveTo(startX, startY);
                        ctx.lineTo(bendX, bendY);
                        ctx.lineTo(endX, endY);
                        ctx.stroke();

                        ctx.beginPath();
                        ctx.fillStyle = color;
                        ctx.arc(startX, startY, 3, 0, 2 * Math.PI);
                        ctx.fill();
                        // 3. Draw text (The count)
                        ctx.font = '700 13px "Inter", "Plus Jakarta Sans", sans-serif';
                        ctx.fillStyle = '#1E293B';
                        ctx.shadowColor = 'rgba(255, 255, 255, 0.8)';
                        ctx.shadowBlur = 4;
                        ctx.textAlign = isRightSide ? 'left' : 'right';
                        ctx.textBaseline = 'middle';
                        
                        const textPadding = 10;
                        const textX = endX + (isRightSide ? textPadding : -textPadding);
                        ctx.fillText(value, textX, endY);
                        
                        // Reset shadow for next draws
                        ctx.shadowBlur = 0;
                    });
                });
            }
        };

        new Chart(ctxDonut, {
            type: 'doughnut',
            plugins: [leaderLinesPlugin],
            data: {
                labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
                datasets: [{
                    data: [
                        window.attendanceBreakdown.Hadir,
                        window.attendanceBreakdown.Izin,
                        window.attendanceBreakdown.Sakit,
                        window.attendanceBreakdown.Alpha
                    ],
                    backgroundColor: ['#3B82F6', '#EAB308', '#EF4444', '#94A3B8'],
                    hoverBackgroundColor: ['#2563EB', '#CA8A04', '#DC2626', '#64748B'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    spacing: 4,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 15,
                        bottom: 15,
                        left: 35,
                        right: 35
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#1E293B',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 12 },
                        callbacks: {
                            label: function(context) {
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return ` ${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500,
                    easing: 'easeOutQuart'
                }
            }
        });
    }
});

