@extends('layouts.mobile')

@section('title', 'المفضلة | My Interests')

{{-- Ensure these CSS files are correctly linked --}}
<link rel="stylesheet" href="{{ asset('assets/assets/css/my-places.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<x-china-header :title="__('messages.interests')" :route="route('mobile.profile.profile')" />
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">

    <div style="margin-top: 90px;">
        @forelse($favoritePlaces as $place)
        <a href="{{ route('mobile.china-discovers.info_place', $place) }}" class="container---features">
            <div style="width: 100%; height: 183px;">
                <div class="">
                    <div style="border-radius: 20%; width: 43px; gap: 3px; cursor: normal;" class="heart-icon"
                        >
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
                style="margin-top: 24px; direction: {{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
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
        </a>
        @empty
        <x-empty />
        @endforelse
    </div>
</div>

@endsection