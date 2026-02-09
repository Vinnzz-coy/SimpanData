document.addEventListener('DOMContentLoaded', function () {
    const data = window.dashboardData;


    // ===== CHART PIE PESERTA =====
    const pieCanvas = document.getElementById('salesPieChart');
    if (pieCanvas) {
        const leaderLinesPlugin = {
            id: 'leaderLines',
            afterDraw: (chart) => {
                const { ctx, data, chartArea: { width, height } } = chart;

                data.datasets.forEach((dataset, i) => {
                    chart.getDatasetMeta(i).data.forEach((datapoint, index) => {
                        const { x, y } = datapoint.tooltipPosition();

                        if (dataset.data[index] === 0) return;

                        const label = data.labels[index];
                        const value = dataset.data[index];
                        const color = dataset.backgroundColor[index];

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

                        // Draw line
                        ctx.beginPath();
                        ctx.moveTo(x, y);
                        ctx.lineTo(endX, endY);
                        ctx.strokeStyle = color;
                        ctx.lineWidth = 2;
                        ctx.stroke();

                        // Draw text
                        const text = `${label}: ${value}`;
                        ctx.font = 'bold 12px Inter, sans-serif';
                        ctx.textAlign = textAlign;
                        ctx.textBaseline = 'middle';
                        ctx.fillStyle = '#1f2937';
                        ctx.fillText(text, textX, endY);
                    });
                });
            }
        };

        new Chart(pieCanvas, {
            type: 'doughnut',
            data: {
                labels: ['PKL', 'Magang'],
                datasets: [{
                    data: [data.totalPkl || 0, data.totalMagang || 0],
                    backgroundColor: ['#4f46e5', '#f59e0b'],
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
                        display: true,
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            font: { size: 12 }
                        }
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
                    duration: 1500,
                    easing: 'easeOutQuart'
                }
            },
            plugins: [leaderLinesPlugin]
        });
    }

    // ===== CHART BAR SEKOLAH =====
    const ctxSekolah = document.getElementById('sekolahChart');
    if (ctxSekolah && data.pesertaSekolah) {
        const sekolahData = data.pesertaSekolah;
        const labels = sekolahData.map(item => item.asal_sekolah_universitas);
        const totals = sekolahData.map(item => item.total);

        const maxValue = Math.max(...totals, 10);
        const stepSize = maxValue <= 10 ? 1 : 2;

        const wrapper = document.getElementById('chartWrapper');
        if (wrapper) {
            const count = parseInt(wrapper.dataset.count) || labels.length;
            wrapper.style.minWidth = (count * 120) + 'px';
        }

        const valueLabelPlugin = {
            id: 'valueLabel',
            afterDatasetsDraw(chart) {
                const { ctx } = chart;
                chart.data.datasets.forEach((dataset, i) => {
                    const meta = chart.getDatasetMeta(i);
                    meta.data.forEach((bar, index) => {
                        ctx.save();
                        ctx.fillStyle = '#374151';
                        ctx.font = 'bold 12px sans-serif';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillText(
                            dataset.data[index],
                            bar.x,
                            bar.y - 5
                        );
                        ctx.restore();
                    });
                });
            }
        };

        new Chart(ctxSekolah, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Peserta',
                    data: totals,
                    backgroundColor: '#4f46e5',
                    borderColor: '#4338ca',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 30,
                            font: { size: 11 }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: stepSize,
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 10,
                        cornerRadius: 6
                    }
                }
            },
            plugins: [valueLabelPlugin]
        });

    }

});
