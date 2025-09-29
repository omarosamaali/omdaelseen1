import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

// إعدادات Firebase
const firebaseConfig = {
    apiKey: "AIzaSyBQCPTwnybdtLNUwNCzDDA23TLt3pD5zP4",
    authDomain: "omdachina25.firebaseapp.com",
    projectId: "omdachina25",
    storageBucket: "omdachina25.firebasestorage.app",
    messagingSenderId: "1031143486488",
    appId: "1:212ca723-6015-43de-8e66-6f24d0defbd9",
    measurementId: "G-G9TLSKJ92H"
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// قائمة لتتبع الإشعارات المعالجة بناءً على report_id و type
const processedNotifications = new Set();

// تنظيف Service Workers قديمة وتسجيل Service Worker جديد
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.getRegistrations().then((registrations) => {
        const promises = registrations.map(reg => {
            if (reg.scope.includes('firebase-messaging-sw.js') || reg.scope.includes('service-worker')) {
                return reg.unregister().then(() => console.log(`Unregistered old SW: ${reg.scope}`));
            }
            return Promise.resolve();
        });

        Promise.all(promises).then(() => {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then(() => console.log('✅ Firebase Service Worker registered'))
                .catch((err) => console.error('SW registration failed:', err));
        });
    }).catch(err => console.error('Error checking SW registrations:', err));
}

// طلب الإذن وجلب التوكن مرة واحدة
window.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('fcm_token_saved')) {
        console.log('FCM Token already saved');
        return;
    }

    Notification.requestPermission().then(permission => {
        console.log('Permission:', permission);
        if (permission === 'granted') {
            getToken(messaging, {
                vapidKey: "BB168ueRnlIhDY0r5lrLD7pvQydPk467794F97CWizmwnvzxAWtlx3fuZ9NQtxc0QeokXdnBjiYoiINBIRvCQiY"
            })
            .then(currentToken => {
                if (currentToken) {
                    console.log("FCM Token:", currentToken);
                    fetch('/save-fcm-token', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ token: currentToken })
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log('Save token response:', data);
                        localStorage.setItem('fcm_token_saved', 'true');
                    })
                    .catch(err => console.error('Error saving token:', err));
                } else {
                    console.warn('No FCM registration token available.');
                }
            })
            .catch(err => console.error('Error getting token:', err));
        }
    });
});

