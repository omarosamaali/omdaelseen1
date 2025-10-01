<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/assets/images/logo.png') }}" type="image/x-icon" />
    <link rel="icon" href="{{ asset('assets/assets/images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/swiper.min.css" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <title>@yield('title')</title>
    <link href="{{ asset('assets/assets/css/style.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Cairo:wght@200..1000&display=swap"
        rel="stylesheet">
    @vite('resources/js/app.js')
    <script src="https://js.ziina.com/v1/ziina.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="-z-20" style="overflow-x: hidden;">
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
                        
                        const emptyState = document.querySelector('.empty-state');
                        if (emptyState) {
                            emptyState.remove();
                        }
                        
                        displayNotification(notification, notificationId);
                        updateUnreadCount();
                        playNotificationSound();
                        showBrowserNotification(notification);
                        animateBell();
                    });
            
                    function displayNotification(data, id) {
                        const container = document.getElementById('notifications');
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
                        
                        countSpan.textContent = unreadCount;
                        badge.style.display = 'block';
                    }
            
                    function animateBell() {
                        const badge = document.getElementById('unreadBadge');
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
            
                    // تحميل الإشعارات السابقة
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
        </script>
    {{-- <img src="{{ asset('assets/assets/images/PG-OMDA-1.png') }}" class="image-container" alt=""> --}}
    @yield('content')
    <script src="{{ asset('assets/assets/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugin-custom.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/circle-slider.js') }}"></script>
    <script src="{{ asset('assets/assets/js/main.js') }}"></script>
    <script defer src="{{ asset('assets/assets/js/index.js') }}"></script>

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
                
                const emptyState = document.querySelector('.empty-state');
                if (emptyState) {
                    emptyState.remove();
                }
                
                displayNotification(notification, notificationId);
                updateUnreadCount();
                playNotificationSound();
                showBrowserNotification(notification);
                animateBell();
            });
    
            function displayNotification(data, id) {
                const container = document.getElementById('notifications');
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
                
                countSpan.textContent = unreadCount;
                badge.style.display = 'block';
            }
    
            function animateBell() {
                const badge = document.getElementById('unreadBadge');
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
    
            // تحميل الإشعارات السابقة
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
    </script>

</body>

</html>