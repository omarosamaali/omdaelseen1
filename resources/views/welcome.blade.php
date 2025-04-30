@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> عمدة الصين</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">

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
                z-index: 99999;
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

            .logo-title {
                width: 70%;
                z-index: 99;
                color: #be3d1e;
                text-align: center;
                font-size: 56px;
                font-weight: normal !important;
                position: absolute;
                top: 30%;
                line-height: 1.4;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .main-content {
                flex: 1;
                padding: 20px;
            }

            .chair-image {
                position: absolute;
                bottom: 52px;
                left: 50%;
                transform: translateX(-50%);
                height: 400px;
                z-index: 9;
            }

            .arrow-image {
                position: absolute;
                bottom: 0;
                left: 90%;
                transform: translateX(-90%);
                height: 200px;
                z-index: 9;
            }

            .arrow-link {
                position: absolute;
                bottom: 14%;
                left: 87.9%;
                z-index: 99;
                transform: translateX(-90%);
                color: #efdfe6;
                text-decoration: none;
                font-size: 25px;
                font-weight: bold;
                min-width: 170px;
            }

            .logo-container {
                display: none;
            }

            @media (max-width:760px) {
                .page-container {
                    display: none;
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

            .google-play svg {
                width: 50px;
                height: 50px;
            }

            .logo-container-bottom {
                display: flex;
                justify-content: center;
                align-items: center;
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

            .dragon-container {
                width: 100%;
                overflow: hidden;
                position: relative;
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

            #next-date {
                position: absolute;
                z-index: 999999;
                top: 48px;
                text-align: center;
                left: 48px;
                color: white;
            }

            #next-date-2 {
                position: absolute;
                z-index: 999999;
                top: 44px;
                text-align: center;
                right: 33px;
                color: white;
            }

            #home-man {
                width: 214px;
                height: 152px;
                position: absolute;
                top: 79px;
                right: 103px;
                z-index: 0;
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

        <div class="page-container">
            <div class="">
                <div>
                    <img style="right: 20px; position: absolute; width: 150px;" src="{{ asset('assets/img/sgin.svg') }}"
                        alt="">
                    <div id="next-date">
                        <p style="font-weight: bold;">المناسبة القادمة</p>
                        @php
                            // Get the next active exhibition event
                            $nextExhibition1 = DB::table('events')
                                ->where('type', '=', 'مناسبة')
                                ->where('status', '=', 'نشط')
                                ->where('start_date', '>=', date('Y-m-d'))
                                ->orderBy('start_date', 'asc')
                                ->first();
                        @endphp
                        @if ($nextExhibition1)
                            <p>{{ $event->start_date }}</p>
                        @else
                            <p>--/--/--</p>
                        @endif
                    </div>
                </div>
                <div>
                    <img style="left: 20px; position: absolute; width: 150px;" src="{{ asset('assets/img/sgin.svg') }}"
                        alt="">
                    <div id="next-date-2">
                        <p style="font-weight: bold; margin-right: 15px;">المعرض القادم</p>
                        @php
                            // Get the next active exhibition event
                            $nextExhibition = DB::table('events')
                                ->where('type', '=', 'معرض')
                                ->where('status', '=', 'نشط')
                                ->where('start_date', '>=', date('Y-m-d'))
                                ->orderBy('start_date', 'asc')
                                ->first();

                            // Calculate days remaining if event exists
                            $daysUntilExhibition = null;
                            $exhibitionTitle = '';

                            if ($nextExhibition) {
                                $startDate = new DateTime($nextExhibition->start_date);
                                $today = new DateTime(date('Y-m-d'));
                                $daysUntilExhibition = $today->diff($startDate)->days;
                                $exhibitionTitle = $nextExhibition->title_ar;
                            }
                        @endphp

                        @if ($nextExhibition)
                            {{-- {{ Str::limit($exhibitionTitle, 1) }} <br /> --}}
                            بعد ({{ $daysUntilExhibition }}) يوم
                        @else
                            لا توجد معارض قادمة
                        @endif

                    </div>
                </div>
                <div class="dragon-container">
                    <img class="dragon-img" src="{{ asset('assets/img/darogn.gif') }}" alt="">
                </div>
                <div class="">
                    <div class="logo-container-bottom">
                        <img class="logo pendulum" src="{{ asset('assets/img/logo.svg') }}" alt="">
                    </div>
                    <h1 class="logo-title">مرحبا بك في قرية عمدة الصين</h1>

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
                        <li><a href="#">中文 <img src="{{ asset('assets/img/ch.png') }}" alt="uae flag"
                                    class="lang-icon" />
                            </a></li>

                    </ul>
                </div>
                {{-- جمع الصور للسلايدر --}}
                @php
                    $sliderImages = [];
                    // تجميع الصور من مجموعة البانرات
                    foreach ($banners as $banner) {
                        if (isset($banner->avatar) && !empty($banner->avatar)) {
                            $sliderImages[] = asset('storage/' . $banner->avatar);
                        }
                    }
                @endphp

                {{-- كود السلايدر --}}
                <script>
                    // نقل مصفوفة الصور من PHP إلى JavaScript
                    const bannerImages = {!! json_encode($sliderImages) !!};

                    document.addEventListener('DOMContentLoaded', function() {
                        // تحديد الصورة المراد تغييرها
                        const bannerImage = document.getElementById('home-man');

                        // في حالة عدم وجود صور متعددة، لا داعي لإنشاء سلايدر
                        if (bannerImages.length <= 1) {
                            return;
                        }

                        // مؤشر الصورة الحالية
                        let currentImageIndex = 0;

                        // وظيفة تغيير الصورة
                        function changeImage() {
                            // الانتقال للصورة التالية في المصفوفة
                            currentImageIndex = (currentImageIndex + 1) % bannerImages.length;

                            // إخفاء الصورة الحالية
                            bannerImage.style.opacity = '0';

                            // تغيير الصورة بعد الإخفاء
                            setTimeout(function() {
                                bannerImage.src = bannerImages[currentImageIndex];

                                // إظهار الصورة الجديدة
                                bannerImage.style.opacity = '1';
                            }, 500);
                        }

                        // إضافة تأثير الانتقال للصورة
                        bannerImage.style.transition = 'opacity 0.5s ease-in-out';

                        // تشغيل السلايدر كل ثانيتين
                        setInterval(changeImage, 30000);
                    });
                </script>

                {{-- عرض الصورة الأولى من المجموعة --}}
                <div style="position: absolute; bottom: 55px; left: 11%;">
                    <img src="{{ asset('assets/img/home-ads.svg') }}"
                        style="
                                position: relative;
                                z-index: 99;
                                width: 400px; height: 400px;"
                        alt="">

                    @if ($banners->count() > 0)
                        <img src="{{ asset('storage/' . $banners->first()->avatar) }}" id="home-man" alt="Banner Image">
                    @else
                        <img src="{{ asset('assets/img/default-banner.jpg') }}" id="home-man" alt="Banner Image">
                    @endif
                </div>
                {{-- <div style="position: absolute; bottom: 55px; left: 11%;">
                    <img src="{{ asset('assets/img/home-ads.svg') }}"
                        style="
                        position: relative;
                        z-index: 99;
                        width: 400px; height: 400px;"
                        alt="">


                    <img src="{{ asset('storage/' . $banners->avatar) }}" id="home-man" alt="Banner Image">


                </div> --}}
                <!-- Main Content with Background -->
                <div class="main-content">
                    <img class="chair-image" src="{{ asset('assets/img/chinaomda-man.svg') }}" alt="unkown image">

                    <div class="arrow-container">
                        <a href="{{ route('home') }}" class="arrow-link">الدخول للقرية</a>
                        <img class="arrow-image" src="{{ asset('assets/img/arrow-l.svg') }}" alt="unkown image">
                    </div>
                </div>
                <footer>
                    <div class="footer-container">
                        <div class="footer-link">صمم ونحن ☕ في الامارات العربية المتحدة
                        </div>
                        <div class="footer-link-bottom">
                            جميع الحقوق محفوظة ل عمدة الصين للوساطة التجارية © 2025
                        </div>
                    </div>
                </footer>
            </div>

            @if (Route::has('login'))
                {{-- <div class="h-14.5 hidden lg:block"></div> --}}
            @endif
    </body>

    </html>
@endsection
