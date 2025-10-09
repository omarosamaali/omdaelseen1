@extends('layouts.mobile')

@section('title', 'تفاصيل المستند | Document Details')
<link rel="stylesheet" href="{{ asset('assets/assets/css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">

@section('content')
<x-china-header :title="__('messages.تفاصيل المستند')" 
:route="url()->previous()" />
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">
    <div style="margin-top: 36px;">
        <div class="relative z-20">
            <div class="flex flex-col gap-4 pt-8" style="padding-left: 10px; padding-right: 10px; direction: rtl;">
                <div class="shadow flex flex-col border bg-white dark:bg-color9 py-4 px-5 rounded-2xl">
                    <div class="flex justify-start items-center gap-3 mb-4">
                        <img src="{{ asset('storage/' . $document->file_path) }}" alt="Document"
                            class="size-12 rounded-full" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <p class="text-xs font-semibold">
                            <span class="font-bold">رقم المستند:</span> {{ $document->document_number ?? 'غير محدد' }}
                        </p>
                        <p class="text-xs font-semibold">
                            <span class="font-bold">تاريخ المستند:</span> {{ $document->document_date ?
                            \Carbon\Carbon::parse($document->document_date)->format('Y-m-d') : 'غير محدد' }}
                        </p>
                        <p class="text-xs font-semibold">
                            <span class="font-bold">العنوان:</span> {{ $document->title ?? 'بدون عنوان' }}
                        </p>
                        <p class="text-xs font-semibold">
                            <span class="font-bold">التفاصيل:</span> {{ $document->details ?? 'بدون تفاصيل' }}
                        </p>
                        <p class="text-xs font-semibold">
                            <span class="font-bold">المستخدم:</span> {{ $document->user ? $document->user->name : 'غير
                            محدد' }}
                        </p>
                        @if ($document->file_path)
                        <p class="text-xs font-semibold">
                            <span class="font-bold">الملف:</span>
<a href="{{ asset('storage/' . $document->file_path) }}" download>تحميل الملف</a>                        </p>
                        @else
                        <p class="text-xs font-semibold text-gray-500">لا يوجد ملف مرفق</p>
                        @endif
                    </div>
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('mobile.profile.actions.doc', $trip->id) }}"
                            class="bg-color16 dark:bg-bgColor14 py-1.5 px-4 rounded-full text-xs font-semibold">
                            العودة إلى المستندات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection