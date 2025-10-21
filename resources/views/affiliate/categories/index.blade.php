<x-affiliate-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">All Categories</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Manage all your store categories</p>
            </div>

            <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Categories ({{ $categories->count() }})</h3>
                    <button id="addCategoryBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <i class="fas fa-plus mr-2"></i>Add Category
                    </button>
                </div>
                
                @if($categories->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($categories as $category)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $category->name }}</h4>
                                    @if($category->description)
                                    <p class="text-sm text-gray-500 mt-1">{{ $category->description }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-2">{{ $category->products()->count() }} products</p>
                                </div>
                                <button onclick="deleteCategory('{{ $category->id }}', '{{ $category->name }}')" class="text-red-500 hover:text-red-700 ml-2">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-tags text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 text-sm mb-4">No categories yet</p>
                        <button onclick="document.getElementById('addCategoryBtn').click()" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                            Create your first category
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full dark:bg-gray-800">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Category</h3>
                </div>
                
                <form id="categoryForm" method="POST" action="{{ route('affiliate.store.categories.store') }}" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                        <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <button type="button" id="cancelCategoryBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                        <button type="submit" id="categorySubmitBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div id="deleteCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full dark:bg-gray-800">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-trash text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Delete Category</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">This action cannot be undone</p>
                        </div>
                    </div>
                    
                    <p class="text-gray-700 dark:text-gray-300 mb-6">Are you sure you want to delete "<span id="deleteCategoryName" class="font-medium"></span>"?</p>
                    
                    <div class="flex justify-end space-x-4">
                        <button type="button" id="cancelCategoryDeleteBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                        <button type="button" id="confirmCategoryDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Delete Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addCategoryBtn = document.getElementById('addCategoryBtn');
            const addCategoryModal = document.getElementById('addCategoryModal');
            const cancelCategoryBtn = document.getElementById('cancelCategoryBtn');

            if (addCategoryBtn) {
                addCategoryBtn.onclick = () => addCategoryModal?.classList.remove('hidden');
            }

            if (cancelCategoryBtn) {
                cancelCategoryBtn.onclick = () => addCategoryModal?.classList.add('hidden');
            }

            if (addCategoryModal) {
                addCategoryModal.onclick = (e) => {
                    if (e.target === addCategoryModal) addCategoryModal.classList.add('hidden');
                };
            }

            // Handle category form submission
            const categoryForm = document.getElementById('categoryForm');
            if (categoryForm) {
                categoryForm.onsubmit = function(e) {
                    const submitBtn = document.getElementById('categorySubmitBtn');
                    const originalText = submitBtn.innerHTML;
                    
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
                };
            }

            // Delete category modal
            const deleteCategoryModal = document.getElementById('deleteCategoryModal');
            const cancelCategoryDeleteBtn = document.getElementById('cancelCategoryDeleteBtn');
            
            if (cancelCategoryDeleteBtn) {
                cancelCategoryDeleteBtn.onclick = () => deleteCategoryModal?.classList.add('hidden');
            }
            
            if (deleteCategoryModal) {
                deleteCategoryModal.onclick = (e) => {
                    if (e.target === deleteCategoryModal) deleteCategoryModal.classList.add('hidden');
                };
            }

            // Delete category function
            window.deleteCategory = function(categoryId, categoryName) {
                const modal = document.getElementById('deleteCategoryModal');
                const categoryNameSpan = document.getElementById('deleteCategoryName');
                const confirmBtn = document.getElementById('confirmCategoryDeleteBtn');
                
                categoryNameSpan.textContent = categoryName;
                modal.classList.remove('hidden');
                
                confirmBtn.onclick = function() {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('affiliate.store.categories.index') }}/${categoryId}`;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                };
            };
        });
    </script>
    @endpush
</x-affiliate-layout>