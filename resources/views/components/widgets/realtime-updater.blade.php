@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let updateInterval;
    let isPageVisible = true;
    
    // Track page visibility
    document.addEventListener('visibilitychange', function() {
        isPageVisible = !document.hidden;
        if (isPageVisible) {
            startUpdates();
        } else {
            stopUpdates();
        }
    });
    
    function updateWidgets() {
        if (!isPageVisible) return;
        
        fetch('{{ route("admin.widgets.data") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update Total Users
            const totalUsers = document.querySelector('[data-widget="total-users"]');
            if (totalUsers && data.total_users !== undefined) {
                totalUsers.textContent = data.total_users;
            }
            
            // Update Active Users
            const activeUsers = document.querySelector('[data-widget="active-users"]');
            if (activeUsers && data.active_users !== undefined) {
                activeUsers.textContent = data.active_users;
            }
            
            // Update New Users
            const newUsers = document.querySelector('[data-widget="new-users"]');
            if (newUsers && data.new_users !== undefined) {
                newUsers.textContent = data.new_users;
            }
            
            // Update Online Users
            const onlineUsers = document.querySelector('[data-widget="online-users"]');
            if (onlineUsers && data.online_users !== undefined) {
                onlineUsers.textContent = data.online_users;
            }
            
            // Update Total Admins
            const totalAdmins = document.querySelector('[data-widget="total-admins"]');
            if (totalAdmins && data.total_admins !== undefined) {
                totalAdmins.textContent = data.total_admins;
            }
            
            // Update Total Roles
            const totalRoles = document.querySelector('[data-widget="total-roles"]');
            if (totalRoles && data.total_roles !== undefined) {
                totalRoles.textContent = data.total_roles;
            }
            
            // Update Total Permissions
            const totalPermissions = document.querySelector('[data-widget="total-permissions"]');
            if (totalPermissions && data.total_permissions !== undefined) {
                totalPermissions.textContent = data.total_permissions;
            }
        })
        .catch(error => console.error('Widget update error:', error));
    }
    
    function startUpdates() {
        if (updateInterval) clearInterval(updateInterval);
        updateInterval = setInterval(updateWidgets, 30000); // 30 seconds
    }
    
    function stopUpdates() {
        if (updateInterval) {
            clearInterval(updateInterval);
            updateInterval = null;
        }
    }
    
    // Start updates when page loads
    startUpdates();
    
    // Stop updates when page unloads
    window.addEventListener('beforeunload', stopUpdates);
});
</script>
@endpush