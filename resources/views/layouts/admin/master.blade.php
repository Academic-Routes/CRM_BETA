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
    let lastNotificationId = 0;

    function initializeNotifications() {
        updateNotificationCount();
        startSSE();
    }

    function startSSE() {
        if (eventSource) {
            eventSource.close();
        }
        
        eventSource = new EventSource(`/notifications/stream?lastId=${lastNotificationId}`);
        
        eventSource.onmessage = function(event) {
            const data = JSON.parse(event.data);
            
            if (data.type === 'notification') {
                lastNotificationId = data.id;
                updateNotificationCount();
                showNotificationToast(data);
            }
        };
        
        eventSource.onerror = function() {
            setTimeout(startSSE, 5000);
        };
    }

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

    function showNotificationToast(notification) {
        const toast = document.createElement('div');
        toast.className = 'notification-toast';
        toast.innerHTML = `
            <div class="toast-header">${notification.title}</div>
            <div class="toast-body">${notification.message}</div>
        `;
        toast.style.cssText = `
            position: fixed; top: 20px; right: 20px; z-index: 9999;
            background: #fff; border: 1px solid #ddd; border-radius: 5px;
            padding: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 300px; animation: slideIn 0.3s ease;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
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