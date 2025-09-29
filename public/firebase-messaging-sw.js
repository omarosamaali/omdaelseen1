importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js');

firebase.initializeApp({
  apiKey: "AIzaSyBQCPTwnybdtLNUwNCzDDA23TLt3pD5zP4",
  authDomain: "omdachina25.firebaseapp.com",
  projectId: "omdachina25",
  storageBucket: "omdachina25.firebasestorage.app",
  messagingSenderId: "1031143486488",
  appId: "1:1031143486488:web:0a662055d970826268bf6d"
});

const messaging = firebase.messaging();

// استقبال الإشعارات في الخلفية
messaging.onBackgroundMessage(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    
    const notificationTitle = payload.notification?.title || 'إشعار';
    const notificationOptions = {
        body: payload.notification?.body || '',
        icon: '/favicon.ico',
        badge: '/favicon.ico',
        data: payload.data,
        tag: 'notification-tag', // منع تكرار الإشعارات
        actions: [
            {
                action: 'view',
                title: 'عرض'
            }
        ]
    };
    
    self.registration.showNotification(notificationTitle, notificationOptions);
});

// التعامل مع النقر على الإشعار
self.addEventListener('notificationclick', function(event) {
    console.log('[Service Worker] Notification click received.');
    
    event.notification.close();
    
    if (event.action === 'view' || !event.action) {
        const urlToOpen = event.notification.data?.place_id 
            ? `/mobile/info_place/${event.notification.data.place_id}`
            : '/';
            
        event.waitUntil(
            clients.openWindow(urlToOpen)
        );
    }
});

// التعامل مع أخطاء الـ Service Worker
self.addEventListener('error', function(error) {
    console.error('Service Worker error:', error);
});

// تحديث الـ Service Worker
self.addEventListener('activate', function(event) {
    console.log('[Service Worker] Activating...');
    event.waitUntil(self.clients.claim());
});

self.addEventListener('install', function(event) {
    console.log('[Service Worker] Installing...');
    self.skipWaiting();
});