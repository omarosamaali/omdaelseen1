@extends('layouts.mobile')

@section('title', 'أوسمتي | My Medals')

@section('content')
<div class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">
    <img src="assets/images/header-bg-2.png" alt="" style="margin-top: -4rem;" class="absolute top-0 left-0 right-0" />
    <div class="absolute top-0 left-0 bg-p3 blur-[145px] h-[174px] w-[149px]"></div>
    <div class="absolute top-40 right-0 bg-[#0ABAC9] blur-[150px] h-[174px] w-[91px]"></div>
    <div class="absolute top-80 right-40 bg-p2 blur-[235px] h-[205px] w-[176px]"></div>
    <div class="absolute bottom-0 right-0 bg-p3 blur-[220px] h-[174px] w-[149px]"></div>
    <div class="flex justify-start items-center relative z-10">
        <div class="logo-register">
            <img src="{{ asset('assets/assets/images/logo-all.png') }}" class="image-regsiter" alt="">
        </div>
        <x-back-button href="{{ route('mobile.profile.profile') }}" />
    </div>

    <div class="relative z-20 pt-3">
        <p class="text-lg font-semibold">أوسمتي</p>

        <div class="grid grid-cols-2 gap-5 pt-5 text-center">
            <a href="medal-details.html" class="py-5 px-4 rounded-xl bg-white flex justify-center items-center flex-col relative dark:bg-color9">
                <div class="absolute top-2 right-2 flex justify-center items-center bg-color14 text-p2 border border-color16 rounded-full p-1.5 text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16">
                    <i class="ph ph-lock-simple"></i>
                </div>
                <img src="{{ asset('assets/assets/images/medal1.svg') }}" alt="" />
                <p class="text-sm font-semibold pt-3">Beginner</p>
                <p class="pt-1 text-xs pb-3">0-1000 points</p>
                <p class="flex justify-center items-center gap-2 py-2 px-6 rounded-full bg-p2 text-white text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16 dark:border">
                    1600 <i class="ph ph-users text-base"></i>
                </p>
            </a>
            <a href="medal-details.html" class="py-5 px-4 rounded-xl bg-white flex justify-center items-center flex-col relative dark:bg-color9">
                <div class="absolute top-2 right-2 flex justify-center items-center bg-color14 text-p2 border border-color16 rounded-full p-1.5 text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16">
                    <i class="ph ph-lock-simple"></i>
                </div>
                <img src="{{ asset('assets/assets/images/medal2.svg') }}" alt="" />
                <p class="text-sm font-semibold pt-3">Pro</p>
                <p class="pt-1 text-xs pb-3">0-1000 points</p>
                <p class="flex justify-center items-center gap-2 py-2 px-6 rounded-full bg-p2 text-white text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16 dark:border">
                    1600 <i class="ph ph-users text-base"></i>
                </p>
            </a>
            <a href="medal-details.html" class="py-5 px-4 rounded-xl bg-white flex justify-center items-center flex-col relative dark:bg-color9">
                <div class="absolute top-2 right-2 flex justify-center items-center bg-color14 text-p2 border border-color16 rounded-full p-1.5 text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16">
                    <i class="ph ph-lock-simple"></i>
                </div>
                <img src="{{ asset('assets/assets/images/medal3.svg') }}" alt="" />
                <p class="text-sm font-semibold pt-3">Hustler</p>
                <p class="pt-1 text-xs pb-3">0-1000 points</p>
                <p class="flex justify-center items-center gap-2 py-2 px-6 rounded-full bg-p2 text-white text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16 dark:border">
                    1600 <i class="ph ph-users text-base"></i>
                </p>
            </a>
            <a href="medal-details.html" class="py-5 px-4 rounded-xl bg-white flex justify-center items-center flex-col relative dark:bg-color9">
                <div class="absolute top-2 right-2 flex justify-center items-center bg-color14 text-p2 border border-color16 rounded-full p-1.5 text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16">
                    <i class="ph ph-lock-simple"></i>
                </div>
                <img src="{{ asset('assets/assets/images/medal4.svg') }}" alt="" />
                <p class="text-sm font-semibold pt-3">Scholar</p>
                <p class="pt-1 text-xs pb-3">0-1000 points</p>
                <p class="flex justify-center items-center gap-2 py-2 px-6 rounded-full bg-p2 text-white text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16 dark:border">
                    1600 <i class="ph ph-users text-base"></i>
                </p>
            </a>
            <a href="medal-details.html" class="py-5 px-4 rounded-xl bg-white flex justify-center items-center flex-col relative dark:bg-color9">
                <div class="absolute top-2 right-2 flex justify-center items-center bg-color14 text-p2 border border-color16 rounded-full p-1.5 text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16">
                    <i class="ph ph-lock-simple"></i>
                </div>
                <img src="{{ asset('assets/assets/images/medal5.svg') }}" alt="" />
                <p class="text-sm font-semibold pt-3">Champion</p>
                <p class="pt-1 text-xs pb-3">0-1000 points</p>
                <p class="flex justify-center items-center gap-2 py-2 px-6 rounded-full bg-p2 text-white text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16 dark:border">
                    1600 <i class="ph ph-users text-base"></i>
                </p>
            </a>
        </div>

    </div>
</div>

@endsection
