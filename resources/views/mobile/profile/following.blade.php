@extends('layouts.mobile')

@section('title', 'أتابع | My Following')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="{{ asset('assets/assets/css/followers.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
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
@section('content')

<x-china-header :title="__('messages.أتابع')" :route="route('mobile.profile.profile')" />

<div class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-black">
    <div class="relative z-10">
        <div class="pt-6">
            <div class="grid grid-cols-2 gap-4 pt-5" style="direction: rtl;">
                @forelse ($myFollowings as $myFollower)
                @php
                $user = $myFollower->following;
                @endphp
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
                            @php
                            if ($user->status == 1) {
                            $src = asset('assets/assets/images/user-progress-green.svg');
                            } elseif ($user->status == 0) {
                            $src = asset('assets/assets/images/user-progress.svg');
                            } elseif ($user->status == 2) {
                            $src = asset('assets/assets/images/user-progress-black.svg');
                            } elseif ($user->status == 3) {
                            $src = asset('assets/assets/images/user-progress-red.svg');
                            }
                            @endphp
                            <img src="{{ $src }}" alt="" class="absolute top-0 left-0" />
                            <span id="badgeModal-{{ $user->id }}" style="display: none;">{{
                                __('messages.explorer_badge') }}</span>
                            <script>
                                function openBadgeModal() {
                                        var modal = document.getElementById("badgeModal-{{ $user->id }}");
                                        modal.style.display = "block";
                                    }
                            </script>
                        </div>
                        <div class="text-xs font-semibold text-color8 dark:text-white">
                            {{ $user->explorer_name }}
                        </div>
                        <div class="flex justify-between items-center pt-2 w-full">
                            <p class="text-color8 pt-1 dark:text-white text-xs">
                                <span id="followers-count-{{ $user->id }}">{{ $user->followers_count }}</span>
                                <i class="fa fa-users"></i>
                            </p>
                        </div>
                        <button class="toggle-follow-btn text-white text-xs bg-p2 py-1 px-4 rounded-full dark:bg-p1"
                            data-user-id="{{ $user->id }}"
                            data-following="{{ $myFollower->is_following_back ? 'true' : 'false' }}"
                            style="background-color: {{ $myFollower->is_following_back ? '#fee2e2' : '#dcfce7' }}; color: red; font-size: 10px;">
                            <i class="fa-solid fa-user-xmark" style="color: red;"></i>
                            {{ __('messages.unfollow') }}
                        </button>
                    </div>
                </div>
                @empty
                <x-empty />
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".toggle-follow-btn");
        buttons.forEach(btn => {
            btn.addEventListener("click", async function () {
                const userId = this.dataset.userId;
                const parentCard = this.closest(".swiper-slide");
                this.disabled = true;
                try {
                    const response = await fetch(`/followers/toggle/${userId}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        }
                    });
                    if (!response.ok) throw new Error("Request failed");
                    parentCard.remove();
                } catch (error) {
                    console.error("Error:", error);
                } finally {
                    this.disabled = false;
                }
            });
        });
    });
</script>
@endsection