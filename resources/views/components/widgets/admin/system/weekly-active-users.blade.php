@if(auth('admin')->user()->can('view-weekly-active-users-widget'))
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Weekly Active Users</p>
        <div class="flex items-center">
            <i class="fas fa-users text-xl mr-3 text-purple-600 dark:text-purple-400"></i>
            @php
                $weeklyUsers = DB::table('sessions')
                    ->whereNotNull('user_id')
                    ->where('last_activity', '>=', now()->subDays(7)->timestamp)
                    ->distinct('user_id')
                    ->count();
                    
                // Get daily active users for last 7 days
                $chartData = [];
                for ($i = 6; $i >= 0; $i--) {
                    $date = now()->subDays($i);
                    $dailyUsers = DB::table('sessions')
                        ->whereNotNull('user_id')
                        ->whereDate('last_activity', $date->format('Y-m-d'))
                        ->distinct('user_id')
                        ->count();
                    $chartData[] = $dailyUsers;
                }
            @endphp
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-widget="weekly-users">{{ $weeklyUsers }}</p>
        </div>
        
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            <i class="fas fa-calendar-week text-purple-500 text-xs"></i> 
            Last 7 days
        </p>
    </div>
    
    <div class="h-8">
        <canvas id="weeklyUsersChart" class="w-full h-full"></canvas>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('weeklyUsersChart');
    if (canvas) {
        const chartData = @json($chartData);
        
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', ''],
                datasets: [{
                    data: chartData,
                    borderColor: '#7C3AED',
                    backgroundColor: 'rgba(124, 58, 237, 0.2)',
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