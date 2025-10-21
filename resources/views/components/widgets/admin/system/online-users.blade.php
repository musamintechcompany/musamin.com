@if(auth('admin')->user()->can('view-online-users-widget'))
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Online Users</p>
        <div class="flex items-center">
            <i class="fas fa-circle text-xl mr-3 text-green-600 dark:text-green-400"></i>
            @php
                $onlineUsers = DB::table('sessions')
                    ->whereNotNull('user_id')
                    ->where('last_activity', '>=', now()->subMinutes(5)->timestamp)
                    ->distinct('user_id')
                    ->count();
                    
                // Get hourly online users data for today
                $chartData = [];
                $currentHour = now()->hour;
                for ($hour = 0; $hour <= $currentHour; $hour++) {
                    $hourStart = now()->startOfDay()->addHours($hour);
                    $hourEnd = $hourStart->copy()->addHour();
                    
                    $hourlyUsers = DB::table('sessions')
                        ->whereNotNull('user_id')
                        ->whereBetween('last_activity', [$hourStart->timestamp, $hourEnd->timestamp])
                        ->distinct('user_id')
                        ->count();
                    $chartData[] = $hourlyUsers;
                }
            @endphp
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-widget="online-users">{{ $onlineUsers }}</p>
        </div>
        
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            <i class="fas fa-circle text-green-500 text-xs animate-pulse"></i> 
            Active now
        </p>
    </div>
    
    <div class="h-8">
        <canvas id="onlineUsersChart" class="w-full h-full"></canvas>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('onlineUsersChart');
    if (canvas) {
        const chartData = @json($chartData);
        const currentHour = {{ now()->hour }};
        
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: chartData.map((_, i) => `${i}:00`),
                datasets: [{
                    data: chartData,
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
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