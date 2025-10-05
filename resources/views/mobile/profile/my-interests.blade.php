@extends('layouts.mobile')

@section('title', 'المفضلة | My Interests')

{{-- Ensure these CSS files are correctly linked --}}
<link rel="stylesheet" href="{{ asset('assets/assets/css/my-places.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<x-china-header :title="__('messages.favorites')" :route="route('mobile.profile.profile')" />
    <div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">
        {{-- <div class="header-container">
            <img src="{{ asset('assets/assets/images/header-bg.png') }}" alt="">
            <a href="{{ route('mobile.profile.profile') }}" class="profile-link dark:bg-color10">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
            <div class="logo-register">{{ __('messages.favorites') }}</div>
        </div> --}}

        <div style="margin-top: 90px;">
            @forelse($favoritePlaces as $place)
                <div class="container---features">
                    <div style="width: 100%; height: 183px;">
                        <div class="">
                            <div style="border-radius: 20%; width: 43px; gap: 3px;" class="heart-icon favorited"
                                data-place-id="{{ $place->id }}">
                                <i class="fa-solid fa-heart" style="font-size: 20px; color: red;"></i>
                                <span class="like-count-span">{{ $place->favorites()->count() ?? 0 }}</span>
                            </div>
                        </div>

                        <img style="width: 100%; border-top-right-radius: 12px; border-top-left-radius: 12px; height: 213px;"
                            src="{{ asset('storage/' . $place->avatar) }}"
                            alt="{{ $place->{'name_' . App::getLocale()} ?? __('messages.place_name') }}">
                        <p
                            style="text-align: center; padding: 9px 0px; font-size: 15px; position: relative; top: -110px; background-color: rgba(255, 255, 255, 0.5);">
                            {{ $place->{'name_' . App::getLocale()} ?? __('messages.place_name') }}
                        </p>
                    </div>

                    <div class="container--features"
                        style="margin-top: 10px; direction: {{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                        <div>
                            <img src="{{ asset('storage/' . $place->region?->avatar) }}" alt="">
                            <p>{{ $place->region?->{'name_' . App::getLocale()} ?? __('messages.region') }}</p>
                        </div>
                        <div>
                            <img src="{{ asset('storage/' . $place->mainCategory?->avatar) }}" alt="">
                            <p>{{ $place->mainCategory?->{'name_' . App::getLocale()} ?? __('messages.main_category') }}
                            </p>
                        </div>
                        <div>
                            <img src="{{ asset('storage/' . $place->subCategory?->avatar) }}" alt="">
                            <p>{{ $place->subCategory?->{'name_' . App::getLocale()} ?? __('messages.sub_category') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-message-container" style="text-align: center; width: 100%; padding: 20px;">
                    <p style="color: #6c757d; font-size: 18px;">{{ __('messages.no_favorite_places') }}</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('.heart-icon').forEach(icon => {
                icon.addEventListener('click', function() {
                    const placeId = this.getAttribute('data-place-id');
                    const heartSvg = this.querySelector('i');
                    const likeCountSpan = this.querySelector('.like-count-span');

                    fetch('{{ route('favorites.toggle') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                place_id: placeId
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.status === 'added') {
                                heartSvg.classList.remove('fa-regular');
                                heartSvg.classList.add('fa-solid');
                                if (likeCountSpan) {
                                    likeCountSpan.textContent = parseInt(likeCountSpan
                                        .textContent) + 1;
                                }
                            } else if (data.status === 'removed') {
                                heartSvg.classList.remove('fa-solid');
                                heartSvg.classList.add('fa-regular');
                                if (likeCountSpan) {
                                    likeCountSpan.textContent = parseInt(likeCountSpan
                                        .textContent) - 1;
                                }

                                // Optionally remove the whole card from the DOM
                                const card = this.closest('.container---features');
                                if (card) {
                                    card.remove();
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred. Please log in or try again later.');
                        });
                });
            });
        });
    </script>

@endsection
