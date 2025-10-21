<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Newsletter Subscription Details') }}
            </h2>
            <a href="{{ route('admin.newsletter-subscriptions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Subscriptions
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Subscription Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $newsletterSubscription->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($newsletterSubscription->status === 'active') bg-green-100 text-green-800
                                            @elseif($newsletterSubscription->status === 'inactive') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($newsletterSubscription->status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Subscribed At</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $newsletterSubscription->subscribed_at ? $newsletterSubscription->subscribed_at->format('M d, Y H:i') : 'Not subscribed' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Verified At</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $newsletterSubscription->verified_at ? $newsletterSubscription->verified_at->format('M d, Y H:i') : 'Not verified' }}</dd>
                                </div>
                            </dl>
                        </div>

                        @if($newsletterSubscription->user)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Associated User</h3>
                            <div class="flex items-center space-x-4">
                                <img class="h-16 w-16 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($newsletterSubscription->user->name) }}&background=6366f1&color=fff" alt="">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $newsletterSubscription->user->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $newsletterSubscription->user->email }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6 flex justify-end">
                        <form action="{{ route('admin.newsletter-subscriptions.destroy', $newsletterSubscription) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure?')">
                                Delete Subscription
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>