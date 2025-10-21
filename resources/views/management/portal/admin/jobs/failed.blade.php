<x-admin-layout title="Failed Jobs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                {{ session('warning') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                {{ session('info') }}
            </div>
        @endif

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Failed Jobs</h1>
            <p class="text-gray-600 dark:text-gray-400">Manage and retry failed jobs</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="mb-6">
            <nav class="flex space-x-8">
                <a href="{{ route('admin.jobs.index') }}" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-2 px-1 text-sm font-medium">
                    Jobs
                </a>
                <a href="{{ route('admin.jobs.batches') }}" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-2 px-1 text-sm font-medium">
                    Batches
                </a>
                <a href="{{ route('admin.jobs.failed') }}" class="border-b-2 border-blue-500 text-blue-600 py-2 px-1 text-sm font-medium">
                    Failed Jobs
                </a>
            </nav>
        </div>

        <!-- Failed Jobs Table -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Failed Jobs ({{ $failedJobs->total() }})</h3>
                @if($failedJobs->total() > 0)
                    <form action="{{ route('admin.jobs.retry-all') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium" onclick="return confirm('Are you sure you want to retry all failed jobs?')">
                            Retry All Failed Jobs
                        </button>
                    </form>
                @endif
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">UUID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Connection</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Queue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Failed At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($failedJobs as $job)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $job->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ Str::limit($job->uuid, 8) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $job->connection }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $job->queue }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $job->failed_at }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form action="{{ route('admin.jobs.retry', $job->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-900 mr-3">Retry</button>
                                    </form>
                                    <button onclick="showException({{ $job->id }})" class="text-gray-600 hover:text-gray-900">View Error</button>
                                </td>
                            </tr>
                            
                            <!-- Hidden exception details -->
                            <tr id="exception-{{ $job->id }}" class="hidden">
                                <td colspan="6" class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                                    <div class="text-sm">
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Exception Details:</h4>
                                        <pre class="text-xs text-red-600 dark:text-red-400 whitespace-pre-wrap bg-white dark:bg-gray-800 p-3 rounded border">{{ $job->exception }}</pre>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No failed jobs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($failedJobs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $failedJobs->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function showException(jobId) {
            const row = document.getElementById('exception-' + jobId);
            row.classList.toggle('hidden');
        }
    </script>
</x-admin-layout>