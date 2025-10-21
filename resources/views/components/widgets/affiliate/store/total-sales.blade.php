<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Sales</p>
        <div class="flex items-center">
            <i class="fas fa-dollar-sign text-xl mr-3 text-green-600 dark:text-green-400"></i>
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-widget="total-sales">$0.00</p>
        </div>
        
        @php
            $store = auth()->user()->store;
            $totalSales = 0; // Will be calculated from actual orders
            $growth = 0; // Will be calculated from previous period
        @endphp
        
        <p class="text-xs {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1" data-growth="total-sales">
            @if($growth > 0)
                <i class="fas fa-arrow-up text-green-500 text-xs mr-1"></i> +{{ number_format(abs($growth), 1) }}%
            @elseif($growth < 0)
                <i class="fas fa-arrow-down text-red-500 text-xs mr-1"></i> {{ number_format($growth, 1) }}%
            @else
                <i class="fas fa-minus text-gray-500 text-xs mr-1"></i> No change
            @endif
        </p>
    </div>
</div>

@push('scripts')
<script>
async function updateTotalSales() {
    try {
        const response = await fetch('{{ route("affiliate.store.stats") }}', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            const salesElement = document.querySelector('[data-widget="total-sales"]');
            if (salesElement) {
                salesElement.textContent = '$' + new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(result.stats.total_sales);
            }
        }
    } catch (error) {
        console.error('Error updating total sales:', error);
    }
}

@if(auth()->user()->store)
setInterval(updateTotalSales, 30000);
@endif
</script>
@endpush