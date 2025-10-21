@if(auth('admin')->user()->can('view-pie-chart'))
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">System Distribution</h3>
            <div class="flex space-x-2">
                <select id="pieChartType" class="text-sm border-gray-300 rounded-md">
                    <option value="users" selected>User Types</option>
                    <option value="assets">Asset Categories</option>
                    <option value="transactions">Transaction Types</option>
                    <option value="revenue">Revenue Sources</option>
                </select>
            </div>
        </div>
        <div class="relative h-80">
            <canvas id="systemPieChart"></canvas>
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
            initPieChart();
        };
        document.head.appendChild(script);
    } else {
        initPieChart();
    }

    function initPieChart() {
        const ctx = document.getElementById('systemPieChart').getContext('2d');
        let pieChart;

        function loadChartData(type = 'users') {
            fetch(`/management/portal/admin/dashboard/pie-chart-data?type=${type}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    if (pieChart) {
                        pieChart.destroy();
                    }

                    if (!data.labels || !data.values || data.labels.length === 0) {
                        console.error('Invalid chart data:', data);
                        return;
                    }

                    pieChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.values,
                                backgroundColor: [
                                    '#3B82F6',
                                    '#10B981',
                                    '#F59E0B',
                                    '#EF4444',
                                    '#8B5CF6',
                                    '#EC4899',
                                    '#14B8A6',
                                    '#F97316'
                                ],
                                borderWidth: 2,
                                borderColor: '#ffffff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                                            return `${context.label}: ${context.parsed} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Pie chart error:', error);
                });
    }

        document.getElementById('pieChartType').addEventListener('change', function() {
            loadChartData(this.value);
        });

        loadChartData();

    }
});
</script>
@endif