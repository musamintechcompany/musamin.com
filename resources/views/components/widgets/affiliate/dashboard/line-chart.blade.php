@if(auth()->user()->store)
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Store Performance</h3>
            <div class="flex space-x-2">
                <select id="affiliateLineChartPeriod" class="text-sm border-gray-300 rounded-md">
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                    <option value="90">Last 3 Months</option>
                </select>
            </div>
        </div>
        <div class="relative h-80">
            <canvas id="affiliateLineChart"></canvas>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Chart === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
        script.onload = function() {
            initAffiliateLineChart();
        };
        document.head.appendChild(script);
    } else {
        initAffiliateLineChart();
    }

    function initAffiliateLineChart() {
        const ctx = document.getElementById('affiliateLineChart').getContext('2d');
        let lineChart;

        function loadChartData(period = 30) {
            fetch(`/affiliate/dashboard/line-chart-data?period=${period}`)
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
                                    label: 'Store Visits',
                                    data: data.visits,
                                    borderColor: '#3B82F6',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
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

        document.getElementById('affiliateLineChartPeriod').addEventListener('change', function() {
            loadChartData(this.value);
        });

        loadChartData();
    }
});
</script>
@endif