@extends('layouts.mobile')

@section('title', 'أماكني | My places')
<link rel="stylesheet" href="{{ asset('assets/assets/css/my-places.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">

@section('content')
    <div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">

        <div class="header-container">
            <img src="{{ asset('assets/assets/images/header-bg.png') }}" alt="">
            <a href="{{ route('mobile.profile.profile') }}" class="profile-link dark:bg-color10">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
            <div class="logo-register">{{ __('messages.app_name') }}</div>
        </div>

        <div style="margin-top: 90px;">
            @foreach ($myPlaces as $place)
                <div class="container---features">
                    <div style="width: 100%; height: 183px;">
                        @if ($place->status == 'inactive' || $place->status == 'banned')
                            <div class="bg-opacity">
                                <span>{{ __('messages.violating_place') }}</span>
                            </div>
                        @endif
                        {{-- الإعجابات --}}
                        <div class="container-like">
                            <i class="fa-solid fa-heart" style="font-size: 20px; color: red;"></i>
                            {{ $place->likes ?? 0 }}
                        </div>

                        {{-- التعليقات --}}
                        <div class="container-comments">
                            <i class="fa-solid fa-message" style="font-size: 20px; color: green;"></i>
                            {{ $place->comments_count ?? 0 }}
                        </div>

                        {{-- التقييم --}}
                        <div class="container-rate">
                            <i class="fa-solid fa-star" style="font-size: 20px; color: orange;"></i>
                            {{ $place->rating ?? 0 }}
                        </div>

                        {{-- صورة المكان --}}
                        <img style="width: 100%; border-top-right-radius: 12px; border-top-left-radius: 12px; height: 213px;"
                            src="{{ asset('storage/' . $place->avatar) }}" alt="">

                        {{-- اسم المكان متعدد اللغات --}}
                        <p
                            style="text-align: center; padding: 9px 0px; font-size: 15px; position: relative; top: -110px; background-color: rgba(255, 255, 255, 0.5);">
                            {{ $place->{'title_' . app()->getLocale()} ?? ($place->title_ar ?? __('messages.default_place_title')) }}
                        </p>
                    </div>

                    {{-- خصائص المكان (المنطقة، التصنيف الرئيسي، التصنيف الفرعي) --}}
                    <div class="container--features" style="margin-top: 10px; direction: rtl;">
                        <div>
                            <img src="{{ asset('storage/' . $place->region->avatar) }}" alt="">
                            <p>{{ $place->region->{'name_' . app()->getLocale()} ?? ($place->region->name_ar ?? __('messages.default_region')) }}
                            </p>
                        </div>
                        <div>
                            <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}" alt="">
                            <p>{{ $place->mainCategory->{'name_' . app()->getLocale()} ?? ($place->mainCategory->name_ar ?? __('messages.default_main')) }}
                            </p>
                        </div>
                        <div>
                            <img src="{{ asset('storage/' . $place->subCategory->avatar) }}" alt="">
                            <p>{{ $place->subCategory->{'name_' . app()->getLocale()} ?? ($place->subCategory->name_ar ?? __('messages.default_sub')) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
