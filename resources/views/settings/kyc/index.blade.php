<x-app-layout>
    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    
                    <!-- Header -->
                    <div class="flex items-center mb-6">
                        <button onclick="window.history.back()" class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">KYC Verification</h2>
                    </div>

                    <!-- KYC Status Card -->
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100">Verification Status</h3>
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    @php
                                        $kycStatus = auth()->user()->kyc_status ?? 'not_started';
                                    @endphp
                                    
                                    @if($kycStatus === 'not_started')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            <i class="fas fa-clock mr-1"></i>
                                            Not Started
                                        </span>
                                    @elseif($kycStatus === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-300">
                                            <i class="fas fa-hourglass-half mr-1"></i>
                                            Under Review
                                        </span>
                                    @elseif($kycStatus === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-300">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Verified
                                        </span>
                                    @elseif($kycStatus === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-300">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Rejected
                                        </span>
                                    @endif
                                </p>
                            </div>
                            
                            @if($kycStatus === 'approved')
                                <i class="fas fa-shield-alt text-3xl text-green-500"></i>
                            @elseif($kycStatus === 'pending')
                                <div class="text-center">
                                    <div class="inline-flex items-center px-4 py-2 bg-yellow-100 dark:bg-yellow-900/20 border border-yellow-300 dark:border-yellow-700 rounded-md">
                                        <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 mr-2"></i>
                                        <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Under Review</span>
                                    </div>
                                </div>
                            @elseif($kycStatus === 'rejected')
                                <a href="{{ route('settings.kyc.identity') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                    <i class="fas fa-redo mr-2"></i>
                                    Resubmit
                                </a>
                            @else
                                <a href="{{ route('settings.kyc.identity') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                    <i class="fas fa-arrow-right mr-2"></i>
                                    Start Verification
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- KYC Steps -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Verification Steps</h3>
                        
                        <!-- Address Verification -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                            <i class="fas fa-home text-gray-600 dark:text-gray-400"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Address Verification</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Verify your residential address with utility bills</p>
                                    </div>
                                </div>
                                
                                @if($kycStatus === 'not_started' || $kycStatus === 'rejected')
                                    <i class="fas fa-times text-gray-400 text-xl"></i>
                                @elseif($kycStatus === 'pending')
                                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                                @else
                                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                @endif
                            </div>
                            

                        </div>

                        <!-- Identity Verification -->
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                            <i class="fas fa-id-card text-gray-600 dark:text-gray-400"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Identity Verification</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Upload your government-issued ID and personal information</p>
                                    </div>
                                </div>
                                
                                @if($kycStatus === 'not_started' || $kycStatus === 'rejected')
                                    <i class="fas fa-times text-gray-400 text-xl"></i>
                                @elseif($kycStatus === 'pending')
                                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                                @else
                                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                @endif
                            </div>
                            

                        </div>
                    </div>

                    <!-- Status Messages -->
                    @if($kycStatus === 'pending')
                        <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                            <div class="flex">
                                <i class="fas fa-info-circle text-yellow-400 mt-0.5"></i>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Under Review</h3>
                                    <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                                        Your documents are being reviewed. This process typically takes 2-3 business days. We'll notify you once the review is complete.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif($kycStatus === 'approved')
                        <div class="mt-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <div class="flex">
                                <i class="fas fa-check-circle text-green-400 mt-0.5"></i>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800 dark:text-green-200">Verification Complete</h3>
                                    <p class="mt-1 text-sm text-green-700 dark:text-green-300">
                                        Congratulations! Your identity has been successfully verified. You now have full access to all platform features.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif($kycStatus === 'rejected')
                        <div class="mt-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <div class="flex">
                                <i class="fas fa-exclamation-triangle text-red-400 mt-0.5"></i>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Verification Failed</h3>
                                    <p class="mt-1 text-sm text-red-700 dark:text-red-300">
                                        Your verification was unsuccessful. Please review the requirements and submit new documents. Contact support if you need assistance.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>