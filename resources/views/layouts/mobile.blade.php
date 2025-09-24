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
    <script src="https://js.ziina.com/v1/ziina.js"></script>
</head>

<body class="-z-20" style="overflow-x: hidden;">
    {{-- <img src="{{ asset('assets/assets/images/PG-OMDA-1.png') }}" class="image-container" alt=""> --}}
    @yield('content')
    <script src="{{ asset('assets/assets/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugin-custom.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/circle-slider.js') }}"></script>
    <script src="{{ asset('assets/assets/js/main.js') }}"></script>
    <script defer src="{{ asset('assets/assets/js/index.js') }}"></script>
    @auth
        <!-- Firebase Modular SDK -->
        <script type="module">
            import {
                initializeApp
            } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js";
            import {
                getMessaging,
                getToken
            } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-messaging.js";

            const firebaseConfig = {
                apiKey: "AIzaSyBQCPTwnybdtLNUwNCzDDA23TLt3pD5zP4",
                authDomain: "omdachina25.firebaseapp.com",
                projectId: "omdachina25",
                storageBucket: "omdachina25.firebasestorage.app",
                messagingSenderId: "1031143486488",
                appId: "1:1031143486488:web:0a662055d970826268bf6d",
                measurementId: "G-G9TLSKJ92H"
            };

            const app = initializeApp(firebaseConfig);
            const messaging = getMessaging(app);

            async function requestFCMToken() {
                try {
                    const token = await getToken(messaging, {
                        vapidKey: "BB168ueRnlIhDY0r5lrLD7pvQydPk467794F97CWizmwnvzxAWtlx3fuZ9NQtxc0QeokXdnBjiYoiINBIRvCQiY"
                        // حط هنا ال Public Key اللي تحت في Web Push Certificates
                    });
                    
                    console.log("FCM Token:", token);
                    if (token) {
                        await fetch("{{ route('save-fcm-token') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({
                                token
                            }),
                        });
                    }
                } catch (e) {
                    console.error("FCM Error:", e);
                }
            }

            requestFCMToken();
        </script>
    @endauth
</body>

</html>
