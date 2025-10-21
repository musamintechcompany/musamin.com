<!-- Status Banners -->
@auth
    @if(!auth()->user()->isActive())
        <div @class([
            'mb-4 p-4 rounded-xl',
            'bg-gradient-to-r from-yellow-400 to-yellow-500' => auth()->user()->isPending(),
            'bg-gradient-to-r from-red-500 to-red-600' => auth()->user()->isBlocked(),
            'bg-gradient-to-r from-red-400 to-red-500' => auth()->user()->isSuspended(),
            'bg-gradient-to-r from-orange-400 to-orange-500' => auth()->user()->isOnHold(),
            'bg-gradient-to-r from-purple-400 to-purple-500' => auth()->user()->isWarning()
        ])>
            <div class="flex items-center">
                @if(auth()->user()->isPending())
                    <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-white font-medium">Please verify your email address to activate your account</p>
                @elseif(auth()->user()->isBlocked())
                    <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-white font-medium">Your account has been blocked. Please contact support</p>
                @elseif(auth()->user()->isSuspended())
                    <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-white font-medium">Your account is temporarily suspended</p>
                @elseif(auth()->user()->isOnHold())
                    <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-white font-medium">Your account is on hold. Please complete verification</p>
                @elseif(auth()->user()->isWarning())
                    <svg class="w-5 h-5 mr-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-white font-medium">Your account has warnings. Please review your account</p>
                @endif
            </div>
        </div>
    @endif
@endauth