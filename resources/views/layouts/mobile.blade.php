<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/assets/images/logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="assets/css/swiper.min.css" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="manifest" href="manifest.json" />
    <title>@yield('title')</title>
    <link href="{{ asset('assets/assets/css/style.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="-z-20" style="overflow-x: hidden;">
    {{-- <img src="{{ asset('assets/assets/images/PG-OMDA-1.png') }}" class="image-container" alt=""> --}}
    @yield('content')
    <script src="{{ asset('assets/assets/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugin-custom.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/circle-slider.js') }}"></script>
    <script src="{{ asset('assets/assets/js/main.js') }}"></script>
    <script defer src="{{ asset('assets/assets/js/index.js') }}"></script>
</body>

</html>
