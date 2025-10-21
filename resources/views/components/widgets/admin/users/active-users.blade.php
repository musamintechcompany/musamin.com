@if(auth('admin')->user()->can('view-active-users-widget'))
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Active Users</p>
        <div class="flex items-center">
            <i class="fas fa-user-check text-xl mr-3 text-green-600 dark:text-green-400"></i>
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-widget="active-users">{{ \App\Models\User::where('status', 'active')->count() }}</p>
        </div>
        
        @php
            $current = \App\Models\User::where('status', 'active')->count();
            $lastWeek = \App\Models\User::where('status', 'active')->where('created_at', '<', now()->subWeek())->count();
            $growth = $lastWeek > 0 ? (($current - $lastWeek) / $lastWeek) * 100 : 0;
        @endphp
        
        <p class="text-xs {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1" data-growth="active-users">
            @if($growth > 0)
                <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i> +{{ number_format(abs($growth), 1) }}%
            @else
                <i class="fas fa-arrow-down text-red-500 text-xs mr-1"></i> {{ number_format($growth, 1) }}%
            @endif
        </p>
    </div>
    
    <div class="h-8">
        <canvas id="activeUsersChart" class="w-full h-full"></canvas>
    </div>
</div>

@php
    $activeChartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i);
        $activeChartData[] = \App\Models\User::where('status', 'active')->whereDate('created_at', $date)->count();
    }
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('activeUsersChart');
    if (canvas) {
        const chartData = @json($activeChartData);
        const displayData = chartData.every(val => val === 0) ? [1, 1, 1, 1, 1, 1, 1] : chartData;
        
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', ''],
                datasets: [{
                    data: displayData,
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
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