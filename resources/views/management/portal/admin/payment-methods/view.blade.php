<x-app-layout>
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Payment Method Details</h1>
        <div class="flex space-x-3">
            <a href="{{ route('portal.payment-methods.edit', $paymentMethod) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('portal.payment-methods.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Method Preview -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Method Preview</h3>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <i class="{{ $paymentMethod->icon }} text-2xl mr-4 text-blue-600"></i>
                    <div>
                        <div class="text-lg font-semibold">{{ $paymentMethod->name }}</div>
                        <div class="text-sm text-gray-500">{{ $paymentMethod->code }}</div>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Type:</span>
                        <span class="font-medium">{{ ucfirst($paymentMethod->type) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Category:</span>
                        <span class="font-medium">{{ ucfirst($paymentMethod->category) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Rate:</span>
                        <span class="font-medium">1 USD = {{ number_format($paymentMethod->usd_rate, $paymentMethod->category === 'crypto' ? 8 : 2) }} {{ $paymentMethod->code }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Method Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Method Information</h3>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Method Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $paymentMethod->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Code</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $paymentMethod->code }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paymentMethod->type === 'manual' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($paymentMethod->type) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paymentMethod->category === 'crypto' ? 'bg-purple-100 text-purple-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($paymentMethod->category) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Icon Class</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $paymentMethod->icon }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">USD Rate</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ number_format($paymentMethod->usd_rate, $paymentMethod->category === 'crypto' ? 8 : 2) }}</dd>
                </div>
                @if($paymentMethod->currency_symbol)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Currency Symbol</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $paymentMethod->currency_symbol }}</dd>
                </div>
                @endif
                @if($paymentMethod->type === 'manual')
                <div>
                    <dt class="text-sm font-medium text-gray-500">Countdown Time</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ gmdate('i:s', $paymentMethod->countdown_time) }}</dd>
                </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">Has Fees</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paymentMethod->has_fee ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $paymentMethod->has_fee ? 'Yes' : 'No' }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paymentMethod->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $paymentMethod->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Sort Order</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $paymentMethod->sort_order }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Credentials -->
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Credentials</h3>
        @if($paymentMethod->formatted_credentials && count($paymentMethod->formatted_credentials) > 0)
            <div class="space-y-4">
                @foreach($paymentMethod->formatted_credentials as $index => $credential)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-3">
                            {{ $paymentMethod->category === 'crypto' ? 'Wallet #' . ($index + 1) : 'Account #' . ($index + 1) }}
                        </h4>
                        @if($paymentMethod->category === 'crypto')
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Address:</span>
                                    <span class="text-sm text-gray-900 font-mono ml-2">{{ $credential['address'] }}</span>
                                </div>
                                @if($credential['comment'])
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Comment:</span>
                                        <span class="text-sm text-gray-900 ml-2">{{ $credential['comment'] }}</span>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="space-y-2">
                                @foreach($credential['details'] as $detail)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">{{ $detail['title'] }}:</span>
                                        <span class="text-sm text-gray-900 ml-2">{{ $detail['value'] }}</span>
                                    </div>
                                @endforeach
                                @if($credential['comment'])
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Comment:</span>
                                        <span class="text-sm text-gray-900 ml-2">{{ $credential['comment'] }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">No credentials configured for this payment method.</p>
        @endif
    </div>
</div>
</x-app-layout>