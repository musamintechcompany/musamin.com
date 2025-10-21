<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Store Visits</p>
        <div class="flex items-center">
            <i class="fas fa-eye text-xl mr-3 text-blue-600 dark:text-blue-400"></i>
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-widget="store-visits">{{ number_format(auth()->user()->store->visits_count ?? 0) }}</p>
        </div>
        
        @php
            $store = auth()->user()->store;
            $current = $store ? $store->visits_count : 0;
            // Since we don't have historical data yet, show 0% growth
            $lastWeek = 0;
            $growth = 0;
        @endphp
        
        <p class="text-xs {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1" data-growth="store-visits">
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

async function updateStoreVisits() {
    try {
        const response = await fetch('{{ route("affiliate.store.stats") }}', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            const visitsElement = document.querySelector('[data-widget="store-visits"]');
            if (visitsElement) {
                visitsElement.textContent = new Intl.NumberFormat().format(result.stats.visits_count);
            }
        }
    } catch (error) {
        console.error('Error updating store visits:', error);
    }
}

@if(auth()->user()->store)
setInterval(updateStoreVisits, 30000);
@endif
</script>
@endpush