@extends('layouts.appOmdahome')

@section('content')
    <style>
        #chair-image {
            bottom: 0px;
            position: absolute;
            height: 500px;
            align-items: center;
            justify-content: center;
            margin: auto;
            display: flex;
            right: 43%;
            z-index: 9999;
        }

        #container-title {
            z-index: 9999999;
            bottom: 255px;
            position: absolute;
            right: 41%;
        }

        #chat-bubble {
            height: 187px;
            align-items: center;
            justify-content: center;
            margin: auto;
            display: flex;
            z-index: 9999999;
            transform: scaleX(-1);
            rotate: 21deg;
        }

        .home-title {
            position: relative;
            z-index: 9999999;
            color: rgb(0, 0, 0);
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            top: 89px;
            right: -6px;
        }

        .ads-container {
            display: flex;
            justify-content: space-between;
        }

        .logo {
            width: 350px;
            height: 250px;
        }

        .image-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: rgb(0, 0, 0);
            font-size: 16px;
            font-weight: normal;
            text-align: center;
            z-index: 1000;
            width: 100%;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
    <div>
        <div class="container">
            <div class="top-container">
                <div class="ads-container">
                    <div>
                                        @php
                    $sliderImages = [];
                    // تجميع الصور من مجموعة البانرات
                    foreach ($banners as $banner) {
                        if (isset($banner->avatar) && !empty($banner->avatar)) {
                            $sliderImages[] = asset('storage/' . $banner->avatar);
                        }
                    }
                @endphp

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
                        setInterval(changeImage, 2000);
                    });
                </script>

                        <img src="{{ asset('assets/img/home-insaide-ads.svg') }}"
                            style="position: relative;
                    right: -95%;
                    z-index: 999;
                    top: 27px;
                    rotate: 180deg;
                    width: 400px;"
                            class="logo" alt="">


                        @if ($banners->count() > 0)
                        <img style="  position: relative;
    right: -92.8%;
    max-height: 122px;
    z-index: 999;
    top: -159px;
    width: 348px;
" src="{{ asset('storage/' . $banners->first()->avatar) }}" id="home-man" alt="Banner Image">
                    @else
                        <img style="  position: relative;
    right: -92.8%;
    max-height: 122px;
    z-index: 999;
    top: -159px;
    width: 348px;
" src="{{ asset('assets/img/default-banner.jpg') }}" id="home-man" alt="Banner Image">
                    @endif

                    </div>
                    <div>
                        <div>
                            <p style="display: flex; gap:5px; margin-top: 10px; color: rgb(0, 0, 0);"><span
                                    style="color: #c00000">مرحبا بك</span>
                                {{ Auth::user()->name }}</p>
                            <a style="background: black; color: white;
                                padding: 5px 10px; border-radius: 5px;
                                top: 15px !important;
                                position: relative;
                                z-index: 999999999999;
                                cursor: pointer;"
                                href="#"> لوحة التحكم</a>

                        </div>
                        <div style="position: relative; right: -76px; top:-10px;">
                            <img src="{{ asset('assets/img/home-insaide-ads.svg') }}" class="logo" alt="">
                            <span class="image-text">
                                <p style="font-weight: bold;">المناسبة القادمة</p>
                                @php
                                    // Get the next active occasion event
                                    $nextOccasion = DB::table('events')
                                        ->where('type', '=', 'مناسبة')
                                        ->where('status', '=', 'نشط')
                                        ->where('start_date', '>=', date('Y-m-d'))
                                        ->orderBy('start_date', 'asc')
                                        ->first();

                                    // Calculate days remaining if event exists
                                    $daysUntilOccasion = null;
                                    $occasionTitle = '';
                                    $occasionDuration = '';

                                    if ($nextOccasion) {
                                        $startDate = new DateTime($nextOccasion->start_date);
                                        $today = new DateTime(date('Y-m-d'));
                                        $daysUntilOccasion = $today->diff($startDate)->days;
                                        $occasionTitle = $nextOccasion->title_ar;

                                        // Calculate duration if end_date exists
                                        if (!empty($nextOccasion->end_date)) {
                                            $endDate = new DateTime($nextOccasion->end_date);
                                            $duration = $startDate->diff($endDate)->days + 1;
                                            $occasionDuration = "عطلة $duration يوم";
                                        }
                                    }
                                @endphp

                                @if ($nextOccasion)
                                    بعد ({{ $daysUntilOccasion }}) <br />
                                    يوم {{ $occasionTitle }} <br />
                                    {{ $occasionDuration }}
                                @else
                                    لا توجد مناسبات قادمة
                                @endif
                            </span>
                        </div>

                        <div style="top: -51px; position: relative; right: -76px;">
                            <img src="{{ asset('assets/img/home-insaide-ads.svg') }}" class="logo" alt="">
                            <span class="image-text">
                                <p style="font-weight: bold;">المعرض القادم</p>
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
                                    بعد ({{ $daysUntilExhibition }}) <br />
                                    {{ $exhibitionTitle }}
                                @else
                                    لا توجد معارض قادمة
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bottom-container">
                    <div id="container-title">
                        <p class="home-title">مرحبا بيك ببيت العمدة</p>
                        <img src="{{ asset('assets/img/chat-bubble.png') }}" id="chat-bubble" alt="">
                    </div>
                    <img src="{{ asset('assets/img/chinaomda-man.svg') }}" id="chair-image" alt="">
                </div>
            </div>
        </div>
    @endsection
