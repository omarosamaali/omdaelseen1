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
<x-china-header
    :title="app()->getLocale() == 'en' ? $explorer->name_en : (app()->getLocale() == 'zh' ? $explorer->name_ch : $explorer->name_ar)"
    :route="route('mobile.china-discovers.all-places')" />
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">
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
                {{ app()->getLocale() == 'en' ? $branch->name_en : (app()->getLocale() == 'zh' ? $branch->name_ch :
                $branch->name_ar) }}
            </p>
        </a>
        @endforeach
    </div>
</div>
@endsection