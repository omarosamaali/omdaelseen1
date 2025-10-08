@extends('layouts.mobile')

@section('title', 'المتابعين | My Profile')
<link href="{{ asset('assets/assets/css/followers.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
{{-- <img style="height: unset !important;" src="{{ asset('assets/assets/images/header-bg-2.png') }}"
    class="image-container" alt=""> --}}
<x-china-header :title="__('messages.المتابعين')" :route="route('mobile.profile.profile')" />
<div class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">

    <img src="{{ asset('assets/assets/images/leader-bg.png') }}" alt=""
        class="fixed top-0 left-0 right-0 w-full -mt-44" />

    <!-- Page Title Start -->
    <div class="relative z-20">
        <div class="flex justify-center items-center gap-4 relative">
            <a href="{{ route('mobile.profile.profile') }}"
                class="absolute-left-0 bg-white size-8 rounded-full flex justify-center items-center text-xl dark:bg-color10">
                <i class="ph ph-caret-left"></i>
            </a>
            <h2 class="text-2xl font-semibold text-white text-center">المتابعين</h2>
        </div>
        {{-- <div class="relative" style="height: 300px; margin-top: 20px; direction: ltr;">
            @foreach ($topUsers as $topUser)
            @if($topUser['rank'] == 2)
            <!-- المركز الثاني - يسار -->
            <div class="absolute" style="left: 8px; top: 56px;">
                <div class="relative" style="width: 110px; height: 110px; padding: 14px;">
                    <img src="{{ $topUser['user'] && $topUser['user']->avatar ? asset('storage/' . $topUser['user']->avatar) : asset('assets/assets/images/user-img-1.png') }}"
                        alt="{{ $topUser['user'] ? $topUser['user']->explorer_name : 'User' }}"
                        style="width: 100%; height: 100%;" class="rounded-full" />
                    <img src="{{ asset('assets/assets/images/leader-img-bg.png') }}" alt="" class="absolute"
                        style="top: 0; left: 0;" />
                    <img src="{{ asset('assets/assets/images/leader-crown.svg') }}" alt="" class="absolute"
                        style="width: 80px; top: -24px; left: -16px;" />
                    <img src="https://flagcdn.com/32x24/{{ strtolower($topUser['user']->country) }}.png" alt="Flag"
                        class="flag-img">
                    <div class="absolute" style="left: 40px; bottom: -10px;">
                        <span
                            class="text-white text-sm font-semibold bg-p3 flex justify-center items-center rounded-full"
                            style="width: 30px; height: 30px;">
                            2
                        </span>
                    </div>
                </div>
                <div class="flex justify-center items-center" style="padding: 8px;">
                    <div class="flex flex-col justify-center items-center font-semibold" style="gap: 8px;">
                        <p class="text-xs text-center">{{ $topUser['user'] ? $topUser['user']->explorer_name : 'User' }}
                        </p>
                        <div class="flex items-center bg-p3 rounded-full text-white"
                            style="gap: 4px; padding: 4px 12px;">
                            <i class="ph ph-user text-xs"></i>
                            <p class="text-xs">{{ $topUser['followers_count'] }}</p>
                        </div>
                        <div class="flex items-center bg-p3 rounded-full text-white"
                            style="gap: 4px; padding: 4px 12px;">
                            <i class="fa fa-location-dot text-xs"></i>
                            <p class="text-xs">{{ $topUser['user'] ? $topUser['user']->places_count : 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @elseif($topUser['rank'] == 1)
            <!-- المركز الأول - وسط -->
            <div class="absolute" style="left: 50%; transform: translateX(-50%); top: 0;">
                <div class="relative" style="width: 117px;
    height: 116px; padding: 16px;">
                    <img src="{{ $topUser['user'] && $topUser['user']->avatar ? asset('storage/' . $topUser['user']->avatar) : asset('assets/assets/images/user-img-1.png') }}"
                        alt="{{ $topUser['user'] ? $topUser['user']->explorer_name : 'User' }}"
                        style="width: 100%; height: 100%;" class="rounded-full" />
                    <img src="{{ asset('assets/assets/images/leader-img-bg.png') }}" alt="" class="absolute"
                        style="top: 0; left: 0;" />
                    <img src="{{ asset('assets/assets/images/leader-crown.svg') }}" alt="" class="absolute"
                        style="width: 90px; top: -32px; left: -8px;" />
                    <img src="https://flagcdn.com/32x24/{{ strtolower($topUser['user']->country) }}.png" alt="Flag"
                        class="flag-img">
                    <div class="absolute" style="left: 56px; bottom: -14px;">
                        <div class="relative flex justify-center items-center rounded-full"
                            style="right: 17px; width: 40px; height: 40px;">
                            <img src="{{ asset('assets/assets/images/leader-illus.svg') }}" alt="" class="absolute"
                                style="left: 0; top: 0;" />
                            <span
                                class="text-white text-sm font-semibold flex justify-center items-center rounded-full relative"
                                style="width: 24px; height: 24px; z-index: 10;">
                                1
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center items-center" style="padding: 8px;">
                    <div class="flex flex-col justify-center items-center font-semibold" style="gap: 8px;">
                        <p class="text-xs text-center">{{ $topUser['user'] ? $topUser['user']->explorer_name : 'User' }}
                        </p>
                        <div class="flex items-center bg-p3 rounded-full text-white"
                            style="gap: 4px; padding: 4px 12px;">
                            <i class="ph ph-user text-xs"></i>
                            <p class="text-xs">{{ $topUser['followers_count'] }}</p>
                        </div>
                        <div class="flex items-center bg-p3 rounded-full text-white"
                            style="gap: 4px; padding: 4px 12px;">
                            <i class="fa fa-location-dot text-xs"></i>
                            <p class="text-xs">{{ $topUser['user'] ? $topUser['user']->places_count : 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- المركز الثالث - يمين -->
            <div class="absolute" style="right: 8px; top: 56px;">
                <div class="relative" style="width: 110px; height: 110px; padding: 14px;">
                    <img src="{{ $topUser['user'] && $topUser['user']->avatar ? asset('storage/' . $topUser['user']->avatar) : asset('assets/assets/images/user-img-1.png') }}"
                        alt="{{ $topUser['user'] ? $topUser['user']->explorer_name : 'User' }}"
                        style="width: 100%; height: 100%;" class="rounded-full" />
                    <img src="{{ asset('assets/assets/images/leader-img-bg.png') }}" alt="" class="absolute"
                        style="top: 0; right: 0;" />
                    <img src="{{ asset('assets/assets/images/leader-crown.svg') }}" alt="" class="absolute"
                        style="width: 80px; top: -24px; right: 35px;" />
                    <img src="https://flagcdn.com/32x24/{{ strtolower($topUser['user']->country) }}.png" alt="Flag"
                        class="flag-img">
                    <div class="absolute" style="right: 36px; bottom: -10px;">
                        <span
                            class="text-white text-sm font-semibold bg-p2 flex justify-center items-center rounded-full"
                            style="width: 30px; height: 30px;">
                            3
                        </span>
                    </div>
                </div>
                <div class="flex justify-center items-center" style="padding: 8px;">
                    <div class="flex flex-col justify-center items-center font-semibold" style="gap: 8px;">
                        <p class="text-xs text-center">{{ $topUser['user'] ? $topUser['user']->explorer_name : 'User' }}
                        </p>
                        <div class="flex items-center bg-p3 rounded-full text-white"
                            style="gap: 4px; padding: 4px 12px;">
                            <i class="ph ph-user text-xs"></i>
                            <p class="text-xs">{{ $topUser['followers_count'] }}</p>
                        </div>
                        <div class="flex items-center bg-p3 rounded-full text-white"
                            style="gap: 4px; padding: 4px 12px;">
                            <i class="fa fa-location-dot text-xs"></i>
                            <p class="text-xs">{{ $topUser['user'] ? $topUser['user']->places_count : 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div> --}}

        <div class="flex flex-col" style="gap: 16px; padding-top: 20px; direction: rtl;">
            <div class="flex flex-col gap-4" style="padding-top: 30px; direction: rtl;">

                <div class="flex flex-col gap-4" style="direction: rtl;">
                    <div class="flex flex-col gap-4" style="direction: rtl;">
<div class="grid grid-cols-2 gap-4 pt-5" style="direction: rtl;">
    @forelse ($myFollowers as $myFollower)
    @php
    $follower = $myFollower->follower;
    if ($follower->id == auth()->id()) continue;
    @endphp

    <div
        class="p-4 rounded-xl border border-black border-opacity-10 bg-white shadow2 swiper-slide dark:bg-color9 dark:border-color24">
        <div class="flex justify-between items-center pb-3 border-b border-dashed border-black border-opacity-10">
            <div
                class="bg-p2 bg-opacity-10 border border-p2 border-opacity-20 py-1 px-3 flex justify-start items-center gap-1 rounded-full dark:bg-bgColor14 dark:border-bgColor16">
                <i class="fa fa-location-dot" style="color: white;"></i>
                <p class="text-xs font-semibold text-p2 text-white">
                    {{ $follower->places_count }}
                </p>
            </div>
            <img src="https://flagcdn.com/32x24/{{ strtolower($follower->country) }}.png" alt="Flag" class="flag-img">
        </div>

        <div class="flex flex-col justify-center items-center pt-4">
            <div class="relative size-24 flex justify-center items-center">
                <img src="{{ asset('storage/' . $follower->avatar) }}" alt="" class="size-[68px] rounded-full" />
                @php
                if ($follower->status == 1) {
                $src = asset('assets/assets/images/user-progress-green.svg');
                } elseif ($follower->status == 0) {
                $src = asset('assets/assets/images/user-progress.svg');
                } elseif ($follower->status == 2) {
                $src = asset('assets/assets/images/user-progress-black.svg');
                } elseif ($follower->status == 3) {
                $src = asset('assets/assets/images/user-progress-red.svg');
                }
                @endphp
                <img src="{{ $src }}" alt="" class="absolute top-0 left-0" />
            </div>

            <div class="text-xs font-semibold text-color8 dark:text-white">
                {{ $follower->explorer_name }}
            </div>

            <div class="flex justify-between items-center pt-2 w-full">
                <p class="text-color8 pt-1 dark:text-white text-xs">
                    <span id="followers-count-{{ $follower->id }}">{{ $follower->followers_count }}</span>
                    <i class="fa fa-users"></i>
                </p>
            </div>

            <form action="{{ route('followers.toggle', $follower->id) }}" method="POST">
                @csrf
                @if ($myFollower->is_following_back)
                <button type="submit" class="text-white text-xs bg-p2 py-1 px-4 rounded-full dark:bg-p1"
                    style="background-color: #fee2e2; color: red; font-size: 10px;">
                    <i class="fa-solid fa-user-xmark" style="color: red;"></i>
                    {{ __('messages.unfollow') }}
                </button>
                @else
                <button type="submit" class="text-white text-xs bg-p2 py-1 px-4 rounded-full dark:bg-p1"
                    style="background-color: #dcfce7; color: blue; font-size: 10px;">
                    <i class="fa-solid fa-user-plus" style="color: blue;"></i>
                    {{ __('messages.follow') }}
                </button>
                @endif
            </form>
        </div>
    </div>
    @empty
    <x-empty />
    @endforelse
</div>                    </div>
                </div>
            </div>
        </div>
        @endsection