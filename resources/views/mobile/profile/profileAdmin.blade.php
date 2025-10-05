@extends('layouts.mobile')

@section('title', 'ملفي الشخصي | My Profile')
<style>
    .custom-img {
        width: 125px !important;
        top: 17px !important;
        margin: 0px auto !important;
    }

    .fixed-header {
        position: fixed !important;
        width: 100% !important;
        z-index: 99 !important;
        top: 0px !important;
        height: 83px !important;
    }

    .image-container {
        height: 295px !important;
    }

    .header-controls {
        z-index: 9999 !important;
        right: 10px !important;
        position: fixed !important;
    }

    .header-logo {
        position: fixed !important;
        z-index: 999 !important;
    }

    .header-more-options {
        z-index: 9999 !important;
        right: 60px !important;
        position: fixed !important;
    }

    .back-button-container {
        position: fixed !important;
        left: 16px !important;
        z-index: 999999999 !important;
    }

    .profile-section-fixed {
        position: fixed !important;
        width: 100% !important;
        z-index: 9999999999 !important;
    }

    .profile-fixed-header-content {
        z-index: 9999999 !important;
        top: 29px !important;
        position: fixed !important;
        left: 12px !important;
    }

    .user-stats-container {
        position: relative !important;
        left: -30px !important;
    }

    .user-stats-text {
        color: white !important;
    }

    .user-stats-count {
        color: orange !important;
    }

    .user-avatar {
        width: 7rem !important;
        height: 7rem !important;
    }

    .badge-icon {
        bottom: 0px !important;
    }

    .reports-section {
        position: relative !important;
        z-index: 9 !important;
        margin: 0px 20px !important;
        direction: rtl !important;
    }

    .stats-count {
        position: absolute;
        top: -9px;
        background: red;
        color: white;
        width: 19px;
        height: 19px;
        border-radius: 50%;
        text-align: center;
        align-items: anchor-center;
        justify-content: center;
        display: flex;
        margin: auto;
        right: -5px;
        font-size: 12px;
    }
</style>
@section('content')
    <img src="{{ asset('assets/assets/images/header-bg-2.png') }}" class="image-container" alt="">
    <img src="{{ asset('assets/assets/images/header-bg-222.png') }}" alt="" class="fixed-header" />
