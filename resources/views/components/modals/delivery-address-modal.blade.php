<div id="deliveryAddressModal" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-lg shadow-xl">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Delivery Address</h3>
        

        
        <form id="addressForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address Label</label>
                <input type="text" id="addressLabel" placeholder="Home, Office, etc." required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                <input type="text" id="deliveryName" value="{{ auth()->user()->name ?? '' }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                <input type="email" id="deliveryEmail" value="{{ auth()->user()->email ?? '' }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone (Optional)</label>
                <input type="tel" id="deliveryPhone" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                <textarea id="deliveryAddress" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" rows="2">{{ auth()->user()->address ?? '' }}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                    <input type="text" id="deliveryCity" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Postal Code</label>
                    <input type="text" id="deliveryPostal" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">State</label>
                    <input type="text" id="deliveryState" value="{{ auth()->user()->state ?? '' }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country</label>
                    <input type="text" id="deliveryCountry" value="{{ auth()->user()->country ?? '' }}" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes (Optional)</label>
                <textarea id="deliveryNotes" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white" rows="2" placeholder="Special delivery instructions..."></textarea>
            </div>
        </form>
        <div class="flex gap-3 mt-6">
            <button onclick="hideDeliveryAddressModal()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                Cancel
            </button>
            <button onclick="saveAddressAndContinue(this)" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <span class="button-text">Save & Continue</span>
            </button>
        </div>
    </div>
</div>

<script>
function showDeliveryAddressModal() {
    document.getElementById('deliveryAddressModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideDeliveryAddressModal() {
    document.getElementById('deliveryAddressModal').classList.add('hidden');
    document.body.style.overflow = '';
}



function loadAddressData(address) {
    document.getElementById('addressLabel').value = address.label;
    document.getElementById('deliveryName').value = address.details.name || '';
    document.getElementById('deliveryEmail').value = address.details.email || '';
    document.getElementById('deliveryPhone').value = address.details.phone || '';
    document.getElementById('deliveryAddress').value = address.details.address || '';
    document.getElementById('deliveryCity').value = address.details.city || '';
    document.getElementById('deliveryState').value = address.details.state || '';
    document.getElementById('deliveryCountry').value = address.details.country || '';
    document.getElementById('deliveryPostal').value = address.details.postal_code || '';
    document.getElementById('deliveryNotes').value = address.details.notes || '';
}

function saveAddressAndContinue(button) {
    const form = document.getElementById('addressForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const buttonText = button.querySelector('.button-text');
    buttonText.textContent = 'Saving...';
    button.disabled = true;
    
    const addressData = {
        label: document.getElementById('addressLabel').value,
        details: {
            name: document.getElementById('deliveryName').value,
            email: document.getElementById('deliveryEmail').value,
            phone: document.getElementById('deliveryPhone').value,
            address: document.getElementById('deliveryAddress').value,
            city: document.getElementById('deliveryCity').value,
            state: document.getElementById('deliveryState').value,
            country: document.getElementById('deliveryCountry').value,
            postal_code: document.getElementById('deliveryPostal').value,
            notes: document.getElementById('deliveryNotes').value
        }
    };
    
    fetch('/delivery-details', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(addressData)
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            hideDeliveryAddressModal();
            // Update address display in cart
            if (typeof updateAddressDisplay === 'function') {
                updateAddressDisplay();
            }
            alert('Address saved successfully!');
        } else {
            alert('Error saving address: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Error saving address. Please try again.');
    })
    .finally(() => {
        buttonText.textContent = 'Save & Continue';
        button.disabled = false;
    });
}



// Close modal when clicking outside
document.getElementById('deliveryAddressModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeliveryAddressModal();
    }
});
</script>