<x-admin-layout title="Pending Transactions">
<div class="p-4 lg:p-6">
    <div class="space-y-4 overflow-hidden">
        <div class="flex flex-col sm:flex-row lg:justify-between lg:items-center gap-4">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Pending Transactions</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            @if($transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">Package</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">Total Coins</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">Proof</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600">Proof of Payment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="transactionsTableBody">
                            @foreach($transactions as $transaction)
                            <tr data-transaction-id="{{ $transaction->id }}">
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center">
                                        <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($transaction->user->name) }}&background=22c55e&color=fff" alt="{{ $transaction->user->name }}">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->user->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $transaction->package_name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($transaction->total_coins) }} coins</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-600">
                                    ${{ number_format($transaction->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-600">
                                    <div class="flex items-center">
                                        <i class="fas fa-coins text-yellow-500 mr-1"></i>
                                        <span class="font-semibold">{{ number_format($transaction->totalCoins()) }}</span>
                                        @if($transaction->bonus_coins > 0)
                                            <span class="text-xs text-green-600 ml-1">(+{{ number_format($transaction->bonus_coins) }} bonus)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600">
                                    @if($transaction->proofs && count($transaction->proofs) > 0)
                                        <div class="flex space-x-1">
                                            @foreach(array_slice($transaction->proofs, 0, 3) as $index => $proof)
                                                <img src="{{ Storage::url($proof) }}" 
                                                     alt="Proof {{ $index + 1 }}" 
                                                     class="w-8 h-8 rounded object-cover cursor-pointer hover:scale-110 transition-transform"
                                                     onclick="showImageModal('{{ Storage::url($proof) }}', 'Proof {{ $index + 1 }}')">
                                            @endforeach
                                            @if(count($transaction->proofs) > 3)
                                                <div class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center text-xs font-bold text-gray-600">
                                                    +{{ count($transaction->proofs) - 3 }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">No proof</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600">
                                    @if($transaction->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            🟡 Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            🔵 Processing
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 border-r border-gray-200 dark:border-gray-600">
                                    {{ $transaction->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600">
                                    @if($transaction->proofs && count($transaction->proofs) > 0)
                                        <div class="flex items-center gap-2">
                                            <button onclick="showProofModal({{ json_encode($transaction->proofs) }}, '{{ $transaction->user->name }}')" class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 transition-colors" title="View Proofs">
                                                <i class="fas fa-image text-sm mr-1"></i>
                                                {{ count($transaction->proofs) }} file(s)
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">No proof uploaded</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="showActionModal('{{ $transaction->id }}', '{{ $transaction->user->name }}', '{{ $transaction->package_name }}')" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-cog text-sm mr-2"></i>
                                        Action
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $transactions->links() }}
                </div>
            @else
                <tr>
                    <td colspan="8" class="text-center py-12">
                        <i class="fas fa-clock text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No pending transactions</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">All transactions have been processed.</p>
                    </td>
                </tr>
            @endif
        </div>
    </div>
</div>

<!-- Action Modal -->
<div id="actionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[9999]">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <form id="actionForm" method="POST">
            @csrf
            @method('PUT')
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                    <i class="fas fa-cog text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Process Transaction</h3>
                <p class="text-sm text-gray-500 mb-4">Transaction for <span id="modalUserName" class="font-semibold"></span> - <span id="modalPackageName" class="font-semibold"></span></p>
            </div>
            
            <div class="space-y-4">
                <!-- Status Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select id="statusSelect" name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Status</option>
                        <option value="approved">Approved</option>
                        <option value="declined">Declined</option>
                    </select>
                </div>
                
                <!-- Processed By -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Processed By <span class="text-red-500">*</span></label>
                    <input type="text" name="processed_by" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter your name or admin identifier">
                </div>
                
                <!-- Decline Reason (shows only when declined is selected) -->
                <div id="declineReasonField" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Decline Reason <span class="text-red-500">*</span></label>
                    <input type="text" name="decline_reason" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Reason for declining...">
                </div>
                
                <!-- Staff Comments -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Staff Comments (Optional)</label>
                    <textarea name="staff_comments" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Add any comments..."></textarea>
                </div>
            </div>
            
            <div class="flex gap-3 justify-center mt-6">
                <button type="button" onclick="closeActionModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                    Process Transaction
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentTransactionId = null;

    // Make functions global so they can be called from onclick
    window.showActionModal = function(transactionId, userName, packageName) {
        currentTransactionId = transactionId;
        document.getElementById('modalUserName').textContent = userName;
        document.getElementById('modalPackageName').textContent = packageName;
        document.getElementById('actionModal').classList.remove('hidden');
        document.getElementById('actionModal').classList.add('flex');
    };

    window.closeActionModal = function() {
        document.getElementById('actionModal').classList.add('hidden');
        document.getElementById('actionModal').classList.remove('flex');
        document.getElementById('actionForm').reset();
        document.getElementById('declineReasonField').classList.add('hidden');
    };

    // Show/hide decline reason field based on status selection
    document.getElementById('statusSelect').addEventListener('change', function() {
        const declineField = document.getElementById('declineReasonField');
        const declineInput = declineField.querySelector('input[name="decline_reason"]');
        
        if (this.value === 'declined') {
            declineField.classList.remove('hidden');
            declineInput.required = true;
        } else {
            declineField.classList.add('hidden');
            declineInput.required = false;
            declineInput.value = '';
        }
    });

    // Handle form submission
    document.getElementById('actionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const status = document.getElementById('statusSelect').value;
        if (!status) {
            alert('Please select a status');
            return;
        }
        
        // Set the correct action URL based on status
        const baseUrl = '{{ url("/management/portal/admin/coin-transactions") }}';
        const actionUrl = status === 'approved' 
            ? `${baseUrl}/${currentTransactionId}/approve`
            : `${baseUrl}/${currentTransactionId}/decline`;
        
        console.log('Setting action URL:', actionUrl); // Debug log
        this.action = actionUrl;
        this.submit();
    });

    // Proof modal functions
    window.showProofModal = function(proofs, userName) {
        document.getElementById('proofUserName').textContent = userName;
        const proofContent = document.getElementById('proofContent');
        proofContent.innerHTML = '';
        
        proofs.forEach((proof, index) => {
            const fileExtension = proof.split('.').pop().toLowerCase();
            const fileName = proof.split('/').pop();
            const fileUrl = `/storage/${proof}`;
            
            const proofItem = document.createElement('div');
            proofItem.className = 'border rounded-lg p-4';
            
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension)) {
                // Image preview
                proofItem.innerHTML = `
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Image ${index + 1}: ${fileName}</span>
                        <a href="${fileUrl}" download class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition-colors">
                            <i class="fas fa-download text-sm mr-1"></i> Download
                        </a>
                    </div>
                    <img src="${fileUrl}" alt="Proof ${index + 1}" class="max-w-full h-auto rounded border cursor-pointer" onclick="window.open('${fileUrl}', '_blank')">
                `;
            } else {
                // File preview
                proofItem.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <i class="fas fa-file text-gray-400 text-2xl mr-3"></i>
                            <div>
                                <div class="text-sm font-medium text-gray-700">${fileName}</div>
                                <div class="text-xs text-gray-500">${fileExtension.toUpperCase()} file</div>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="${fileUrl}" target="_blank" class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200 transition-colors">
                                <i class="fas fa-eye text-sm mr-1"></i> View
                            </a>
                            <a href="${fileUrl}" download class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition-colors">
                                <i class="fas fa-download text-sm mr-1"></i> Download
                            </a>
                        </div>
                    </div>
                `;
            }
            
            proofContent.appendChild(proofItem);
        });
        
        document.getElementById('proofModal').classList.remove('hidden');
        document.getElementById('proofModal').classList.add('flex');
    };

    window.closeProofModal = function() {
        document.getElementById('proofModal').classList.add('hidden');
        document.getElementById('proofModal').classList.remove('flex');
    };
});
</script>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-[10000]">
    <div class="max-w-4xl max-h-full p-4">
        <div class="relative">
            <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white bg-black bg-opacity-50 rounded-full w-8 h-8 flex items-center justify-center hover:bg-opacity-75">
                ×
            </button>
            <img id="modalImage" src="" alt="" class="max-w-full max-h-[90vh] object-contain">
            <div id="modalTitle" class="text-white text-center mt-2 font-semibold"></div>
        </div>
    </div>
</div>

<script>
// Auto-refresh pending transactions every 30 seconds
let refreshInterval;

function startAutoRefresh() {
    refreshInterval = setInterval(() => {
        if (!document.hidden) {
            refreshPendingTransactions();
        }
    }, 30000);
}

function stopAutoRefresh() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
    }
}

// Handle page visibility changes
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        stopAutoRefresh();
    } else {
        startAutoRefresh();
    }
});

// Start auto-refresh when page loads
document.addEventListener('DOMContentLoaded', () => {
    startAutoRefresh();
});

// Function to refresh pending transactions
function refreshPendingTransactions() {
    fetch('{{ route("admin.coin-transactions.pending-data") }}', {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateTransactionsTable(data.transactions);
        }
    })
    .catch(error => console.log('Refresh error:', error));
}

// Function to update transactions table
function updateTransactionsTable(transactions) {
    const tbody = document.querySelector('tbody');
    let html = '';
    
    if (transactions.data && transactions.data.length > 0) {
        transactions.data.forEach(transaction => {
            const proofImages = transaction.proofs && transaction.proofs.length > 0 
                ? transaction.proofs.slice(0, 3).map((proof, index) => 
                    `<img src="/storage/${proof}" alt="Proof ${index + 1}" class="w-8 h-8 rounded object-cover cursor-pointer hover:scale-110 transition-transform" onclick="showImageModal('/storage/${proof}', 'Proof ${index + 1}')">` 
                  ).join('')
                : '<span class="text-gray-400 text-sm">No proof</span>';
            
            const extraCount = transaction.proofs && transaction.proofs.length > 3 
                ? `<div class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center text-xs font-bold text-gray-600">+${transaction.proofs.length - 3}</div>`
                : '';
            
            html += `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600">
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=${encodeURIComponent(transaction.user.name)}&background=22c55e&color=fff" alt="${transaction.user.name}">
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">${transaction.user.name}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">${transaction.user.email}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600">
                        <div class="text-sm text-gray-900 dark:text-white">${transaction.package_name}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">${parseInt(transaction.total_coins).toLocaleString()} coins</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-600">
                        $${parseFloat(transaction.amount).toFixed(2)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white border-r border-gray-200 dark:border-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-coins text-yellow-500 mr-1"></i>
                            <span class="font-semibold">${parseInt(transaction.base_coins + transaction.bonus_coins).toLocaleString()}</span>
                            ${transaction.bonus_coins > 0 ? `<span class="text-xs text-green-600 ml-1">(+${parseInt(transaction.bonus_coins).toLocaleString()} bonus)</span>` : ''}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600">
                        <div class="flex space-x-1">
                            ${proofImages}
                            ${extraCount}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600">
                        ${transaction.status === 'pending' 
                            ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">🟡 Pending</span>'
                            : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">🔵 Processing</span>'
                        }
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 border-r border-gray-200 dark:border-gray-600">
                        ${new Date(transaction.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' })}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="showActionModal('${transaction.id}', '${transaction.user.name}', '${transaction.package_name}')" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-cog text-sm mr-2"></i>
                            Action
                        </button>
                    </td>
                </tr>
            `;
        });
    } else {
        html = `
            <tr>
                <td colspan="8" class="text-center py-12">
                    <i class="fas fa-clock text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No pending transactions</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">All transactions have been processed.</p>
                </td>
            </tr>
        `;
    }
    
    tbody.innerHTML = html;
}

// Image modal functions
function showImageModal(src, title) {
    document.getElementById('modalImage').src = src;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageModal').classList.add('flex');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>

<!-- Proof of Payment Modal -->
<div id="proofModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[9999]">
    <div class="bg-white rounded-lg p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Proof of Payment - <span id="proofUserName"></span></h3>
            <button onclick="closeProofModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div id="proofContent" class="space-y-4">
            <!-- Proof files will be loaded here -->
        </div>
        
        <div class="flex justify-end mt-6">
            <button onclick="closeProofModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                Close
            </button>
        </div>
    </div>
</div>

</x-admin-layout>