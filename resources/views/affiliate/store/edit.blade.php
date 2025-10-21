<x-affiliate-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6 dark:bg-gray-800">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Store</h1>
                    <a href="{{ route('stores') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Store
                    </a>
                </div>

                <form id="editStoreForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Name</label>
                            <input type="text" name="name" value="{{ $store->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store URL</label>
                            <div class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:border-gray-600 dark:bg-gray-600 text-gray-500">
                                {{ config('app.url') }}/{{ $store->slug }}
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Description</label>
                        <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">{{ $store->description }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Select Category</option>
                            <option value="Digital Assets" {{ $store->category == 'Digital Assets' ? 'selected' : '' }}>Digital Assets</option>
                            <option value="Web Templates" {{ $store->category == 'Web Templates' ? 'selected' : '' }}>Web Templates</option>
                            <option value="Mobile Apps" {{ $store->category == 'Mobile Apps' ? 'selected' : '' }}>Mobile Apps</option>
                            <option value="Plugins" {{ $store->category == 'Plugins' ? 'selected' : '' }}>Plugins</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('editStoreForm').onsubmit = async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            
            try {
                const response = await fetch('{{ route("affiliate.store.update") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Store updated successfully!');
                    window.location.href = '{{ route("stores") }}';
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while updating the store.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Save Changes';
            }
        };
    </script>
    @endpush
</x-affiliate-layout>