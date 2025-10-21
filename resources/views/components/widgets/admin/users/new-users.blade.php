@if(auth('admin')->user()->can('view-new-users-widget'))
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">New Today</p>
        <div class="flex items-center">
            <i class="fas fa-user-plus text-xl mr-3 text-yellow-600 dark:text-yellow-400"></i>
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-stat="New Today">{{ \App\Models\User::whereDate('created_at', today())->count() }}</p>
        </div>
        
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Registered today
        </p>
    </div>
    
    <div class="h-8">
        <canvas id="newUsersChart" class="w-full h-full"></canvas>
    </div>
</div>

@php
    $newUsersChartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i);
        $newUsersChartData[] = \App\Models\User::whereDate('created_at', $date)->count();
    }
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('newUsersChart');
    if (canvas) {
        const chartData = @json($newUsersChartData);
        const displayData = chartData.every(val => val === 0) ? [1, 1, 1, 1, 1, 1, 1] : chartData;
        
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', ''],
                datasets: [{
                    data: displayData,
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245, 158, 11, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 0,
                    pointHoverRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: { enabled: false }
                },
                scales: { 
                    x: { display: false }, 
                    y: { display: false } 
                },
                elements: {
                    point: { radius: 0 }
                }
            }
        });
    }
});
</script>
@endpush
@endif