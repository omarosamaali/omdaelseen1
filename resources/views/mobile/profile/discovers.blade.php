@extends('layouts.mobile')

@section('title', 'ملفي الشخصي | My Profile')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                <div class="relative z-10 px-6">
                    <div class="flex justify-between items-center gap-4" style="flex-direction: row-reverse;">
                        <div style="position: absolute;" class="flex justify-start items-center gap-4">
                            <a href="{{ route('mobile.profile.profile') }}"
                                class="bg-white size-8 rounded-full flex justify-center items-center text-xl dark:bg-color10">
                                <i class="ph ph-caret-left"></i>
                            </a>
                        </div>
                        <img src="{{ asset('assets/assets/images/logo-all.png') }}" class="logo--image" />
                    </div>
                    <form action="{{ Auth::user()->role == 'admin' ? route('mobile.admin.users.index') : route('mobile.users.index') }}" method="GET">
                        <div class="flex justify-between items-center gap-3 pt-6">
                            <div style="background-color: white; color: black; border: 1px solid gray;"
                                class="flex justify-start items-center gap-3 bg-color24 border border-color24 p-4 rounded-full text-white w-full">
                                <i class="ph ph-magnifying-glass"></i>
                                <input type="text" placeholder="{{ __('messages.search_explorer') }}" name="search"
                                    style="color: black !important; text-align: center;"
                                    class="bg-transparent outline-none w-full text-xs" />
                            </div>
                            <button type="submit" style="display: none;"></button>
                        </div>
                    </form>
                </div>

                <div class="px-6 pt-0">
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
                                        <span id="badgeModal"
                                            style="display: none;">{{ __('messages.explorer_badge') }}</span>
                                        <script>
                                            function openBadgeModal() {
                                                var modal = document.getElementById("badgeModal");
                                                modal.style.display = "block";
                                            }
                                        </script>
                                    </div>
                                    <div class="text-xs font-semibold text-color8 dark:text-white">
                                        {{ $user->explorer_name }}
                                    </div>
                                    <div class="flex justify-between items-center pt-2 w-full">
                                        <p class="text-color8 pt-1 dark:text-white text-xs">
                                            <span
                                                id="followers-count-{{ $user->id }}">{{ $user->followers_count }}</span>
                                            <i class="fa fa-users"></i>
                                        </p>
                                        <p class="text-color8 pt-1 dark:text-white text-xs">
                                            {{ $user->favorites_count }} <i class="fa fa-heart"></i>
                                        </p>
                                    </div>
                                    <div class="flex justify-between items-center pt-2 w-full">
                                        <p class="text-color8 dark:text-white text-xs">
                                            {{ $user->ratings_count }} <i class="fa fa-star"></i>
                                        </p>
                                    </div>
                                    <div class="text-white text-xs bg-p2 py-1 px-4 rounded-full dark:bg-p1"
                                        id="follow-button-{{ $user->id }}"
                                        style="{{ Auth::user()->isFollowing($user) ? 'background: green;' : '' }}">
                                        @if (auth()->check() && Auth::user()->id != $user->id)
                                            <div class="tab-details-content-headpone">
                                                <i class="follow-icon fa-solid {{ Auth::user()->isFollowing($user) ? 'fa-user-check' : 'fa-user-plus' }}"
                                                    data-user-id="{{ $user->id }}"
                                                    title="{{ Auth::user()->isFollowing($user) ? __('messages.unfollow') : __('messages.follow') }}"
                                                    style="cursor: pointer;">
                                                </i>
                                            </div>
                                        @else
                                            <div class="tab-details-content-headpone">
                                                {{ __('messages.this_is_me') }}
                                            </div>
                                        @endif
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            if (window.followSystemInitialized) {
                                                return;
                                            }
                                            window.followSystemInitialized = true;

                                            function initializeFollowButtons() {
                                                const followIcons = document.querySelectorAll('.follow-icon:not([data-initialized])');
                                                followIcons.forEach(icon => {
                                                    icon.setAttribute('data-initialized', 'true');
                                                    icon.addEventListener('click', handleFollowClick);
                                                });
                                            }

                                            function handleFollowClick(event) {
                                                event.preventDefault();
                                                event.stopPropagation();
                                                const iconElement = this;
                                                const userId = iconElement.getAttribute('data-user-id');
                                                if (iconElement.dataset.processing === 'true') {
                                                    return;
                                                }
                                                toggleFollow(userId, iconElement);
                                            }

                                            function toggleFollow(userId, iconElement) {
                                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                                                if (!csrfToken) {
                                                    console.error('CSRF token not found');
                                                    return;
                                                }

                                                iconElement.dataset.processing = 'true';
                                                iconElement.style.opacity = '0.5';
                                                iconElement.style.pointerEvents = 'none';

                                                fetch('/users/toggle-follow', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': csrfToken,
                                                            'Accept': 'application/json'
                                                        },
                                                        body: JSON.stringify({
                                                            user_id: parseInt(userId)
                                                        })
                                                    })
                                                    .then(response => {
                                                        if (!response.ok) {
                                                            throw new Error(`HTTP error! status: ${response.status}`);
                                                        }
                                                        return response.json();
                                                    })
                                                    .then(data => {
                                                        if (data.success) {
                                                            updateFollowIcon(iconElement, data.is_following);
                                                            const buttonContainer = document.getElementById(`follow-button-${userId}`);
                                                            if (buttonContainer) {
                                                                if (data.is_following) {
                                                                    buttonContainer.style.backgroundColor = 'green';
                                                                } else {
                                                                    buttonContainer.style.backgroundColor = '';
                                                                }
                                                            }
                                                            updateFollowersCount(data.followers_count, userId);
                                                            console.log(
                                                                `Follow status updated: ${data.is_following ? '{{ __('messages.following') }}' : '{{ __('messages.not_following') }}'}`
                                                            );
                                                        } else {
                                                            console.error('Server error:', data.message || data.error || 'Unknown error');
                                                            alert('{{ __('messages.follow_error') }}');
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error('Network error:', error);
                                                        alert('{{ __('messages.network_error') }}');
                                                    })
                                                    .finally(() => {
                                                        iconElement.style.opacity = '1';
                                                        iconElement.style.pointerEvents = 'auto';
                                                        iconElement.dataset.processing = 'false';
                                                    });
                                            }

                                            function updateFollowIcon(iconElement, isFollowing) {
                                                iconElement.classList.remove('fa-user-plus', 'fa-user-check');
                                                if (isFollowing) {
                                                    iconElement.classList.add('fa-user-check');
                                                    iconElement.setAttribute('title', '{{ __('messages.unfollow') }}');
                                                } else {
                                                    iconElement.classList.add('fa-user-plus');
                                                    iconElement.setAttribute('title', '{{ __('messages.follow') }}');
                                                }
                                            }

                                            function updateFollowersCount(count, userId) {
                                                const followersElement = document.getElementById(`followers-count-${userId}`);
                                                if (followersElement && typeof count !== 'undefined') {
                                                    followersElement.textContent = count;
                                                }
                                            }

                                            initializeFollowButtons();
                                        });
                                    </script>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </body>
@endsection
