@extends('layouts.mobile')

@section('title', 'أوسمتي | My Medals')

@section('content')
<x-china-header :title="__('messages.my_medals')" :route="route('mobile.profile.profile')" />
    <div style="padding-top: 70px;" class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">
        <div class="relative z-20 pt-3">
            <p class="text-lg font-semibold">{{ __('messages.my_medals') }}</p>

            <div class="grid grid-cols-2 gap-5 pt-5 text-center">
                <a href="medal-details.html"
                    class="py-5 px-4 rounded-xl bg-white flex justify-center items-center flex-col relative dark:bg-color9">
                    <div
                        class="absolute top-2 right-2 flex justify-center items-center bg-color14 text-p2 border border-color16 rounded-full p-1.5 text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16">
                        <i class="ph ph-lock-simple"></i>
                    </div>
                    <img src="{{ asset('assets/assets/images/medal1.svg') }}" alt="" />
                    <p class="text-sm font-semibold pt-3">{{ __('messages.medal_beginner') }}</p>
                    <p class="pt-1 text-xs pb-3">{{ __('messages.points_range') }}</p>
                    <p
                        class="flex justify-center items-center gap-2 py-2 px-6 rounded-full bg-p2 text-white text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16 dark:border">
                        1600 <i class="ph ph-users text-base"></i>
                    </p>
                </a>
                <a href="medal-details.html"
                    class="py-5 px-4 rounded-xl bg-white flex justify-center items-center flex-col relative dark:bg-color9">
                    <div
                        class="absolute top-2 right-2 flex justify-center items-center bg-color14 text-p2 border border-color16 rounded-full p-1.5 text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16">
                        <i class="ph ph-lock-simple"></i>
                    </div>
                    <img src="{{ asset('assets/assets/images/medal2.svg') }}" alt="" />
                    <p class="text-sm font-semibold pt-3">{{ __('messages.medal_pro') }}</p>
                    <p class="pt-1 text-xs pb-3">{{ __('messages.points_range') }}</p>
                    <p
                        class="flex justify-center items-center gap-2 py-2 px-6 rounded-full bg-p2 text-white text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16 dark:border">
                        1600 <i class="ph ph-users text-base"></i>
                    </p>
                </a>
                <a href="medal-details.html"
                    class="py-5 px-4 rounded-xl bg-white flex justify-center items-center flex-col relative dark:bg-color9">
                    <div
                        class="absolute top-2 right-2 flex justify-center items-center bg-color14 text-p2 border border-color16 rounded-full p-1.5 text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16">
                        <i class="ph ph-lock-simple"></i>
                    </div>
                    <img src="{{ asset('assets/assets/images/medal3.svg') }}" alt="" />
                    <p class="text-sm font-semibold pt-3">{{ __('messages.medal_hustler') }}</p>
                    <p class="pt-1 text-xs pb-3">{{ __('messages.points_range') }}</p>
                    <p
                        class="flex justify-center items-center gap-2 py-2 px-6 rounded-full bg-p2 text-white text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16 dark:border">
                        1600 <i class="ph ph-users text-base"></i>
                    </p>
                </a>
                <a href="medal-details.html"
                    class="py-5 px-4 rounded-xl bg-white flex justify-center items-center flex-col relative dark:bg-color9">
                    <div
                        class="absolute top-2 right-2 flex justify-center items-center bg-color14 text-p2 border border-color16 rounded-full p-1.5 text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16">
                        <i class="ph ph-lock-simple"></i>
                    </div>
                    <img src="{{ asset('assets/assets/images/medal4.svg') }}" alt="" />
                    <p class="text-sm font-semibold pt-3">{{ __('messages.medal_scholar') }}</p>
                    <p class="pt-1 text-xs pb-3">{{ __('messages.points_range') }}</p>
                    <p
                        class="flex justify-center items-center gap-2 py-2 px-6 rounded-full bg-p2 text-white text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16 dark:border">
                        1600 <i class="ph ph-users text-base"></i>
                    </p>
                </a>
                <a href="medal-details.html"
                    class="py-5 px-4 rounded-xl bg-white flex justify-center items-center flex-col relative dark:bg-color9">
                    <div
                        class="absolute top-2 right-2 flex justify-center items-center bg-color14 text-p2 border border-color16 rounded-full p-1.5 text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16">
                        <i class="ph ph-lock-simple"></i>
                    </div>
                    <img src="{{ asset('assets/assets/images/medal5.svg') }}" alt="" />
                    <p class="text-sm font-semibold pt-3">{{ __('messages.medal_champion') }}</p>
                    <p class="pt-1 text-xs pb-3">{{ __('messages.points_range') }}</p>
                    <p
                        class="flex justify-center items-center gap-2 py-2 px-6 rounded-full bg-p2 text-white text-sm dark:text-p1 dark:bg-bgColor14 dark:border-bgColor16 dark:border">
                        1600 <i class="ph ph-users text-base"></i>
                    </p>
                </a>
            </div>
        </div>
</div>@endsection
