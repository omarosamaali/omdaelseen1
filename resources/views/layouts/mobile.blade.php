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
    const firebaseConfig = {
    apiKey: "AIzaSyBQCPTwnybdtLNUwNCzDDA23TLt3pD5zP4",
    authDomain: "omdachina25.firebaseapp.com",
    databaseURL: "https://omdachina25-default-rtdb.firebaseio.com",
    projectId: "omdachina25",
    storageBucket: "omdachina25.firebasestorage.app",
    messagingSenderId: "1031143486488",
    appId: "1:1031143486488:web:0a662055d970826268bf6d",
  };

  firebase.initializeApp(firebaseConfig);

  const messaging = firebase.messaging();

  // طلب إذن الإشعارات
  Notification.requestPermission().then(permission => {
    if (permission === "granted") {
      messaging.getToken({ vapidKey: "BB168ueRnlIhDY0r5lrLD7pvQydPk467794F97CWizmwnvzxAWtlx3fuZ9NQtxc0QeokXdnBjiYoiINBIRvCQiY" })
        .then((currentToken) => {
          if (currentToken) {
            console.log("✅ FCM Token:", currentToken);
            // هنا بقى تبعته للباك اند Laravel واحفظه في DB
          }
        });
    }
  });

  // استقبال إشعار لو المتصفح مفتوح
  messaging.onMessage((payload) => {
    console.log("📩 إشعار مستلم:", payload);
    new Notification(payload.notification.title, {
      body: payload.notification.body,
      icon: "/favicon.ico"
    });
  });
</script>

</body>

</html>