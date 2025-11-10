@extends('layouts.mobile')

@section('title', 'عمدة الصين | China Omda')
<link href="{{ asset('assets/assets/css/trip-show.css') }}" rel="stylesheet">

@section('content')
<style>
    .tab-button {
        padding: 8px 7px;
    }
</style>

<body class="relative -z-20">
    <x-china-header-two />
    <div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white -z-10 dark:bg-color1">
        <img class="main-image" src="{{ asset('images/trips/' . $trip->image) }}" max-height="300px" alt="">
        <div class="relative z-10">
            <div class="main-image-container">
                <div>
                    <div class="py-5 bg-white dark:bg-color10">
                        <div style="border-bottom: 1px dashed rgba(150, 147, 147, 0.401) !important;"
                            class="text-center pb-4 border-b border-dashed border-black dark:border-color24 border-opacity-10 ">
                            <p class=" text-sm" style="margin-bottom: 15px;">
                                {{ app()->getLocale() == 'en'
                                ? $trip->title_en
                                : (app()->getLocale() == 'zh'
                                ? $trip->title_zh
                                : $trip->title_ar) }}
                            </p>
                            <?php
                                if($trip->trip_type == 'group'){
                                    $trip->trip_type = 'رحلة جماعية';
                                } elseif($trip->trip_type == 'traders_only'){
                                    $trip->trip_type = 'للتجار فقط';
                                } elseif($trip->trip_type == 'trade_and_tourism'){
                                    $trip->trip_type = 'للتجارة والسياحة';
                                } elseif($trip->trip_type == 'tourism_only'){
                                    $trip->trip_type = 'للسياحة فقط';
                                } elseif($trip->trip_type == 'family'){
                                    $trip->trip_type = 'عائلية';
                                }
                            ?>
                            <p class="text-sm font-bold" style="color:maroon; margin-bottom: 15px;">
                               نوع الرحلة : {{ $trip->trip_type }}
                            </p>
                        </div>
                        <img src="{{ asset('assets/assets/images/fly-GIF.gif') }}" class="fly-img" style="z-index: 999;"
                            alt="">
                        <div style="position: relative; top: -30px; gap: 30px;"
                            class="flex justify-between items-center">
                            <div class="flex justify-start items-center gap-2">
                                <div class="text-center">
                                    <span class="text-sm">{{
                                        \Carbon\Carbon::parse($trip->departure_date)->translatedFormat('l') }}</span>
                                    <div style="background-color: white;" class="py-1 px-2 bg-p2 rounded-lg">
                                        <p class="font-semibold text-lg">
                                            {{ \Carbon\Carbon::parse($trip->departure_date)->format('m/d') }}</p>
                                        <p class="text-[19px] font-bold">
                                            {{ \Carbon\Carbon::parse($trip->departure_date)->format('Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-start items-center gap-2">
                                <div class="text-center">
                                    <span class="text-sm">{{
                                        \Carbon\Carbon::parse($trip->return_date)->translatedFormat('l') }}</span>
                                    <div style="background-color: white;" class="py-1 px-2 bg-p2 rounded-lg ">
                                        <p class="font-semibold text-lg">
                                            {{ \Carbon\Carbon::parse($trip->return_date)->format('m/d') }}</p>
                                        <p class="text-[19px] font-bold">
                                            {{ \Carbon\Carbon::parse($trip->return_date)->format('Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            
                            if ($trip->room_type == 'shared') {
                                $room_type = 'مشتركة';
                            } elseif ($trip->room_type == 'private') {
                                $room_type = 'خاصة';
                            }
                            ?>
                        @if ($trip->private_room_price)
                        <form id="payment-form" style="margin: 0px 19px;" method="POST"
                            action="{{ route('trip.payment', $trip->id) }}">
                            @csrf
                            <div class="flex justify-between items-center">
                                <label style="display:flex; flex-direction:column; align-items:center;">
                                    {{-- <input type="radio" name="room_type" value="shared" required> --}}
                                    <i class="fa-solid fa-bed" style="color: maroon;"></i>
                                    غرفة مشتركة
                                    <span id="shared-price">{{ $trip->shared_room_price }} <svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z"
                                                stroke="#000" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg></span>
                                </label>
                                <label style="display:flex; flex-direction:column; align-items:center;">
                                    {{-- <input type="radio" name="room_type" value="private" required> --}}
                                    <i class="fa-solid fa-bed" style="color: maroon;"></i>
                                    غرفة خاصة
                                    <span id="private-price">{{ $trip->private_room_price }} <svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z"
                                                stroke="#000" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg></span>
                                </label>
                            </div>
                            <div class="mb-4 text-center">
                                <div
                                    style=" background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 15px; border-radius: 12px; margin: 15px 0;">
                                    {{-- <span
                                        style="font-size: 14px; color: #495057; display: block; margin-bottom: 5px;">
                                        السعر
                                        الإجمالي:
                                    </span>
                                    <span id="total-price-display"
                                        style="font-size: 24px; font-weight: bold; color: maroon;">
                                        {{ number_format($trip->shared_room_price + $trip->shared_room_price * 0.029, 2)
                                        }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z"
                                                stroke="#000" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </span> --}}
                                    <span
                                        style="text-align: center; display: block; font-size: 12px; color: rgb(97, 95, 95);">
                                        يشمل رسوم بوابة الدفع
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('logout.and.register', $trip->id) }}" class="trip-button">
                                الاشتراك
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                            <script>
                                function handleTripRegister(event) {
                                event.preventDefault();
                        
                                @if(Auth::check())
                                    // لو فيه تسجيل دخول نعمل logout وبعدين نروح للرابط
                                    document.getElementById('logout-form').submit();
                        
                                    // نعمل redirect بعد الـ logout باستخدام callback بسيط
                                    document.getElementById('logout-form').addEventListener('submit', function () {
                                        setTimeout(function () {
                                            window.location.href = "{{ route('mobile.trip.register', $trip->id) }}";
                                        }, 500);
                                    });
                                @else
                                    // لو مفيش تسجيل دخول روح مباشرة
                                    window.location.href = "{{ route('mobile.trip.register', $trip->id) }}";
                                @endif
                            }
                            </script>
                            <span style="text-align: center; display: block; font-size: 12px; color: rgb(97, 95, 95);">
                                يسهُب إشتراكك في الخدمة موافقتك الكاملة على جميع البنود والشروط الواردة في الإشادات
                            </span>
                        </form>
                        @else
                        <div class="flex justify-between items-center">
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <p class="tab-details-content"
                                    style="display: flex; flex-direction: column; align-items: center;">
                                    نوع الغرفة
                                    <i class="fa-solid fa-bed" style="color: maroon;"></i>
                                    <span style="display: flex; align-items: center;">{{ $room_type }}</span>
                                    @php
                                    $priceWithFee = $trip->price;
                                    @endphp
                                    <span style="display: flex; align-items: center;">
                                        {{ number_format($priceWithFee, 2) }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z"
                                                stroke="#000" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <form id="payment-form" style="margin: 0px 19px;" method="POST"
                            action="{{ route('trip.payment', $trip->id) }}">
                            @csrf
                            <input type="hidden" name="room_type" value="standard">
                            <div class="mb-4 text-center">
                                <div
                                    style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 15px; border-radius: 12px; margin: 15px 0;">
                                    {{-- <span style="font-size: 14px; color: #495057; display: block; margin-bottom: 5px;">
                                        السعر
                                        الإجمالي:
                                    </span> --}}
                                    {{-- <span id="total-price-display"
                                        style="font-size: 24px; font-weight: bold; color: maroon;">
                                        {{ number_format($trip->price + $trip->price * 0.029, 2) }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z"
                                                stroke="#000" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </span> --}}
                                    <span
                                        style="text-align: center; display: block; font-size: 12px; color: rgb(97, 95, 95);">
                                        يشمل رسوم بوابة الدفع
                                    </span>
                                </div>
                            </div>
                            <a href="#" class="trip-button" onclick="handleTripRegister(event)">
                                الاشتراك
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                            <script>
                                function handleTripRegister(event) {
        event.preventDefault();

        @if(Auth::check())
            // لو فيه تسجيل دخول نعمل logout وبعدين نروح للرابط
            document.getElementById('logout-form').submit();

            // نعمل redirect بعد الـ logout باستخدام callback بسيط
            document.getElementById('logout-form').addEventListener('submit', function () {
                setTimeout(function () {
                    window.location.href = "{{ route('mobile.trip.register', $trip->id) }}";
                }, 500);
            });
        @else
            // لو مفيش تسجيل دخول روح مباشرة
            window.location.href = "{{ route('mobile.trip.register', $trip->id) }}";
        @endif
    }
                            </script>

                        </form>
                        <span style="text-align: center; display: block; font-size: 12px; color: rgb(97, 95, 95);">
                            يسهُب إشتراكك في الخدمة موافقتك الكاملة على جميع البنود والشروط الواردة في الإشادات
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tabs-container">
                <div class="tab-buttons">
                    <button class="tab-button active details" onclick="showTab('tab1')">التفاصيل</button>
                    <button class="tab-button" onclick="showTab('tab2')">الارشادات</button>
                    <button class="tab-button rating" onclick="showTab('tab3')">المميزات</button>
                    <button class="tab-button rating" onclick="showTab('tab4')">الجدول</button>
                </div>
                <div id="tab4" class="tab-content">
                    @foreach ($activities as $date => $dailyActivities)
                    <div style="color: maroon; margin-bottom: 15px; font-weight: bold; font-size: 16px;">
                        <i class="fa fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}
                    </div>
                    @foreach ($dailyActivities as $activity)
                    <div class="flex flex-col gap-4" style="margin-bottom: 10px;">
                        <div class="rounded-2xl overflow-hidden quiz-link">
                            <div class="quiz-link p-2 bg-white dark:bg-color10">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 7px;">
                                </div>
                                <div style="position: relative; top: -30px;"
                                    class="border-b border-dashed border-black dark:border-color24 border-opacity-10 flex justify-between items-center">
                                    <div class="sub-category">
                                        @if ($activity->place?->subCategory->name_ar)
                                        <p>{{ $activity->place->subCategory->name_ar }}</p>
                                        @else
                                        <p>فعالية</p>
                                        @endif
                                    </div>
                                    <div class="sub-category-right">
                                        @php
                                        $periodTranslation = '';
                                        switch ($activity->period) {
                                        case 'morning':
                                        $periodTranslation =
                                        '<img src="' .
                                                                    asset('assets/assets/images/mor2.png') .
                                                                    '">';
                                        break;
                                        case 'afternoon':
                                        $periodTranslation =
                                        '<img src="' .
                                                                    asset('assets/assets/images/noon2.png') .
                                                                    '">';
                                        break;
                                        case 'evening':
                                        $periodTranslation =
                                        '<img src="' .
                                                                    asset('assets/assets/images/nghit2.png') .
                                                                    '">';
                                        break;
                                        default:
                                        $periodTranslation = $activity->period;
                                        }
                                        @endphp
                                        {!! $periodTranslation !!}
                                    </div>
                                    @if ($activity->is_place_related == 0)
                                    <img src="{{ asset('storage/' . $activity?->image) }}" class="fly-img-order" alt="">
                                    @else
                                    <img src="{{ asset('storage/' . $activity?->place->avatar ?? '') }}"
                                        class="fly-img-order" alt="">
                                    @endif
                                </div>
                                <div class="text-center pb-4">
                                    <p class="font-semibold text-sm px-3">
                                        @if ($activity->is_place_related == 0)
                                        {!! app()->getLocale() == 'en'
                                        ? $activity?->place_name_en
                                        : (app()->getLocale() == 'zh'
                                        ? $activity?->place_name_zh
                                        : $activity?->place_name_ar) !!}
                                        @else
                                        {!! app()->getLocale() == 'en'
                                        ? $activity?->place->name_en
                                        : (app()->getLocale() == 'zh'
                                        ? $activity?->place->name_zh
                                        : $activity?->place->name_ar) !!}
                                        @endif
                                    </p>
                                    <p class="text-xs pt-2">
                                        @if ($activity->is_place_related == 0)
                                        {!! app()->getLocale() == 'en'
                                        ? $activity->details_en
                                        : (app()->getLocale() == 'zh'
                                        ? $activity->details_zh
                                        : $activity->details_ar) !!}
                                        @else
                                        {!! app()->getLocale() == 'en'
                                        ? $activity->place->details_en
                                        : (app()->getLocale() == 'zh'
                                        ? $activity->place->details_zh
                                        : $activity->place->details_ar) !!}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if (!$loop->last)
                    <hr style="margin: 20px 0; border-color: #ddd;">
                    @endif
                    @endforeach
                </div>

                <div id="tab3" class="tab-content">
                    @if ($trip->trip_features)
                    <div class=" bg-gray-100 p-4 rounded-lg shadow-sm">
                        <h3 class="font-semibold text-lg mb-4 text-right text-gray-700 border-b pb-2">مميزات الرحلة
                        </h3>
                        <ul class="list-disc list-inside text-right text-gray-600">
                            @php
                            $features = $trip->trip_features;
                            if (is_string($features)) {
                            $features = json_decode($features, true);
                            }
                            @endphp

                            @forelse ($features as $feature_id)
                            @php
                            if (is_numeric($feature_id)) {
                            $feature = \App\Models\TripFeatures::find($feature_id);
                            } else {
                            $feature = null;
                            }
                            @endphp
                            @if ($feature)
                            <li style="display: flex; align-items: center;">
                                <x-iconSub2 />
                                {{ $feature?->name_ar }}
                            </li>
                            @endif
                            @empty
                            <li>لا توجد مميزات مُضافة.</li>
                            @endforelse
                        </ul>
                    </div>
                    @endif
                </div>

                <div id="tab2" class="tab-content">

@if ($trip->trip_guidelines)
<div class="bg-gray-100 p-4 rounded-lg shadow-sm">
    <h3 class="font-semibold text-lg mb-4 text-right text-gray-700 border-b pb-2">
        إرشادات الرحلة
    </h3>
    <ul class="list-disc list-inside text-right text-gray-600">
        @php
        $guidelines = $trip->trip_guidelines;
        if (is_string($guidelines)) {
        $guidelines = json_decode($guidelines, true);
        }

        // 👇 عكس الترتيب
        if (is_array($guidelines)) {
        $guidelines = array_reverse($guidelines);
        }
        @endphp

        @forelse ($guidelines as $guideline_id)
        @php
        if (is_numeric($guideline_id)) {
        $guideline = \App\Models\TripGuideline::find($guideline_id);
        } else {
        $guideline = null;
        }
        @endphp
        @if ($guideline)
        <li style="display: flex; align-items: center;">
            <x-iconSub2 />
            {{ $guideline?->name_ar }}
        </li>
        @endif
        @empty
        <li>لا توجد إرشادات مُضافة.</li>
        @endforelse
    </ul>
</div>
@endif
                </div>

                <div id="tab1" class="tab-content">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-square-h" style="color: maroon;"></i>
                            <span style="color: maroon">
                                فندق الاقامة
                            </span>
                            {{ app()->getLocale() == 'en'
                            ? $trip->hotel_en
                            : (app()->getLocale() == 'zh'
                            ? $trip->hotel_zh
                            : $trip->hotel_ar) }}
                        </p>
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-car" style="color: maroon;"></i>
                            <span style="color: maroon">
                                مركبة خاصة
                            </span>
                            {{ $trip->transportation_type == 'shared_bus'
                            ? 'حافلة خاصة مشتركة'
                            : ($trip->transportation_type == 'private_car'
                            ? 'سيارة خاصة'
                            : ($trip->transportation_type == 'airport_only'
                            ? 'من وإلي المطار فقط'
                            : 'بدون مواصلات')) }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-language" style="color: maroon;"></i>
                            <span style="color: maroon">
                                المترجمين
                            </span>
                            {{ $trip->translators == 'group_translator'
                            ? 'للمجموعة'
                            : ($trip->translators == 'private_translator'
                            ? 'خاص لكل شخص'
                            : ($trip->translators == 'none'
                            ? 'لا يوجد'
                            : '')) }}
                        </p>
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-utensils" style="color: maroon;"></i>
                            <span style="color: maroon">
                                وجبات الطعام
                            </span>
                            {{ is_array($trip->meals) && !empty($trip->meals)
                            ? implode(
                            ', ',
                            array_map(function ($meal) {
                            switch ($meal) {
                            case 'breakfast':
                            return 'إفطار';
                            case 'lunch':
                            return 'غداء';
                            case 'dinner':
                            return 'عشاء';
                            default:
                            return '';
                            }
                            }, $trip->meals),
                            )
                            : '' }}
                        </p>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-user" style="color: maroon;"></i>
                            <span style="color: maroon">
                                استقبال بالمطار
                            </span>
                            {{ $trip->airport_pickup == '1' ? 'نعم' : 'لا' }}
                        </p>
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <img src="{{ asset('assets/assets/images/omda-icon (1).png') }}"
                                style="width: 30px; height: 19px;" alt="">
                            <span style="color: maroon">مشرف من عمدة الصين</span>
                            {{ $trip->supervisor == '1' ? 'نعم' : 'لا' }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-industry" style="color: maroon;"></i>
                            <span style="color: maroon">
                                زيارة المصانع
                            </span>
                            {{ $trip->factory_visit == '1' ? 'نعم' : 'لا' }}
                        </p>
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-torii-gate" style="color: maroon;"></i>
                            <span style="color: maroon">
                                زيارة المواقع السياحية
                            </span>
                            {{ $trip->tourist_sites_visit == '1' ? 'نعم' : 'لا' }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-shopping-basket" style="color: maroon;"></i>
                            <span style="color: maroon">
                                زيارة الأسواق
                            </span>
                            {{ $trip->markets_visit == '1' ? 'نعم' : 'لا' }}
                        </p>
                        <p class="tab-details-content" style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-ticket" style="color: maroon;"></i>
                            <span style="color: maroon">
                                التذاكر مشمولة
                            </span>
                            {{ $trip->tickets_included == '1' ? 'نعم' : 'لا' }}
                        </p>
                    </div>

                    {{-- <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-ticket" style="color: maroon;"></i>
                            <span style="color: maroon">
                                يشمل التذاكر
                            </span>
                            {{ $trip->tickets_included == '1' ? 'نعم' : 'لا' }}
                        </p>
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-wallet" style="color: maroon;"></i>
                            <span style="color: maroon">
                                سعر الرحلة
                            </span>
                            {{ $trip->price }}
                        </p>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    window.showTab = function(tabId) {
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => content.style.display = 'none');

        const buttons = document.querySelectorAll('.tab-button');
        buttons.forEach(button => {
            button.style.backgroundColor = 'black';
            button.style.color = 'white';
        });

        document.getElementById(tabId).style.display = 'block';

        const active_button = document.querySelector(`[onclick="showTab('${tabId}')"]`);
        if (active_button) {
            active_button.style.backgroundColor = 'maroon';
            active_button.style.color = 'white';
        }
    };

    window.onload = function() {
        window.showTab('tab1');
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
                const paymentForm = document.getElementById('payment-form');
                const subscriptionBtn = document.getElementById('subscription-btn');
                const loadingSpinner = subscriptionBtn?.querySelector('.loading-spinner');
                const btnText = subscriptionBtn?.querySelector('.btn-text');
                let isProcessing = false;
                const roomTypeInputs = document.querySelectorAll('input[name="room_type"]');
                const totalPriceDisplay = document.getElementById('total-price-display');
                const prices = {
                    @if ($trip->private_room_price)
                        shared: {{ $trip->shared_room_price + $trip->shared_room_price * 0.029 }},
                        private: {{ $trip->private_room_price + $trip->private_room_price * 0.029 }}
                    @endif
                };

                roomTypeInputs.forEach(input => {
                    input.addEventListener('change', function() {
                        if (totalPriceDisplay && prices[this.value]) {
                            const newPrice = prices[this.value].toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            totalPriceDisplay.textContent = newPrice + ' <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
										</svg>';
                        }
                    });
                });

                if (paymentForm) {
                    paymentForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        if (isProcessing) {
                            console.log('Request already in progress');
                            return;
                        }
                        isProcessing = true;
                        subscriptionBtn.disabled = true;
                        if (loadingSpinner) loadingSpinner.style.display = 'inline-block';
                        if (btnText) btnText.textContent = 'جاري المعالجة...';
                        const formData = new FormData(paymentForm);
                        fetch(paymentForm.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success && data.redirect_url) {
                                    if (btnText) btnText.textContent = 'جاري التحويل...';
                                    window.location.href = data.redirect_url;
                                } else {
                                    alert(data.error || 'حدث خطأ في عملية الدفع');
                                    resetButton();
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('حدث خطأ في الاتصال');
                                resetButton();
                            });

                        function resetButton() {
                            isProcessing = false;
                            subscriptionBtn.disabled = false;
                            if (loadingSpinner) loadingSpinner.style.display = 'none';
                            if (btnText) btnText.textContent = 'الاشتراك';
                        }
                    });
                }
            });
            document.addEventListener('DOMContentLoaded', function() {
                const filterItems = document.querySelectorAll('.item');
                const tripCards = document.querySelectorAll('.trip-card');
                filterItems.forEach(item => {
                    item.addEventListener('click', function() {
                        filterItems.forEach(i => i.classList.remove('active'));
                        this.classList.add('active');
                        const filterValue = this.getAttribute('data-filter');
                        tripCards.forEach(card => {
                            const tripType = card.getAttribute('data-trip-type');
                            if (filterValue === 'all' || tripType === filterValue) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });
            });

            function showTab(tabId) {
                const contents = document.querySelectorAll('.tab-content');
                contents.forEach(content => {
                    content.style.display = 'none';
                });

                const buttons = document.querySelectorAll('.tab-button');
                buttons.forEach(button => {
                    button.style.backgroundColor = 'black';
                    button.style.color = 'white';
                });

                document.getElementById(tabId).style.display = 'block';

                const active_button = document.querySelector(`[onclick="showTab('${tabId}')"]`);
                active_button.style.backgroundColor = 'maroon';
                active_button.style.color = 'white';

                if (tabId === 'tab3') {
                    updateAverageRating();
                    renderReviews();
                }
            }
function showTab(tabId) {
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => {
        content.style.display = 'none';
        });
        
        const buttons = document.querySelectorAll('.tab-button');
        buttons.forEach(button => {
        button.style.backgroundColor = 'black';
        button.style.color = 'white';
        });
        
        document.getElementById(tabId).style.display = 'block';
        
        const active_button = document.querySelector(`[onclick="showTab('${tabId}')"]`);
        active_button.style.backgroundColor = 'maroon';
        active_button.style.color = 'white';
        
        if (tabId === 'tab3') {
        updateAverageRating();
        renderReviews();
        }
        }
            window.onload = function() {
                showTab('tab1');
            };

            document.addEventListener('DOMContentLoaded', function() {
                updateAverageRating();
                renderReviews();
                const modal = document.querySelector('.modal');
                if (modal) {
                    modal.addEventListener('click', function(event) {
                        event.stopPropagation();
                    });
                }
                const imageModal = document.querySelector('.image-modal');
                if (imageModal) {
                    imageModal.addEventListener('click', function(event) {
                        event.stopPropagation();
                    });
                }
            });
</script>
@endsection