@extends('layouts.mobile')

@section('title', 'المتابعين | My Profile')
<link href="{{ asset('assets/assets/css/followers.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
{{-- <img style="height: unset !important;" src="{{ asset('assets/assets/images/header-bg-2.png') }}" class="image-container"
    alt=""> --}}
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
<div class="relative" style="height: 300px; margin-top: 20px; direction: ltr;">
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
                <span class="text-white text-sm font-semibold bg-p3 flex justify-center items-center rounded-full"
                    style="width: 30px; height: 30px;">
                    2
                </span>
            </div>
        </div>
        <div class="flex justify-center items-center" style="padding: 8px;">
            <div class="flex flex-col justify-center items-center font-semibold" style="gap: 8px;">
                <p class="text-xs text-center">{{ $topUser['user'] ? $topUser['user']->explorer_name : 'User' }}</p>
                <div class="flex items-center bg-p3 rounded-full text-white" style="gap: 4px; padding: 4px 12px;">
                    <i class="ph ph-user text-xs"></i>
                    <p class="text-xs">{{ $topUser['followers_count'] }}</p>
                </div>
                <div class="flex items-center bg-p3 rounded-full text-white" style="gap: 4px; padding: 4px 12px;">
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
                <div class="relative flex justify-center items-center rounded-full" style="right: 17px; width: 40px; height: 40px;">
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
                <p class="text-xs text-center">{{ $topUser['user'] ? $topUser['user']->explorer_name : 'User' }}</p>
                <div class="flex items-center bg-p3 rounded-full text-white" style="gap: 4px; padding: 4px 12px;">
                    <i class="ph ph-user text-xs"></i>
                    <p class="text-xs">{{ $topUser['followers_count'] }}</p>
                </div>
                <div class="flex items-center bg-p3 rounded-full text-white" style="gap: 4px; padding: 4px 12px;">
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
                <span class="text-white text-sm font-semibold bg-p2 flex justify-center items-center rounded-full"
                    style="width: 30px; height: 30px;">
                    3
                </span>
            </div>
        </div>
        <div class="flex justify-center items-center" style="padding: 8px;">
            <div class="flex flex-col justify-center items-center font-semibold" style="gap: 8px;">
                <p class="text-xs text-center">{{ $topUser['user'] ? $topUser['user']->explorer_name : 'User' }}</p>
                <div class="flex items-center bg-p3 rounded-full text-white" style="gap: 4px; padding: 4px 12px;">
                    <i class="ph ph-user text-xs"></i>
                    <p class="text-xs">{{ $topUser['followers_count'] }}</p>
                </div>
                <div class="flex items-center bg-p3 rounded-full text-white" style="gap: 4px; padding: 4px 12px;">
                    <i class="fa fa-location-dot text-xs"></i>
                    <p class="text-xs">{{ $topUser['user'] ? $topUser['user']->places_count : 0 }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>

<div class="flex flex-col" style="gap: 16px; padding-top: 20px; direction: rtl;">
<div class="flex flex-col gap-4" style="padding-top: 30px; direction: rtl;">

        <div class="flex flex-col gap-4" style="direction: rtl;">
<div class="flex flex-col gap-4" style="direction: rtl;">
    @foreach ($myFollowers as $myFollower)
    @php
    $follower = $myFollower->follower; // الشخص اللي بيتابعك
    // نتأكد ما نعرضش حسابك
    if ($follower->id == auth()->id()) continue;
    @endphp

    <div style="box-shadow: 0px 0px 0px 3px #c6c6c6;"
        class="flex justify-between items-center bg-white dark:bg-color9 py-4 px-5 rounded-2xl">

        <div class="flex justify-start items-center gap-3">
            <p class="font-semibold">{{ $loop->iteration }}</p>
            <img src="{{ asset('storage/' . $follower->avatar) }}" alt="{{ $follower->explorer_name }}"
                class="size-10 rounded-full" />
            <p class="font-semibold flex justify-start items-center gap-1">
                {{ $follower->explorer_name }} - {{ $follower->id }}
            </p>
        </div>

        <form action="{{ route('followers.toggle', $follower->id) }}" method="POST">
            @csrf
            @if ($myFollower->is_following_back)
            <button type="submit"
                class="flex justify-center items-center gap-2 bg-red-100 hover:bg-red-200 text-red-600 py-1.5 px-4 rounded-full"
                style="position: relative; top: 7px;">
                <i class="fa-solid fa-user-xmark" style="color: red;"></i>
            </button>
            @else
            <button type="submit"
                class="flex justify-center items-center gap-2 bg-green-100 hover:bg-green-200 text-green-600 py-1.5 px-4 rounded-full"
                style="position: relative; top: 7px;">
                <i class="fa-solid fa-user-plus" style="color: blue;"></i>
            </button>
            @endif
        </form>

    </div>
    @endforeach
</div>        </div>
    </div>
</div>
@endsection