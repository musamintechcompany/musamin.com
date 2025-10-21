<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Country') }}
            </h2>
            <a href="{{ route('admin.countries.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Countries
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800">
                    <form action="{{ route('admin.countries.update', $country) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $country->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country Code</label>
                                <input type="text" name="code" id="code" value="{{ old('code', $country->code) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" maxlength="3" required>
                                @error('code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="flag" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Flag Emoji</label>
                                <input type="text" name="flag" id="flag" value="{{ old('flag', $country->flag) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" maxlength="10">
                                @error('flag')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">States</label>
                            <div id="states-container">
                                @foreach($country->states as $index => $state)
                                    <div class="flex items-center mb-2 state-input">
                                        <input type="text" name="states[]" value="{{ old('states.' . $index, $state->name) }}" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="State name">
                                        <button type="button" onclick="removeState(this)" class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Remove</button>
                                    </div>
                                @endforeach
                                @if($country->states->isEmpty())
                                    <div class="flex items-center mb-2 state-input">
                                        <input type="text" name="states[]" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="State name">
                                        <button type="button" onclick="removeState(this)" class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Remove</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="addState()" class="mt-2 bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-sm">Add State</button>
                        </div>

                        <div class="mt-6 flex justify-end space-x-2">
                            <a href="{{ route('admin.countries.show', $country) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Country
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addState() {
            const container = document.getElementById('states-container');
            const div = document.createElement('div');
            div.className = 'flex items-center mb-2 state-input';
            div.innerHTML = `
                <input type="text" name="states[]" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="State name">
                <button type="button" onclick="removeState(this)" class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">Remove</button>
            `;
            container.appendChild(div);
        }

        function removeState(button) {
            const container = document.getElementById('states-container');
            if (container.children.length > 1) {
                button.parentElement.remove();
            }
        }
    </script>
</x-admin-layout>