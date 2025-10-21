<x-app-layout>
    <div class="py-4 px-2 sm:py-8 sm:px-4">
        <div class="mx-auto max-w-4xl">
            <!-- Profile Photo -->
            <div class="flex justify-center mb-6">
                @if (Auth::user()->profile_photo_path)
                    <img class="object-cover border-4 border-gray-200 rounded-full w-20 h-20 sm:w-32 sm:h-32 dark:border-gray-600" 
                         src="{{ Auth::user()->profile_photo_url }}" 
                         alt="{{ Auth::user()->name }}" />
                @else
                    <div class="flex items-center justify-center bg-gray-300 border-4 border-gray-200 rounded-full w-20 h-20 sm:w-32 sm:h-32 dark:bg-gray-600 dark:border-gray-600">
                        <span class="text-2xl sm:text-4xl font-bold text-gray-600 dark:text-gray-300">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Profile Information -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                <!-- Name -->
                <div class="p-3 sm:p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <label class="block mb-1 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        Full Name
                    </label>
                    <p class="text-sm sm:text-lg font-semibold text-gray-900 dark:text-white break-words">
                        {{ Auth::user()->name }}
                    </p>
                </div>

                <!-- Email -->
                <div class="p-3 sm:p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <label class="block mb-1 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email Address
                    </label>
                    <p class="text-sm sm:text-lg font-semibold text-gray-900 dark:text-white break-all">
                        {{ Auth::user()->email }}
                    </p>
                    @if (!Auth::user()->hasVerifiedEmail())
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mt-2">
                            Unverified
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                            Verified
                        </span>
                    @endif
                </div>



                <!-- Phone -->
                <div class="p-3 sm:p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <label class="block mb-1 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        Phone
                    </label>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <p class="text-sm sm:text-lg font-semibold text-gray-900 dark:text-white break-all">
                            {{ Auth::user()->phone ?? 'Not provided' }}
                        </p>
                        @if(Auth::user()->phone)
                            @if(Auth::user()->phone_verified_at)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 self-start">
                                    Verified
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 self-start">
                                    Unverified
                                </span>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Username -->
                <div class="p-3 sm:p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <label class="block mb-1 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        Username
                    </label>
                    <p class="text-sm sm:text-lg font-semibold text-gray-900 dark:text-white break-words">
                        {{ Auth::user()->username ?: 'Not set' }}
                    </p>
                </div>

                <!-- Location -->
                <div class="p-3 sm:p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <label class="block mb-1 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        Location
                    </label>
                    <p class="text-sm sm:text-lg font-semibold text-gray-900 dark:text-white break-words">
                        @php
                            $location = collect([Auth::user()->state, Auth::user()->country])->filter()->implode(', ');
                        @endphp
                        {{ $location ?: 'Not provided' }}
                    </p>
                </div>

                <!-- Member Since -->
                <div class="p-3 sm:p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <label class="block mb-1 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        Member Since
                    </label>
                    <p class="text-sm sm:text-lg font-semibold text-gray-900 dark:text-white">
                        {{ Auth::user()->created_at->format('M d, Y') }}
                    </p>
                </div>

                <!-- Account Status -->
                <div class="p-3 sm:p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <label class="block mb-1 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        Account Status
                    </label>
                    <div class="flex items-center">
                        @php
                            $status = Auth::user()->status;
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'active' => 'bg-green-100 text-green-800',
                                'warning' => 'bg-orange-100 text-orange-800',
                                'hold' => 'bg-blue-100 text-blue-800',
                                'suspended' => 'bg-red-100 text-red-800',
                                'blocked' => 'bg-gray-100 text-gray-800'
                            ];
                            $statusIcons = [
                                'pending' => '🟡',
                                'active' => '🟢',
                                'warning' => '🟠',
                                'hold' => '🔵',
                                'suspended' => '🔴',
                                'blocked' => '⚫'
                            ];
                        @endphp
                        <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusIcons[$status] ?? '⚪' }} {{ ucfirst($status) }}
                        </span>
                    </div>
                </div>

                <!-- Affiliate Status -->
                @if(Auth::user()->affiliate)
                <div class="col-span-1 sm:col-span-2 p-3 sm:p-4 border border-purple-200 rounded-lg bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900 dark:to-indigo-900 dark:border-purple-700">
                    <label class="block mb-1 text-xs sm:text-sm font-medium text-purple-700 dark:text-purple-300">
                        Affiliate Status
                    </label>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                        @if(Auth::user()->isAffiliate())
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 text-xs sm:text-sm font-medium text-purple-800 bg-purple-100 rounded-full dark:bg-purple-800 dark:text-purple-200 self-start">
                                ⭐ Active Affiliate
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 text-xs sm:text-sm font-medium text-red-800 bg-red-100 rounded-full dark:bg-red-800 dark:text-red-200 self-start">
                                ❌ Expired
                            </span>
                        @endif
                        <span class="text-xs text-purple-600 dark:text-purple-400">
                            @if(Auth::user()->isAffiliate())
                                Expires at: {{ Auth::user()->affiliate->expires_at->format('M d, Y') }}
                            @else
                                Expired at: {{ Auth::user()->affiliate->expires_at->format('M d, Y') }}
                            @endif
                        </span>
                    </div>
                    <div class="text-center mb-3">
                        <div id="affiliateCountdown" class="text-xs sm:text-sm font-mono text-purple-700 dark:text-purple-300"></div>
                    </div>
                    @if(!Auth::user()->isAffiliate())
                    <div class="text-center">
                        <a href="{{ route('affiliate.join') }}" class="inline-flex items-center px-3 py-2 text-xs font-semibold text-white transition duration-150 ease-in-out border border-transparent rounded-md bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                            <i class="mr-1 fas fa-sync-alt"></i>
                            Renew Membership
                        </a>
                    </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center mt-6 sm:mt-8">
                <a href="{{ route('profile.show') }}" 
                   class="inline-flex items-center px-4 py-2 text-xs sm:text-sm font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <i class="mr-2 fas fa-edit"></i>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    @if(Auth::user()->affiliate)
    <script>
    function updateAffiliateCountdown() {
        const expiryDate = new Date('{{ Auth::user()->affiliate->expires_at->toISOString() }}');
        const now = new Date();
        const diff = expiryDate - now;
        
        if (diff <= 0) {
            document.getElementById('affiliateCountdown').innerHTML = '<span class="text-red-600 font-bold">Expired</span>';
            return;
        }
        
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        document.getElementById('affiliateCountdown').innerHTML = 
            `${days}d ${hours}h ${minutes}m ${seconds}s remaining`;
    }
    
    updateAffiliateCountdown();
    setInterval(updateAffiliateCountdown, 1000);
    </script>
    @endif
</x-app-layout>