@extends('layouts.mobile')

@section('title', 'تفاصيل الموافقة | Approve Details')
<link rel="stylesheet" href="{{ asset('assets/assets/css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">

@section('content')
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">
    <div class="header-container">
        <img src="{{ asset('assets/assets/images/header-bg.png') }}" alt="">
        <a href="{{ route('mobile.profile.actions.approve', $product->id) }}" class="profile-link dark:bg-color10">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <div class="logo-register">{{ __('messages.تفاصيل الموافقة') }}</div>
    </div>

    <div style="margin-top: 36px;">
        <div class="relative z-20">
            <div class="flex flex-col gap-4 pt-8" style="padding-left: 10px; padding-right: 10px; direction: rtl;">
                <div class="shadow flex flex-col border bg-white dark:bg-color9 py-4 px-5 rounded-2xl">

                    <div class="flex flex-col gap-2">
                        <p class="text-xs font-semibold">
                            <span class="font-bold">رقم الفاتورة:</span> {{ $approve->approval_number ?? 'غير محدد' }}
                        </p>
                        <p class="text-xs font-semibold">
                            <span class="font-bold">تاريخ الفاتورة:</span> {{ $approve->approval_date ?
                            \Carbon\Carbon::parse($approve->approval_date)->format('Y-m-d') : 'غير محدد' }}
                        </p>
                        <p class="text-xs font-semibold">
                            <span class="font-bold">العنوان:</span> {{ $approve->title ?? 'بدون عنوان' }}
                        </p>
                        <p class="text-xs font-semibold">
                            <span class="font-bold">التفاصيل:</span> {{ $approve->details ?? 'بدون تفاصيل' }}
                        </p>
                        <p class="text-xs font-semibold">
                            <span class="font-bold">الحالة:</span> {{ $approve->status ?? 'بدون تفاصيل' }}
                        </p>
                        <p class="text-xs font-semibold">
                            <span class="font-bold">المستخدم:</span> {{ $approve->user ? $approve->user->name : 'غير
                            محدد' }}
                        </p>
                        @if ($approve->file_path)
                        <p class="text-xs font-semibold">
                            <span class="font-bold">الملف:</span>
                            <a href="{{ asset($approve->file_path) }}" target="_blank" class="text-blue-500 underline">
                                تحميل الملف
                            </a>
                        </p>
                        @else
                        <p class="text-xs font-semibold text-gray-500">لا يوجد ملف مرفق</p>
                        @endif
                    </div>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('mobile.profile.actions.approve', $product->id) }}"
                            class="bg-color16 dark:bg-bgColor14 py-1.5 px-4 rounded-full text-xs font-semibold">
                            العودة إلى الموافقات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection