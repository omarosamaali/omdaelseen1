@extends('layouts.mobile')

@section('title', 'الاشتراك | Subscribe')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/assets/css/auth.css') }}">
<style>
    .room-radio:checked+.room-label {
        background-color: maroon !important;
        color: white !important;
        border-color: maroon !important;
    }

    .room-label:hover {
        background-color: #f5f5f5;
    }

    .room-radio:checked+.room-label:hover {
        background-color: maroon !important;
    }

    .error-text {
        display: none;
    }

    .error-text.show {
        display: block;
    }
</style>

<x-china-header-two />

<div class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">
    <h1 class="text-2xl font-semibold text-center">الاشتراك</h1>
    <div class="bg-white pb-8 px-6 rounded-xl dark:bg-color10">
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('mobile.trip.register.submit') }}" method="POST" class="relative z-20"
            id="registration-form">
            @csrf
            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
            <div class="pt-8">
                <p class="text-sm font-semibold pb-2">الإسم</p>
                <div
                    class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="text" name="name" value="omar osama" placeholder="الإسم"
                        class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                    <i class="ph ph-user text-xl text-bgColor18 !leading-none"></i>
                </div>
                @error('name')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            @php
            use Illuminate\Support\Str;
            $randomEmail = Str::random(8) . '@gmail.com';
            @endphp

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">البريد الإلكتروني</p>
                <div
                    class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="email" name="email" value="{{ $randomEmail }}" placeholder="أدخل البريد الإلكتروني"
                        class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                    <i class="ph ph-envelope-simple text-xl text-bgColor18 !leading-none"></i>
                </div>
                @error('email')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">رقم الهاتف</p>
                <div
                    class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="tel" name="phone" value="{{ rand(1000, 9999) }}" placeholder="رقم الهاتف المحترك"
                        class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                    <i class="ph ph-phone text-xl text-bgColor18 !leading-none"></i>
                </div>
                @error('phone')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">الدولة</p>
                <div
                    class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <select name="country"
                        class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18">
                        @foreach (__('countries') as $code => $name)
                        <option value="{{ $code }}" {{ old('country')==$code ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @error('country')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">كلمة المرور</p>
                <div
                    class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="password" name="password" value="o1m2r3e4l5" placeholder="*****"
                        class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18 passwordField" />
                    <i
                        class="ph ph-eye-slash text-xl text-bgColor18 !leading-none passowordShow cursor-pointer dark:text-color18"></i>
                </div>
                @error('password')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">تأكيد كلمة المرور</p>
                <div
                    class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="password" name="password_confirmation" value="o1m2r3e4l5" placeholder="*****"
                        class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18 confirmPasswordField" />
                    <i
                        class="ph ph-eye-slash text-xl text-bgColor18 !leading-none confirmPasswordShow cursor-pointer dark:text-color18"></i>
                </div>
            </div>

            <img src="{{ asset('assets/assets/images/fly-GIF.gif') }}" class="fly-img" style="z-index: 999;" alt="">

            <!-- Trip Dates -->
            <div style="position: relative; top: -30px; gap: 30px;" class="flex justify-between items-center">
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

            @if ($trip->private_room_price)
            <div class="flex justify-between items-center mb-4">
                <div
                    style="display: flex; align-items: center; justify-content: space-between; width: 100%; gap: 10px;">
                    <!-- Shared Room Option -->
                    <div class="room-option flex-1">
                        <input type="radio" id="shared-room" name="room_type" value="shared" class="hidden room-radio"
                            {{ old('room_type', 'shared' )=='shared' ? 'checked' : '' }}>
                        <label for="shared-room"
                            class="room-label cursor-pointer block text-center p-3 border border-gray-300 rounded-lg transition-all">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-bed mb-2"></i>
                                <span class="text-sm">غرفة مشتركة</span>
                                <span class="font-bold mt-1">
                                    {{ number_format($trip->shared_room_price, 0) }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" class="inline">
                                        <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                        <path d="M6.5 11H18.5" stroke="currentColor" stroke-width="1.5"></path>
                                        <path d="M6.5 13H12.5H18.5" stroke="currentColor" stroke-width="1.5"></path>
                                    </svg>
                                </span>
                            </div>
                        </label>
                    </div>

                    <!-- Private Room Option -->
                    <div class="room-option flex-1">
                        <input type="radio" id="private-room" name="room_type" value="private" class="hidden room-radio"
                            {{ old('room_type')=='private' ? 'checked' : '' }}>
                        <label for="private-room"
                            class="room-label cursor-pointer block text-center p-3 border border-gray-300 rounded-lg transition-all">
                            <div class="flex flex-col items-center">
                                <i class="fa-solid fa-bed mb-2"></i>
                                <span class="text-sm">غرفة خاصة</span>
                                <span class="font-bold mt-1">
                                    {{ number_format($trip->private_room_price, 0) }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" class="inline">
                                        <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                        <path d="M6.5 11H18.5" stroke="currentColor" stroke-width="1.5"></path>
                                        <path d="M6.5 13H12.5H18.5" stroke="currentColor" stroke-width="1.5"></path>
                                    </svg>
                                </span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- إضافة hidden input لحفظ السعر المحدد -->
            <input type="hidden" name="selected_price" id="selected-price-input" value="">

            <div class="mb-4 text-center">
                <div
                    style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 15px; border-radius: 12px; margin: 15px 0;">
                    <span style="font-size: 14px; color: #495057; display: block; margin-bottom: 5px;">
                        السعر الإجمالي:
                    </span>
                    <span id="total-price-display" style="font-size: 24px; font-weight: bold; color: maroon;">
                        <!-- سيتم تحديثه بواسطة JavaScript -->
                    </span>
                    <span style="text-align: center; display: block; font-size: 12px; color: rgb(97, 95, 95);">
                        يشمل 2.9% رسوم بوابة الدفع
                    </span>
                </div>
            </div>
            <span id="room-error" class="error-text text-red-500 text-sm hidden">يجب اختيار نوع الغرفة</span>

            @else
            <div class="flex justify-between items-center mb-4">
                <div class="text-center w-full">
                    <p class="tab-details-content flex flex-col items-center">
                        <span class="mb-2">نوع الغرفة</span>
                        <i class="fa-solid fa-bed mb-2" style="color: maroon;"></i>
                        @if($trip->room_type == 'shared')
                        <span>مشتركة</span>
                        @elseif($trip->room_type == 'private')
                        <span>خاصة</span>
                        @endif
                        <span class="font-bold mt-1">
                            {{ number_format($trip->price, 0) }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" class="inline">
                                <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="currentColor"
                                    stroke-width="1.5"></path>
                                <path d="M6.5 11H18.5" stroke="currentColor" stroke-width="1.5"></path>
                                <path d="M6.5 13H12.5H18.5" stroke="currentColor" stroke-width="1.5"></path>
                            </svg>
                        </span>
                    </p>
                </div>
            </div>

            @php
            $basePrice = $trip->price;
            $feePercent = 2.9 / 100;
            $totalPrice = $basePrice * (1 + $feePercent);
            @endphp

            <div class="mb-4 text-center">
                <div
                    style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 15px; border-radius: 12px; margin: 15px 0;">
                    <span style="font-size: 14px; color: #495057; display: block; margin-bottom: 5px;">
                        السعر الإجمالي:
                    </span>
                    <span style="font-size: 24px; font-weight: bold; color: maroon;">
                        {{ number_format($totalPrice, 2) }} درهم
                    </span>
                    <span style="text-align: center; display: block; font-size: 12px; color: rgb(97, 95, 95);">
                        يشمل 2.9% رسوم بوابة الدفع
                    </span>
                </div>
            </div>
            @endif

            <div class="mb-4">
                <span style="font-size: 12px; color: rgb(97, 95, 95);">
                    ملاحظة: سيتم إضافة 2.9% رسوم بوابة الدفع
                </span>
            </div>

            @if(session('error'))
            <div class="alert alert-danger mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
            @endif
            <button type="submit" id="register-btn"
                class="bg-p2 rounded-full py-3 text-white text-sm font-semibold text-center block mt-6 dark:bg-p1 w-full">
                <span class="loading-spinner hidden">
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
                <span class="btn-text">إنشاء حساب والدفع</span>
            </button>
            <div style="display: none;" class="pt-4">
                <label for="checkbox" class="flex justify-start items-center gap-3 text-sm cursor-pointer">
                    <input type="checkbox" name="terms" id="checkbox" class="peer hidden" checked />
                </label>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // التحقق من وجود خيارات الغرف
    const roomRadios = document.querySelectorAll('.room-radio');
    const totalPriceDisplay = document.getElementById('total-price-display');
    const selectedPriceInput = document.getElementById('selected-price-input');
    
    if (roomRadios.length > 0) {
        // الأسعار الأساسية لكل غرفة
        const sharedPrice = {{ $trip->shared_room_price ?? 0 }};
        const privatePrice = {{ $trip->private_room_price ?? 0 }};
        const feePercent = 0.029; // 2.9%

        function updateTotalPrice() {
            const selectedRoom = document.querySelector('.room-radio:checked');
            if (!selectedRoom) return;

            let basePrice = 0;
            if (selectedRoom.value === 'shared') {
                basePrice = sharedPrice;
            } else if (selectedRoom.value === 'private') {
                basePrice = privatePrice;
            }

            // حساب السعر الإجمالي مع الرسوم
            const totalPrice = basePrice * (1 + feePercent);
            
            // تحديث العرض
            if (totalPriceDisplay) {
                totalPriceDisplay.textContent = totalPrice.toFixed(2) + ' درهم';
            }
            
            // حفظ السعر في الـ hidden input
            if (selectedPriceInput) {
                selectedPriceInput.value = totalPrice.toFixed(2);
            }
        }

        // استمع لتغيير أي خيار
        roomRadios.forEach(radio => {
            radio.addEventListener('change', updateTotalPrice);
        });

        // تحديث السعر عند التحميل (إذا كان خيار محدد مسبقاً)
        updateTotalPrice();
        
        // التحقق من اختيار الغرفة عند إرسال الفورم
        const form = document.getElementById('registration-form');
        form.addEventListener('submit', function(e) {
            const selectedRoom = document.querySelector('.room-radio:checked');
            const roomError = document.getElementById('room-error');
            
            if (!selectedRoom) {
                e.preventDefault();
                if (roomError) {
                    roomError.classList.remove('hidden');
                    roomError.classList.add('show');
                }
            } else {
                if (roomError) {
                    roomError.classList.add('hidden');
                    roomError.classList.remove('show');
                }
            }
        });
    }
});
</script>
@endsection