// منع تكرار تسجيل onMessage
if (!window.__FIREBASE_ONMESSAGE_REGISTERED__) {
    window.__FIREBASE_ONMESSAGE_REGISTERED__ = true;

    onMessage(messaging, (payload) => {
        // تحقق إذا كان الإشعار تم معالجته بناءً على report_id أو place_id و type
        const notificationKey = payload.data?.report_id 
            ? `${payload.data.type}_${payload.data.report_id}`
            : `${payload.data.type}_${payload.data.place_id}`;
        if (processedNotifications.has(notificationKey)) {
            console.log(`Duplicate notification ignored: ${notificationKey}`);
            return;
        }
        if (payload.data?.type && (payload.data?.report_id || payload.data?.place_id)) {
            processedNotifications.add(notificationKey);
        }

        console.log('📩 Message received:', payload);
        console.log('🔎 Data:', payload.data);

        // تنبيه عام لأي إشعار
        Swal.fire({
            title: payload.notification?.title || 'إشعار جديد',
            text: payload.notification?.body || '',
            icon: 'info',
            confirmButtonText: 'موافق'
        });

        // إشعار مكان جديد أو مكان تم إضافته للمفضلة → للأدمن فقط
        if (payload.data?.type === 'place_added' || payload.data?.type === 'place_favorited') {
            const userRole = document.querySelector('meta[name="user-role"]')?.getAttribute('content');
            
            if (userRole === 'admin') {
                const title = payload.data.type === 'place_added' ? '🎉 مكان جديد!' : '❤️ مكان تم إضافته للمفضلة!';
                Swal.fire({
                    title: title,
                    text: `المكان: ${payload.data.place_name}`,
                    icon: 'success',
                    confirmButtonText: 'عرض',
                    showCancelButton: true,
                    cancelButtonText: 'لاحقاً'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/admin/places/${payload.data.place_id}`;
                    }
                });

                addPlaceNotification(payload);
            }
        }

        // باقي أنواع الإشعارات
        if (payload.data?.type === 'admin_place_report') {
            showAdminReportNotification(payload);
        }

        if (payload.data?.type === 'place_report') {
            updateNotificationUI(payload);
        }

        if (payload.data?.type === 'review_report') {
            updateReviewReportUI(payload);
        }
    });
}

// دالة لعرض إشعار بلاغ الأدمن
function showAdminReportNotification(payload) {
    const container = document.querySelector('.notifications-container');
    if (!container) {
        console.warn('Notifications container not found');
        return;
    }

    if (container.querySelector(`[data-id="admin-report-${payload.data.report_id}"]`)) {
        console.log(`Duplicate admin report notification ignored: ${payload.data.report_id}`);
        return;
    }

    const newNotification = `
        <div class="flex justify-between items-center pb-4 border-b border-dashed border-purple-400 dark:border-purple-600 notification-item"
             data-id="admin-report-${payload.data.report_id}">
            <p>🚨 بلاغ جديد عن المكان: ${payload.data.place_name}</p>
            <i class="ph ph-flag text-purple-500"></i>
        </div>
    `;
    container.insertAdjacentHTML('afterbegin', newNotification);
}

// دالة لتحديث واجهة إشعار تقييم تم الإبلاغ عنه
function updateReviewReportUI(payload) {
    const container = document.querySelector('.notifications-container');
    if (!container) {
        console.warn('Notifications container not found');
        return;
    }

    if (container.querySelector(`[data-id="review-report-${payload.data.report_id}"]`)) {
        console.log(`Duplicate review report notification ignored: ${payload.data.report_id}`);
        return;
    }

    container.insertAdjacentHTML('afterbegin', `
        <div class="flex justify-between items-center pb-4 border-b border-dashed border-yellow-400 dark:border-yellow-600 notification-item"
             data-id="review-report-${payload.data.report_id}">
            <p>🚨 تم الإبلاغ عن تقييم في مكانك: ${payload.notification.body}</p>
            <i class="ph ph-warning text-yellow-500"></i>
        </div>
    `);
}

// دالة لإضافة إشعار مكان جديد أو مفضل
function addPlaceNotification(payload) {
    const container = document.querySelector('.notifications-container');
    if (!container) {
        console.warn('Notifications container not found');
        return;
    }

    if (container.querySelector(`[data-id="place-${payload.data.place_id}"]`)) {
        console.log(`Duplicate place notification ignored: ${payload.data.place_id}`);
        return;
    }

    const borderColor = payload.data.type === 'place_added' ? 'border-green-400 dark:border-green-600' : 'border-red-400 dark:border-red-600';
    const message = payload.data.type === 'place_added' ? `🎉 تم إضافة المكان: ${payload.data.place_name}` : `❤️ تم إضافة المكان للمفضلة: ${payload.data.place_name}`;

    container.insertAdjacentHTML('afterbegin', `
        <div class="flex justify-between items-center pb-4 border-b border-dashed ${borderColor} notification-item"
             data-id="place-${payload.data.place_id}">
            <p>${message}</p>
            <i class="ph ph-x"></i>
        </div>
    `);
}

// دالة لتحديث واجهة إشعار بلاغ ضد مكان
function updateNotificationUI(payload) {
    const container = document.querySelector('.notifications-container');
    if (!container) {
        console.warn('Notifications container not found');
        return;
    }

    if (container.querySelector(`[data-id="report-against-${payload.data.report_id}"]`)) {
        console.log(`Duplicate place report notification ignored: ${payload.data.report_id}`);
        return;
    }

    container.insertAdjacentHTML('afterbegin', `
        <div class="flex justify-between items-center pb-4 border-b border-dashed border-red-400 dark:border-red-600 notification-item"
             data-id="report-against-${payload.data.report_id}">
            <p>تم الإبلاغ عن مكانك: ${payload.notification.body}</p>
            <i class="ph ph-warning text-red-500"></i>
        </div>
    `);
}