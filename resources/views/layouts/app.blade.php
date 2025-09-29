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
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <main>
            @yield('content')
        </main>
    </div>

<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
              window.OneSignalDeferred.push(async function(OneSignal) {
                  await OneSignal.init({
                      appId: "212ca723-6015-43de-8e66-6f24d0defbd9  ",
                      notifyButton: {
                          enable: true
                      },
                      serviceWorkerPath: "push/onesignal/OneSignalSDKWorker.js",
                      serviceWorkerParam: { scope: "/push/onesignal/js/" },
                  });
              });
    </script>

</body>
</html>


