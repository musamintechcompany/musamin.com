<header class="bg-white shadow-sm dark:bg-gray-800">
    <style>
        .header-shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dark .header-shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        #sidebarToggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #4b5563;
            cursor: pointer;
            padding: 0.5rem;
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        #sidebarToggle:hover {
            background-color: rgba(0,0,0,0.05);
        }

        .dark #sidebarToggle {
            color: #d1d5db;
        }

        .dark #sidebarToggle:hover {
            background-color: rgba(255,255,255,0.05);
        }

        #sidebarToggle i {
            transition: transform 0.3s ease;
        }
    </style>

    <div class="flex items-center justify-between p-4">
        <div class="flex items-center gap-4">
            <button id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="flex items-center gap-4">
            <a href="{{ route('affiliate.notifications.index') }}" class="relative p-2 text-gray-600 rounded-full dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-bell"></i>
                <span id="affiliateNotificationBadge" class="absolute -top-1 -right-1 bg-purple-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold" style="display: none">
                    0
                </span>
            </a>

            <a href="{{ route('profile.show') }}" class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                <img class="w-10 h-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
            </a>
        </div>
    </div>
</header>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationBadge = document.getElementById('affiliateNotificationBadge');
        const notificationSound = new Audio('/sounds/notification.mp3');

        // Load initial notifications
        loadAffiliateNotifications();

        // Listen for real-time notifications
        window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
            .notification((notification) => {
                playNotificationSound();
                showToast(notification);
                loadAffiliateNotifications();
            });



        function loadAffiliateNotifications() {
            fetch('/affiliate-notifications/unread')
                .then(response => response.json())
                .then(data => {
                    updateNotificationBadge(data.count);
                });
        }

        function updateNotificationBadge(count) {
            if (count > 0) {
                notificationBadge.textContent = count > 99 ? '99+' : count;
                notificationBadge.style.display = 'flex';
            } else {
                notificationBadge.style.display = 'none';
            }
        }



        function getIconClass(icon, color) {
            const colorClass = {
                'green': 'text-green-500',
                'blue': 'text-blue-500',
                'yellow': 'text-yellow-500',
                'red': 'text-red-500',
                'purple': 'text-purple-500'
            }[color] || 'text-gray-500';
            return `fas fa-${icon} ${colorClass}`;
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleString();
        }



        function playNotificationSound() {
            notificationSound.play().catch(() => {});
        }

        function showToast(notification) {
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4 z-50 max-w-sm';
            toast.innerHTML = `
                <div class="flex items-start">
                    <i class="fas fa-${notification.icon} ${getIconClass(notification.icon, notification.color)} mr-3 mt-1"></i>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${notification.message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
        }
    });
</script>
@endpush


