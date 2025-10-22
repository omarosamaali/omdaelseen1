@extends('layouts.mobile')

@section('title', 'جميع التصنيفات | All Categories')
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

    .container--features {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0px 15px;
        margin-top: 20px;
        margin: 0;
    }

    .container--features div {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .container--features div img {
        width: 60px;
        height: 60px;
        margin-left: 5px;
    }

    .img-places {
        margin: auto;
        width: 95%;
        margin-top: 74px;
        height: 166px;
    }

    .image-logo {
        margin-top: 10px !important;
        width: 150px;
        text-align: center;
        display: flex;
        justify-content: center;
        margin: auto;
    }

    .search--icon {
        left: 19px;
        top: 27px;
    }

    .continaer--title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px;
    }

    .show--all {
        font-size: 14px;
        color: gray;
    }

    .categories {
        font-weight: bold;
        font-size: 18px;
        color: white;
    }

    /* Slider Styles */
    .slider-container {
        margin: 20px 10px;
        overflow: hidden;
    }

    .slider {
        display: flex;
        gap: 15px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 10px 5px;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .slider::-webkit-scrollbar {
        display: none;
    }

    .place-card {
        min-width: 200px;
        height: 250px;
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .place-card:hover {
        transform: translateY(-5px);
    }

    .place-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .heart-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .heart-icon:hover {
        background: rgba(255, 181, 49, 0.9);
        transform: scale(1.1);
    }

    .heart-icon.liked {
        background: rgba(255, 181, 49, 0.9);
        color: #ff6b6b;
    }

    .category-tag {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255, 181, 49, 0.95);
        padding: 5px 8px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: bold;
        color: white;
    }

    .category-tag img {
        width: 16px;
        height: 16px;
        object-fit: cover;
        border-radius: 3px;
    }

    .place-name {
        position: absolute;
        bottom: 50px;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
        padding: 20px 15px 10px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
    }

    .explore-btn {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: maroon;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(255, 181, 49, 0.3);
    }

    .explore-btn:hover {
        background: #ffa500;
        transform: translateX(-50%) translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 181, 49, 0.4);
    }

    /* Popular Places Styling */
    .popular-card {
        border: 2px solid maroon;
        box-shadow: 0 6px 20px rgba(255, 181, 49, 0.2);
    }

    .popular-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(255, 181, 49, 0.3);
    }

    .popular-tag {
        background: linear-gradient(45deg, maroon, #ffa500);
        color: white;
        font-weight: bold;
    }

    .popular-btn {
        background: linear-gradient(45deg, maroon, #ffa500);
        color: white;
        font-weight: bold;
    }

    .popular-btn:hover {
        background: linear-gradient(45deg, #ffa500, #ff8c00);
        transform: translateX(-50%) translateY(-3px);
        box-shadow: 0 6px 15px rgba(255, 181, 49, 0.5);
    }

    /* Latest Places Styling */
    .latest-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 181, 49, 0.05));
        backdrop-filter: blur(10px);
    }

    .latest-card .category-tag {
        background: rgba(74, 45, 11, 0.9);
        color: maroon;
    }

    .latest-card .explore-btn {
        background: white;
        color: maroon;
        border: 1px solid maroon;
    }

    .latest-card .explore-btn:hover {
        background: maroon;
        color: white;
        transform: translateX(-50%) translateY(-2px);
    }

    /* Slider Navigation Arrows */
    .slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 181, 49, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .slider-nav:hover {
        background: #ffa500;
        transform: translateY(-50%) scale(1.1);
    }

    .slider-nav.prev {
        left: -20px;
    }

    .slider-nav.next {
        right: -20px;
    }

    .slider-container {
        position: relative;
    }

    /* Loading Animation */
    .place-card {
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }

    .place-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .place-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .place-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .place-card:nth-child(4) {
        animation-delay: 0.4s;
    }

    .place-card:nth-child(5) {
        animation-delay: 0.5s;
    }

    .place-card:nth-child(6) {
        animation-delay: 0.6s;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

@section('content')
<x-china-header
    :title="__('messages.new_places')"
    :route="route('mobile.china-discovers.all--places')" />
<div class="container min-h-dvh relative pb-8 dark:text-white dark:bg-black" style="overflow-y: auto !important; padding-top: 30px;">
    <div style="width: 100%; display: block;">
        @if ($banners->isNotEmpty())
        @foreach ($banners as $banner)
        <img class="fav-image" style="width: 100%; padding-top: 31px;" src="{{ asset('storage/' . $banner->avatar) }}" alt="">
        @endforeach
        @endif
    </div>
    <div style="display: grid; grid-template-columns: repeat(1, 1fr); gap: 10px; margin: 0px 10px; height: 221px; justify-content: center;">
        @foreach ($places as $place)
        <a href="{{ route('mobile.china-discovers.info_place', $place) }}" style="width: 100%; position: relative;">
            <img style="width: 100%; border-radius: 15px; border: 2px solid maroon; height: 200px;"
                src="{{ asset('storage/' . $place->avatar) }}"
                alt="{{ app()->getLocale() == 'en' ? $place->name_en : (app()->getLocale() == 'zh' ? $place->name_ch : $place->name_ar) }}">
                <div class="rating-icon"
                            style="left: 6%; bottom: 208px; top: unset; position: absolute; color: #f9a50f; display: flex; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-star" style="font-size: 18px;"></i>
                            <span style="font-size: 14px; font-weight: bold; color: #fff;">
                                {{ number_format($place->ratings_avg_rating ?? 0, 1) }} ({{ $place->ratings_count ?? 0 }})
                            </span>
                        </div>
                        @php
                        $isFavorited = auth()->check() && auth()->user()->isFavorite($place);
                        @endphp
                        @if (auth()->check() && auth()->id() != $place->user_id)
                        <div style="bottom: 193px; top: unset;" class="heart-icon @if ($isFavorited) favorited @endif"
                            data-place-id="{{ $place->id }}">
                            <i class="fa @if ($isFavorited) fa-solid fa-heart @else fa-regular fa-heart @endif" style="font-size: 18px;"></i>
                        </div>
                        @endif
            <p
                style="text-align: center; padding: 9px 0px; font-size: 15px; position: relative; top: -60px; background-color: rgba(255, 255, 255, 0.5);">
                {{ app()->getLocale() == 'en' ? $place->name_en : (app()->getLocale() == 'zh' ? $place->name_ch :
                $place->name_ar) }}
            </p>
        </a>
        @endforeach
    </div>
</div>
@endsection