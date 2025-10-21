<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Monthly Revenue</p>
        <div class="flex items-center">
            <i class="fas fa-calendar-alt text-xl mr-3 text-blue-600 dark:text-blue-400"></i>
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-widget="monthly-revenue">$0.00</p>
        </div>
        
        @php
            $current = 0;
            $lastMonth = 0;
            $growth = 0;
        @endphp
        
        <p class="text-xs {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1" data-growth="monthly-revenue">
            @if($growth > 0)
                <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i> +{{ number_format(abs($growth), 1) }}%
            @else
                <i class="fas fa-arrow-down text-red-500 text-xs mr-1"></i> {{ number_format($growth, 1) }}%
            @endif
        </p>
    </div>
    
    <div class="h-8">
        <canvas id="monthlyRevenueChart" class="w-full h-full"></canvas>
    </div>
</div>

@php
    $chartData = [0, 0, 0, 0, 0, 0, 0];
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('monthlyRevenueChart');
    if (canvas) {
        const chartData = @json($chartData);
        const displayData = chartData.every(val => val === 0) ? [1, 1, 1, 1, 1, 1, 1] : chartData;
        
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', ''],
                datasets: [{
                    data: displayData,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
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