<div class="container min-h-dvh relative overflow-hidden py-8 dark:text-white dark:bg-color1">
    <div style="display: flex; gap: 10px;">
        <div class="flex justify-start items-center gap-2 header-controls">
            <div class="relative">
                <a href="{{ route('mobile.profile.notifications') }}"
                    class="border border-color24 rounded-full flex justify-center items-center relative"
                    style="padding: 3px; background-color: white;">
                    @if ($countNotifications > 0)
                        <span class="stats-count">
                            @if ($countNotifications > 99)
                                99+
                            @else
                                {{ $countNotifications }}
                            @endif
                        </span>
                    @endif
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 640 640">
                        <path
                            d="M320 64C302.3 64 288 78.3 288 96L288 99.2C215 114 160 178.6 160 256L160 277.7C160 325.8 143.6 372.5 113.6 410.1L103.8 422.3C98.7 428.6 96 436.4 96 444.5C96 464.1 111.9 480 131.5 480L508.4 480C528 480 543.9 464.1 543.9 444.5C543.9 436.4 541.2 428.6 536.1 422.3L526.3 410.1C496.4 372.5 480 325.8 480 277.7L480 256C480 178.6 425 114 352 99.2L352 96C352 78.3 337.7 64 320 64zM258 528C265.1 555.6 290.2 576 320 576C349.8 576 374.9 555.6 382 528L258 528z" />
                    </svg>
                </a>
            </div>
        </div>
        <img src="{{ asset('assets/assets/images/logo-all.png') }}" alt=""
            class="top-0 left-0 right-0 custom-img header-logo"
            style="position: fixed !important; margin-top: 0rem !important; top: 10px !important;" />
        <div class="flex justify-start items-center gap-2 header-more-options">
            <div class="relative">
                <button
                    class="border border-color24 rounded-full flex justify-center items-center relative quizDetailsMoreOptionsModalOpenButton"
                    style="background-color: white;">
                    <i class="ph ph-dots-three profile-icon"></i>
                </button>
                <div style="direction: rtl; padding-bottom: 0px;"
                    class="absolute top-12 right-0 z-40 min-w-48 modalClose duration-500 bg-white dark:bg-color9 p-5 rounded-xl shadow6 quizDetailsMoreOptionsModal">
                    <a href="{{ route('mobile.profile.edit-profile') }}"
                        class="flex justify-start items-center gap-3 pb-3 cursor-pointer">
                        <div
                            class="text-p2 dark:text-white dark:bg-color24 dark:border-color18 border border-color16 p-2 rounded-full flex justify-center items-center bg-color14 text-sm">
                            <i class="ph ph-user"></i>
                        </div>
                        <p class="text-sm">{{ __('messages.edit_account') }}</p>
                    </a>
                    <a href="{{ route('mobile.profile.my-medals') }}"
                        class="flex justify-start items-center gap-3 pt-3 border-y border-dashed border-color21 dark:border-color24 pb-3 cursor-pointer">
                        <div
                            class="text-p2 dark:text-white dark:bg-color24 dark:border-color18 border border-color16 p-2 rounded-full flex justify-center items-center bg-color14 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="16" height="16">
                                <path
                                    d="M333.4 66.9C329.2 65 324.7 64 320 64C315.3 64 310.8 65 306.6 66.9L118.3 146.8C96.3 156.1 79.9 177.8 80 204C80.5 303.2 121.3 484.7 293.6 567.2C310.3 575.2 329.7 575.2 346.4 567.2C518.8 484.7 559.6 303.2 560 204C560.1 177.8 543.7 156.1 521.7 146.8L333.4 66.9zM313.6 247.5L320 256L326.4 247.5C337.5 232.7 354.9 224 373.3 224C405.7 224 432 250.3 432 282.7L432 288C432 337.1 366.2 386.1 335.5 406.3C326 412.5 314 412.5 304.6 406.3C273.9 386.1 208.1 337 208.1 288L208.1 282.7C208.1 250.3 234.4 224 266.8 224C285.3 224 302.7 232.7 313.7 247.5z" />
                            </svg>
                        </div>
                        <p class="text-sm text-nowrap">{{ __('messages.medals') }}</p>
                    </a>
                    <form action="{{ route('mobile.auth.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex justify-start items-center gap-3 py-3 w-full cursor-pointer">
                            <div
                                class="text-p2 dark:text-white dark:bg-color24 dark:border-color18 border border-color16 p-2 rounded-full flex justify-center items-center bg-color14 text-sm">
                                <i class="ph ph-sign-out"></i>
                            </div>
                            <p class="text-sm text-nowrap">{{ __('messages.logout') }}</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="back-button-container">
            <x-back-button href="{{ route('mobile.welcome') }}" />
        </div>
    </div>

    <div class="relative z-10 px-6">
        <div class="flex justify-center items-end pt-16 gap-8">
            <div
                class="flex justify-center items-center gap-1 bg-p2 bg-opacity-10 px-3 py-1 rounded-full border border-p2 border-opacity-20 mb-6 dark:bg-bgColor14 dark:border-bgColor16 user-stats-container">
                <p class="text-sm text-p2 dark:text-white user-stats-text">{{ __('messages.users') }}</p>
                <p class="text-sm text-p2 dark:text-white user-stats-count">{{ $all_users }}</p>
            </div>
            <div class="relative size-40 flex justify-center items-center" style="min-width: 132px;">
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt=""
                    class="bg-[#B190B6] rounded-full overflow-hidden user-avatar" />
                <img src="{{ asset('assets/assets/images/user-progress.svg') }}" alt="" style="top: 14px;"
                    class="absolute left-0 right-0" />
                <img src="{{ asset('assets/assets/images/badge1.png') }}" alt="" class="absolute badge-icon" />
            </div>
            <div class="flex justify-center items-center gap-1 bg-p2 bg-opacity-10 px-3 py-1 rounded-full border border-p2 border-opacity-20 mb-6 dark:bg-bgColor14 dark:border-bgColor16 user-stats-container"
                style="right: -30px;">
                <p class="text-sm text-p2 dark:text-white user-stats-text">{{ __('messages.places') }}</p>
                <p class="text-sm text-p2 dark:text-white user-stats-count">{{ $all_places }}</p>
            </div>
        </div>
        <div class="flex justify-center items-center pt-5 flex-col pb-5">
            <div class="flex justify-start items-center gap-1 text-2xl">
                <p class="font-semibold" style="text-transform: capitalize;">{{ __('messages.admin_name') }}</p>
                @if (Auth::user()->is_verified == 1)
                    <i class="ph-fill ph-seal-check text-p1"></i>
                @endif
            </div>
            <p class="text-color5 pt-1 dark:text-bgColor20">{{ __('countries.' . Auth::user()->country) }}</p>
        </div>
    </div>

    <div class="relative z-10">
        <div class="grid grid-cols-3 gap-2 mx-6 py-5 border-b border-color21 border-dashed dark:border-color24">
            <a href="{{ route('mobile.admin-orders') }}" class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl">
                <p class="text-xs font-semibold">{{ __('messages.requests') }}</p>
                <p class="font-semibold py-1 px-8 bg-color12 rounded-full">{{ $all_orders }}</p>
            </a>
            <a href="{{ route('mobile.china-discovers.my-places') }}"
                class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl dark:border-color24">
                <p class="text-xs font-semibold">{{ __('messages.places') }}</p>
                <p class="font-semibold py-1 px-8 bg-color14 rounded-full dark:bg-color7">
                    {{ $all_places }}
                </p>
            </a>
            <a href="{{ route('mobile.admin.users.index') }}"
                class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl dark:border-color24">
                <p class="text-xs font-semibold">{{ __('messages.users') }}</p>
                <p class="font-semibold py-1 px-8 bg-color14 rounded-full dark:bg-color7">
                    {{ $all_users }}
                </p>
            </a>
        </div>
        <div class="grid grid-cols-3 gap-2 mx-6 py-5">
            <a href="{{ route('mobile.reports.index') }}"
                class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl">
                <p class="text-xs font-semibold">{{ __('messages.reports') }}</p>
                <p class="font-semibold py-1 px-8 bg-color12 rounded-full">{{ $all_reports }}</p>
            </a>
            <a href="{{ route('mobile.admin.all-chat') }}"
                class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl dark:border-color24">
                <p class="text-xs font-semibold">{{ __('messages.conversations') }}</p>
                <p class="font-semibold py-1 px-8 bg-color14 rounded-full dark:bg-color7">
                    {{ $all_conversations }}
                </p>
            </a>
            <a href="{{ route('mobile.profile.my-interests') }}"
                class="flex flex-col gap-2 p-4 justify-center items-center border border-color12 rounded-xl dark:border-color24">
                <p class="text-xs font-semibold">{{ __('messages.interests') }}</p>
                <p class="font-semibold py-1 px-8 bg-color14 rounded-full dark:bg-color7">
                    {{ $countInterests }}
                </p>
            </a>
        </div>
    </div>

    <div class="flex flex-col gap-4 pt-0 reports-section">
        <h6>{{ __('messages.needs_action') }}</h6>

        @foreach ($reports as $report)
            <div style="border: 1px solid gray; box-shadow: 0px 0px 0px 1px #948c8c82;"
                class="flex justify-between items-center bg-white dark:bg-color9 py-4 px-5 rounded-2xl">
                <div class="flex justify-start items-center gap-3">
                    <p class="text-xs font-semibold">1</p>
                    <p class="text-xs font-semibold flex justify-start items-center gap-1">
                        {{ $report->place->{'name_' . App::getLocale()} ?? __('messages.place_name') }}
                    </p>
                </div>
                <div
                    class="flex justify-center items-center gap-2 bg-color16 dark:bg-bgColor14 py-1.5 px-4 rounded-full">
                    <p class="text-xs font-semibold text-black">{{ __('messages.violating_place') }}</p>
                </div>
            </div>
        @endforeach

        @foreach ($review_reports as $review_report)
            <div style="border: 1px solid gray; box-shadow: 0px 0px 0px 1px #948c8c82;"
                class="flex justify-between items-center bg-white dark:bg-color9 py-4 px-5 rounded-2xl">
                <div class="flex justify-start items-center gap-3">
                    <p class="text-xs font-semibold">1</p>
                    <p class="text-xs font-semibold flex justify-start items-center gap-1">
                        {{ $review_report->place->{'name_' . App::getLocale()} ?? __('messages.place_name') }}
                    </p>
                </div>
                <div
                    class="flex justify-center items-center gap-2 bg-color16 dark:bg-bgColor14 py-1.5 px-4 rounded-full">
                    <p class="text-xs font-semibold text-black">{{ __('messages.violating_review') }}</p>
                </div>
            </div>
        @endforeach

        {{-- <div class="flex justify-between items-center bg-white dark:bg-color9 py-4 px-5 rounded-2xl">
            <div class="flex justify-start items-center gap-3">
                <p class="text-xs font-semibold">3</p>
                <p class="text-xs font-semibold flex justify-start items-center gap-1">
                    {{ __('messages.user_name') }}
                </p>
            </div>
            <div class="flex justify-center items-center gap-2 bg-color16 dark:bg-bgColor14 py-1.5 px-4 rounded-full">
                <p class="text-xs font-semibold text-black">{{ __('messages.violating_user') }}</p>
            </div>
        </div> --}}
    </div>
</div>
@endsection
