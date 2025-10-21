@if(auth('admin')->user()->can('view-yearly-active-users-widget'))
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Yearly Active Users</p>
        <div class="flex items-center">
            <i class="fas fa-calendar text-xl mr-3 text-indigo-600 dark:text-indigo-400"></i>
            @php
                $yearlyUsers = DB::table('sessions')
                    ->whereNotNull('user_id')
                    ->where('last_activity', '>=', now()->subYear()->timestamp)
                    ->distinct('user_id')
                    ->count();
                    
                // Get monthly active users for last 12 months
                $chartData = [];
                for ($i = 11; $i >= 0; $i--) {
                    $monthStart = now()->subMonths($i)->startOfMonth();
                    $monthEnd = $monthStart->copy()->endOfMonth();
                    
                    $monthlyUsers = DB::table('sessions')
                        ->whereNotNull('user_id')
                        ->whereBetween('last_activity', [$monthStart->timestamp, $monthEnd->timestamp])
                        ->distinct('user_id')
                        ->count();
                    $chartData[] = $monthlyUsers;
                }
            @endphp
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-widget="yearly-users">{{ $yearlyUsers }}</p>
        </div>
        
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            <i class="fas fa-calendar-check text-indigo-500 text-xs"></i> 
            Last 365 days
        </p>
    </div>
    
    <div class="h-8">
        <canvas id="yearlyUsersChart" class="w-full h-full"></canvas>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('yearlyUsersChart');
    if (canvas) {
        const chartData = @json($chartData);
        
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', '', '', '', '', '', ''],
                datasets: [{
                    data: chartData,
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
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