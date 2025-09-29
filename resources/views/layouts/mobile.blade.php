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
    {{-- <img src="{{ asset('assets/assets/images/PG-OMDA-1.png') }}" class="image-container" alt=""> --}}
    @yield('content')
    <script src="{{ asset('assets/assets/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugin-custom.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/circle-slider.js') }}"></script>
    <script src="{{ asset('assets/assets/js/main.js') }}"></script>
    <script defer src="{{ asset('assets/assets/js/index.js') }}"></script>
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
          window.OneSignalDeferred.push(async function(OneSignal) {
              await OneSignal.init({
                  appId: "212ca723-6015-43de-8e66-6f24d0defbd9",
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