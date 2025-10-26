@extends('layouts.mobile')

@section('title', 'الطلبات | Orders')
<link rel="stylesheet" href="{{ asset('assets/assets/css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">

@section('content')
<x-china-header :title="__('messages.الطلبات')" :route="url()->previous()" />
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">

    <div style="margin-top: 36px;">
        <div class="relative z-20 px-2">
            <div class="flex justify-between items-center px-4">
                <div class="flex flex-col justify-center items-center gap-2 pt-5 font-semibold">
                    <p>الرحلات</p>
                    <a href="{{ route('mobile.orders', ['filter' => 'منتهية']) }}"
                        class="flex justify-center items-center gap-1 px-4 py-1.5 cursor-pointer transition-all hover:shadow-md"
                        style="color:black; border: 1px solid maroon; background-color: {{ $filter === 'منتهية' ? '#fef3f3' : 'white' }}; width: 100%; border-radius: 12px;">
                        <p class="text-xs" style="display: flex; flex-direction: column; align-items: center;">
                            منتهية
                            <span style="color: maroon; font-weight: bold;">{{ $tripsFinished }}</span>
                        </p>
                    </a>
                    <a href="{{ route('mobile.orders', ['filter' => 'غير منتهية']) }}"
                        class="flex justify-center items-center gap-1 px-4 py-1.5 cursor-pointer transition-all hover:shadow-md"
                        style="color:black; border: 1px solid maroon; background-color: {{ $filter === 'غير منتهية' ? '#fef3f3' : 'white' }}; width: 100%; border-radius: 12px;">
                        <p class="text-xs" style="display: flex; flex-direction: column; align-items: center;">
                            غير منتهية
                            <span style="color: maroon; font-weight: bold;">{{ $tripsUnfinished }}</span>
                        </p>
                    </a>
                </div>
                <div class="flex flex-col justify-center items-center gap-2 pt-5 font-semibold">
                    <p>المنتجات</p>
                    <a href="{{ route('mobile.orders', ['filter' => 'products_finished']) }}"
                        class="flex justify-center items-center gap-1 px-4 py-1.5 cursor-pointer transition-all hover:shadow-md"
                        style="color:black; border: 1px solid maroon; background-color: {{ $filter === 'products_finished' ? '#fef3f3' : 'white' }}; width: 100%; border-radius: 12px;">
                        <p class="text-xs" style="display: flex; flex-direction: column; align-items: center;">
                            منتهية
                            <span style="color: maroon; font-weight: bold;">{{ $productsFinished }}</span>
                        </p>
                    </a>
                    <a href="{{ route('mobile.orders', ['filter' => 'products_unfinished']) }}"
                        class="flex justify-center items-center gap-1 px-4 py-1.5 cursor-pointer transition-all hover:shadow-md"
                        style="color:black; border: 1px solid maroon; background-color: {{ $filter === 'products_unfinished' ? '#fef3f3' : 'white' }}; width: 100%; border-radius: 12px;">
                        <p class="text-xs" style="display: flex; flex-direction: column; align-items: center;">
                            غير منتهية
                            <span style="color: maroon; font-weight: bold;">{{ $productsUnfinished }}</span>
                        </p>
                    </a>
                </div>

                <div class="flex flex-col justify-center items-center gap-2 pt-5 font-semibold">
                    <p>الطلبات الخاصة</p>
                    <div class="flex justify-center items-center gap-1 bg-p1 px-4 py-1.5 text-white"
                        style="color:black; border: 1px solid maroon; background-color: white; width: 100%; border-radius: 12px;">
                        <p class="text-xs" style="display: flex; flex-direction: column; align-items: center;">
                            منتهية
                            <span style="color: maroon;">{{ $specialOrdersFinished }}</span>
                        </p>
                    </div>
                    <div class="flex justify-center items-center gap-1 bg-p1 px-4 py-1.5 text-white"
                        style="color:black; border: 1px solid maroon; background-color: white; width: 100%; border-radius: 12px;">
                        <p class="text-xs" style="display: flex; flex-direction: column; align-items: center;">
                            غير منتهية
                            <span style="color: maroon;">{{ $specialOrdersUnfinished }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <style>
                .text-maroon {
                    color: rgb(255, 255, 255);
                }

                .bg-maroon {
                    background-color: maroon;
                }
            </style>

            <a href="{{ route('mobile.orders', ['filter' => 'all']) }}"
                style="display: flex; align-items: center; justify-content: center; margin: auto; margin-top: 20px; border: 1px solid maroon;"
                class="px-4 py-2 rounded-lg {{ $filter === 'all' ? 'bg-maroon text-maroon' : 'bg-gray-200 text-gray-700' }}">
                الكل
            </a>

            <div class="flex flex-col gap-4 pt-8" style="direction: rtl;">
                @foreach ($tripRegisters as $trip)
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
                                    <div class="py-1 px-2 bg-p2 rounded-lg" style="background-color: white;">
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
                            <p class="text-xs font-semibold" style="color: maroon;">
                                {{ $trip->reference_number }}
                            </p>
                            <p class="text-xs font-semibold" style="color: black;">
                                طلب رحلة
                            </p>
                            <p class="text-xs font-semibold" style="color: green;">
                                @if ($trip->payment_status == 'paid')
                                مدفوعة
                                @elseif ($trip->payment_status == 'rejected')
                                مرفوضة
                                @else
                                في المراجعة
                                @endif
                            </p>
                        </div>

                        <div id="container-type">
                            <span>إضافة</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center absolute bottom-5 gap-2"
                        style="width: 91%; left: 50%; transform: translateX(-50%);">

                        <!-- View Trip -->
                        <a href="{{ route('mobile.orders.trip-show-client', $trip) }}"
                            class="btns flex flex-col items-center text-xs">
                            <span>
                                <svg class="w-6 h-6 text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </span>
                            عرض
                        </a>

                        <!-- Invoices -->
                        <a href="{{ route('mobile.profile.actions.invoice-trip-client', $trip->id) }}"
                            class="{{ $trip->invoices()->exists() ? 'rainbow btns' : 'btns' }} flex flex-col items-center text-xs">
                            <span><i class="fa-solid fa-file-invoice" style="font-size: 18px;"></i></span>
                            فواتير
                        </a>

                        <!-- Documents -->
                        <a href="{{ route('mobile.profile.actions.doc-trip-client', $trip->id) }}"
                            class="btns flex flex-col items-center text-xs">
                            <span><i class="fa-regular fa-folder-open" style="font-size: 18px;"></i></span>
                            مستندات
                        </a>

                        <!-- Approval -->
                        <a href="{{ route('mobile.profile.actions.approve-trip-client', $trip->id) }}"
                            class="{{ $trip->approvals()->exists() ? 'rainbow btns' : 'btns' }} flex flex-col items-center text-xs">
                            <span><i class="fa-solid fa-check-circle" style="font-size: 18px;"></i></span>
                            موافقة
                        </a>

                        <!-- Chat (Only for user role & inside loop) -->
                        @if(Auth::user()->role === 'user')
                        <a href="{{ route('mobile.profile.actions.trip-chat', [
                'user_id' => $user->id,
                'order_id' => $trip->id,  // Use $trip->id, not $order->id
                'order_type' => 'registration'
            ]) }}" class="btns flex flex-col items-center text-xs">
                            <span><i class="fa-regular fa-envelope" style="font-size: 18px;"></i></span>
                            مراسلة
                        </a>
                        @endif

                        <!-- Notes -->
                        <a href="{{ route('mobile.profile.actions.note-trip-client', $trip->id) }}"
                            class="btns flex flex-col items-center text-xs">
                            <span><i class="fa-solid fa-sticky-note" style="font-size: 18px;"></i></span>
                            ملاحظات
                        </a>
                    </div>
                </div>
                @endforeach 
                @foreach ($unpaidTripRequests as $trip)
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
                                @if ($trip->payment_status == 'paid')
                                مدفوعة
                                @elseif ($trip->payment_status == 'rejected')
                                مرفوضة
                                @else
                                في المراجعة
                                @endif
                            </p>
                        </div>
                        <div id="container-type">
                            <span>إضافة</span>
                        </div>
                    </div>
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; position: absolute; bottom: 5px; gap: 2px; width: 91%;">
                        <a href={{ route('mobile.orders.trip-show-client', $trip) }} class="btns">
                            <span>
                                <svg class="w-6 h-6 text-green-800" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z">
                                    </path>
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                </svg>
                            </span>
                            عرض

                            <a href="{{ route('mobile.profile.actions.invoice-trip-client', $trip->id) }}"
                                class="{{ $trip->invoices()->exists() ? 'rainbow btns' : 'btns' }}"><span><i
                                        class="fa-solid fa-file-invoice" style="font-size: 18px;"></i></span>
                                فواتير
                            </a>

                        </a>
                        <a href="{{ route('mobile.profile.actions.doc-trip-client', $trip->id) }}" class="btns"><span><i
                                    class="fa-regular fa-folder-open" style="font-size: 18px;"></i></span> مستندات
                        </a>

                        <a href="{{ route('mobile.profile.actions.approve-trip-client', $trip->id) }}"
                            class="{{ $trip->approvals()->exists() ? 'rainbow btns' : 'btns' }}"><span><i
                                    class="fa-solid fa-check-circle" style="font-size: 18px;"></i></span> موافقة
                        </a>
                        @if(Auth::user()->role == 'user')
                        <a href="{{ route('mobile.profile.actions.trip-chat', ['user_id' => Auth::id(), 'order_id' => $trip->id, 'order_type' => 'unpaid']) }}"
                            class="btns">
                            <span><i class="fa-regular fa-envelope" style="font-size: 18px;"></i></span>
                            مراسلة
                        </a>
                        @endif
                        <a href="{{ route('mobile.profile.actions.note-trip-client', $trip->id) }}"
                            class="btns"><span><i class="fa-solid fa-sticky-note" style="font-size: 18px;"></i></span>
                            ملاحظات</a>

                    </div>
                </div>
                @endforeach
                @foreach ($products as $product)
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

                        <a href={{ route('mobile.orders.show', $product) }} class="btns">
                            <span>
                                <svg class="w-6 h-6 text-green-800" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z">
                                    </path>
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                </svg>
                            </span>
                            عرض
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
                            class="{{ $product->order_messages()->exists() ? 'rainbow btns' : 'btns' }}">
                            <span><i class="fa-regular fa-envelope" style="font-size: 18px;"></i></span>
                            مراسلة
                        </a>
                        @elseif(Auth::user()->role == 'admin')
                        <a href="{{ route('mobile.profile.actions.admin-chat', ['product_id' => $product->id]) }}"
                            class="{{ $product->order_messages()->exists() ? 'rainbow btns' : 'btns' }}">
                            <span><i class="fa-regular fa-envelope" style="font-size: 18px;"></i></span>
                            مراسلة
                        </a>
                        @endif
                        <a href="{{ route('mobile.profile.actions.note', $product->id) }}" class="btns"><span><i
                                    class="fa-solid fa-sticky-note" style="font-size: 18px;"></i></span>
                            ملاحظات</a>
                    </div>
                </div>
                @endforeach
                @foreach ($trip_requests as $trip)
                <div class="bg-white dark:bg-color9 py-4 px-5 rounded-2xl shadow-md border relative"
                    style="overflow: hidden; height: 163px;">
                    <!-- Header -->
                    <div class="relative gap-3 flex justify-between">
                        <!-- Date -->
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
                                    <div class="py-1 px-2 bg-p2 rounded-lg" style="background-color: white;">
                                        <p class="font-semibold text-lg">{{ $trip->created_at->format('m/d') }}</p>
                                        <p class="text-[19px] font-bold">{{ $trip->created_at->format('Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reference & Status -->
                        <div class="text-center">
                            <p class="text-xs font-semibold" style="color: maroon;">{{ $trip->reference_number }}</p>
                            <p class="text-xs font-semibold" style="color: black;">طلب رحلة</p>
                            <p class="text-xs font-semibold" style="color: green;">{{ $trip->status }}</p>
                        </div>

                        <!-- Type -->
                        <div id="container-type"><span>إضافة</span></div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center absolute bottom-5 gap-2"
                        style="width: 91%; left: 50%; transform: translateX(-50%);">

                        <!-- View -->
                        <a href="{{ route('mobile.orders.trip-display', $trip) }}"
                            class="btns flex flex-col items-center text-xs">
                            <span>
                                <svg class="w-6 h-6 text-green-800" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z">
                                    </path>
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                </svg>
                            </span>
                            عرض
                        </a>

                        <!-- Invoices -->
                        <a href="{{ route('mobile.profile.actions.invoice-trip', $trip->id) }}"
                            class="{{ $trip->invoices()->exists() ? 'rainbow btns' : 'btns' }} flex flex-col items-center text-xs">
                            <span><i class="fa-solid fa-file-invoice" style="font-size: 18px;"></i></span>
                            فواتير
                        </a>

                        <!-- Documents -->
                        <a href="{{ route('mobile.profile.actions.doc-trip', $trip->id) }}"
                            class="btns flex flex-col items-center text-xs">
                            <span><i class="fa-regular fa-folder-open" style="font-size: 18px;"></i></span>
                            مستندات
                        </a>

                        <!-- Approval -->
                        <a href="{{ route('mobile.profile.actions.approve-trip', $trip->id) }}"
                            class="{{ $trip->approvals()->exists() ? 'rainbow btns' : 'btns' }} flex flex-col items-center text-xs">
                            <span><i class="fa-solid fa-check-circle" style="font-size: 18px;"></i></span>
                            موافقة
                        </a>

                        <!-- Chat (only for regular users) -->
                        @if(Auth::user()->role === 'user')
                        <a href="{{ route('mobile.profile.actions.trip-chat', [
                    'user_id'    => $user->id,
                    'order_id'   => $trip->id,          // correct trip ID
                    'order_type' => 'trip_request'
                ]) }}" class="btns flex flex-col items-center text-xs">
                            <span><i class="fa-regular fa-envelope" style="font-size: 18px;"></i></span>
                            مراسلة
                        </a>
                        @endif

                        <!-- Notes -->
                        <a href="{{ route('mobile.profile.actions.note-trip', $trip->id) }}"
                            class="btns flex flex-col items-center text-xs">
                            <span><i class="fa-solid fa-sticky-note" style="font-size: 18px;"></i></span>
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