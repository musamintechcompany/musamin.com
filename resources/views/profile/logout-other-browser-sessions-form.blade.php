<div>
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
        </div>

        @php
            $sessions = collect(\DB::table('sessions')
                ->where('user_id', auth()->id())
                ->orderBy('last_activity', 'desc')
                ->get())
                ->map(function ($session) {
                    $userAgent = $session->user_agent ?? 'Unknown';
                    
                    // Simple browser detection
                    $browser = 'Unknown';
                    $platform = 'Unknown';
                    $isDesktop = true;
                    
                    if (str_contains($userAgent, 'Chrome')) $browser = 'Chrome';
                    elseif (str_contains($userAgent, 'Firefox')) $browser = 'Firefox';
                    elseif (str_contains($userAgent, 'Safari')) $browser = 'Safari';
                    elseif (str_contains($userAgent, 'Edge')) $browser = 'Edge';
                    
                    if (str_contains($userAgent, 'Windows')) $platform = 'Windows';
                    elseif (str_contains($userAgent, 'Mac')) $platform = 'macOS';
                    elseif (str_contains($userAgent, 'Linux')) $platform = 'Linux';
                    elseif (str_contains($userAgent, 'Android')) { $platform = 'Android'; $isDesktop = false; }
                    elseif (str_contains($userAgent, 'iPhone') || str_contains($userAgent, 'iPad')) { $platform = 'iOS'; $isDesktop = false; }
                    
                    return (object) [
                        'agent' => (object) [
                            'browser' => fn() => $browser,
                            'platform' => fn() => $platform,
                            'isDesktop' => fn() => $isDesktop,
                        ],
                        'ip_address' => $session->ip_address,
                        'is_current_device' => $session->id === session()->getId(),
                        'last_active' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                    ];
                });
        @endphp
        @if (count($sessions) > 0)
            <div class="mt-5 space-y-6">
                <!-- Other Browser Sessions -->
                @foreach ($sessions as $session)
                    <div class="flex items-center">
                        <div>
                            @if (($session->agent->isDesktop)())
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            @endif
                        </div>

                        <div class="ms-3">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                {{ ($session->agent->platform)() ? ($session->agent->platform)() : __('Unknown') }} - {{ ($session->agent->browser)() ? ($session->agent->browser)() : __('Unknown') }}
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">
                                    {{ $session->ip_address }},

                                    @if ($session->is_current_device)
                                        <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                    @else
                                        {{ __('Last active') }} {{ $session->last_active }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex items-center mt-5">
            <x-button type="button" id="logoutOtherSessionsBtn">
                {{ __('Log Out Other Browser Sessions') }}
            </x-button>
        </div>

        <!-- Password Confirmation Modal -->
        <div id="sessionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Confirm Password</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Please enter your password to log out other browser sessions.</p>
                
                <div class="mb-4">
                    <x-input type="password" id="sessionPassword" placeholder="Password" class="w-full" />
                </div>
                
                <div class="flex justify-end space-x-3">
                    <x-secondary-button id="cancelSessionBtn">Cancel</x-secondary-button>
                    <x-button id="confirmSessionBtn">Log Out Sessions</x-button>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('logoutOtherSessionsBtn');
            const modal = document.getElementById('sessionModal');
            const cancelBtn = document.getElementById('cancelSessionBtn');
            const confirmBtn = document.getElementById('confirmSessionBtn');
            const passwordInput = document.getElementById('sessionPassword');
            
            logoutBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                passwordInput.focus();
            });
            
            cancelBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                passwordInput.value = '';
            });
            
            confirmBtn.addEventListener('click', function() {
                const password = passwordInput.value;
                if (!password) {
                    alert('Please enter your password');
                    return;
                }
                
                confirmBtn.disabled = true;
                confirmBtn.textContent = 'Logging out...';
                
                fetch('{{ route("logout-other-sessions") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ password: password })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        passwordInput.value = '';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error logging out sessions');
                })
                .finally(() => {
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = 'Log Out Sessions';
                });
            });
        });
        </script>
</div>
