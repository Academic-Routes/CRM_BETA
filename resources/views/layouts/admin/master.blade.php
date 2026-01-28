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
    let eventSource;

    function initializeNotifications() {
        updateNotificationCount();
        startSSE();
    }

    function startSSE() {
        eventSource = new EventSource('/notifications/stream');
        
        eventSource.onmessage = function(event) {
            const data = JSON.parse(event.data);
            
            if (data.type === 'notification') {
                showNotificationToast(data);
                updateNotificationCount();
            }
        };
        
        eventSource.onerror = function(event) {
            console.log('SSE connection error, reconnecting...');
            eventSource.close();
            setTimeout(startSSE, 3000);
        };
    }

    function updateNotificationCount() {
        fetch('/notifications/count')
            .then(response => response.json())
            .then(data => {
                updateNotificationBadge(data.count);
            })
            .catch(error => console.log('Error fetching notification count:', error));
    }
    
    function updateNotificationBadge(count) {
        const badge = document.getElementById('notificationCount');
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        }
    }

    function showNotificationToast(notification) {
        const toast = document.createElement('div');
        toast.className = 'notification-toast';
        toast.innerHTML = `
            <div class="toast-header fw-bold text-primary">${notification.title}</div>
            <div class="toast-body text-sm">${notification.message}</div>
        `;
        toast.style.cssText = `
            position: fixed; top: 80px; right: 20px; z-index: 9999;
            background: #fff; border-left: 4px solid #007bff; border-radius: 8px;
            padding: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            max-width: 350px; min-width: 300px;
            transform: translateX(100%); transition: transform 0.3s ease;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);
        
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }
    
    document.addEventListener('DOMContentLoaded', initializeNotifications);
    
    window.addEventListener('beforeunload', function() {
        if (eventSource) {
            eventSource.close();
        }
    });
    
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