@extends('layouts.mobile')

@section('title', 'جميع الأماكن | All places')
<link rel="stylesheet" href="{{ asset('assets/assets/css/my-places.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">
<style>
    #container-header {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 9999;
    }
</style>
@section('content')
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">

    <x-china-header :title="__('messages.all_places')" :route="route('mobile.profile.profileAdmin')" />
    <div style="margin-top: 90px; margin-bottom: 90px;">
        @forelse ($allPlaces as $place)
        <a href="{{ route('mobile.china-discovers.info_place', $place) }}" class="container---features">
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
                    {{ $place->{'title_' . app()->getLocale()} ?? ($place->name_ar ??
                    __('messages.default_place_title')) }}
                </p>
            </div>

            {{-- خصائص المكان (المنطقة، التصنيف الرئيسي، التصنيف الفرعي) --}}
            <div class="container--features" style="margin-top: 24px; direction: rtl;">
                <div>
                    <img src="{{ asset('storage/' . $place->region->avatar) }}" alt="">
                    <p style="font-size: 12px;">{{ Str::limit($place->region->{'name_' . app()->getLocale()} ??
                        ($place->region->name_ar ??
                        __('messages.default_region')), 15) }}
                    </p>
                </div>
                <div>
                    <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}" alt="">
                    <p style="font-size: 12px;">{{ Str::limit($place->mainCategory->{'name_' . app()->getLocale()} ??
                        ($place->mainCategory->name_ar ??
                        __('messages.default_main')), 15) }}
                    </p>
                </div>
                <div>
                    <img src="{{ asset('storage/' . $place->subCategory->avatar) }}" alt="">
                    <p style="font-size: 12px;">{{ Str::limit($place->subCategory->{'name_' . app()->getLocale()} ??
                        ($place->subCategory->name_ar ??
                        __('messages.default_sub')), 15) }}
                    </p>
                </div>
            </div>
        </a>
        @empty
        <div style="text-align: center; margin-top: 100px;">
            <x-empty />
        </div>
        @endforelse
    </div>
</div>

@endsection