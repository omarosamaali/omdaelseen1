@extends('layouts.mobile')

@section('title', 'ملفي الشخصي | My Profile')

@section('content')
<div class="container min-h-dvh relative overflow-hidden py-8 dark:text-white dark:bg-color1">
    <img src="{{ asset('assets/assets/images/header-bg-1-2.png') }}" alt="" class="absolute top-0 left-0 right-0 custom-img" style="margin-top: -6rem;" />
    <div class="absolute top-0 left-0 bg-p3 blur-[145px] h-[174px] w-[149px]"></div>
    <div class="absolute top-40 right-0 bg-[#0ABAC9] blur-[150px] h-[174px] w-[91px]"></div>
    <div class="absolute top-80 right-40 bg-p2 blur-[235px] h-[205px] w-[176px]"></div>
    <div class="absolute bottom-0 right-0 bg-p3 blur-[220px] h-[174px] w-[149px]"></div>
    <div class="relative z-10 px-6">
        <div class="flex justify-between items-center gap-4">
            <div style="display: flex; gap: 10px;">
                <div class="flex justify-start items-center gap-2">
                    <div class="relative">
                        <a href="{{ route('mobile.profile.notifications') }}" class="border border-color24 rounded-full flex justify-center items-center relative" style="padding: 3px; background-color: white;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 640 640">
                                <path d="M320 64C302.3 64 288 78.3 288 96L288 99.2C215 114 160 178.6 160 256L160 277.7C160 325.8 143.6 372.5 113.6 410.1L103.8 422.3C98.7 428.6 96 436.4 96 444.5C96 464.1 111.9 480 131.5 480L508.4 480C528 480 543.9 464.1 543.9 444.5C543.9 436.4 541.2 428.6 536.1 422.3L526.3 410.1C496.4 372.5 480 325.8 480 277.7L480 256C480 178.6 425 114 352 99.2L352 96C352 78.3 337.7 64 320 64zM258 528C265.1 555.6 290.2 576 320 576C349.8 576 374.9 555.6 382 528L258 528z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="flex justify-start items-center gap-2">
                    <div class="relative">
                        <button class="border border-color24 rounded-full flex justify-center items-center relative quizDetailsMoreOptionsModalOpenButton" style="background-color: white;">
                            <i class="ph ph-dots-three profile-icon"></i>
                        </button>
                        <div style="direction: rtl;" class="absolute top-12 right-0 z-40 min-w-48 modalClose duration-500 bg-white dark:bg-color9 p-5 rounded-xl shadow6 quizDetailsMoreOptionsModal">
                            <a href="{{ route('mobile.profile.edit-profile') }}" class="flex justify-start items-center gap-3 pb-3 cursor-pointer">
                                <div class="text-p2 dark:text-white dark:bg-color24 dark:border-color18 border border-color16 p-2 rounded-full flex justify-center items-center bg-color14 text-sm">
                                    <i class="ph ph-user"></i>
                                </div>
                                <p class="text-sm">تعديل الحساب</p>
                            </a>
                            <a href="{{ route('mobile.profile.my-medals') }}" class="flex justify-start items-center gap-3 pt-3 border-y border-dashed border-color21 dark:border-color24 pb-3 cursor-pointer">
                                <div class="text-p2 dark:text-white dark:bg-color24 dark:border-color18 border border-color16 p-2 rounded-full flex justify-center items-center bg-color14 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="16" height="16">
                                        <path d="M333.4 66.9C329.2 65 324.7 64 320 64C315.3 64 310.8 65 306.6 66.9L118.3 146.8C96.3 156.1 79.9 177.8 80 204C80.5 303.2 121.3 484.7 293.6 567.2C310.3 575.2 329.7 575.2 346.4 567.2C518.8 484.7 559.6 303.2 560 204C560.1 177.8 543.7 156.1 521.7 146.8L333.4 66.9zM313.6 247.5L320 256L326.4 247.5C337.5 232.7 354.9 224 373.3 224C405.7 224 432 250.3 432 282.7L432 288C432 337.1 366.2 386.1 335.5 406.3C326 412.5 314 412.5 304.6 406.3C273.9 386.1 208.1 337 208.1 288L208.1 282.7C208.1 250.3 234.4 224 266.8 224C285.3 224 302.7 232.7 313.7 247.5z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-nowrap">الأوسمة</p>
                            </a>

                            <form action="{{ route('mobile.auth.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex justify-start items-center gap-3 py-3 w-full cursor-pointer">
                                    <div class="text-p2 dark:text-white dark:bg-color24 dark:border-color18 border border-color16 p-2 rounded-full flex justify-center items-center bg-color14 text-sm">
                                        <i class="ph ph-sign-out"></i>
                                    </div>
                                    <p class="text-sm text-nowrap">تسجيل خروج</p>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-start items-center gap-4">
                <x-back-button href="{{ route('mobile.welcome') }}" />
            </div>

        </div>
        <div class="flex justify-center items-end pt-16 gap-8">
            <div style="position: relative; left: -30px;" class="flex justify-center items-center gap-1 bg-p2 bg-opacity-10 px-3 py-1 rounded-full border border-p2 border-opacity-20 mb-6 dark:bg-bgColor14 dark:border-bgColor16">
                <p class="text-sm text-p2 dark:text-white" style="color: white;">إهتماماتي</p>
                <p class="text-sm text-p2 dark:text-white" style="color: orange;">{{ $countInterests }}</p>
            </div>
            <div class="relative size-40 flex justify-center items-center" style="min-width: 132px;">
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="" style="width: 7rem; height: 7rem;" class="bg-[#B190B6] rounded-full overflow-hidden" />
                <img src="{{ asset('assets/assets/images/user-progress.svg') }}" alt="" style="top: 14px;" class="absolute left-0 right-0" />
                <img src="{{ asset('assets/assets/images/badge1.png') }}" alt="" class="absolute" style="bottom: 0px;" />
            </div>
            <div style="position: relative; right: -30px;" class="flex justify-center items-center gap-1 bg-p2 bg-opacity-10 px-3 py-1 rounded-full border border-p2 border-opacity-20 mb-6 dark:bg-bgColor14 dark:border-bgColor16">
                <p class="text-sm text-p2 dark:text-white" style="color: white;">المتابعين</p>
                <p class="text-sm text-p2 dark:text-white" style="color: orange;">{{ $myFollowers }}</p>

            </div>
        </div>
        <div class="flex justify-center items-center pt-5 flex-col pb-5">
            <div class="flex justify-start items-center gap-1 text-2xl">
                <p class="font-semibold" style="text-transform: capitalize;">{{ Auth::user()->name }}</p>
                @if(Auth::user()->is_verified == 1)
                <i class="ph-fill ph-seal-check text-p1"></i>
                @endif
            </div>
            <p class="text-color5 pt-1 dark:text-bgColor20">{{ __('countries.' . Auth::user()->country) }}</p>
        </div>
        @if(Auth::user()->is_verified !== 1)
        <form action="{{ route('mobile.profile.send-otp') }}" method="POST">
            @csrf
            <button type="submit" class="flex justify-start items-center gap-2 w-full">
                <div style="width: 100%;" class="flex justify-start items-center gap-4 bg-white py-3 px-5 border border-color21 dark:border-color24 rounded-2xl dark:bg-color9">
                    <div class="text-p2 dark:text-p1 dark:border-bgColor16 dark:bg-bgColor14 border border-color14 p-2 rounded-full flex justify-center items-center bg-color16">
                        <i class="ph ph-caret-right"></i>
                    </div>
                    <div class="">
                        <p class="text-p2 font-semibold dark:text-p1" style="text-align: right;"> غير موثق</p>
                        <p class="text-xs text-nowrap">للإستفادة من جميع الخدمات وثق حسابك</p>
                    </div>
                </div>
            </button>
        </form>
        @endif
    </div>
    <div class="relative z-10">
        <div class="grid grid-cols-3 gap-2 mx-6 py-5 border-b border-color21 border-dashed dark:border-color24">
            <div class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl">
                <p class="text-xs font-semibold">رحلاتي</p>
                <p class="font-semibold py-1 px-8 bg-color12 rounded-full">280</p>
            </div>
            <a href="{{ route('mobile.china-discovers.my-places') }}" class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl dark:border-color24">
                <p class="text-xs font-semibold">أماكني</p>
                <p class="font-semibold py-1 px-8 bg-color14 rounded-full dark:bg-color7">
                    {{ $count }}
                </p>
            </a>
            <div class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl dark:border-color24">
                <p class="text-xs font-semibold">طلباتي</p>
                <p class="font-semibold py-1 px-8 bg-color14 rounded-full dark:bg-color7">
                    320
                </p>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2 mx-6 py-5">
            <a href="{{ route('mobile.profile.my-interests') }}" class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl">
                <p class="text-xs font-semibold">الإهتمامات</p>
                <p class="font-semibold py-1 px-8 bg-color12 rounded-full">{{ $countInterests }}</p>
            </a>
            <div class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl dark:border-color24">
                <p class="text-xs font-semibold">أتابع</p>
                <p class="font-semibold py-1 px-8 bg-color14 rounded-full dark:bg-color7">
                    {{ $iFollow }}
                </p>
            </div>
            <div class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl dark:border-color24">
                <p class="text-xs font-semibold">المتابعين</p>
                <p class="font-semibold py-1 px-8 bg-color14 rounded-full dark:bg-color7">
                    {{ $myFollowers }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
