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
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Cairo', sans-serif !important;
            background-color: #e29609;
        }

        /* تصميم الـ Sidebar */
        .sidebar {
            position: fixed;
            top: 63px;
            right: 0px;
            width: 250px;
            border-radius: 61px;
            text-align: center;
            height: calc(100vh - 170px);
            /* box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1); */
            padding: 20px;
            z-index: 0;
            direction: rtl;
            align-items: center;
            justify-content: start;
            display: flex;
        }

        .sidebar ul {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            top: -21px;
            justify-content: start;
            position: relative;
        }

        .sidebar ul li {
            margin-bottom: 3px;
        }

        .sidebar ul li a {
            display: flex;
            width: 193px;
            text-align: right;
            justify-content: start;
            align-items: center;
            gap: 10px;
            color: #333;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            padding: 2px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }


        .sidebar ul li a:hover {
            background-color: #ffffff;
            color: #82535e;
        }

        .sidebar-icon {
            width: 20px;
            height: 20px;
        }

        .container {
            margin-right: 270px;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .container {
                margin-right: 0;
            }
        }

        #middle {
            width: 156px;
            margin-top: -16px;
            margin-bottom: 50px;
            z-index: 9;
        }

        #middle img {
            position: fixed;
            top: -8px;
            width: 156px;
            right: 166px;
        }

        @media (max-width: 1300px) {
            main {
                position: relative;
                right: 98px !important;
            }
        }

        @media (max-width: 1075px) {
            main {
                max-width: 500px !important;
            }
        }

        @media (max-width: 870px) {
            #middle img {
                display: none;
            }

            main {
                right: 28px !important;
            }

        }

        .logo-container {
            display: none;
        }

        @media (max-width:760px) {
            #app {

                display: none !important;
            }

            .logo-container {
                display: none;
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
            bottom: 120px;
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

        footer {
            position: fixed;
            TOP: 96%;
            width: 100%;
            height: 100%;
            left: -35%;
            Z-INDEX: 99999999;
        }

        ul li img {
            width: 30px;
            height: 15px;
        }

        footer ul li a {
            color: white;
            align-items: center;
            justify-content: center;
            margin: auto;
            display: flex;
            flex-direction: row;
            gap: 5px;
        }

        footer ul {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 20px;
            align-items: center;
            justify-content: center;
            margin: auto;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="user-layout font-sans antialiased">

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
                        <path fill="#EA4335"
                            d="M24 9.5c3.5 0 6.6 1.3 9 3.5l6.7-6.7C35.4 2.3 30.2 0 24 0 14.6 0 6.6 5.8 2.5 14.2l7.8 6C12.4 13.2 17.7 9.5 24 9.5z" />
                        <path fill="#4285F4"
                            d="M46.1 24.5c0-1.7-.1-2.9-.4-4.2H24v7.9h12.6c-.3 2.1-1.4 5.1-4.1 7.1l6.4 5C42.9 36.6 46.1 31.3 46.1 24.5z" />
                        <path fill="#FBBC05"
                            d="M10.3 28.3C9.6 26.6 9.2 24.7 9.2 22.8s.4-3.8 1.1-5.5l-7.8-6C.8 15.2 0 18.4 0 22.8s.8 7.6 2.5 11l7.8-5.5z" />
                        <path fill="#34A853"
                            d="M24 48c6.2 0 11.4-2.1 15.2-5.7l-7.1-5.5c-2 1.4-4.6 2.2-8.1 2.2-6.3 0-11.6-4.2-13.5-9.9l-7.9 6c3.9 8.3 11.8 13.9 21.4 13.9z" />
                        <path fill="none" d="M0 0h48v48H0z" />
                    </svg>
                </a>
                <a href="">
                    <svg style="color:black;" class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.537 12.625a4.421 4.421 0 0 0 2.684 4.047 10.96 10.96 0 0 1-1.384 2.845c-.834 1.218-1.7 2.432-3.062 2.457-1.34.025-1.77-.794-3.3-.794-1.531 0-2.01.769-3.275.82-1.316.049-2.317-1.318-3.158-2.532-1.72-2.484-3.032-7.017-1.27-10.077A4.9 4.9 0 0 1 8.91 6.884c1.292-.025 2.51.869 3.3.869.789 0 2.27-1.075 3.828-.917a4.67 4.67 0 0 1 3.66 1.984 4.524 4.524 0 0 0-2.16 3.805m-2.52-7.432A4.4 4.4 0 0 0 16.06 2a4.482 4.482 0 0 0-2.945 1.516 4.185 4.185 0 0 0-1.061 3.093 3.708 3.708 0 0 0 2.967-1.416Z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div id="app" class="min-h-screen"
        style="background-image: url('{{ asset('assets/img/pg.svg') }}'); background-size: cover; background-position: center;">
        <img src="{{ asset('assets/img/head1.svg') }}" alt=""
            style="z-index: 9; position: fixed; width: 100%; top: 0px;">

        <header class="bg-white shadow">
            {{ $header ?? '' }}
        </header>

        <!-- Page Content -->
        <div style="display: flex; align-items: center; justify-content: center; gap: 20px;">
            <main style="margin-top: 90px; margin-bottom: 50px; direction: rtl;">
                {{-- {{ $slot }} --}}
                @yield(section: 'content')

            </main>
            <div id="middle">
                <img src="{{ asset('assets/img/right.svg') }}" alt="">
            </div>
            <div>
                <!-- Sidebar here -->
                <div class="sidebar">

                    <ul>
                        <div type="button" class="flex mx-3 text-sm  md:mr-0" id="user-menu-button"
                            aria-expanded="false">
                            <img src="{{ asset('assets/img/logo.png') }}"
                                alt="Avatar" class="h-24 w-24 ">
                        </div>
                        <div
                            style="display: flex; align-items: center; justify-content: end; flex-direction: column; margin-bottom: 10px; ">
                            {{-- <p style="display: flex; flex-direction: column; color: rgb(0, 0, 0);"><span
                                    style="color: #c00000">مرحبا بك</span>
                                {{ Auth::user()->name }}</p> --}}
                        </div>

                        <li>
                            <a href="{{ route('about.index') }}">
                                <x-icon />
                                من نحن
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('work.index') }}">
                                <x-icon />
                                كيف نعمل
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacy.index') }}">
                                <x-icon />
                                سياسة الخصوصية
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('terms.index') }}">
                                <x-icon />
                                الشروط والأحكام
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('event.index') }}">
                                <x-icon />
                                المعارض
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('meet.index') }}">
                                <x-icon />
                                المناسبات
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('faq.index') }}">
                                <x-icon />
                                الأسئلة الشائعة
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('help_words.index') }}">
                                <x-icon />
                                كلمات مساعدة
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact.submit') }}">
                                <x-icon />
                                تواصل معنا
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}">
                                <x-icon />

                                الخروج من المنزل
                            </a>
                        </li>

                        <li>
                            <img src="{{ asset('assets/img/dragon.svg') }}"
                                style="      width: 188px;
    height: 178px;
    position: absolute;
    right: -44.9px;
    bottom: -169px;

                                alt="">
                        </li>
                    </ul>


                </div>
            </div>
        </div>

        <div style="position: relative;">
            <img src="{{ asset('assets/img/foot1.svg') }}" alt=""
                style="z-index: 9; position: fixed; width: 100%; bottom: 0px;">
            <footer>
                <ul>
                    <li><a href="#">English
                            <img src="{{ asset('assets/img/en.png') }}" alt="uae flag" class="lang-icon" />

                        </a></li>
                    <li><a href="#">中文 <img src="{{ asset('assets/img/ch.png') }}" alt="uae flag"
                                class="lang-icon" />
                        </a></li>
                    <li>
                        <a href="#" class="">
                            العربية
                            <img src="{{ asset('assets/img/uae.webp') }}" alt="uae flag" class="lang-icon" />
                        </a>
                    </li>
                </ul>

            </footer>
        </div>
    </div>
</body>

</html>
