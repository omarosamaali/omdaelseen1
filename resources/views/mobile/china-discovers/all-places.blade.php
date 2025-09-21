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

    .explorer-name {
        font-size: 15px;
        color: #333;
        transition: all 0.3s ease;
    }

    .explorer-name.active {
        font-weight: bold !important;
        color: #861530 !important;
        border-bottom: 2px solid #861530 !important;
        padding-bottom: 5px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        transition: all 0.3s ease;
    }

    .all-link .explorer-name {
        color: #f99e4d !important;
        font-size: 15px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .all-link:hover .explorer-name:not(.active) {
        color: #f99e4d !important;
        border-bottom: 2px solid #f99e4d;
        padding-bottom: 5px;
    }

    .region-link:hover .explorer-name:not(.active) {
        font-weight: bold;
        color: #861530;
        border-bottom: 2px solid #861530;
        padding-bottom: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        transition: all 0.3s ease;
    }

    .explorer-link:hover .explorer-name:not(.active) {
        font-weight: bold;
        color: #861530;
        border-bottom: 2px solid #861530;
        padding-bottom: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        transition: all 0.3s ease;
    }
</style>

@section('content')
<x-china-header :title="__('messages.all_categories')" :route="route('mobile.china-discovers.index')" />
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">
    <div style="width: 100%; display: block;">
        @if ($banners->isNotEmpty())
        @foreach ($banners as $banner)
        <img class="fav-image" src="{{ asset('storage/' . $banner->avatar) }}" alt="">
        @endforeach
        @endif
    </div>

    <div style="display: flex; align-items: center; justify-content: flex-start; gap: 10px; margin: 10px;">
        <a href="{{ route('all.places') }}" class="all-link region-link" data-region-id="0"
            style="flex-shrink: 0; text-decoration: none; color: inherit; text-align: center;">
            <div style="flex-shrink: 0;">
                <p class="explorer-name" style="font-size: 15px;">{{ __('messages.all') }}</p>
            </div>
        </a>

        <div class="slider-container"
            style="display: flex; overflow-x: auto; scroll-snap-type: x mandatory; gap: 10px; padding: 10px; scrollbar-width: none; -ms-overflow-style: none;">
            @foreach ($regions as $region)
            <a href="{{ route('all.places', ['region_id' => $region->id]) }}" class="region-link"
                data-region-id="{{ $region->id }}"
                style="flex-shrink: 0; text-decoration: none; color: inherit; text-align: center; scroll-snap-align: start;">
                <div style="flex-shrink: 0;">
                    <img style="max-width: 68px; width: 100%; border-radius: 15px;"
                        src="{{ asset('storage/' . $region->avatar) }}"
                        alt="{{ app()->getLocale() == 'en' ? $region->name_en : (app()->getLocale() == 'zh' ? $region->name_ch : $region->name_ar) }}">
                    <p class="explorer-name" style="padding-top: 9px; font-size: 15px;">
                        {{ app()->getLocale() == 'en' ? $region->name_en : (app()->getLocale() == 'zh' ?
                        $region->name_ch : $region->name_ar) }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <div class="category-section" id="category-section">
        @foreach ($explorers as $explorer)
        <a href="{{ route('all.sub-category', ['explorer_id' => $explorer->id]) }}" class="category-card explorer-link"
            data-explorer-id="{{ $explorer->id }}">
            <img style="width: 100px;" class="category-card-image" src="{{ asset('storage/' . $explorer->avatar) }}"
                alt="{{ app()->getLocale() == 'en' ? $explorer->name_en : (app()->getLocale() == 'zh' ? $explorer->name_ch : $explorer->name_ar) }}">
            <p class="category-card-text explorer-name">
                {{ app()->getLocale() == 'en' ? $explorer->name_en : (app()->getLocale() == 'zh' ? $explorer->name_ch :
                $explorer->name_ar) }}
            </p>
        </a>
        @endforeach
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
            $('.region-link').hover(
                function() {
                    // On hover in
                    var regionId = $(this).data('region-id');
                    var $link = $(this);
                    $('.explorer-name').removeClass('active'); // Remove active class from all
                    $link.find('.explorer-name').addClass('active'); // Add active class to hovered region

                    // Make AJAX request to filter explorers
                    $.ajax({
                        url: '{{ route('mobile.china-discovers.filter-explorers') }}',
                        method: 'POST',
                        data: {
                            region_id: regionId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#category-section').html(response.html);
                            } else {
                                console.error('Error:', response.message);
                            }
                        },
                        error: function(xhr) {
                            console.error('AJAX Error:', xhr.responseText);
                        }
                    });
                },
                function() {
                    // On hover out, do nothing to persist active class until next hover
                }
            );
        });
</script>
@endsection