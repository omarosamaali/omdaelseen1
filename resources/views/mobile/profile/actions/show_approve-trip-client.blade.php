@extends('layouts.mobile')

@section('title', 'تفاصيل الموافقة | Approve Details')
<link rel="stylesheet" href="{{ asset('assets/assets/css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">

@section('content')
<x-china-header :title="__('messages.تفاصيل الموافقة')" :route="url()->previous()" />
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">
    <div style="margin-top: 36px;">
        <div class="relative z-20">
            <div class="flex flex-col gap-4 pt-8" style="padding-left: 10px; padding-right: 10px; direction: rtl;">
                <div class="shadow flex flex-col border bg-white dark:bg-color9 py-4 px-5 rounded-2xl">

                    <div class="flex flex-col gap-2">
                        <p class="text-xs font-semibold">
                            <span class="font-bold">رقم الموافقة:</span> {{ $approve->approval_number ?? 'غير محدد' }}
                        </p>
                        <p class="text-xs font-semibold">
                            <span class="font-bold">تاريخ الموافقة:</span> {{ $approve->approval_date ?
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
<a href="{{ asset('storage/' . $approve->file_path) }}" download="" target="_blank" class="text-blue-500 underline">
                                تحميل الملف
                            </a>
                        </p>
                        @else
                        <p class="text-xs font-semibold text-gray-500">لا يوجد ملف مرفق</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection