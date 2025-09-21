@extends('layouts.mobile')

@section('title', 'عمدة الصين | China Omda')

@section('content')
<style>
    body {
        position: relative !important;
        background: #f3f3f3 !important;
    }

    .quiz-link {
        box-shadow: 0px 1px 15px 0px rgb(91 82 82 / 63%);
    }

    .fly-img {
        text-align: center;
        margin: auto;
        width: 142px;
        position: relative;
        top: 15px;
        right: 0px;
    }

    .empty-img {
        width: 269px;
        border-radius: 8px;
    }

    .container-empty {
        align-items: center;
        justify-content: center;
        display: flex;
        flex-direction: column;
        text-align: center;
    }
</style>

<x-china-header :title="__('messages.الرحلات التجارية والسياحية')" :route="route('mobile.welcome')" />

<div class="container min-h-dvh relative overflow-hidden py-8 dark:text-white -z-10 dark:bg-color1">
    <div class="relative z-10 px-6">
        <div class="faqCategory pt-8">
            <ul class="flex flex-wrap justify-center items-center tab-button gap-4" style="margin: auto;">
                <li class="item cursor-pointer" data-filter="group">{{ __('messages.جماعية') }}</li>
                <li class="item cursor-pointer" data-filter="family">{{ __('messages.عائلية') }}</li>
                <li class="item cursor-pointer" data-filter="traders_only">{{ __('messages.للتجار') }}</li>
            </ul>
            <ul class="pt-4 flex flex-wrap justify-center items-center tab-button gap-4" style="margin: auto;">
                <li class="item cursor-pointer" data-filter="tourism_only">{{ __('messages.للسياحة') }}</li>
                <li class="item cursor-pointer" data-filter="trade_and_tourism">
                    {{ __('messages.للتجارة والسياحة') }}</li>
            </ul>
        </div>

        <div class="pt-10 px-2">
            <div class="pt-5">
                <div id="trips-container">
                    @if ($trips->isNotEmpty())
                    @foreach ($trips as $trip)
                    <div class="flex flex-col gap-4 trip-card" data-trip-type="{{ $trip->trip_type }}"
                        style="margin-bottom: 20px;">
                        <div class="rounded-2xl overflow-hidden quiz-link">
                            <div class="p-5 bg-white dark:bg-color10">
                                <div
                                    class="text-center pb-4 border-b border-dashed border-black dark:border-color24 border-opacity-10">
                                    <p class="font-semibold text-sm">
                                        {{ app()->getLocale() == 'en'
                                        ? $trip->title_en
                                        : (app()->getLocale() == 'zh'
                                        ? $trip->title_zh
                                        : $trip->title_ar) }}
                                    </p>
                                    <p class="text-xs pt-2">
                                        {{ $trip->translated_trip_type }}
                                    </p>
                                </div>
                                <img src="{{ asset('assets/assets/images/fly.png') }}" class="fly-img" alt="">
                                <div style="position: relative; top: -30px;"
                                    class="border-b border-dashed border-black dark:border-color24 border-opacity-10 flex justify-between items-center">
                                    <div class="flex justify-start items-center gap-2">
                                        <div class="text-center">
                                            <span class="text-xs">
                                                {{ \Carbon\Carbon::parse($trip->departure_date)->translatedFormat('l')
                                                }}
                                            </span>
                                            <div style="background-color: white;" class="py-1 px-2 bg-p2 rounded-lg">
                                                <p class="font-semibold text-lg font-bold">
                                                    {{ $trip->departure_date->format('d/m') }}</p>
                                                <p class="text-[19px] font-bold">
                                                    {{ $trip->departure_date->format('Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-start items-center gap-2">
                                        <div class="text-center">
                                            <span class="text-xs">{{
                                                \Carbon\Carbon::parse($trip->return_date)->translatedFormat('l')
                                                }}</span>
                                            <div style="background-color: white;" class="py-1 px-2 bg-p2 rounded-lg">
                                                <p class="font-semibold text-lg font-bold">
                                                    {{ $trip->return_date->format('d/m') }}</p>
                                                <p class="text-[19px] font-bold">
                                                    {{ $trip->return_date->format('Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="position: relative; top: -20px;"
                                    class="border-b border-dashed border-black pb-3 dark:border-color24 border-opacity-10 flex justify-between items-center text-xs">
                                    <div class="flex justify-start items-center gap-2">
                                        <div>
                                            <p style="display: flex; align-items: center;" class="font-semibold">
                                                {{ $trip->price }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z"
                                                        stroke="#000" stroke-width="1.5" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                    <path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex justify-start items-center gap-2">
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <p class="font-semibold">
                                                @if ($trip->tickets_included == 0)
                                                {{ __('messages.غير شامل تذاكر السفر') }}
                                                @else
                                                {{ __('messages.شامل تذاكر السفر') }}
                                                @endif
                                            <div style="width: fit-content; margin: auto;"
                                                class="text-white flex justify-center items-center p-2 rounded-full">
                                                <i class="fa-solid fa-plane" style="color: black;"></i>
                                            </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    @auth
                                    <a href="{{ route('mobile.trip-show', $trip->id) }}"
                                        class="w-full text-white text-md bg-p2 py-2 px-4 rounded-full dark:bg-p1 text-center">
                                        التفاصيل
                                    </a>
                                    @else
                                    <a href="{{ route('mobile.auth.login', $trip->id) }}"
                                        class="w-full text-white text-md bg-p2 py-2 px-4 rounded-full dark:bg-p1 text-center">
                                        التفاصيل
                                    </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <x-empty />
                    @endif
                </div>
                <div id="empty-container" style="display: none;">
                    <x-empty />
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterItems = document.querySelectorAll('.item');
            const tripCards = document.querySelectorAll('.trip-card');
            const tripsContainer = document.querySelector('#trips-container');
            const emptyContainer = document.querySelector('#empty-container');

            filterItems.forEach(item => {
                item.addEventListener('click', function() {
                    filterItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                    const filterValue = this.getAttribute('data-filter');
                    let visibleTrips = 0;

                    tripCards.forEach(card => {
                        const tripType = card.getAttribute('data-trip-type');
                        if (filterValue === 'all' || tripType === filterValue) {
                            card.style.display = 'block';
                            visibleTrips++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Show or hide the empty container based on visible trips
                    if (visibleTrips === 0) {
                        emptyContainer.style.display = 'block';
                    } else {
                        emptyContainer.style.display = 'none';
                    }
                });
            });

            // Check if no trips exist initially
            if (tripCards.length === 0) {
                emptyContainer.style.display = 'block';
            }
        });
    </script>@endsection