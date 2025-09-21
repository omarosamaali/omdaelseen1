<div id="image-modal" class="image-modal">
    <span class="close-button">&times;</span>
    <img class="modal-content" id="modal-image">
</div>
@extends('layouts.mobile')

@section('title', 'الطلبات | Orders')
<link rel="stylesheet" href="{{ asset('assets/assets/css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">

<style>
    body {
        background-color: #eee;
    }

    .user-avatar {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #e5e7eb;
    }

    .image-modal {
        opacity: 1;
        display: none;
        position: fixed;
        z-index: 1000;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .close-button {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close-button:hover,
    .close-button:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    .swiper-slide img {
        cursor: pointer;
    }

    .swiper {
        width: 100%;
        max-width: 268px;
        margin: 0 auto;
    }

    .swiper-slide img {
        width: 100%;
        height: 200px;
        object-fit: unset;
        border-radius: 8px;
    }

    .swiper-button-prev,
    .swiper-button-next {
        color: #0ABAC9;
    }

    .swiper-pagination-bullet-active {
        background-color: #0ABAC9;
    }
</style>
@section('content')
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">
    <div class="header-container">
        <img src="{{ asset('assets/assets/images/header-bg.png') }}" alt="">
        <a href="{{ url()->previous() }}" class="profile-link dark:bg-color10">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <div class="logo-register">{{ __('messages.تفاصيل الطلب') }}</div>
    </div>
    <div class="container">
        <div class="container mx-auto py-8 px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-1 bg-white rounded-lg shadow-md p-6 text-center">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">بيانات العميل</h2>
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('storage/' . $trip_requests?->user->avatar) }}" alt="عمدة الصين"
                            class="user-avatar mb-4">
                        <div class="info-label">اسم العميل</div>
                        <div class="info-value text-lg font-semibold">{{ $trip_requests?->user->name }}</div>
                    </div>
                </div>
                <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">تفاصيل الطلب الحالي</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="info-label">رقم المرجع</div>
                            <div class="info-value font-mono">{{ $trip_requests->reference_number }}</div>
                        </div>
                        <div>
                            <div class="info-label">الحالة</div>
                            <div class="info-value">
                                <span class="status-badge bg-green-100 text-green-800">
                                    {{ $trip_requests->status }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="info-label">العنوان</div>
                            <div class="info-value"><span class="status-badge bg-green-100 text-green-800">
                                    رحلة خاصة
                                </span></div>
                        </div>
                        <div>
                            <div class="info-label">عدد المسافرين</div>
                            <div class="info-value">{{ $trip_requests->travelers_count }}</div>
                        </div>
                        <div>
                            <div class="info-label">عدد الاهتمامات</div>
                            <div class="info-value">
                                <div class="info-value">{{ implode(', ', $trip_requests->interests) }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="info-label">تاريخ الإضافة</div>
                            <div class="info-value">{{ $trip_requests->created_at }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection