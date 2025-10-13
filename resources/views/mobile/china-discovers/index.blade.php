@extends('layouts.mobile')
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

@section('title', 'مستكشفي الصين | China Discover')

@section('content')
<style>
    .place-name {
        /* position: absolute; */
        bottom: 0px !important;
    }

    .rating-icon {
        z-index: 99;
    }

    .categories {
        color: black;
    }

    #container-header {
        position: fixed;
        width: 100%;
        z-index: 999999;
    }

    .heart-icon {
        top: unset !important;
        bottom: 12px;
    }
</style>
<x-china-header :title="__('messages.china_explorers')" :route="route('mobile.welcome')" />

<div style="width: 100%; display: block; padding-top: 61px;">
    @if ($banners->isNotEmpty())
    @foreach ($banners as $banner)
    <img class="fav-image" src="{{ asset('storage/' . $banner->avatar) }}" style="width: 100%;" alt="">
    @endforeach
    @endif
</div>
<div style="padding-top: 60px;" class="container min-h-dvh relative overflow-hidden pb-8 text-black dark:bg-black">

    <div>
        <div class="continaer--title">
            <h6 class="categories text-black" style="color: maroon;">{{ __('messages.categories') }}</h6>
            <a href={{ route('mobile.china-discovers.all--places') }} class="show--all">{{
                __('messages.search_for_place') }}</a>
        </div>

        <div style="display: flex; align-items: center; justify-content: flex-start; gap: 10px; margin: 10px;">
            <a href="#" class="all-link" data-explorer-id="">
                <div style="width: 99px; flex-shrink: 0;">
                    <div class="explorer-name" id="all-link" style="font-size: 15px; color: #f99e4d !important;">
                        {{ __('messages.all') }}
                    </div>
                </div>
            </a>

            <div class="slider-container"
                style="display: flex; overflow-x: auto; scroll-snap-type: x mandatory; gap: 10px; padding: 10px; scrollbar-width: none; -ms-overflow-style: none;">
                @foreach ($explorers as $explorer)
                <a href="#"
                    style="flex-shrink: 0; text-decoration: none; color: inherit; text-align: center; scroll-snap-align: start;"
                    class="explorer-link" data-explorer-id="{{ $explorer->id }}">
                    <div style="flex-shrink: 0;">
                        <img style="height: 68px; width: 68px; border-radius: 50%; margin: auto;"
                            src="{{ asset('storage/' . $explorer->avatar) }}"
                            alt="{{ $explorer->{'name_' . app()->getLocale()} ?? $explorer->name_ar }}">
                        <p class="explorer-name {{ request()->segment(3) == $explorer->id ? 'active' : '' }}"
                            style="padding-top: 9px; font-size: 15px;">
                            {{ $explorer->{'name_' . app()->getLocale()} ?? $explorer->name_ar }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <a href="{{ route('mobile.create') }}" class="add-place-button">{{ __('messages.add_new_place') }}
        </h2>
    </a>

    @if (session('success'))
    <div id="success-alert" style="background: #282b28; color: green; margin: 20px 20px 4px;"
        class="bg-green-500 text-white p-4 rounded-xl my-4 text-center">
        {{ session('success') }}
    </div>
    @endif

    {{-- الأماكن --}}
    <div class="slider-container">
        <div class="slider" id="placesSlider">
            @forelse ($places as $place)
            @auth
            <a href="{{ route('mobile.china-discovers.info_place', $place) }}">
                <div class="place-card">
                    <img src="{{ asset('storage/' . $place->avatar) }}"
                        alt="{{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }}">
                    @php
                    $isFavorited = auth()->check() && auth()->user()->isFavorite($place);
                    @endphp
                    @if (auth()->check() && auth()->id() != $place->user_id)
                    <div style="bottom: 12px; top: unset;" class="heart-icon @if ($isFavorited) favorited @endif"
                        data-place-id="{{ $place->id }}">
                        <i class="fa @if ($isFavorited) fa-solid fa-heart @else fa-regular fa-heart @endif"
                            style="font-size: 18px;"></i>
                    </div>
                    @endif
                    <div class="rating-icon"
                        style="bottom: 16px; top: unset; position: absolute; left: 10px; color: #f9a50f; display: flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-star" style="font-size: 18px;"></i>
                        <span style="font-size: 14px; font-weight: bold; color: #fff;">
                            {{ number_format($place->ratings_avg_rating ?? 0, 1) }} ({{ $place->ratings_count ?? 0 }})
                        </span>
                    </div>
                    <div class="category-tag">
                        @if ($place->mainCategory)
                        <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}"
                            alt="{{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}">
                        <span>
                            {{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}
                        </span>
                        @else
                        <img src="{{ asset('storage/placeholders/no-category.png') }}" alt="{{ __('بدون تصنيف') }}">
                        <span>{{ __('بدون تصنيف') }}</span>
                        @endif
                    </div>
                    <div class="place-name">
                        <span style="bottom: 50px; position: relative;">
                            {{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }}
                        </span>
                    </div>
                    @auth
                    {{-- @if(Auth::user()->status != 1) --}}
                    {{-- <button onclick="showActivationAlert()" class="explore-btn">
                        {{ __('messages.explore') }}
                    </button> --}}
                    @else
                    {{-- <a href="{{ route('mobile.china-discovers.info_place', $place) }}" class="explore-btn">
                        {{ __('messages.explore') }}
                    </a> --}}
                    {{-- @endif --}}
                    @endauth
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        function showActivationAlert() {
        Swal.fire({
            title: 'تنبيه',
            text: 'يجب تفعيل الحساب أولاً قبل استكشاف الأماكن.',
            icon: 'warning',
            confirmButtonText: 'حسناً',
            confirmButtonColor: '#3085d6',
        });
    }
                    </script>
                </div>
            </a>
            @else
            <a href="{{ route('mobile.auth.login') }}">
                <div class="place-card">
                    <img src="{{ asset('storage/' . $place->avatar) }}"
                        alt="{{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }}">

                    @php
                    $isFavorited = auth()->check() && auth()->user()->isFavorite($place);
                    @endphp

                    @if (auth()->check() && auth()->id() != $place->user_id)
                    <div style="bottom: 12px; top: unset;" class="heart-icon @if ($isFavorited) favorited @endif"
                        data-place-id="{{ $place->id }}">
                        <i class="fa @if ($isFavorited) fa-solid fa-heart @else fa-regular fa-heart @endif"
                            style="font-size: 18px;"></i>
                    </div>
                    @endif

                    <div class="rating-icon"
                        style="bottom: 16px; top: unset; position: absolute; left: 10px; color: #f9a50f; display: flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-star" style="font-size: 18px;"></i>
                        <span style="font-size: 14px; font-weight: bold; color: #fff;">
                            {{ number_format($place->ratings_avg_rating ?? 0, 1) }} ({{ $place->ratings_count ?? 0 }})
                        </span>
                    </div>

                    <div class="category-tag">
                        @if ($place->mainCategory)
                        <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}"
                            alt="{{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}">
                        <span>
                            {{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}
                        </span>
                        @else
                        <img src="{{ asset('storage/placeholders/no-category.png') }}" alt="{{ __('بدون تصنيف') }}">
                        <span>{{ __('بدون تصنيف') }}</span>
                        @endif
                    </div>

                    <span style="bottom: 50px; position: relative;">
                        {{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }} @auth
                        {{-- @if(Auth::user()->status != 1) --}}
                        {{-- <button onclick="showActivationAlert()" class="explore-btn">
                            {{ __('messages.explore') }}
                        </button> --}}
                        @else
                        {{-- <a href="{{ route('mobile.china-discovers.info_place', $place) }}" class="explore-btn">
                            {{ __('messages.explore') }}
                        </a> --}}
                        {{-- @endif --}}
                        @endauth
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <script>
                            function showActivationAlert() {
                                Swal.fire({
                                    title: 'تنبيه',
                                    text: 'يجب تفعيل الحساب أولاً قبل استكشاف الأماكن.',
                                    icon: 'warning',
                                    confirmButtonText: 'حسناً',
                                    confirmButtonColor: '#3085d6',
                                });
                            }
                        </script>
                </div>
            </a>
            @endauth
            @empty
            <div class="empty-message-container" style="text-align: center; width: 100%; padding: 20px;">
                <p style="color: #6c757d; font-size: 18px;">{{ __('لا يوجد أماكن للعرض حاليًا.') }}</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- أحدث الأماكن --}}
    <div class="continaer--title" style="margin-top: 30px;">
        <h6 class="categories" style="color: maroon;">{{ __('messages.latest_places') }}</h6>
        <a href="{{ route('mobile.china-discovers.all--places') }}" style="border: 0px;" class="show--all">{{
            __('messages.show_all')
            }}</a>
    </div>

    <div class="slider-container">
        <div class="slider" id="latestPlacesSlider">
            @forelse ($latestPlaces as $place)
            @auth
            <a href="{{ route('mobile.china-discovers.info_place', $place) }}">
                <div class="place-card">
                    <img src="{{ asset('storage/' . $place->avatar) }}"
                        alt="{{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }}">

                    @php
                    $isFavorited = auth()->check() && auth()->user()->isFavorite($place);
                    @endphp

                    @if (auth()->check() && auth()->id() != $place->user_id)
                    <div style="bottom: 12px; top: unset;" class="heart-icon @if ($isFavorited) favorited @endif"
                        data-place-id="{{ $place->id }}">
                        <i class="fa @if ($isFavorited) fa-solid fa-heart @else fa-regular fa-heart @endif"
                            style="font-size: 18px;"></i>
                    </div>
                    @endif

                    <div class="rating-icon"
                        style="bottom: 16px; top: unset; position: absolute; left: 10px; color: #f9a50f; display: flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-star" style="font-size: 18px;"></i>
                        <span style="font-size: 14px; font-weight: bold; color: #fff;">
                            {{ number_format($place->ratings_avg_rating ?? 0, 1) }} ({{ $place->ratings_count ?? 0 }})
                        </span>
                    </div>

                    <div class="category-tag">
                        @if ($place->mainCategory)
                        <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}"
                            alt="{{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}">
                        <span>
                            {{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}
                        </span>
                        @else
                        <img src="{{ asset('storage/placeholders/no-category.png') }}" alt="{{ __('بدون تصنيف') }}">
                        <span>{{ __('بدون تصنيف') }}</span>
                        @endif
                    </div>

                    <div class="place-name">
                        <span style="bottom: 50px; position: relative;">
                            {{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }}
                    </div>
                    @auth
                    {{-- @if(Auth::user()->status != 1) --}}
                    {{-- <button onclick="showActivationAlert()" class="explore-btn">
                        {{ __('messages.explore') }}
                    </button> --}}
                    @else
                    {{-- <a href="{{ route('mobile.china-discovers.info_place', $place) }}" class="explore-btn">
                        {{ __('messages.explore') }}
                    </a> --}}
                    {{-- @endif --}}
                    @endauth
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        function showActivationAlert() {
                    Swal.fire({
                        title: 'تنبيه',
                        text: 'يجب تفعيل الحساب أولاً قبل استكشاف الأماكن.',
                        icon: 'warning',
                        confirmButtonText: 'حسناً',
                        confirmButtonColor: '#3085d6',
                    });
                }
                    </script>
                </div>
            </a>
            @else
            <a href="{{ route('mobile.auth.login') }}">
                <div class="place-card">
                    <img src="{{ asset('storage/' . $place->avatar) }}"
                        alt="{{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }}">

                    @php
                    $isFavorited = auth()->check() && auth()->user()->isFavorite($place);
                    @endphp

                    @if (auth()->check() && auth()->id() != $place->user_id)
                    <div style="bottom: 12px; top: unset;" class="heart-icon @if ($isFavorited) favorited @endif"
                        data-place-id="{{ $place->id }}">
                        <i class="fa @if ($isFavorited) fa-solid fa-heart @else fa-regular fa-heart @endif"
                            style="font-size: 18px;"></i>
                    </div>
                    @endif

                    <div class="rating-icon"
                        style="bottom: 16px; top: unset; position: absolute; left: 10px; color: #f9a50f; display: flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-star" style="font-size: 18px;"></i>
                        <span style="font-size: 14px; font-weight: bold; color: #fff;">
                            {{ number_format($place->ratings_avg_rating ?? 0, 1) }} ({{ $place->ratings_count ?? 0 }})
                        </span>
                    </div>

                    <div class="category-tag">
                        @if ($place->mainCategory)
                        <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}"
                            alt="{{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}">
                        <span>
                            {{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}
                        </span>
                        @else
                        <img src="{{ asset('storage/placeholders/no-category.png') }}" alt="{{ __('بدون تصنيف') }}">
                        <span>{{ __('بدون تصنيف') }}</span>
                        @endif
                    </div>

                    <div class="place-name">
                        <span style="bottom: 50px; position: relative;">
                            {{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }}
                    </div>
                    @auth
                    {{-- @if(Auth::user()->status != 1) --}}
                    {{-- <button onclick="showActivationAlert()" class="explore-btn">
                        {{ __('messages.explore') }}
                    </button> --}}
                    @else
                    {{-- <a href="{{ route('mobile.china-discovers.info_place', $place) }}" class="explore-btn">
                        {{ __('messages.explore') }}
                    </a> --}}
                    {{-- @endif --}}
                    @endauth
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        function showActivationAlert() {
                                            Swal.fire({
                                                title: 'تنبيه',
                                                text: 'يجب تفعيل الحساب أولاً قبل استكشاف الأماكن.',
                                                icon: 'warning',
                                                confirmButtonText: 'حسناً',
                                                confirmButtonColor: '#3085d6',
                                            });
                                        }
                    </script>
                </div>
            </a>
            @endauth @empty
            <div class="empty-message-container" style="text-align: center; width: 100%; padding: 20px;">
                <p style="color: #6c757d; font-size: 18px;">{{ __('لا يوجد أماكن للعرض حاليًا.') }}</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- الأكثر تقييماً --}}
    <div class="continaer--title" style="margin-top: 30px;">
        <h6 class="categories" style="color: maroon;">{{ __('messages.most_rated') }}</h6>
        <a href={{ route('mobile.china-discovers.all--places') }} style="border: 0px !important;" class="show--all">{{
            __('messages.show_all') }}</a>
    </div>

    <div class="slider-container">
        <div class="slider" id="placesSlider">
            @forelse ($topRatedPlaces as $place)
            @auth
            <a href="{{ route('mobile.china-discovers.info_place', $place) }}">
                <div class="place-card">
                    <img src="{{ asset('storage/' . $place->avatar) }}"
                        alt="{{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }}">

                    @php
                    $isFavorited = auth()->check() && auth()->user()->isFavorite($place);
                    @endphp

                    @if (auth()->check() && auth()->id() != $place->user_id)
                    <div style="bottom: 12px; top: unset;" class="heart-icon @if ($isFavorited) favorited @endif"
                        data-place-id="{{ $place->id }}">
                        <i class="fa @if ($isFavorited) fa-solid fa-heart @else fa-regular fa-heart @endif"
                            style="font-size: 18px;"></i>
                    </div>
                    @endif

                    <div class="rating-icon"
                        style="bottom: 16px; top: unset; position: absolute; left: 10px; color: #f9a50f; display: flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-star" style="font-size: 18px;"></i>
                        <span style="font-size: 14px; font-weight: bold; color: #fff;">
                            {{ number_format($place->ratings_avg_rating ?? 0, 1) }} ({{ $place->ratings_count ?? 0 }})
                        </span>
                    </div>

                    <div class="category-tag">
                        @if ($place->mainCategory)
                        <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}"
                            alt="{{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}">
                        <span>
                            {{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}
                        </span>
                        @else
                        <img src="{{ asset('storage/placeholders/no-category.png') }}" alt="{{ __('بدون تصنيف') }}">
                        <span>{{ __('بدون تصنيف') }}</span>
                        @endif
                    </div>

                    <div class="place-name">
                        <span style="bottom: 50px; position: relative;">
                            {{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }}
                    </div>
                    @auth
                    {{-- @if(Auth::user()->status != 1) --}}
                    {{-- <button onclick="showActivationAlert()" class="explore-btn">
                        {{ __('messages.explore') }}
                    </button> --}}
                    @else
                    {{-- <a href="{{ route('mobile.china-discovers.info_place', $place) }}" class="explore-btn">
                        {{ __('messages.explore') }}
                    </a> --}}
                    {{-- @endif --}}
                    @endauth
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        function showActivationAlert() {
                    Swal.fire({
                        title: 'تنبيه',
                        text: 'يجب تفعيل الحساب أولاً قبل استكشاف الأماكن.',
                        icon: 'warning',
                        confirmButtonText: 'حسناً',
                        confirmButtonColor: '#3085d6',
                    });
                }
                    </script>
                </div>
            </a>
            @else
            <a href="{{ route('mobile.auth.login') }}">
                <div class="place-card">
                    <img src="{{ asset('storage/' . $place->avatar) }}"
                        alt="{{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }}">

                    @php
                    $isFavorited = auth()->check() && auth()->user()->isFavorite($place);
                    @endphp

                    @if (auth()->check() && auth()->id() != $place->user_id)
                    <div style="bottom: 12px; top: unset;" class="heart-icon @if ($isFavorited) favorited @endif"
                        data-place-id="{{ $place->id }}">
                        <i class="fa @if ($isFavorited) fa-solid fa-heart @else fa-regular fa-heart @endif"
                            style="font-size: 18px;"></i>
                    </div>
                    @endif

                    <div class="rating-icon"
                        style="bottom: 16px; top: unset; position: absolute; left: 10px; color: #f9a50f; display: flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-star" style="font-size: 18px;"></i>
                        <span style="font-size: 14px; font-weight: bold; color: #fff;">
                            {{ number_format($place->ratings_avg_rating ?? 0, 1) }} ({{ $place->ratings_count ?? 0 }})
                        </span>
                    </div>

                    <div class="category-tag">
                        @if ($place->mainCategory)
                        <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}"
                            alt="{{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}">
                        <span>
                            {{ $place->mainCategory->{'name_' . app()->getLocale()} ?? $place->mainCategory->name_ar }}
                        </span>
                        @else
                        <img src="{{ asset('storage/placeholders/no-category.png') }}" alt="{{ __('بدون تصنيف') }}">
                        <span>{{ __('بدون تصنيف') }}</span>
                        @endif
                    </div>

                    <div class="place-name">
                        <span style="bottom: 50px; position: relative;">
                            {{ $place->{'name_' . app()->getLocale()} ?? $place->name_ar }}
                    </div>
                    @auth
                    {{-- @if(Auth::user()->status != 1) --}}
                    {{-- <button onclick="showActivationAlert()" class="explore-btn">
                        {{ __('messages.explore') }}
                    </button> --}}
                    @else
                    {{-- <a href="{{ route('mobile.china-discovers.info_place', $place) }}" class="explore-btn">
                        {{ __('messages.explore') }}
                    </a> --}}
                    {{-- @endif --}}
                    @endauth
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        function showActivationAlert() {
                                            Swal.fire({
                                                title: 'تنبيه',
                                                text: 'يجب تفعيل الحساب أولاً قبل استكشاف الأماكن.',
                                                icon: 'warning',
                                                confirmButtonText: 'حسناً',
                                                confirmButtonColor: '#3085d6',
                                            });
                                        }
                    </script>
                </div>
            </a>
            @endauth @empty
            <div class="empty-message-container" style="text-align: center; width: 100%; padding: 20px;">
                <p style="color: #6c757d; font-size: 18px;">{{ __('لا يوجد أماكن للعرض حاليًا.') }}</p>
            </div>
            @endforelse
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const sliderContainer = document.querySelector('.slider-container');
    const explorerLinks = document.querySelectorAll('.explorer-link');
    const allLink = document.querySelector('.all-link');
    let isFiltering = false;
    let scrollTimeout;

    // دالة لإيجاد العنصر في المنتصف
    function getCenterElement() {
        const containerRect = sliderContainer.getBoundingClientRect();
        const containerCenter = containerRect.left + (containerRect.width / 2);
        let closestElement = null;
        let closestDistance = Infinity;

        explorerLinks.forEach(link => {
            const linkRect = link.getBoundingClientRect();
            const linkCenter = linkRect.left + (linkRect.width / 2);
            const distance = Math.abs(containerCenter - linkCenter);
            if (distance < closestDistance) {
                closestDistance = distance;
                closestElement = link;
            }
        });
        return closestElement;
    }

    // تحديث الشكل النشط
    function updateActiveState(activeLink) {
        document.querySelectorAll('.explorer-name').forEach(name => {
            name.style.color = '#000';
        });
        document.getElementById('all-link').style.color = '#000';

        if (activeLink) {
            const explorerName = activeLink.querySelector('.explorer-name');
            if (explorerName) explorerName.style.color = '#f99e4d';
        }
    }

    // فلترة الأماكن
    async function filterPlaces(explorerId) {
        if (isFiltering) return;
        isFiltering = true;

        try {
            const url = explorerId ? `/mobile/china-discovers/${explorerId}` : '/mobile/china-discovers';
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            
            // تحديث الأماكن
            updatePlacesHTML('#placesSlider', data.places);
            updatePlacesHTML('#latestPlacesSlider', data.latestPlaces);
            
            reinitializeHeartIcons();

        } catch (error) {
            console.error('Error:', error);
        } finally {
            isFiltering = false;
        }
    }
const userStatus = {{ Auth::user()->status ?? 0 }};
const explorUrl = "{{ __('messages.explore') }}";
    // تحديث HTML الأماكن
    function updatePlacesHTML(selector, places) {
        const slider = document.querySelector(selector);
        if (!slider) return;

        if (places.length === 0) {
            slider.innerHTML = '<div class="empty-message-container" style="text-align: center; width: 100%; padding: 20px;"><p style="color: #6c757d; font-size: 18px;">لا يوجد أماكن للعرض حاليًا.</p></div>';
            return;
        }

        slider.innerHTML = places.map(place => `
        <a href="{{ route('mobile.china-discovers.info_place', $place) }}">
            <div class="place-card">
                <img src="/storage/${place.avatar}" alt="${place.name_ar}">
                
                ${place.user_id !== {{ auth()->id() ?? 'null' }} ? `
                    <div class="heart-icon ${place.is_favorited ? 'favorited' : ''}" data-place-id="${place.id}">
                        <i class="fa ${place.is_favorited ? 'fa-solid' : 'fa-regular'} fa-heart" style="font-size: 18px;"></i>
                    </div>
                ` : ''}
                
                <div class="rating-icon" style="position: absolute; top: unset !important; bottom: 20px; right: 156px; color: #f9a50f; display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-star" style="font-size: 18px;"></i>
                </div>
                
                <div class="category-tag">
                    ${place.main_category ? `
                        <img src="/storage/${place.main_category.avatar}" alt="${place.main_category.name_ar}">
                        <span>${place.main_category.name_ar}</span>
                    ` : `
                        <img src="/storage/placeholders/no-category.png" alt="بدون تصنيف">
                        <span>بدون تصنيف</span>
                    `}
                </div>
                
                <div class="place-name" >
                    <span style="bottom: 50px; position: relative;"> 
                        ${place.name_ar}
                        </span>
                    </div>
                </div>
            </a>
                
${userStatus != 1 ? `
` : `
`}
            </div>
        `).join('');
    }

    // إعادة تهيئة أيقونات القلب
    function reinitializeHeartIcons() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        document.querySelectorAll('.heart-icon').forEach(icon => {
            icon.replaceWith(icon.cloneNode(true));
        });
        
        document.querySelectorAll('.heart-icon').forEach(icon => {
            icon.addEventListener('click', function() {
                const placeId = this.getAttribute('data-place-id');
                const heartSvg = this.querySelector('i');
                
                fetch('{{ route("favorites.toggle") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ place_id: placeId }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'added') {
                        this.classList.add('favorited');
                        heartSvg.classList.remove('fa-regular');
                        heartSvg.classList.add('fa-solid');
                    } else {
                        this.classList.remove('favorited');
                        heartSvg.classList.remove('fa-solid');
                        heartSvg.classList.add('fa-regular');
                    }
                });
            });
        });
    }

    // عند انتهاء السحب
    sliderContainer.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            const centerElement = getCenterElement();
            if (centerElement) {
                const explorerId = centerElement.getAttribute('data-explorer-id');
                updateActiveState(centerElement);
                filterPlaces(explorerId);
            }
        }, 200);
    });

    // النقر على "الكل"
    allLink.addEventListener('click', function(e) {
        e.preventDefault();
        updateActiveState(null);
        document.getElementById('all-link').style.color = '#f99e4d';
        filterPlaces('');
    });

    // النقر المباشر
    explorerLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const explorerId = this.getAttribute('data-explorer-id');
            updateActiveState(this);
            filterPlaces(explorerId);
        });
    });
});

    document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            document.querySelectorAll('.heart-icon').forEach(icon => {
                icon.addEventListener('click', function() {
                    const placeId = this.getAttribute('data-place-id');
                    const iconElement = this;
                    const heartSvg = iconElement.querySelector('i');
                    fetch('{{ route('favorites.toggle') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                place_id: placeId
                            }),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.status === 'added') {
                                iconElement.classList.add('favorited');
                                heartSvg.classList.remove('fa-regular');
                                heartSvg.classList.add('fa-solid');
                            } else if (data.status === 'removed') {
                                iconElement.classList.remove('favorited');
                                heartSvg.classList.remove('fa-solid');
                                heartSvg.classList.add('fa-regular');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('حدث خطأ. يرجى تسجيل الدخول أو المحاولة مرة أخرى.');
                        });
                });
            });
        });

        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 3000);
        }

        function openModal() {
            Swal.fire({
                title: "بلاغ؟",
                text: 'هل هذا المكان مخالف',
                showCancelButton: true,
                confirmButtonText: "نعم",
                cancelButtonText: "لا"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (typeof userId === 'undefined' || userId === null) {
                        Swal.fire("خطأ!", "لا يمكن إرسال البلاغ. يرجى تسجيل الدخول أولاً.", "error");
                        return;
                    }

                    fetch(`/chef-profile/report-by-user/${userId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                report_type: 'content_report'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("تم الإبلاغ!", "شكراً لك. سيتم مراجعة بلاغك.", "success");
                                const reportBtn = document.querySelector('.report-btn');
                                if (reportBtn) {
                                    reportBtn.innerHTML = 'تم الإبلاغ';
                                    reportBtn.style.background = 'gray';
                                    reportBtn.onclick = null;
                                    reportBtn.style.cursor = 'default';
                                }
                            } else {
                                Swal.fire("حدث خطأ!", data.message || "فشل إرسال البلاغ.", "error");
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire("حدث خطأ!", "فشل في التواصل مع الخادم.", "error");
                        });
                }
            });
        }

        function toggleHeart(element) {
            element.classList.toggle('liked');
            const icon = element.querySelector('i');
            if (element.classList.contains('liked')) {
                icon.className = 'fa fa-heart-fill';
            } else {
                icon.className = 'fa fa-heart';
            }
        }

        function explorePlace(element) {
            const card = element.closest('.place-card');
            const placeName = card.querySelector('.place-name').textContent;
            const categorySpan = card.querySelector('.category-tag span');
            const category = categorySpan ? categorySpan.textContent : 'غير محدد';

            alert(`استكشف ${placeName} في فئة ${category}`);
        }
        let autoScrollIntervals = [];
        let userInteracting = [];

        function initializeTouchSupport() {
            document.querySelectorAll('.slider').forEach((slider, index) => {
                let startX = 0;
                let scrollLeft = 0;
                userInteracting[index] = false;
                slider.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].pageX - slider.offsetLeft;
                    scrollLeft = slider.scrollLeft;
                    userInteracting[index] = true;
                    if (autoScrollIntervals[index]) {
                        clearInterval(autoScrollIntervals[index]);
                    }
                });
                slider.addEventListener('touchmove', (e) => {
                    if (!startX) return;
                    e.preventDefault();
                    const x = e.touches[0].pageX - slider.offsetLeft;
                    const walk = (x - startX) * 2;
                    slider.scrollLeft = scrollLeft - walk;
                });
                slider.addEventListener('touchend', () => {
                    startX = 0;
                    setTimeout(() => {
                        userInteracting[index] = false;
                        startAutoScroll(slider, index);
                    }, 3000);
                });
                slider.addEventListener('mouseenter', () => {
                    userInteracting[index] = true;
                    if (autoScrollIntervals[index]) {
                        clearInterval(autoScrollIntervals[index]);
                    }
                });
                slider.addEventListener('mouseleave', () => {
                    setTimeout(() => {
                        userInteracting[index] = false;
                        startAutoScroll(slider, index);
                    }, 1000);
                });
            });
        }

        function startAutoScroll(slider, index) {
            if (autoScrollIntervals[index]) {
                clearInterval(autoScrollIntervals[index]);
            }
            autoScrollIntervals[index] = setInterval(() => {
                if (userInteracting[index]) return;
                const scrollAmount = 280;
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                if (slider.scrollLeft >= maxScroll - 10) {
                    slider.scrollTo({
                        left: 0,
                        behavior: 'smooth'
                    });
                } else {
                    slider.scrollTo({
                        left: slider.scrollLeft + scrollAmount,
                        behavior: 'smooth'
                    });
                }
            }, 4000 + (index * 500));
        }

        function autoScrollSliders() {
            const sliders = document.querySelectorAll('.slider');
            sliders.forEach((slider, index) => {
                userInteracting[index] = false;
                startAutoScroll(slider, index);
            });
        }

        function addScrollIndicators() {
            const sliders = document.querySelectorAll('.slider-container');
            sliders.forEach((container, containerIndex) => {
                const slider = container.querySelector('.slider');
                if (!slider) return;
                const cards = slider.querySelectorAll('.place-card, .chef-card, .recipe-card');
                if (cards.length === 0) return;
                const indicatorContainer = document.createElement('div');
                indicatorContainer.className = 'scroll-indicators';
                indicatorContainer.style.cssText = `
                display: flex;
                justify-content: center;
                gap: 8px;
                margin-top: 15px;
            `;
                const containerWidth = slider.offsetWidth || slider.parentElement.offsetWidth;
                const cardWidth = 280;
                const visibleCards = Math.max(1, Math.floor(containerWidth / cardWidth));
                const indicatorCount = Math.max(1, Math.ceil(cards.length / visibleCards));
                for (let i = 0; i < indicatorCount; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'scroll-dot';
                    dot.style.cssText = `
                    width: 8px;
                    height: 8px;
                    border-radius: 50%;
                    background: rgba(255, 181, 49, 0.3);
                    cursor: pointer;
                    transition: all 0.3s ease;
                `;
                    if (i === 0) {
                        dot.style.background = 'maroon';
                        dot.style.transform = 'scale(1.2)';
                    }
                    dot.addEventListener('click', () => {
                        const scrollPosition = i * cardWidth * visibleCards;
                        slider.scrollTo({
                            left: scrollPosition,
                            behavior: 'smooth'
                        });
                        updateIndicators(indicatorContainer, i);
                        userInteracting[containerIndex] = true;
                        setTimeout(() => {
                            userInteracting[containerIndex] = false;
                        }, 5000);
                    });
                    indicatorContainer.appendChild(dot);
                }
                const existingIndicators = container.querySelector('.scroll-indicators');
                if (existingIndicators) {
                    existingIndicators.remove();
                }
                container.appendChild(indicatorContainer);
                let scrollTimeout;
                slider.addEventListener('scroll', () => {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => {
                        const currentIndex = Math.round(slider.scrollLeft / (cardWidth *
                            visibleCards));
                        updateIndicators(indicatorContainer, Math.min(currentIndex, indicatorCount -
                            1));
                    }, 100);
                });
            });
        }

        function updateIndicators(container, activeIndex) {
            const dots = container.querySelectorAll('.scroll-dot');
            dots.forEach((dot, index) => {
                if (index === activeIndex) {
                    dot.style.background = 'maroon';
                    dot.style.transform = 'scale(1.2)';
                } else {
                    dot.style.background = 'rgba(255, 181, 49, 0.3)';
                    dot.style.transform = 'scale(1)';
                }
            });
        }

        function cleanup() {
            autoScrollIntervals.forEach(interval => {
                if (interval) clearInterval(interval);
            });
            autoScrollIntervals = [];
        }
        document.addEventListener('DOMContentLoaded', () => {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }

            function init() {
                setTimeout(() => {
                    initializeTouchSupport();
                    addScrollIndicators();
                    setTimeout(autoScrollSliders, 2000);
                }, 300);
            }
        });
        window.addEventListener('beforeunload', cleanup);
        window.addEventListener('pagehide', cleanup);
</script>
@endsection