@extends('layouts.mobile')

@section('title', 'ملفي الشخصي | My Profile')

@section('content')
    <style>
        @media (max-width: 400px) {
            .custom-img {
                margin-top: -5rem !important;
            }
        }

        @media (max-width: 370px) {
            .custom-img {
                margin-top: -4rem !important;
            }
        }


        @media (max-width: 370px) {
            .custom-img {
                margin-top: -3rem !important;
            }
        }

        #badgeModal {
            display: block;
            position: absolute;
            z-index: 9;
            background: white;
            padding: 3px;
            border-radius: 5px;
            font-size: 12px;
            top: 44px;
            width: max-content;
        }

        .logo--image {
            top: 20px;
            width: 134px;
            text-align: center;
            align-items: anchor-center;
            margin: auto;
        }
    </style>

    <body>
        <div class="container min-h-dvh relative overflow-hidden py-8 dark:text-white dark:bg-black">

            <!-- Page Title Start -->
            <div class="relative z-10">
                <div class="relative z-10 px-6" style="position: fixed; width: 100%;     width: 96%;
    margin: auto; background-color: white; top: 0px; padding: 10px 0px;">
                    <div class="flex justify-between items-center gap-4" style="flex-direction: row-reverse;">
                        <div style="position: absolute;" class="flex justify-start items-center gap-4">
                            <a href="{{ route('mobile.profile.profileAdmin') }}"
                                class="bg-white size-8 rounded-full flex justify-center items-center text-xl dark:bg-color10">
                                <i class="ph ph-caret-left"></i>
                            </a>
                        </div>
                        <img src="{{ asset('assets/assets/images/logo-all.png') }}" class="logo--image" />
                    </div>
                    <form action="{{ route('mobile.admin.users.index') }}" method="GET" style="width: 90%; margin: auto;">
                        <div class="flex justify-between items-center gap-3 pt-6">
                            <div style="background-color: white; color: black; border: 1px solid gray;"
                                class="flex justify-start items-center gap-3 bg-color24 border border-color24 p-4 rounded-full text-white w-full">
                                <i class="ph ph-magnifying-glass"></i>
                                <input type="text" placeholder="إبحث بإسم المستكشف" name="search"
                                    style="color: black !important; text-align: center;"
                                    class="bg-transparent outline-none w-full text-xs" />
                            </div>
                            <button type="submit" style="display: none;"></button>
                        </div>
                    </form>
                </div>
                <div class="px-6" style="padding-top: 140px;">
                    <div class="grid grid-cols-2 gap-4 pt-5">
                        @foreach ($users as $user)
                            <div
                                class="p-4 rounded-xl border border-black border-opacity-10 bg-white shadow2 swiper-slide dark:bg-color9 dark:border-color24">
                                <div
                                    class="flex justify-between items-center pb-3 border-b border-dashed border-black border-opacity-10">
                                    <div
                                        class="bg-p2 bg-opacity-10 border border-p2 border-opacity-20 py-1 px-3 flex justify-start items-center gap-1 rounded-full dark:bg-bgColor14 dark:border-bgColor16">
                                        <i class="fa fa-location-dot" style="color: white;"></i>
                                        <p class="text-xs font-semibold text-p2 text-white">
                                            {{ $user->places_count }}
                                        </p>
                                    </div>
                                    <img src="https://flagcdn.com/32x24/{{ strtolower($user->country) }}.png" alt="Flag"
                                        class="flag-img">
                                </div>
                                <div class="flex flex-col justify-center items-center pt-4">
                                    <div class="relative size-24 flex justify-center items-center">
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt=""
                                            class="size-[68px] rounded-full" />
                                        <?php
                                        if ($user->status == 1) {
                                            $src = asset('assets/assets/images/user-progress-green.svg');
                                        } elseif ($user->status == 0) {
                                            $src = asset('assets/assets/images/user-progress.svg');
                                        } elseif ($user->status == 2) {
                                            $src = asset('assets/assets/images/user-progress-black.svg');
                                        } elseif ($user->status == 3) {
                                            $src = asset('assets/assets/images/user-progress-red.svg');
                                        }
                                        ?>
                                        <img src="{{ $src }}" alt="" class="absolute top-0 left-0" />
                                        {{-- <div style="display: flex; gap: 10px; padding-top: 20px;">
                                            <img onclick="openBadgeModal()" src="{{ asset('assets/assets/images/badge1.png') }}" alt="" class="absolute -bottom-1.5 size-5" />
                            </div> --}}
                                        <span id="badgeModal" style="display: none; ">مستكشف الأماكن</span>
                                        <script>
                                            function openBadgeModal() {
                                                var modal = document.getElementById("badgeModal");
                                                modal.style.display = "block";
                                            }
                                        </script>
                                    </div>
                                    <a href="user-profile.html"
                                        class="text-xs font-semibold text-color8 dark:text-white pt-4">
                                        {{ $user->name }}
                                    </a>
                                    <div class="text-xs font-semibold text-color8 dark:text-white">
                                        {{ $user->explorer_name }}
                                    </div>
                                    <div class="flex justify-between items-center pt-2 w-full">
                                        <p class="text-color8 pt-1 dark:text-white text-xs">
                                            {{ $user->followers_count }} <i class="fa fa-users"></i>
                                        </p>
                                        <p class="text-color8 pt-1 dark:text-white text-xs">
                                            {{ $user->favorites_count }} <i class="fa fa-heart"></i>
                                        </p>
                                    </div>
                                    <div class="flex justify-between items-center pt-2 w-full">
                                        <p class="text-color8 dark:text-white text-xs">
                                            808 <i class="fa fa-coins"></i>
                                        </p>
                                        <p class="text-color8 dark:text-white text-xs">
                                            {{ $user->ratings_count }} <i class="fa fa-star"></i>
                                        </p>
                                    </div>
                                    <?php
                                    if ($user->status == 1) {
                                        $color = 'green';
                                    } elseif ($user->status == 0) {
                                        $color = '#ff710f';
                                    } elseif ($user->status == 2) {
                                        $color = 'black';
                                    } elseif ($user->status == 3) {
                                        $color = 'red';
                                    }
                                    ?>
                                    <?php
                                    if ($user->status == 1) {
                                        $userState = 'فعال';
                                    } elseif ($user->status == 0) {
                                        $userState = 'غير فعال';
                                    } elseif ($user->status == 2) {
                                        $userState = 'محظور';
                                    } elseif ($user->status == 3) {
                                        $userState= 'ملغي';
                                    }
                                    ?>
                                    <span
                                        style="color: {{ $color }}; font-size: 12px; margin-bottom: 10px;">{{ $userState }}</span>
                                    <a href="{{ route('mobile.admin.users.edit', $user->id) }}"
                                        class="text-white text-xs bg-p2 py-1 px-4 rounded-full dark:bg-p1">
                                        عرض
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
