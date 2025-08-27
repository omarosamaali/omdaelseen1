@extends('layouts.mobile')

@section('title', 'جميع التصنيفات | All Categories')
<link rel="stylesheet" href="{{ asset('assets/assets/css/all-places.css') }}">

@section('content')
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black" style="padding-top: 30px;">

    <div class="header-container flex justify-start items-center relative z-10">
        <a href="{{ route('mobile.china-discovers.index') }}" class="profile-link bg-white p-2 rounded-full flex justify-center items-center text-xl dark:bg-color10">
            <i class="ph ph-caret-left"></i>
        </a>
        <div class="logo-register">
            جميع التصنيفات
        </div>
    </div>

    <div style="width: 100%; display: block;">
        @if ($banners->isNotEmpty())
        @foreach ($banners as $banner)
        <img class="fav-image" src="{{ asset('storage/' . $banner->avatar) }}" alt="">
        @endforeach
        @endif
    </div>

    <div style="display: flex; align-items: center; justify-content: flex-start; gap: 10px; margin: 10px;">
        <a href="{{ route('all.places') }}" style="flex-shrink: 0; text-decoration: none; color: inherit; text-align: center;">
            <div style="width: 99px; flex-shrink: 0;">
                <img style="width: 70%; text-align: center; margin: auto; max-height: 73px;" src="{{ asset('assets/assets/images/logo.png') }}" alt="الجميع">
                <p style="padding-top: 9px; font-size: 15px;">الجميع</p>
            </div>
        </a>

        <div class="slider-container" style="display: flex; overflow-x: auto; scroll-snap-type: x mandatory; gap: 10px; padding: 10px; scrollbar-width: none; -ms-overflow-style: none;">
            @foreach ($regions as $region)
            <a href="{{ route('all.places', ['region_id' => $region->id]) }}" style="flex-shrink: 0; text-decoration: none; color: inherit; text-align: center; scroll-snap-align: start;">
                <div style="width: 99px; flex-shrink: 0;">
                    <img style="width: 100%; border-radius: 15px;" src="{{ asset('storage/' . $region->avatar) }}" alt="{{ $region->name_ar }}">
                    <p style="padding-top: 9px; font-size: 15px;">{{ $region->name_ar }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="category-section">
        @foreach ($explorers as $explorer)
        <div class="category-card">
            <img class="category-card-image" src="{{ asset('storage/' . $explorer->avatar) }}" alt="">
            <p class="category-card-text">{{ $explorer->name_ar }}</p>
        </div>
        @endforeach
    </div>


</div>

@endsection
