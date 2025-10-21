<x-admin-layout title="Payment Methods">
<div class="p-6">
    <div class="flex flex-col sm:flex-row lg:justify-between lg:items-center mb-6 gap-4">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Payment Methods</h1>
        <div class="relative group">
            <a href="{{ route('admin.payment-methods.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 lg:px-6 lg:py-3 rounded-lg text-center transition-colors">
                <i class="fas fa-plus mr-2"></i>Add Method
            </a>
            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                Add New Payment Method
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($paymentMethods->count() > 0)
            <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs lg:text-sm font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Method</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs lg:text-sm font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Type</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs lg:text-sm font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Details</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs lg:text-sm font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Status</th>
                        <th class="px-4 lg:px-6 py-3 text-left text-xs lg:text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($paymentMethods as $method)
                    <tr>
                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap border-r border-gray-200">
                            <div class="flex items-center">
                                <i class="fas fa-credit-card text-base lg:text-lg mr-2 lg:mr-3 text-blue-600"></i>
                                <div>
                                    <div class="text-xs lg:text-sm font-medium text-gray-900">{{ $method->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $method->type }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap border-r border-gray-200">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($method->type) }}
                            </span>
                        </td>
                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap border-r border-gray-200">
                            <div class="text-xs lg:text-sm text-gray-900">
                                @if($method->details && is_array($method->details))
                                    {{ count($method->details) }} details configured
                                @else
                                    No details
                                @endif
                            </div>
                        </td>
                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap border-r border-gray-200">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $method->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $method->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-xs lg:text-sm font-medium">
                            <div class="flex flex-wrap gap-2">
                                <div class="relative group">
                                    <a href="{{ route('admin.payment-methods.edit', $method) }}" class="inline-flex items-center px-2 py-1 lg:px-3 lg:py-2 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 transition-colors">
                                        <i class="fas fa-edit text-xs lg:text-sm"></i>
                                    </a>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                                        Edit Method
                                    </div>
                                </div>
                                <div class="relative group">
                                    <button type="button" class="inline-flex items-center px-2 py-1 lg:px-3 lg:py-2 bg-red-100 text-red-700 rounded hover:bg-red-200 transition-colors" onclick="confirmDelete('{{ $method->name }}', '{{ route('admin.payment-methods.destroy', $method) }}')">
                                        <i class="fas fa-trash text-xs lg:text-sm"></i>
                                    </button>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                                        Delete Method
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $paymentMethods->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-credit-card text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No payment methods found</h3>
                <p class="text-gray-500 mb-4">Get started by adding your first payment method.</p>
                <div class="relative group">
                    <a href="{{ route('admin.payment-methods.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Method
                    </a>
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none whitespace-nowrap z-50">
                        Add New Payment Method
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
function confirmDelete(methodName, url) {
    if (confirm(`Are you sure you want to delete "${methodName}"? This action cannot be undone.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

</x-admin-layout>