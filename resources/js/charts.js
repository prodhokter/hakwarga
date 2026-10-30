import {
    Chart,
    BarController,
    BarElement,
    LineController,
    LineElement,
    PointElement,
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
    LineController,
    LineElement,
    PointElement,
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
                        type: 'line',
                        label: 'Target Standar SLA (100%)',
                        data: window.hwSlaData.map(() => 100),
                        borderColor: '#ef4444',
                        borderWidth: 2,
                        borderDash: [6, 6],
                        pointRadius: 0,
                        fill: false,
                        order: 0,
                    },
                    {
                        type: 'bar',
                        label: 'Respon <= 72 Jam (%)',
                        data: window.hwSlaData.map(d => d.responseRate),
                        backgroundColor: '#0f766e',
                        borderRadius: 6,
                        order: 1,
                    },
                    {
                        type: 'bar',
                        label: 'Penyelesaian <= 14 Hari (%)',
                        data: window.hwSlaData.map(d => d.resolveRate),
                        backgroundColor: '#6366f1',
                        borderRadius: 6,
                        order: 2,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 105,
                        ticks: {
                            callback: (v) => v + '%',
                            font: { family: 'Inter', size: 11 }
                        },
                        grid: { color: '#f1f5f9' },
                    },
                    x: {
                        ticks: { font: { family: 'Inter', size: 11, weight: '600' } },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { family: 'Inter', size: 12 },
                            usePointStyle: true,
                            boxWidth: 8,
                        }
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
                        labels: { font: { family: 'Inter', size: 11 }, usePointStyle: true }
                    }
                }
            }
        });
    }
});
