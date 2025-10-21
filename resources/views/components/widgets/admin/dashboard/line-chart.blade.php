@if(auth('admin')->user()->can('view-line-chart'))
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">System Analytics</h3>
            <div class="flex space-x-2">
                <select id="lineChartPeriod" class="text-sm border-gray-300 rounded-md">
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                    <option value="90">Last 3 Months</option>
                    <option value="180">Last 6 Months</option>
                    <option value="365">Last 1 Year</option>
                </select>
            </div>
        </div>
        <div class="relative h-80">
            <canvas id="systemLineChart"></canvas>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load Chart.js if not already loaded
    if (typeof Chart === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
        script.onload = function() {
            initLineChart();
        };
        document.head.appendChild(script);
    } else {
        initLineChart();
    }

    function initLineChart() {
        const ctx = document.getElementById('systemLineChart').getContext('2d');
        let lineChart;

        function loadChartData(period = 30) {
        fetch(`/management/portal/admin/dashboard/line-chart-data?period=${period}`)
            .then(response => response.json())
            .then(data => {
                if (lineChart) {
                    lineChart.destroy();
                }

                lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Users',
                                data: data.users,
                                borderColor: '#3B82F6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4
                            },
                            {
                                label: 'Revenue ($)',
                                data: data.revenue,
                                borderColor: '#10B981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                tension: 0.4
                            },
                            {
                                label: 'Transactions',
                                data: data.transactions,
                                borderColor: '#F59E0B',
                                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                tension: 0.4
                            },
                            {
                                label: 'Assets',
                                data: data.assets,
                                borderColor: '#8B5CF6',
                                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    }

        document.getElementById('lineChartPeriod').addEventListener('change', function() {
            loadChartData(this.value);
        });

        loadChartData();

    }
});
</script>
@endif