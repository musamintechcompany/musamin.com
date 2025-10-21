<x-admin-layout>
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('admin.withdrawals.index') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Withdrawal Details</h1>
            </div>
            <span @class([
                'inline-flex px-3 py-1 text-sm font-semibold rounded-full',
                'bg-yellow-100 text-yellow-800' => $withdrawal->status === 'pending',
                'bg-green-100 text-green-800' => $withdrawal->status === 'approved',
                'bg-red-100 text-red-800' => $withdrawal->status === 'rejected',
                'bg-blue-100 text-blue-800' => $withdrawal->status === 'completed'
            ])>
                {{ ucfirst($withdrawal->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Withdrawal Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Withdrawal Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Amount</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ number_format($withdrawal->amount) }} coins</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fee</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ number_format($withdrawal->fee) }} coins</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Net Amount</dt>
                        <dd class="text-sm font-bold text-green-600 dark:text-green-400">{{ number_format($withdrawal->net_amount) }} coins</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Requested Date</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $withdrawal->created_at->format('M d, Y H:i:s') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- User Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">User Information</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $withdrawal->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $withdrawal->user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Earned Balance</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ number_format($withdrawal->user->earned_coins) }} coins</dd>
                    </div>
                </dl>
            </div>

            <!-- Bank Account Details -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Bank Account Details</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Method Name</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $withdrawal->withdrawalDetail->method_name }}</dd>
                    </div>
                    @foreach($withdrawal->withdrawalDetail->credentials as $credential)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $credential['name'] }}</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $credential['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <!-- Processing Information -->
            @if($withdrawal->processed_at)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Processing Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Processed By</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $withdrawal->processedBy->name ?? 'Unknown' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Processed Date</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $withdrawal->processed_at->format('M d, Y H:i:s') }}</dd>
                        </div>
                        @if($withdrawal->admin_notes)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Admin Notes</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $withdrawal->admin_notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        @if($withdrawal->isPending())
            <div class="mt-6 flex space-x-4">
                <button onclick="showApproveModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-check mr-2"></i>Approve
                </button>
                <button onclick="showRejectModal()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-times mr-2"></i>Reject
                </button>
            </div>
        @endif
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Approve Withdrawal</h3>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notes (Optional)</label>
                <textarea id="approveNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Add any notes..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="hideApproveModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Cancel</button>
                <button id="approveBtn" onclick="approveWithdrawal()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 flex items-center">
                    <i id="approveIcon" class="fas fa-check mr-2"></i>
                    <span id="approveText">Approve</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Reject Withdrawal</h3>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason for Rejection</label>
                <textarea id="rejectNotes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Please provide a reason..." required></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button onclick="hideRejectModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">Cancel</button>
                <button id="rejectBtn" onclick="rejectWithdrawal()" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center">
                    <i id="rejectIcon" class="fas fa-times mr-2"></i>
                    <span id="rejectText">Reject</span>
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showApproveModal() {
            document.getElementById('approveModal').classList.remove('hidden');
            document.getElementById('approveModal').classList.add('flex');
        }

        function hideApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
            document.getElementById('approveModal').classList.remove('flex');
        }

        function showRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectModal').classList.add('flex');
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectModal').classList.remove('flex');
        }

        function approveWithdrawal() {
            const notes = document.getElementById('approveNotes').value;
            const btn = document.getElementById('approveBtn');
            const icon = document.getElementById('approveIcon');
            const text = document.getElementById('approveText');
            
            // Show loading state
            btn.disabled = true;
            icon.className = 'fas fa-spinner fa-spin mr-2';
            text.textContent = 'Processing...';
            
            fetch(`{{ route('admin.withdrawals.approve', $withdrawal) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ notes })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    // Reset button state
                    btn.disabled = false;
                    icon.className = 'fas fa-check mr-2';
                    text.textContent = 'Approve';
                    alert(data.message);
                }
            })
            .catch(error => {
                // Reset button state
                btn.disabled = false;
                icon.className = 'fas fa-check mr-2';
                text.textContent = 'Approve';
                alert('Error approving withdrawal');
            });
        }

        function rejectWithdrawal() {
            const notes = document.getElementById('rejectNotes').value;
            const btn = document.getElementById('rejectBtn');
            const icon = document.getElementById('rejectIcon');
            const text = document.getElementById('rejectText');
            
            if (!notes.trim()) {
                alert('Please provide a reason for rejection');
                return;
            }
            
            // Show loading state
            btn.disabled = true;
            icon.className = 'fas fa-spinner fa-spin mr-2';
            text.textContent = 'Processing...';
            
            fetch(`{{ route('admin.withdrawals.reject', $withdrawal) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ notes })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    // Reset button state
                    btn.disabled = false;
                    icon.className = 'fas fa-times mr-2';
                    text.textContent = 'Reject';
                    alert(data.message);
                }
            })
            .catch(error => {
                // Reset button state
                btn.disabled = false;
                icon.className = 'fas fa-times mr-2';
                text.textContent = 'Reject';
                alert('Error rejecting withdrawal');
            });
        }
    </script>
    @endpush
</x-admin-layout>