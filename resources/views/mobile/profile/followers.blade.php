@extends('layouts.mobile')

@section('title', 'المتابعين | My Profile')
<link href="{{ asset('assets/assets/css/followers.css') }}" rel="stylesheet">

@section('content')
    <img style="height: unset !important;" src="{{ asset('assets/assets/images/header-bg-2.png') }}" class="image-container"
        alt="">

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
            <div class="relative" style="display: flex; justify-content: space-between;">
                @foreach ($topUsers as $topUser)
                    <div
                        class="absolute {{ $topUser['rank'] == 1 ? 'left-[120px] top-8' : ($topUser['rank'] == 2 ? 'left-0 top-16' : 'right-0 top-16') }}">
                        <div class="relative {{ $topUser['rank'] == 1 ? 'size-[145px] p-4' : 'size-[110px] p-3.5' }}">
                            <img src="{{ $topUser['user'] && $topUser['user']->avatar ? asset('storage/' . $topUser['user']->avatar) : asset('assets/assets/images/user-img-1.png') }}"
                                alt="{{ $topUser['user'] ? $topUser['user']->explorer_name : 'User' }}" style="width: 100%;"
                                class="rounded-full" />
                            <img src="{{ asset('assets/assets/images/leader-img-bg.png') }}" alt=""
                                class="absolute {{ $topUser['rank'] == 3 ? 'top-0 right-0' : 'top-0 left-0' }}" />
                            <img src="{{ asset('assets/assets/images/leader-crown.svg') }}" alt="" class="absolute"
                                style="width: 90px; top: -2.005rem; {{ $topUser['rank'] == 3 ? 'left: -1rem' : ($topUser['rank'] == 1 ? 'left: -.5rem' : 'left: -1rem') }};" />
                            <img src="https://flagcdn.com/32x24/{{ strtolower($topUser['user']->country) }}.png"
                                alt="Flag" class="flag-img">
                            <div
                                class="{{ $topUser['rank'] == 1 ? 'absolute left-14 -bottom-3.5' : ($topUser['rank'] == 2 ? 'absolute left-11 -bottom-2.5' : 'absolute right-10 -bottom-2.5') }}">
                                <div
                                    class="relative {{ $topUser['rank'] == 1 ? 'size-10' : 'size-[30px]' }} flex justify-center items-center rounded-full">
                                    @if ($topUser['rank'] == 1)
                                        <img src="{{ asset('assets/assets/images/leader-illus.svg') }}" alt=""
                                            class="absolute left-0 top-0" />
                                    @endif
                                    <span
                                        class="text-white text-sm font-semibold {{ $topUser['rank'] == 1 ? '' : ($topUser['rank'] == 2 ? 'bg-p3' : 'bg-p2') }} !leading-none flex justify-center items-center rounded-full {{ $topUser['rank'] == 1 ? 'size-6 relative z-10' : 'size-6' }}">
                                        {{ $topUser['rank'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div style="flex-direction: row;" class="flex justify-center items-center px-4">
                            <div class="flex flex-col justify-center items-center gap-2 pt-5 font-semibold">
                                <p class="text-xs">{{ $topUser['user'] ? $topUser['user']->explorer_name : 'User' }}</p>
                                <div
                                    class="flex justify-center items-center gap-1 bg-p3 rounded-full px-4 py-1.5 text-white">
                                    <i class="ph ph-user"></i>
                                    <p class="text-xs">{{ $topUser['followers_count'] }}</p>
                                </div>
                                <div
                                    class="flex justify-center items-center gap-1 bg-p3 rounded-full px-4 py-1.5 text-white">
                                    <i class="fa fa-location-dot"></i>
                                    <p class="text-xs">{{ $topUser['user'] ? $topUser['user']->places_count : 0 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-col gap-4" style="padding-top: 310px; direction: rtl;">
                <div style="box-shadow: 0px 0px 0px 3px #c6c6c6;" class="flex justify-between items-center bg-white dark:bg-color9 py-4 px-5 rounded-2xl">
                    <div class="flex justify-start items-center gap-3">
                        <p class=" font-semibold">1</p>
                        <img src="assets/images/user-img-1.png" alt="" class="size-10 rounded-full" />
                        <p class=" font-semibold flex justify-start items-center gap-1">
                            StealthGamer
                        </p>
                    </div>
                    <div
                        class="flex justify-center items-center gap-2 bg-color16 dark:bg-bgColor14 py-1.5 px-4 rounded-full">
                        <i class="fa-solid fa-user-check" style="color: green;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
