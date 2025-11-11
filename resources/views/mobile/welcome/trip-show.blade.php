@extends('layouts.mobile')

@section('title', 'عمدة الصين | China Omda')
<link href="{{ asset('assets/assets/css/trip-show1.css') }}" rel="stylesheet">

@section('content')

<body class="relative -z-20">
    <x-china-header :title="__('messages.تفاصيل الرحلة')" :route="route('mobile.trip')" />
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
    @endif
    <div class="container min-h-dvh relative overflow-hidden dark:text-white -z-10 dark:bg-color1" style="padding-bottom: 0px;">
        <img class="main-image" src="{{ asset('images/trips/' . $trip->image) }}" style="margin-top: 62px !important;"
            max-height="300px" alt="">
        <div class="relative z-10">
            <div class="main-image-container">
                <div>
                    <div class="py-5 bg-white dark:bg-color10">
                        <div style="border-bottom: 1px dashed rgba(150, 147, 147, 0.401) !important;"
                            class="text-center pb-4 border-b border-dashed border-black dark:border-color24 border-opacity-10 ">
                            <p class="font-semibold text-sm px-3" style="margin-bottom: 15px;">
                                {{ app()->getLocale() == 'en'
                                ? $trip->title_en
                                : (app()->getLocale() == 'zh'
                                ? $trip->title_zh
                                : $trip->title_ar) }}
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
                                        <p class="font-semibold text-lg font-bold">
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
                                        <p class="font-semibold text-lg font-bold">
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
                        @else
                        <div class="flex justify-between items-center">
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <p class="tab-details-content"
                                    style="display: flex; flex-direction: column; align-items: center;">
                                    {{ __('messages.room_type') }}
                                    <i class="fa-solid fa-bed" style="color: maroon;"></i>
                                    <span style="display: flex; align-items: center;">{{ $room_type }}</span>
                                    <span style="display: flex; align-items: center;">{{ $trip->price }} <svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z"
                                                stroke="#000" stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round">
                                            </path>
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
                        @endif
                    </div>

                    @if ($trip->is_paid == 'yes')
                    <form action="{{ route('mobile.trip.register.submit') }}" method="POST" class="relative z-20"
                        id="registration-form">
                        @csrf
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                        @php
                        $hasMultipleRoomTypes = $trip->private_room_price && $trip->shared_room_price;
                        @endphp
                        @if ($hasMultipleRoomTypes)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-center">اختر نوع الغرفة:</label>
                            <div class="flex gap-4 justify-between" style="margin: auto; width: 90%;">
                                <label
                                    style="gap: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <input type="radio" name="room_type" value="shared" {{ old('room_type', 'shared'
                                        )=='shared' ? 'checked' : '' }} class="mr-2">
                                    <i class="fa-solid fa-bed" style="color: maroon;"></i>
                                    نوع الغرفة مشتركة
                                    <div style="display: flex; align-items: center; justify-content: center;">
                                        ({{ $trip->shared_room_price }})
                                    </div>
                                </label>
                                <label
                                    style="gap: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <input type="radio" name="room_type" value="private" {{ old('room_type')=='private'
                                        ? 'checked' : '' }} class="mr-2">
                                    <i class="fa-solid fa-bed" style="color: maroon;"></i>
                                    نوع الغرفة خاصة
                                    <div style="display: flex; align-items: center; justify-content: center;">
                                        ({{ $trip->private_room_price }})
                                    </div>
                                </label>
                            </div>
                        </div>
                        @else

                        <input type="hidden" name="room_type"
                            value="{{ $trip->room_type == 'shared' ? 'shared' : 'private' }}">
                        <input type="hidden" name="selected_price" value="{{ $trip->price }}">
                        @endif

                        <button type="submit" class="trip-button">الاشتراك</button>
                    </form>
                    @else
                    @if($trip->is_paid == 'yes')
                    <form action="{{ route('unpaid-trip-requests.store') }}" method="POST" class="relative z-20"
                        id="registration-form">
                        @csrf
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                        @php
                        $hasMultipleRoomTypes = $trip->private_room_price && $trip->shared_room_price;
                        @endphp

                        @if ($hasMultipleRoomTypes)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-center">اختر نوع الغرفة:</label>
                            <div class="flex gap-4 justify-between" style="margin: auto; width: 90%;">
                                <label
                                    style="gap: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <input type="radio" name="room_type" value="shared" {{ old('room_type', 'shared'
                                        )=='shared' ? 'checked' : '' }} class="mr-2">
                                    <i class="fa-solid fa-bed" style="color: maroon;"></i>
                                    نوع الغرفة مشتركة
                                    <div style="display: flex; align-items: center; justify-content: center;">
                                        ({{ $trip->shared_room_price }})
                                    </div>
                                </label>

                                <label
                                    style="gap: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <input type="radio" name="room_type" value="private" {{ old('room_type')=='private'
                                        ? 'checked' : '' }} class="mr-2">
                                    <i class="fa-solid fa-bed" style="color: maroon;"></i>
                                    نوع الغرفة خاصة
                                    <div style="display: flex; align-items: center; justify-content: center;">
                                        ({{ $trip->private_room_price }})
                                    </div>
                                </label>
                            </div>
                        </div>
                        @else
                        <input type="hidden" name="room_type"
                            value="{{ $trip->room_type == 'shared' ? 'shared' : 'private' }}">
                        <input type="hidden" name="selected_price" value="{{ $trip->price }}">
                        @endif

                        <button type="submit" class="trip-button">الاشتراك</button>
                    </form>

                    @else
                    {{-- الرحلة غير مدفوعة --}}
                    @php
                    $hasRequested = \App\Models\UnpaidTripRequests::where('user_id', auth()->id())
                    ->where('trip_id', $trip->id)
                    ->first();
                    @endphp

                    @if($hasRequested)
                    @if($hasRequested->status == 'pending')
                    <div style="
                text-align: center;
                padding: 1rem;
                margin-bottom: 1rem;
                font-size: 14px;
                color: #1e3a8a; /* text-blue-800 */
                background-color: #eff6ff; /* bg-blue-50 */
                border-radius: 0.5rem; /* rounded-lg */
            ">
                        ✋ طلبك قيد المراجعة
                    </div>
                    <form action="{{ route('unpaid-trip-requests.destroy', $hasRequested->id) }}" method="POST"
                        style="text-align: center; margin-top: 0.5rem;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="
                    background-color: #dc3545; /* bootstrap danger */
                    color: white;
                    font-size: 14px;
                    border: none;
                    border-radius: 4px;
                    padding: 6px 12px;
                    cursor: pointer;
                " onclick="return confirm('هل تريد إلغاء طلبك؟')">
                            إلغاء الطلب
                        </button>
                    </form>
                    @elseif($hasRequested->status == 'paid')
                    <div style="
                background-color: #d1e7dd; /* alert-success */
                color: #0f5132;
                text-align: center;
                padding: 0.75rem;
                border-radius: 6px;
                margin-bottom: 1rem;
            ">✅ تم قبول طلبك!</div>

                    @elseif($hasRequested->status == 'rejected')
                    <div style="
                background-color: #f8d7da; /* alert-danger */
                color: #842029;
                text-align: center;
                padding: 0.75rem;
                border-radius: 6px;
                margin-bottom: 1rem;
            ">❌ تم رفض طلبك</div>
                    @endif

                    @else
                    <div class="flex gap-4 justify-between" style="margin: auto; width: 90%;">
                        <label
                            style="gap: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            {{-- <input type="radio" name="room_type" value="shared" {{ old('room_type', 'shared'
                                )=='shared' ? 'checked' : '' }} class="mr-2"> --}}
                            <i class="fa-solid fa-bed" style="color: maroon;"></i>
                            نوع الغرفة مشتركة
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										</svg> ({{ $trip->shared_room_price }})
                            </div>
                        </label>

                        <label
                            style="gap: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            {{-- <input type="radio" name="room_type" value="private" {{ old('room_type')=='private'
                                ? 'checked' : '' }} class="mr-2"> --}}
                            <i class="fa-solid fa-bed" style="color: maroon;"></i>
                            نوع الغرفة خاصة
                            <div style="display: flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										</svg> ({{ $trip->private_room_price }})
                            </div>
                        </label>
                    </div>
                    {{-- المستخدم لم يقدم طلب بعد --}}
                    <form action="{{ route('unpaid-trip-requests.store') }}" method="POST" class="text-center mt-2">
                        @csrf
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                        <button type="submit" class="trip-button">تقديم طلب</button>
                    </form>
                    @endif
                    @endif
                    </form>
                    @endif

                    <span style="text-align: center; display: block; font-size: 12px; color: rgb(97, 95, 95);">
                        السعر يشمل رسوم بوابة الدفع
                    </span>
                </div>
            </div>
            <div class="tabs-container pt-3">
                <div class="tab-buttons">
                    <button class="tab-button details active" onclick="showTab('tab1')">
                        {{ __('messages.details') }}
                    </button>
                    <button class="tab-button" onclick="showTab('tab2')">
                        {{ __('messages.الإرشادات') }}
                    </button>
                    <button class="tab-button rating" onclick="showTab('tab3')">
                        {{ __('messages.المميزات') }}
                    </button>
                    <button class="tab-button rating" onclick="showTab('tab4')">
                        {{ __('messages.الجدول') }}
                    </button>
                </div>

                <div id="tab1" class="tab-content" style="display: block;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-square-h" style="color: maroon;"></i>
                            <span style="color: maroon">
                                {{ __('messages.فندق_الإقامة') }}
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
                                {{ __('messages.مركبة_خاصة') }}
                            </span>
                            @php
                            $transportationKey = match ($trip->transportation_type) {
                            'shared_bus' => 'shared_bus',
                            'private_car' => 'private_car',
                            'airport_only' => 'airport_only',
                            default => 'no_transportation',
                            };
                            @endphp
                            {{ __('messages.transportation_types.' . $transportationKey) }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-language" style="color: maroon;"></i>
                            <span style="color: maroon">
                                {{ __('messages.المترجمين') }}
                            </span>
                            {{ __('messages.translator_types.' . ($trip->translators ?? 'none')) }}
                        </p>
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-utensils" style="color: maroon;"></i>
                            <span style="color: maroon">
                                {{ __('messages.الوجبات') }}
                            </span>
                            @if (is_array($trip->meals) && !empty($trip->meals))
                            {{ collect($trip->meals)->map(fn($meal) => __('messages.meals.' .
                            $meal))->filter()->implode(', ') }}
                            @endif
                        </p>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-user" style="color: maroon;"></i>
                            <span style="color: maroon">
                                {{ __('messages.استقبال_بالمطار') }}
                            </span>
                            {{ $trip->airport_pickup == '1' ? __('messages.yes') : __('messages.no') }}
                        </p>
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <img src="{{ asset('assets/assets/images/omda-icon (1).png') }}"
                                style="width: 30px; height: 19px;" alt="">
                            <span style="color: maroon">
                                {{ __('messages.مشرف_من_عمدة_الصين') }}

                            </span>
                            {{ $trip->supervisor == '1' ? __('messages.yes') : __('messages.no') }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-industry" style="color: maroon;"></i>
                            <span style="color: maroon">
                                {{ __('messages.زيارة_المصانع') }}
                            </span>
                            {{ $trip->factory_visit == '1' ? __('messages.yes') : __('messages.no') }}
                        </p>
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-torii-gate" style="color: maroon;"></i>
                            <span style="color: maroon">
                                {{ __('messages.زيارة_المواقع_السياحية') }}
                            </span>
                            {{ $trip->tourist_sites_visit == '1' ? __('messages.yes') : __('messages.no') }}
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-ticket" style="color: maroon;"></i>
                            <span style="color: maroon">
                                {{ __('messages.يشمل_التذاكر') }}
                            </span>
                            {{ $trip->tickets_included == '1' ? __('messages.yes') : __('messages.no') }}
                        </p>
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-wallet" style="color: maroon;"></i>
                            <span style="color: maroon">
                                {{ __('messages.سعر_الرحلة') }}
                                <span style="display: flex; align-items: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="#000" stroke-width="1.5"
                                        stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                        <path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />

                                    </svg> 
                                    @if($trip->shared_room_price != null) 
                                    ({{ $trip->shared_room_price}})
                                    @else
                                    ({{ $trip->price }})
                                    @endif
                                </span>
                            </span>
                            {{-- {{ $trip->price }} --}}
                            
                        </p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-square-h" style="color: maroon;"></i>
                            <span style="color: maroon">
                                {{ __('messages.التسوق') }}
                            </span>
                            {{ $trip->markets_visit == '1' ? __('messages.yes') : __('messages.no') }}
                        </p>
                        <p class="tab-details-content"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fa-solid fa-car" style="color: maroon;"></i>
                            <span style="color: maroon">
                                {{ __('messages.نوع الرحلة') }}
                            </span>
                            @php
                            $trip_typeKey = match ($trip->trip_type) {
                            'group' => 'group',
                            'traders_only' => 'traders_only',
                            'trade_and_tourism' => 'trade_and_tourism',
                            'tourism_only' => 'tourism_only',
                            'family' => 'family',
                            default => 'no_transportation',
                            };
                            @endphp

                            {{ __('messages.trip_type.' . $trip_typeKey) }}
                        </p>
                    </div>
                </div>

                <div style="display: none;" id="tab2" class="tab-content">

                    @if ($trip->trip_guidelines)
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                        <h3 class="font-semibold text-lg mb-4 text-right text-gray-700 border-b pb-2">
                            {{ __('messages.ارشادات_الرحلة') }}
                        </h3>
                        <ul class="list-disc list-inside text-right text-gray-600">
                            @php
                            $guidelines = $trip->trip_guidelines;
                            if (is_string($guidelines)) {
                            $guidelines = json_decode($guidelines, true);
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
                            <?php
                                                                                        $locale = app()->getLocale();
                                                                                        
                                                                                        if ($locale == 'en') {
                                                                                            $guidelineName = $guideline->name_en;
                                                                                        } elseif ($locale == 'zh') {
                                                                                            $guidelineName = $guideline->name_zh;
                                                                                        } else {
                                                                                            $guidelineName = $guideline->name_ar;
                                                                                        }
                                                                                        ?>
                            @if ($guideline)
                            <li style="list-style: none; display: flex; align-items: self-start;">
                                <x-iconSub2 />{{ $guidelineName }}
                            </li>
                            @endif
                            @empty
                            <li>
                                <x-empty />
                            </li>
                            @endforelse
                        </ul>
                    </div>
                    @endif

                </div>

                <div style="display: none;" id="tab3" class="tab-content">
                    @if ($trip->trip_features)
                    <div class=" bg-gray-100 p-4 rounded-lg shadow-sm">
                        <h3 class="font-semibold text-lg mb-4 text-right text-gray-700 border-b pb-2">
                            {{ __('messages.مميزات_الرحلة') }}
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
                            <?php
                                    $locale = app()->getLocale();
                                    if ($locale == 'en') {
                                        $featureName = $feature->name_en;
                                    } elseif ($locale == 'zh') {
                                        $featureName = $feature->name_zh;
                                    } else {
                                        $featureName = $feature->name_ar;
                                    }
                                    ?>
                            <li style="display: flex; align-items: self-start;">
                                <x-iconSub2 /> {{ $featureName }}
                            </li>
                            @endif
                            @empty
                            <li>
                                <x-empty />
                            </li>
                            @endforelse
                        </ul>
                    </div>
                    @endif
                </div>

                <div style="display: none;" id="tab4" class="tab-content">
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
                                        <p>{{ __('messages.event') }}</p>
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

                                <div style="" class="text-center pb-4">
                                    <p class="font-semibold text-sm">
                                        {{-- {{ $activity->place->name_ar }} --}}
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
                                        {{-- {{ $activity->place->details_ar }} --}}
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

            </div>
        </div>
    </div>
</body>

<script>
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

        document.addEventListener('DOMContentLoaded', function() {
            const filterItems = document.querySelectorAll('.item');
            const tripCards = document.querySelectorAll('.trip-card');

            filterItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active class from all items
                    filterItems.forEach(i => i.classList.remove('active'));
                    // Add active class to clicked item
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    // Show/hide trip cards based on filter
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
</script>
@endsection