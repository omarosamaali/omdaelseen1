<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>عمدة الصين | China Omda</title>
    {{-- Add Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/fav.png') }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
                window.OneSignalDeferred.push(async function(OneSignal) {
                    await OneSignal.init({
                        appId: "212ca723-6015-43de-8e66-6f24d0defbd9"
                        , notifyButton: {
                            enable: true
                        }
                        , serviceWorkerPath: "/OneSignalSDKWorker.js"
                        , serviceWorkerParam: { scope: "/" },
                    });
                });
    </script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <main>
            <div class="badge" id="unreadBadge" style="display: none;">
                <span id="unreadCount">0</span> إشعار جديد
            </div>
            <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js"></script>
            <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-database-compat.js"></script>
            
            <script>
                let unreadCount = 0;
                
                // Firebase Configuration
                const firebaseConfig = {
                    databaseURL: "https://omdachina25-default-rtdb.firebaseio.com"
                };
            
                firebase.initializeApp(firebaseConfig);
                const database = firebase.database();
                
                // الاستماع لإشعارات الأدمن فقط
                const adminNotificationsRef = database.ref('notifications/admin');
            
                // الاستماع للإشعارات الجديدة
                adminNotificationsRef.on('child_added', (snapshot) => {
                    const notification = snapshot.val();
                    const notificationId = snapshot.key;
                    
                    updateUnreadCount();
                    playNotificationSound();
                    showBrowserNotification(notification);
                    animateBell();
                    
                    // عرض الإشعار فقط لو الصفحة فيها container
                    displayNotification(notification, notificationId);
                });
            
                function displayNotification(data, id) {
                    const container = document.getElementById('notifications');
                    
                    // 🔥 لو مفيش container يبقى مش صفحة الإشعارات
                    if (!container) return;
                    
                    const emptyState = document.querySelector('.empty-state');
                    if (emptyState) {
                        emptyState.remove();
                    }
                    
                    const notifDiv = document.createElement('div');
                    notifDiv.className = 'notification unread';
                    notifDiv.id = `notif-${id}`;
                    
                    const time = new Date(data.timestamp * 1000);
                    const timeString = time.toLocaleString('ar-EG', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    notifDiv.innerHTML = `
                        <div class="notification-icon">⚠️</div>
                        <div class="notification-content">
                            <p><strong>${data.message}</strong></p>
                            <p class="time">⏰ ${timeString}</p>
                        </div>
                    `;
                    
                    container.prepend(notifDiv);
                }
            
                function updateUnreadCount() {
                    unreadCount++;
                    const badge = document.getElementById('unreadBadge');
                    const countSpan = document.getElementById('unreadCount');
                    
                    if (badge && countSpan) {
                        countSpan.textContent = unreadCount;
                        badge.style.display = 'block';
                    }
                }
            
                function animateBell() {
                    const badge = document.getElementById('unreadBadge');
                    if (!badge) return;
                    
                    badge.classList.add('shake');
                    setTimeout(() => badge.classList.remove('shake'), 500);
                }
            
                function playNotificationSound() {
                    const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBCl+zfDTgjMGHm7A7+OZSA0PVK3n77BdGAg+ltryxHMpBSuBzvLSfS4HImS57OihUxILTKXh8bllHAU2jdXyzn0vBSF7zPDUgzcIHmq77OihUBELUKvo8bllHAU5jdTyz34uBSJ7y/DUhDQIHmy57OikVRYLTKXi8bllHAU5jdTyz34uBSJ7y/DUhDQIHmy57OikVRYLTKXi8bllHAU5jdTyz34uBSJ7y/DUhDQIHmy57OikVRYLTKXi8bllHAU5jdTyz34uBSJ7y/DUhDQIHmy57OikVRYLTKXi8bllHAU5jdTyz34uBSJ7y/DUhDQIHmy57OikVRYLTKXi8bllHAU5jdTyz34uBSJ7y/DUhDQIHmy57OikVRYLTKXi8bllHAU5jdTyz34uBSJ7y/DUhDQIHmy57OikVRYLTKXi8bllHAU5jdTyz34uBSJ7y/A=');
                    audio.play().catch(e => console.log('Sound play failed:', e));
                }
            
                function showBrowserNotification(data) {
                    if ('Notification' in window && Notification.permission === 'granted') {
                        new Notification('بلاغ جديد! 🚨', {
                            body: data.message,
                            icon: '/favicon.ico',
                            requireInteraction: true
                        });
                    }
                }
            
                if ('Notification' in window && Notification.permission === 'default') {
                    Notification.requestPermission();
                }
            
                // تحميل الإشعارات السابقة (فقط في صفحة الإشعارات)
                window.addEventListener('load', function() {
                    const container = document.getElementById('notifications');
                    if (!container) return; // مش صفحة الإشعارات
                    
                    adminNotificationsRef.once('value', (snapshot) => {
                        const notifications = snapshot.val();
                        if (notifications) {
                            const notifArray = Object.keys(notifications).map(key => ({
                                id: key,
                                ...notifications[key]
                            }));
                            
                            notifArray.sort((a, b) => b.timestamp - a.timestamp);
                            
                            notifArray.forEach(notif => {
                                displayNotification(notif, notif.id);
                            });
                            
                            const emptyState = document.querySelector('.empty-state');
                            if (emptyState) emptyState.remove();
                        }
                    });
                });
            </script>
            
            <style>
                .badge {
                    position: fixed;
                    top: 20px;
                    left: 20px;
                    background: #f44336;
                    color: white;
                    padding: 8px 16px;
                    border-radius: 20px;
                    font-weight: bold;
                    box-shadow: 0 2px 8px rgba(244, 67, 54, 0.3);
                    z-index: 9999;
                    animation: fadeIn 0.3s;
                }
            
                @keyframes shake {
            
                    0%,
                    100% {
                        transform: translateX(0);
                    }
            
                    25% {
                        transform: translateX(-10px);
                    }
            
                    75% {
                        transform: translateX(10px);
                    }
                }
            
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(-20px);
                    }
            
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            
                .shake {
                    animation: shake 0.5s;
                }
            </style>
            @yield('content')
        </main>
    </div>
</body>

</html>