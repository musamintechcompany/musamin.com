@if(auth('admin')->user()->can('view-admins-widget'))
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Admins</p>
        <div class="flex items-center">
            <i class="fas fa-user-shield text-xl mr-3 text-purple-600 dark:text-purple-400"></i>
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-widget="total-admins">{{ \App\Models\Admin::count() }}</p>
        </div>
        
        @php
            $current = \App\Models\Admin::count();
            $lastWeek = \App\Models\Admin::where('created_at', '<', now()->subWeek())->count();
            $growth = $lastWeek > 0 ? (($current - $lastWeek) / $lastWeek) * 100 : 0;
        @endphp
        
        <p class="text-xs {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1" data-growth="Total Admins">
            @if($growth > 0)
                <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i> +{{ number_format(abs($growth), 1) }}%
            @else
                <i class="fas fa-arrow-down text-red-500 text-xs mr-1"></i> {{ number_format($growth, 1) }}%
            @endif
        </p>
    </div>
    
    <div class="h-8">
        <canvas id="totalAdminsChart" class="w-full h-full"></canvas>
    </div>
</div>

@php
    $adminChartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i);
        $adminChartData[] = \App\Models\Admin::whereDate('created_at', $date)->count();
    }
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('totalAdminsChart');
    if (canvas) {
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['7d ago', '6d ago', '5d ago', '4d ago', '3d ago', '2d ago', 'Today'],
                datasets: [{
                    data: @json($adminChartData),
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.3)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { display: false }, y: { display: false } }
            }
        });
    }
});
</script>
@endpush
@endif