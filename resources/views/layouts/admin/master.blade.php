<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    @include('layouts.admin.styles')
    @stack('styles')
</head>
<body>
    @include('layouts.admin.theme')
    
    <div class="overlay bg-black bg-opacity-50 w-100 h-100 position-fixed z-9 visibility-hidden opacity-0 duration-300"></div>
    
    @include('layouts.admin.sidebar')
    
    <main class="dashboard-main">
        @include('layouts.admin.nav')
        
        <div class="dashboard-main-body">
            @yield('content')
        </div>
    </main>
    
    @include('layouts.admin.scripts')
    
    <script>
    // Update notification count on page load and periodically
    function updateNotificationCount() {
        fetch('/notifications/count')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notificationCount');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'block';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(error => console.log('Error fetching notification count:', error));
    }
    
    // Update count on page load
    document.addEventListener('DOMContentLoaded', updateNotificationCount);
    
    // Update count every 30 seconds
    setInterval(updateNotificationCount, 30000);
    
    // Add click handler for notification button
    document.addEventListener('DOMContentLoaded', function() {
        const notificationBtn = document.getElementById('notificationBtn');
        if (notificationBtn) {
            notificationBtn.addEventListener('click', function() {
                window.location.href = '/notifications';
            });
        }
    });
    </script>
    
    @stack('scripts')
</body>
</html>