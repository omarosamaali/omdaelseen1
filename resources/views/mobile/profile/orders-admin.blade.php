@extends('layouts.mobile')

@section('title', 'الطلبات | Orders')
<link rel="stylesheet" href="{{ asset('assets/assets/css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">
<style>
    .status-box {
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid maroon;
        background-color: white;
        border-radius: 12px;
        padding: 6px 16px;
        width: 100%;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .status-box:hover {
        background-color: #f5f5f5;
        transform: scale(1.02);
    }

    .status-box.active {
        background-color: maroon;
    }

    .status-box.active p {
        color: white !important;
    }

    .status-box.active span {
        color: white !important;
    }

    .status-box p {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 0.65rem;
        color: black;
        margin: 0;
    }

    ::placeholder {
        color: black !important;
    }
</style>

@section('content')
<x-china-header :title="__('messages.الطلبات')" :route="route('mobile.profile.profile')" />
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">

    <div style="margin-top: 36px;">
        <div class="relative z-20 px-2">

            <div class="grid grid-cols-3 gap-4">
                <!-- العمود الأول -->
                <div style="justify-content: start;"
                    class="flex flex-col justify-center items-center gap-2 pt-5 font-semibold">
                    <a href="{{ route('mobile.admin-orders', ['status' => 'في المراجعة']) }}"
                        class="status-box {{ $status == 'في المراجعة' ? 'active' : '' }}"
                        style="text-decoration: none;">
                        <p class="text-xs">في المراجعة 
                            <span style="color: maroon;">
                                {{ $productStats['في المراجعة']}}
                            </span>
                        </p>
                    </a>
                    <a href="{{ route('mobile.admin-orders', ['status' => 'بإنتظار الدفع']) }}"
                        class="status-box {{ $status == 'بإنتظار الدفع' ? 'active' : '' }}"
                        style="text-decoration: none;">
                        <p class="text-xs">بإنتظار الدفع <span style="color: maroon;">{{ $productStats['بإنتظار الدفع']
                                }}</span></p>
                    </a>
                    <a href="{{ route('mobile.admin-orders', ['status' => 'التجهيز للشحن']) }}"
                        class="status-box {{ $status == 'التجهيز للشحن' ? 'active' : '' }}"
                        style="text-decoration: none;">
                        <p class="text-xs">التجهيز للشحن <span style="color: maroon;">{{ $productStats['التجهيز للشحن']
                                }}</span></p>
                    </a>
                    <a href="{{ route('mobile.admin-orders', ['status' => 'تم الشحن']) }}"
                        class="status-box {{ $status == 'تم الشحن' ? 'active' : '' }}" style="text-decoration: none;">
                        <p class="text-xs">تم الشحن <span style="color: maroon;">{{ $productStats['تم الشحن'] }}</span>
                        </p>
                    </a>
                    <a href="{{ route('mobile.admin-orders', ['status' => 'تم الاستلام من قبل العميل']) }}"
                        class="status-box {{ $status == 'تم الاستلام من قبل العميل' ? 'active' : '' }}"
                        style="text-decoration: none;">
                        <p class="text-xs">تم الاستلام من قبل العميل 
                            <span style="color: maroon;">{{ $productStats['تم الاستلام من قبل العميل'] }}</span>
                        </p>
                    </a>
                </div>

                <!-- العمود الثاني -->
                <div style="justify-content: start;"
                    class="flex flex-col justify-center items-center gap-2 pt-5 font-semibold">
                    <a href="{{ route('mobile.admin-orders', ['status' => 'بإنتظار مستندات']) }}"
                        class="status-box {{ $status == 'بإنتظار مستندات' ? 'active' : '' }}"
                        style="text-decoration: none;">
                        <p class="text-xs">بإنتظار مستندات <span style="color: maroon;">{{ $productStats['بإنتظار مستندات'] }}</span></p>
                    </a>
                    <a href="{{ route('mobile.admin-orders', ['status' => 'تحت الإجراء']) }}"
                        class="status-box {{ $status == 'تحت الإجراء' ? 'active' : '' }}"
                        style="text-decoration: none;">
                        <p class="text-xs">تحت الإجراء <span style="color: maroon;">{{ $productStats['تحت الإجراء']
                                }}</span></p>
                    </a>
                    <a href="{{ route('mobile.admin-orders', ['status' => 'تم الاستلام في الصين']) }}"
                        class="status-box {{ $status == 'تم الاستلام في الصين' ? 'active' : '' }}"
                        style="text-decoration: none;">
                        <p class="text-xs">تم الاستلام في الصين <span style="color: maroon;">{{ $productStats['تم الاستلام في الصين'] }}</span></p>
                    </a>
                    <a href="{{ route('mobile.admin-orders', ['status' => 'تم الاستلام بالامارات']) }}"
                        class="status-box {{ $status == 'تم الاستلام بالامارات' ? 'active' : '' }}"
                        style="text-decoration: none;">
                        <p class="text-xs">تم الاستلام بالامارات <span style="color: maroon;">{{ $productStats['تم الاستلام بالامارات'] }}</span></p>
                    </a>
                </div>

                <!-- العمود الثالث -->
                <div style="justify-content: start;"
                    class="flex flex-col justify-center items-center gap-2 pt-5 font-semibold">
                    <a href="{{ route('mobile.admin-orders', ['status' => 'ملغي']) }}"
                        class="status-box {{ $status == 'ملغي' ? 'active' : '' }}" style="text-decoration: none;">
                        <p class="text-xs">ملغي <span style="color: maroon;">{{ $productStats['ملغي'] }}</span></p>
                    </a>
                    <a href="{{ route('mobile.admin-orders', ['status' => 'مكرر']) }}"
                        class="status-box {{ $status == 'مكرر' ? 'active' : '' }}" style="text-decoration: none;">
                        <p class="text-xs">مكرر <span style="color: maroon;">{{ $productStats['مكرر'] }}</span></p>
                    </a>
                    <a href="{{ route('mobile.admin-orders', ['status' => 'منتهي']) }}"
                        class="status-box {{ $status == 'منتهي' ? 'active' : '' }}" style="text-decoration: none;">
                        <p class="text-xs">منتهي <span style="color: maroon;">{{ $productStats['منتهي'] }}</span></p>
                    </a>
                    <a href="{{ route('mobile.admin-orders', ['status' => 'تحتاج لموافقة']) }}"
                        class="status-box {{ $status == 'تحتاج لموافقة' ? 'active' : '' }}"
                        style="text-decoration: none;">
                        <p class="text-xs">تحتاج لموافقة <span style="color: maroon;">{{ $productStats['تحتاج لموافقة']
                                }}</span></p>
                    </a>
                </div>
            </div>

            <!-- زر إعادة تعيين الفلتر -->
            @if($status)
            <div class="flex justify-center mt-4">
                <a href="{{ route('mobile.admin-orders') }}"
                    class="px-6 py-2 bg-maroon text-white rounded-lg hover:bg-red-800 transition"
                    style="background-color: maroon; text-decoration: none;">
                    عرض جميع الطلبات
                </a>
            </div>
            @endif

            <div class="flex flex-col gap-4 pt-8" style="direction: rtl;">
                @forelse ($products as $product)
                <div class="bg-white dark:bg-color9 py-4 px-5 rounded-2xl shadow-md border relative"
                    style="overflow: hidden; height: 163px;">
                    <div class="relative gap-3 flex justify-between">
                        <div class="flex justify-between items-center" style="width: 106px;">
                            <div class="flex justify-start items-center gap-2">
                                <div class="text-center" style="border: 1px solid maroon; border-radius: 13%;">
                                    <span class="text-xs">
                                        @php
                                        $lang = session('locale', 'ar');
                                        $dayName = $product->created_at->locale($lang)->translatedFormat('l');
                                        @endphp
                                        {{ $dayName }}
                                    </span>
                                    <div style="background-color: white;" class="py-1 px-2 bg-p2 rounded-lg">
                                        <p class="font-semibold text-lg">
                                            {{ $product->created_at->format('m/d') }}
                                        </p>
                                        <p class="text-[19px] font-bold">
                                            {{ $product->created_at->format('Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-xs font-semibold gap-1" style="color: maroon;">
                                {{ $product->reference_number }}
                            </p>
                            <p class="text-xs font-semibold gap-1" style="color: rgb(0, 0, 0);">
                                طلب منتج
                            </p>
                            <p class="text-xs font-semibold gap-1" style="color: green;">
                                {{ $product->status }}
                            </p>
                        </div>
                        <div id="container-type">
                            <span>إضافة</span>
                        </div>
                    </div>
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; position: absolute; bottom: 5px; gap: 2px; width: 91%;">
                        <a href="{{ route('mobile.orders.show', $product) }}" class="btns"><span>
                            <svg
                                    class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                </svg></span> عرض
                        </a>

                        <a href="{{ route('mobile.profile.actions.invoice', $product->id) }}"
                            class="{{ $product->invoices()->exists() ? 'rainbow btns' : 'btns' }}"><span><i
                                    class="fa-solid fa-file-invoice" style="font-size: 18px;"></i></span>
                            فواتير
                        </a>

                        <a href="{{ route('mobile.profile.actions.doc', $product->id) }}" class="btns"><span><i
                                    class="fa-regular fa-folder-open" style="font-size: 18px;"></i></span> مستندات
                        </a>

                        <a href="{{ route('mobile.profile.actions.approve', $product->id) }}"
                            class="{{ $product->approvals()->exists() ? 'rainbow btns' : 'btns' }}"><span><i
                                    class="fa-solid fa-check-circle" style="font-size: 18px;"></i></span> موافقة
                        </a>
                        @if(Auth::user()->role == 'user')
                        <a href="{{ route('mobile.profile.actions.user-chat', ['product_id' => $product->id]) }}"
                            class="btns">
                            <span><i class="fa-regular fa-envelope" style="font-size: 18px;"></i></span>
                            مراسلة
                        </a>
                        @elseif(Auth::user()->role == 'admin')
                        <a href="{{ route('mobile.profile.actions.admin-chat', ['product_id' => $product->id]) }}"
                            class="btns">
                            <span><i class="fa-regular fa-envelope" style="font-size: 18px;"></i></span>
                            مراسلة
                        </a>
                        @endif
                        <a href="{{ route('mobile.profile.actions.note', $product->id) }}" class="btns"><span><i
                                    class="fa-solid fa-sticky-note" style="font-size: 18px;"></i></span>
                            ملاحظات</a>
                    </div>
                </div>
                @empty
                @if(!$trip_requests->count())
                <div class="text-center py-8">
                    <p class="text-gray-500">لا توجد طلبات {{ $status ? 'بحالة: ' . $status : '' }}</p>
                </div>
                @endif
                @endforelse

                @foreach ($trip_requests as $trip)
                <div class="bg-white dark:bg-color9 py-4 px-5 rounded-2xl shadow-md border relative"
                    style="overflow: hidden; height: 163px;">
                    <div class="relative gap-3 flex justify-between">
                        <div class="flex justify-between items-center" style="width: 106px;">
                            <div class="flex justify-start items-center gap-2">
                                <div class="text-center" style="border: 1px solid maroon; border-radius: 13%;">
                                    <span class="text-xs">
                                        @php
                                        $lang = session('locale', 'ar');
                                        $dayName = $trip->created_at->locale($lang)->translatedFormat('l');
                                        @endphp
                                        {{ $dayName }}
                                    </span>
                                    <div style="background-color: white;" class="py-1 px-2 bg-p2 rounded-lg">
                                        <p class="font-semibold text-lg">
                                            {{ $trip->created_at->format('m/d') }}
                                        </p>
                                        <p class="text-[19px] font-bold">
                                            {{ $trip->created_at->format('Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-xs font-semibold gap-1" style="color: maroon;">
                                {{ $trip->reference_number }}
                            </p>
                            <p class="text-xs font-semibold gap-1" style="color: rgb(0, 0, 0);">
                                طلب رحلة
                            </p>
                            <p class="text-xs font-semibold gap-1" style="color: green;">
                                {{ $trip->status }}
                            </p>
                        </div>
                        <div id="container-type">
                            <span>إضافة</span>
                        </div>
                    </div>
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; position: absolute; bottom: 5px; gap: 2px; width: 91%;">

                        <a href="{{ route('mobile.orders.show', $trip) }}" class="btns"><span><svg
                                    class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                </svg></span> عرض
                        </a>

                        <a href="{{ route('mobile.profile.actions.invoice', $trip->id) }}"
                            class="{{ $trip->invoices()->exists() ? 'rainbow btns' : 'btns' }}"><span><i
                                    class="fa-solid fa-file-invoice" style="font-size: 18px;"></i></span>
                            فواتير
                        </a>

                        <a href="{{ route('mobile.profile.actions.doc', $trip->id) }}" class="btns"><span><i
                                    class="fa-regular fa-folder-open" style="font-size: 18px;"></i></span> مستندات
                        </a>

                        <a href="{{ route('mobile.profile.actions.approve', $trip->id) }}"
                            class="{{ $trip->approvals()->exists() ? 'rainbow btns' : 'btns' }}"><span><i
                                    class="fa-solid fa-check-circle" style="font-size: 18px;"></i></span> موافقة
                        </a>
                        @if(Auth::user()->role == 'admin')
<a href="{{ route('mobile.profile.actions.admin-chat-trip', ['trip_id' => $trip->id]) }}" class="btns">
                            <span><i class="fa-regular fa-envelope" style="font-size: 18px;"></i></span>
                            مراسلة - {{ $trip->id }}
                        </a>
@endif
                        <a href="{{ route('mobile.profile.actions.note', $trip->id) }}" class="btns"><span><i
                                    class="fa-solid fa-sticky-note" style="font-size: 18px;"></i></span>
                            ملاحظات
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection