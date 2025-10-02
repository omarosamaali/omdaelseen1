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