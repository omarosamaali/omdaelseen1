@extends('layouts.mobile')

@section('title', 'جميع التصنيفات الفرعية | All Sub Categories')
<link rel="stylesheet" href="{{ asset('assets/assets/css/all-places.css') }}">
<style>
    .image-container {
        display: none !important;
    }

    .image-header {
        position: fixed;
        height: 61px;
        z-index: 9;
        object-fit: cover;
        top: 0px;
    }
</style>

@section('content')
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black" style="padding-top: 30px;">
    <img src="{{ asset('assets/assets/images/header-bg.png') }}" class="image-header" alt="">

    <div class="header-container flex justify-start items-center relative z-10" style="position: fixed; top: 8px;">
        <a href="{{ route('mobile.china-discovers.all-places') }}"
            class="profile-link bg-white p-2 rounded-full flex justify-center items-center text-xl dark:bg-color10">
            <i class="ph ph-caret-left"></i>
        </a>
        <div class="logo-register">
            {{ app()->getLocale() == 'en' ? $explorer->name_en : (app()->getLocale() == 'zh' ? $explorer->name_ch : $explorer->name_ar) }}
        </div>
    </div>

    <div style="width: 100%; display: block;">
        @if ($banners->isNotEmpty())
            @foreach ($banners as $banner)
                <img class="fav-image" src="{{ asset('storage/' . $banner->avatar) }}"
                    alt="{{ app()->getLocale() == 'en' ? $banner->name_en : (app()->getLocale() == 'zh' ? $banner->name_ch : $banner->name_ar) }}">
            @endforeach
        @endif
    </div>

    <div class="category-section">
        @foreach ($branches as $branch)
            <a href="{{ route('all-area-places', ['branch_id' => $branch->id]) }}" class="category-card">
                <img style="width: 100px;" class="category-card-image" src="{{ asset('storage/' . $branch->avatar) }}"
                    alt="{{ app()->getLocale() == 'en' ? $branch->name_en : (app()->getLocale() == 'zh' ? $branch->name_ch : $branch->name_ar) }}">
                <p class="category-card-text">
                    {{ app()->getLocale() == 'en' ? $branch->name_en : (app()->getLocale() == 'zh' ? $branch->name_ch : $branch->name_ar) }}
                </p>
            </a>
        @endforeach
    </div>
</div>
@endsection
