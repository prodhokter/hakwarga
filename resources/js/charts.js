import {
    Chart,
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
    DoughnutController,
    ArcElement
} from 'chart.js';

Chart.register(
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
    DoughnutController,
    ArcElement
);

document.addEventListener('DOMContentLoaded', () => {
    // 1. Scorecard Benchmark Bar Chart
    const barCanvas = document.getElementById('sla-benchmark-chart');
    if (barCanvas && window.hwSlaData) {
        new Chart(barCanvas, {
            type: 'bar',
            data: {
                labels: window.hwSlaData.map(d => d.name),
                datasets: [
                    {
                        label: 'Respon <= 72 Jam (%)',
                        data: window.hwSlaData.map(d => d.responseRate),
                        backgroundColor: '#0f766e',
                        borderRadius: 4,
                    },
                    {
                        label: 'Penyelesaian <= 14 Hari (%)',
                        data: window.hwSlaData.map(d => d.resolveRate),
                        backgroundColor: '#6366f1',
                        borderRadius: 4,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: (v) => v + '%',
                            font: { family: 'Inter' }
                        },
                        grid: { color: '#f1f5f9' },
                    },
                    x: {
                        ticks: { font: { family: 'Inter', size: 11 } },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { font: { family: 'Inter', size: 12 } }
                    },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.dataset.label}: ${ctx.raw}%`
                        }
                    }
                }
            }
        });
    }

    // 2. Anomaly Ratio Distribution Doughnut Chart
    const doughnutCanvas = document.getElementById('anomaly-doughnut-chart');
    if (doughnutCanvas && window.hwAnomalyCounts) {
        new Chart(doughnutCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Defisit Kuota (Under)', 'Proporsional', 'Surplus Kuota (Over)'],
                datasets: [{
                    data: [
                        window.hwAnomalyCounts.under,
                        window.hwAnomalyCounts.normal,
                        window.hwAnomalyCounts.over
                    ],
                    backgroundColor: ['#f59e0b', '#10b981', '#6366f1'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { family: 'Inter', size: 11 } }
                    }
                }
            }
        });
    }
});
