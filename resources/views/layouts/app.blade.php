<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>عمدة الصين | China Omda</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/fav.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="{{ asset('assets/assets/css/notifications.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <main>
            <div class="badge" id="unreadBadge" style="display: none;">
                <span id="unreadCount">0</span> إشعار جديد
            </div>
            @yield('content')
        </main>
    </div>
</body>

</html>