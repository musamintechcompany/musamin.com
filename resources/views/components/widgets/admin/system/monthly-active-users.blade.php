@if(auth('admin')->user()->can('view-monthly-active-users-widget'))
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Monthly Active Users</p>
        <div class="flex items-center">
            <i class="fas fa-chart-line text-xl mr-3 text-orange-600 dark:text-orange-400"></i>
            @php
                $monthlyUsers = DB::table('sessions')
                    ->whereNotNull('user_id')
                    ->where('last_activity', '>=', now()->subDays(30)->timestamp)
                    ->distinct('user_id')
                    ->count();
                    
                // Get weekly active users for last 4 weeks
                $chartData = [];
                for ($i = 3; $i >= 0; $i--) {
                    $weekStart = now()->subWeeks($i)->startOfWeek();
                    $weekEnd = $weekStart->copy()->endOfWeek();
                    
                    $weeklyUsers = DB::table('sessions')
                        ->whereNotNull('user_id')
                        ->whereBetween('last_activity', [$weekStart->timestamp, $weekEnd->timestamp])
                        ->distinct('user_id')
                        ->count();
                    $chartData[] = $weeklyUsers;
                }
            @endphp
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-widget="monthly-users">{{ $monthlyUsers }}</p>
        </div>
        
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            <i class="fas fa-calendar-alt text-orange-500 text-xs"></i> 
            Last 30 days
        </p>
    </div>
    
    <div class="h-8">
        <canvas id="monthlyUsersChart" class="w-full h-full"></canvas>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('monthlyUsersChart');
    if (canvas) {
        const chartData = @json($chartData);
        
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['', '', '', ''],
                datasets: [{
                    data: chartData,
                    borderColor: '#EA580C',
                    backgroundColor: 'rgba(234, 88, 12, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { display: false }, y: { display: false } },
                elements: { point: { radius: 0 } }
            }
        });
    }
});
</script>
@endpush
@endif