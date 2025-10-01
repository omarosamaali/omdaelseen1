<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/assets/images/logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/assets/css/swiper.min.css') }}" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <title>الإشعارات | Notifications</title>
    <link href="{{ asset('assets/assets/css/style.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <img src="{{ asset('assets/assets/images/PG-OMDA-1.png') }}" class="image-container" alt="">
    <div class="container bg-white dark:bg-color10 p-6 min-h-screen dark:text-white relative">
        <div class="flex justify-start items-center gap-3">
            <div
                class="flex justify-start items-center gap-3 bg-color14 border border-color16 p-4 rounded-full w-full dark:border-bgColor16 dark:bg-bgColor14">
                <i class="ph ph-magnifying-glass"></i>
                <input type="text" id="searchInput" placeholder="{{ __('messages.search_placeholder') }}"
                    class="bg-transparent outline-none placeholder:text-color1 w-full text-xs dark:text-white dark:placeholder:text-white" />
            </div>
            <x-back-button href="{{ url()->previous() }}" />
        </div>
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
        <p class="text-xl font-semibold pt-8">{{ __('messages.notifications_title') }}</p>
        <div class="flex flex-col gap-4 pt-5">
            <div id="notifications-container" class="flex flex-col gap-4 pt-5">
                @foreach ($places as $place)
                <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item"
                    data-id="place-{{ $place->id }}">
                    <p>تمت إضافة {{ $place->name_ar }}</p>
                    <i class="ph ph-x"></i>
                </div>
                @endforeach
                @foreach ($favorites as $favorite)
                <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item"
                    data-id="favorite-{{ $favorite->id }}">
                    <p>أضاف {{ $favorite->user->name }} {{ $favorite->place->name_ar }} الي المفضلة</p>
                    <i class="ph ph-x"></i>
                </div>
                @endforeach
                @foreach ($reports as $report)
                <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item"
                    data-id="report-{{ $report->id }}">
                    <p>{{ __('messages.place_reported', ['name' => $report->place->{'name_' . App::getLocale()} ??
                        __('messages.place_name')]) }}</p>
                    <i class="ph ph-x"></i>
                </div>
                @endforeach
@foreach ($review_reports as $report)
                <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item"
                    data-id="review_report-{{ $report->id }}">
                    <p>{{ __('messages.review_reported') }}
                        {{ $report->place->name_ar }}
                    </p>
                    <i class="ph ph-x"></i>
                </div>
                @endforeach
                @foreach ($ratings as $rating)
                <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item"
                    data-id="rating-{{ $rating->id }}">
                    <p>قيم {{ $rating->user->name }} - {{ $rating->place->name_ar }}</p>
                    <i class="ph ph-x"></i>
                </div>
                @endforeach

            </div>
        </div>
    </div>
    <script src="{{ asset('assets/assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/apex-custom.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugin-custom.js') }}"></script>
    <script defer src="{{ asset('assets/assets/js/index.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function hideNotification(element) {
                element.style.display = 'none';
            }

            function markAsHidden(id) {
                let hiddenNotifications = JSON.parse(localStorage.getItem('hidden_notifications')) || [];
                if (!hiddenNotifications.includes(id)) {
                    hiddenNotifications.push(id);
                    localStorage.setItem('hidden_notifications', JSON.stringify(hiddenNotifications));
                }
                // أرسل التحديث إلى الخادم فورًا
                sendHiddenNotificationsToServer();
            }

            function showNotification(element) {
                element.style.display = '';
            }

            function checkHiddenNotifications() {
                const hiddenNotifications = JSON.parse(localStorage.getItem('hidden_notifications')) || [];
                const allNotifications = document.querySelectorAll('.notification-item');

                allNotifications.forEach(item => {
                    const id = item.getAttribute('data-id');
                    if (hiddenNotifications.includes(id)) {
                        hideNotification(item);
                    } else {
                        showNotification(item);
                    }
                });
            }

            function addNotificationListeners() {
                const closeButtons = document.querySelectorAll('.ph-x');

                closeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const parentDiv = this.closest('.notification-item');
                        const notificationId = parentDiv.getAttribute('data-id');

                        if (notificationId) {
                            markAsHidden(notificationId);
                            hideNotification(parentDiv);
                        }
                    });
                });
            }

            // دالة لإرسال الإشعارات المخفية إلى الخادم
            function sendHiddenNotificationsToServer() {
                const hiddenNotifications = localStorage.getItem('hidden_notifications');
                if (hiddenNotifications) {
                    fetch('/update-hidden-notifications', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                hidden_notifications: hiddenNotifications
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Hidden notifications updated on server:', data);
                        })
                        .catch(error => {
                            console.error('Error sending hidden notifications:', error);
                        });
                }
            }

            addNotificationListeners();
            checkHiddenNotifications();
            sendHiddenNotificationsToServer(); // أرسل البيانات عند تحميل الصفحة لأول مرة

            const input = document.getElementById('searchInput');
            const container = document.getElementById('notifications-container');
            let timer;

            input.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    let query = this.value;

                    fetch(`{{ route('mobile.notifications.search') }}?query=${query}`)
                        .then(res => res.json())
                        .then(data => {
                            container.innerHTML = '';

                            // بناء المحتوى ديناميكيًا
                            data.places.forEach(place => {
                                container.innerHTML += `
                                    <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item" data-id="place-${place.id}">
                                        <p>تم إضافة ${place.name_ar}</p>
                                        <i class="ph ph-x"></i>
                                    </div>`;
                            });

                            data.favorites.forEach(fav => {
                                container.innerHTML += `
                                    <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item" data-id="favorite-${fav.id}">
                                        <p>أضاف <span style="color: rebeccapurple; font-weight: bold;">${fav.user.name}</span> ${fav.place.name_ar} إلي المفضلة</p>
                                        <i class="ph ph-x"></i>
                                    </div>`;
                            });

                            data.ratings.forEach(rating => {
                                container.innerHTML += `
                                    <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item" data-id="rating-${rating.id}">
                                        <p>قيم <span style="color: rebeccapurple; font-weight: bold;">${rating.user.name}</span> ${rating.place.name_ar}</p>
                                        <i class="ph ph-x"></i>
                                    </div>`;
                            });

                            data.reports.forEach(rep => {
                                container.innerHTML += `
                                    <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item" data-id="report-${rep.id}">
                                        <p>تم الإبلاغ عن ${rep.place.name_ar}</p>
                                        <i class="ph ph-x"></i>
                                    </div>`;
                            });

                            data.review_reports.forEach(rep => {
                                container.innerHTML += `
                                    <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item" data-id="review_report-${rep.id}">
                                        <p>تم الإبلاغ عن تقييم يخص ${rep.place.name_ar}</p>
                                        <i class="ph ph-x"></i>
                                    </div>`;
                            });

                            if (data.places.length === 0 && data.favorites.length === 0 && data.ratings.length === 0 && data.reports.length === 0 && data.review_reports.length === 0) {
                                container.innerHTML = `<p class="text-center text-gray-500 dark:text-gray-400">لا توجد نتائج</p>`;
                            }

                            addNotificationListeners();
                            checkHiddenNotifications();
                        });
                }, 500);
            });
        });
    </script>
</body>

</html>