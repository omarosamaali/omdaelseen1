{{-- <x-guest-layout> --}}
<!-- Session Status -->
{{-- <x-auth-session-status :status="session('status')" /> --}}
@extends('layouts.app')

@section('content')


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>قرية عمدة الصين</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: "cairo", sans-serif;
            overflow-x: hidden;
            /* background-color: #e29609; */
        }

        .page {
            bottom: 69px;
            position: absolute;
            width: 100%;
        }

        .page-container {
            display: flex;
            height: 100vh;
            background-image: url('{{ asset('assets/img/bg-w.svg') }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            width: 100%;
        }

        .sidebar {
            width: fit-content;
            color: white;
            padding: 20px;
            transform: translateY(-50%);
            position: fixed;
            top: 50%;
            left: 0;
            height: auto;
            z-index: 9999999;
        }

        .sidebar-links {
            list-style-type: none;
            padding: 0;
        }

        .sidebar-links li {
            margin: 15px 0;
        }

        .sidebar-links a {
            color: #000000 !important;
            rotate: 270deg;
            font-weight: bold;
            text-decoration: none;
            font-size: 18px;
            display: flex;
            /* تغيير إلى flex لمحاذاة النص والصورة */
            align-items: center;
            /* محاذاة عمودية للنص والصورة */
            padding: 20px 10px;
            border-radius: 5px;
        }

        .language-link {
            gap: 8px;
            /* مسافة بين النص والصورة */
        }

        .lang-icon {
            width: 20px;
            /* حجم الصورة الصغير */
            height: 20px;
            object-fit: contain;
            /* لضمان تناسق الصورة */
            transform: rotate(-270deg);
            /* لتصحيح الصلاحيةان بما يتناسب مع النص */
        }


        .main-content {
            flex: 1;
            padding: 20px;
            position: relative;
        }

        .chair-image {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            height: 400px;
            z-index: 9;
        }

        .arrow-image-sec-page {
            position: absolute;
            bottom: 0;
            left: -70%;
            height: 160px;
            z-index: 99999;
            cursor: pointer;
            transition: .3s;
        }

        .arrow-image-sec-page:hover {
            transform: rotate(13deg);
            transition: transform 0.3s ease;
        }

        .arrow-link {
            position: absolute;
            bottom: 12%;
            left: 85.5%;
            z-index: 99;
            transform: translateX(-90%);
            color: white;
            text-decoration: none;
            font-size: 45px;
            transition: .2s;
        }

        .arrow-link:hover {
            scale: 1.1;
        }

        .logo-container {
            display: none;
        }

        @media (max-width:760px) {
            .page-container {
                display: none;
            }

            .logo-container {
                display: block;
            }
        }


        .logo-container img {
            width: 200px;
            height: 200px;
            position: absolute;
            top: 0px;
            left: 50%;
            transform: translateX(-50%);
        }

        .logo-pc {
            color: white;
            text-align: center;
            font-size: 31px;
            font-weight: 600;
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
        }

        .logo-pc-h3 {
            color: white;
            text-align: center;
            font-size: 31px;
            font-weight: 600;
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
        }

        .google-play {
            bottom: 0px;
            position: absolute;
            align-items: center;
            justify-content: space-between;
            display: flex;
            width: 93%;
            padding: 20px;
            align-items: center;
            margin: auto;
        }

        .logo-title {
            width: 70%;
            z-index: 99;
            color: #be3d1e;
            text-align: center;
            font-size: 46px;
            font-weight: normal !important;
            position: absolute;
            top: 30%;
            line-height: 1.4;
            left: 50%;
            transform: translate(-50%, -50%);
        }


        .google-play svg {
            width: 50px;
            height: 50px;
        }

        .logo {
            position: absolute;
            top: 100px;
            left: 50%;
            width: 200px;
            height: 200px;
            z-index: 99999;
            transform: translate(-50%, -50%);
        }

        .home-containers {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
            justify-items: center;
            align-items: baseline;
            max-width: 87%;
            margin: auto;
        }

        .home-containers img {
            width: 100%;
            max-width: 245px;
            height: auto;
            cursor: pointer;
            transition: transform 0.3s ease;
            z-index: 99999;
        }

        .home-containers img:hover {
            transform: scale(1.05);
        }

        .page {
            display: block;
        }

        .active-page {
            display: block;
        }

        .pagination-controls {
            display: flex;
            justify-content: center;
            gap: 20px;
            bottom: 20px;
            position: absolute;
            right: 15%;
        }

        .pagination-button {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .pagination-button:hover {
            background-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }

        .pagination-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-indicator {
            color: white;
            display: flex;
            align-items: center;
            font-size: 18px;
            z-index: 99999999;
            position: relative;
        }

        .logo-container-bottom {
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .dragon-container {
            width: 100%;
            overflow: hidden;
            position: absolute;
            height: 200px;
            /* Adjust as needed */
        }

        .dragon-img {
            position: absolute;
            width: 150px;
            /* Adjust based on your dragon image size */
            height: auto;
            animation: dragonMove 10s linear infinite;
        }

        @keyframes dragonMove {
            0% {
                left: 100%;
                transform: scaleX(1);
                /* Original orientation */
            }

            45% {
                left: 0;
                transform: scaleX(1);
                /* Original orientation */
            }

            50% {
                left: 0;
                transform: scaleX(-1);
                /* Flip horizontally */
            }

            95% {
                left: 100%;
                transform: scaleX(-1);
                /* Flipped orientation */
            }

            100% {
                left: 100%;
                transform: scaleX(1);
                /* Back to original orientation */
            }
        }

        .home-title {
            text-align: center;
            color: white;
            font-size: 19px;
            margin: 0px;
            top: -10px;
            position: relative;
        }

        .footer-container {
            margin: auto;
            align-items: center;
            justify-content: center;
            display: flex;
            flex-direction: column;
            text-align: center;
            width: 100%;

        }

        footer {
            position: absolute;
            bottom: 5px;
            align-items: center;
            justify-content: center;
            margin: auto;
            display: flex;
            flex-direction: column;
            width: 100%;
            z-index: 99999999999;
            color: white;
        }

        a {
            text-decoration: none;
        }
        input {
                font-size: 12px;
        }
        input:focus {
            outline: none;
            border: none;
        }

        .register-btn:hover {
            color:#1a1a1a !important;
        }
    </style>

</head>
<body style="overflow: hidden;">
    <div class="logo-container">
        <img src="{{ asset('assets/img/logo.svg') }}" alt="">

        <div>
            <h1 class="logo-pc">هذا الموقع متوفر فقط علي أجهزة الكمبيوتر</h1>
        </div>
        <div>
            <h3 class="logo-pc-h3">
                قم بتحميل تطبيق قرية عمدة الصين علي الهاتف
            </h3>
            <div class="google-play">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48">
                        <path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.3 9 3.5l6.7-6.7C35.4 2.3 30.2 0 24 0 14.6 0 6.6 5.8 2.5 14.2l7.8 6C12.4 13.2 17.7 9.5 24 9.5z" />
                        <path fill="#4285F4" d="M46.1 24.5c0-1.7-.1-2.9-.4-4.2H24v7.9h12.6c-.3 2.1-1.4 5.1-4.1 7.1l6.4 5C42.9 36.6 46.1 31.3 46.1 24.5z" />
                        <path fill="#FBBC05" d="M10.3 28.3C9.6 26.6 9.2 24.7 9.2 22.8s.4-3.8 1.1-5.5l-7.8-6C.8 15.2 0 18.4 0 22.8s.8 7.6 2.5 11l7.8-5.5z" />
                        <path fill="#34A853" d="M24 48c6.2 0 11.4-2.1 15.2-5.7l-7.1-5.5c-2 1.4-4.6 2.2-8.1 2.2-6.3 0-11.6-4.2-13.5-9.9l-7.9 6c3.9 8.3 11.8 13.9 21.4 13.9z" />
                        <path fill="none" d="M0 0h48v48H0z" />
                    </svg>
                </a>
                <a href="">
                    <svg style="color:black;" class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.537 12.625a4.421 4.421 0 0 0 2.684 4.047 10.96 10.96 0 0 1-1.384 2.845c-.834 1.218-1.7 2.432-3.062 2.457-1.34.025-1.77-.794-3.3-.794-1.531 0-2.01.769-3.275.82-1.316.049-2.317-1.318-3.158-2.532-1.72-2.484-3.032-7.017-1.27-10.077A4.9 4.9 0 0 1 8.91 6.884c1.292-.025 2.51.869 3.3.869.789 0 2.27-1.075 3.828-.917a4.67 4.67 0 0 1 3.66 1.984 4.524 4.524 0 0 0-2.16 3.805m-2.52-7.432A4.4 4.4 0 0 0 16.06 2a4.482 4.482 0 0 0-2.945 1.516 4.185 4.185 0 0 0-1.061 3.093 3.708 3.708 0 0 0 2.967-1.416Z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="page-container">
        <div class="dragon-container">
            <img class="dragon-img" src="{{ asset('assets/img/darogn.gif') }}" alt="">
        </div>
        <img style="z-index: 999999; position: absolute; max-width: 519px; bottom: 86px;" src="{{ asset('assets/img/tree.svg') }}" alt="">

        <h1 class="logo-title">مرحبا بالضيف عرف نفسك للدخول للقرية</h1>
        <div class="logo-container-bottom">
            <img class="logo" src="{{ asset('assets/img/logo.svg') }}" alt="">
        </div>
        <!-- Sidebar -->
        <div class="sidebar">
            <ul class="sidebar-links">
                <li><a href="/">الرئيسية</a></li>
                <li>
                    <a href="#" class="">
                        العربية
                        <img src="{{ asset('assets/img/uae.webp') }}" alt="uae flag" class="lang-icon" />
                    </a>
                </li>
                <li><a href="#">English
                        <img src="{{ asset('assets/img/en.png') }}" alt="uae flag" class="lang-icon" />

                    </a></li>
                <li><a href="#">中文 <img src="{{ asset('assets/img/ch.png') }}" alt="uae flag" class="lang-icon" />
                    </a></li>

            </ul>
        </div>



        <!-- Main Content with Background -->
        <div class="main-content" style="  text-align: center;   max-width: 385px;
    align-items: center;
    justify-content: center;
    display: flex
;
    margin: auto;
    margin-top: 330px;
    background: #d1d1d142;
    z-index: 9999999999;border-radius: 26px;">

            <!-- Page 1 - First 4 houses -->
            <form method="POST" action="{{ route('login') }}" style="margin-top: 1rem;">
                @csrf

                <!-- Email Address -->
                <div style="margin-bottom: 1rem;">
                    <x-input-label for="email" :value="__('البريد الالكتروني')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" style="text-align: center; display: block; margin-top: 0.25rem; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;" />
                    <x-input-error :messages="$errors->get('email')" style="margin-top: 0.5rem;" />
                </div>

                <!-- Password -->
                <div style="margin-top: 1rem; margin-bottom: 1rem;">
                    <x-input-label for="password" :value="__('كلمة المرور')" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="current-password" style="text-align: center; display: block; margin-top: 0.25rem; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;" />

                    <x-input-error :messages="$errors->get('password')" style="margin-top: 0.5rem;" />
                </div>

                <!-- Remember Me -->
                <div style="margin-top: 1rem;">
                    <label for="remember_me" style="display: inline-flex; align-items: center;">
                        <input id="remember_me" type="checkbox" name="remember" style="border-radius: 0.25rem; border: 1px solid #d1d5db; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                        <span style="margin-left: 0.5rem; font-size: 0.875rem; color: white;">{{ __('تذكرني') }}</span>
                    </label>
                </div>

                <div style="display: flex;
                            align-items: center;
                            justify-content: flex-end;
                            flex-direction: column-reverse;
                            margin-top: 1rem;
                            align-items: center; display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;">
                            <div>

                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" style="text-decoration: underline; font-size: 0.875rem; color: white; margin-right: 0.75rem;" onmouseover="this.style.color='#111827';" onmouseout="this.style.color='white';">
                                    {{ __('نسيت كلمة المرور') }}
                                </a>
                                @endif
                                
                                @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="register-btn" style="font-weight: 700; text-decoration: underline; font-size: 0.875rem; color: rgb(0, 0, 0) !important; margin-right: 0.75rem;" onmouseover="this.style.color='#111827';">
                                    {{ __('لا يوجد حساب') }}
                                </a>
                                @endif
                            </div>

                    <x-primary-button style="font-family: cairo; border:0; padding: 0.5rem 1rem; background-color: #c00000; color: white; border-radius: 0.375rem; font-weight: 500;">
                        {{ __('دخول') }}
                    </x-primary-button>
                </div>
            </form>


            <!-- Page 2 - Last 2 houses -->
            <div id="page2" class="page">
                <div class="home-containers">


                </div>
            </div>

            <!-- Pagination controls -->
            {{-- <div class="pagination-controls">
                
                <img id="prevBtn" onclick="changePage(-1)" class="arrow-image-sec-page" src="{{ asset('assets/img/arrow-r.svg') }}" alt="السابق">
            <img id="nextBtn" onclick="changePage(1)" class="arrow-image-sec-page" src="{{ asset('assets/img/arrow-l.svg') }}" alt="التالي">
        </div> --}}

    </div>
    <footer>
        <div class="footer-container">
            {{-- <div class="footer-link">صمم ونحن ☕ في الامارات العربية المتحدة
                    </div> --}}
            <div class="footer-link-bottom">
                جميع الحقوق محفوظة ل عمدة الصين للوساطة التجارية © 2025
            </div>
        </div>
    </footer>


    </div>

    <script>
        let currentPageIndex = 1;
        const totalPages = 2;

        function changePage(direction) {
            // Hide current page
            document.getElementById('page' + currentPageIndex).classList.remove('active-page');

            // Calculate new page index
            currentPageIndex += direction;

            // Show new page
            document.getElementById('page' + currentPageIndex).classList.add('active-page');

            // Show/hide arrows based on page index
            document.getElementById('prevBtn').style.display = (currentPageIndex === 1) ? 'none' : 'block';
            document.getElementById('nextBtn').style.display = (currentPageIndex === totalPages) ? 'none' : 'block';
        }

        // في البداية نخفي زر الرجوع لأنه أول صفحة
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('prevBtn').style.display = 'none';
        });

    </script>


</body>
</html>
@endsection


{{-- </x-guest-layout> --}}
