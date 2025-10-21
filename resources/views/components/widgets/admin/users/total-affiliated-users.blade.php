@if(auth('admin')->user()->can('view-total-affiliated-users-widget'))
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Affiliated Users</p>
        <div class="flex items-center">
            <i class="fas fa-handshake text-xl mr-3 text-emerald-600 dark:text-emerald-400"></i>
            @php
                $totalAffiliates = DB::table('affiliates')
                    ->where('status', 'active')
                    ->where('expires_at', '>', now())
                    ->count();
                    
                // Get monthly affiliate registrations for last 6 months
                $chartData = [];
                for ($i = 5; $i >= 0; $i--) {
                    $monthStart = now()->subMonths($i)->startOfMonth();
                    $monthEnd = $monthStart->copy()->endOfMonth();
                    
                    $monthlyAffiliates = DB::table('affiliates')
                        ->whereBetween('joined_at', [$monthStart, $monthEnd])
                        ->count();
                    $chartData[] = $monthlyAffiliates;
                }
            @endphp
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-widget="total-affiliates">{{ number_format($totalAffiliates) }}</p>
        </div>
        
        @php
            $thisMonth = DB::table('affiliates')
                ->whereMonth('joined_at', now()->month)
                ->whereYear('joined_at', now()->year)
                ->count();
            $lastMonth = DB::table('affiliates')
                ->whereMonth('joined_at', now()->subMonth()->month)
                ->whereYear('joined_at', now()->subMonth()->year)
                ->count();
            $growth = $lastMonth > 0 ? (($thisMonth - $lastMonth) / $lastMonth) * 100 : ($thisMonth > 0 ? 100 : 0);
        @endphp
        
        <p class="text-xs {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">
            @if($growth > 0)
                <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i> +{{ number_format(abs($growth), 1) }}%
            @elseif($growth < 0)
                <i class="fas fa-arrow-down text-red-500 text-xs mr-1"></i> {{ number_format($growth, 1) }}%
            @else
                <i class="fas fa-minus text-gray-500 text-xs mr-1"></i> 0%
            @endif
            vs last month
        </p>
    </div>
    
    <div class="h-8">
        <canvas id="totalAffiliatesChart" class="w-full h-full"></canvas>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('totalAffiliatesChart');
    if (canvas) {
        const chartData = @json($chartData);
        
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', ''],
                datasets: [{
                    data: chartData,
                    borderColor: '#059669',
                    backgroundColor: 'rgba(5, 150, 105, 0.2)',
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