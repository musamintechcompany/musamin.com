<!-- Status Badge -->
<div class="flex justify-between items-center mb-6">
    <div class="flex items-center space-x-4">
        <img class="h-12 w-12 rounded-full" src="{{ $kyc->user->profile_photo_url }}" alt="">
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $kyc->user->name }}</h3>
            <p class="text-gray-500 dark:text-gray-400">{{ $kyc->user->email }}</p>
        </div>
    </div>
    
    @if($kyc->status === 'pending')
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
            <i class="fas fa-clock mr-2"></i>
            Pending Review
        </span>
    @elseif($kyc->status === 'approved')
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
            <i class="fas fa-check mr-2"></i>
            Approved
        </span>
    @else
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
            <i class="fas fa-times mr-2"></i>
            Rejected
        </span>
    @endif
</div>

<!-- Personal Information -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Personal Information</h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">First Name</label>
            <p class="text-gray-900 dark:text-white">{{ $kyc->first_name }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Last Name</label>
            <p class="text-gray-900 dark:text-white">{{ $kyc->last_name }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth</label>
            <p class="text-gray-900 dark:text-white">{{ $kyc->date_of_birth?->format('M j, Y') }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Phone</label>
            <p class="text-gray-900 dark:text-white">{{ $kyc->phone }}</p>
        </div>
    </div>
</div>

<!-- Address Information -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Address Information</h3>
    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Street Address</label>
            <p class="text-gray-900 dark:text-white">{{ $kyc->street_address }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">City</label>
            <p class="text-gray-900 dark:text-white">{{ $kyc->city }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">State</label>
            <p class="text-gray-900 dark:text-white">{{ $kyc->state }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Postal Code</label>
            <p class="text-gray-900 dark:text-white">{{ $kyc->postal_code }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Country</label>
            <p class="text-gray-900 dark:text-white">{{ $kyc->country }}</p>
        </div>
    </div>
</div>

<!-- Documents -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
    <!-- ID Verification -->
    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">ID Verification</h3>
        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">ID Type</label>
                <p class="text-gray-900 dark:text-white capitalize">{{ str_replace('_', ' ', $kyc->id_type) }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">ID Number</label>
                <p class="text-gray-900 dark:text-white">{{ $kyc->id_number }}</p>
            </div>
            @if($kyc->id_document_path)
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">ID Document</label>
                    <a href="{{ Storage::url($kyc->id_document_path) }}" target="_blank" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-600 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-500">
                        <i class="fas fa-eye mr-2"></i>
                        View Document
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Utility Bill -->
    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Proof of Address</h3>
        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Utility Type</label>
                <p class="text-gray-900 dark:text-white capitalize">{{ str_replace('_', ' ', $kyc->utility_type) }}</p>
            </div>
            @if($kyc->utility_bill_path)
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Utility Bill</label>
                    <a href="{{ Storage::url($kyc->utility_bill_path) }}" target="_blank" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-600 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-500">
                        <i class="fas fa-eye mr-2"></i>
                        View Document
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Selfie Video -->
@if($kyc->selfie_video_path)
    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Selfie Video</h3>
        <video controls class="w-full max-w-md rounded-lg">
            <source src="{{ Storage::url($kyc->selfie_video_path) }}" type="video/webm">
            <source src="{{ Storage::url($kyc->selfie_video_path) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
@endif

<!-- Review Information -->
@if($kyc->status !== 'pending')
    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Review Information</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Reviewed By</label>
                <p class="text-gray-900 dark:text-white">{{ $kyc->reviewed_by_name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Reviewed At</label>
                <p class="text-gray-900 dark:text-white">{{ $kyc->reviewed_at?->format('M j, Y g:i A') }}</p>
            </div>
            @if($kyc->rejection_reason)
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Rejection Reason</label>
                    <p class="text-red-600 dark:text-red-400">{{ $kyc->rejection_reason }}</p>
                </div>
            @endif
            @if($kyc->reviewer_notes)
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Reviewer Notes</label>
                    <p class="text-gray-900 dark:text-white">{{ $kyc->reviewer_notes }}</p>
                </div>
            @endif
        </div>
    </div>
@endif

<!-- Action Buttons -->
@if($kyc->status === 'pending')
    <div class="flex space-x-4 pt-4 border-t border-gray-200 dark:border-gray-600">
        <button onclick="showApproveModal()" 
                class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            <i class="fas fa-check mr-2"></i>
            Approve KYC
        </button>
        <button onclick="showRejectModal()" 
                class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
            <i class="fas fa-times mr-2"></i>
            Reject KYC
        </button>
    </div>
@endif