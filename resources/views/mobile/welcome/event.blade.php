@extends('layouts.mobile')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('title', 'عمدة الصين | China Omda')
@section('content')
<style>
    body {
        position: relative !important;
    }

    .tab-button .item.active {
        background-color: #000;
        color: #fff;
        padding: 8px 16px;
        border-radius: 9999px;
    }

    .quiz-link {
        box-shadow: 0px 1px 2px 0px rgb(58 58 58 / 62%), 0px 1px 3px 0px rgb(58 58 58 / 36%);
    }

    .fly-img {
        text-align: center;
        margin: auto;
        width: 100%;
        margin-top: 30px;
        border-radius: 15px;
    }

    .active {
        background-color: black;
        color: white;
    }

    .countdown-display {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 19px;
    }

    #container-type {
        background: darkorange;
        color: #000000;
        position: absolute;
        z-index: 9;
        left: -34px;
        padding: 15px;
        rotate: -43deg;
        top: -7px;
        font-size: 12px;
        width: 106px;
        text-align: center;
    }

    #container-type span {position: relative;
    top: 8px;}
</style>

<body class="relative -z-20">
    <x-china-header :title="__('messages.exhibitions_events')" :route="route('mobile.welcome')" />
    <div class="container min-h-dvh relative overflow-hidden py-8 dark:text-white -z-10 dark:bg-color1">
        <div class="relative z-10 px-6">

            <div class="p-4 px-6" style="margin-top: 20px;">
                <div class="flex justify-between items-center">
                    <button style="max-width: 200px; margin: auto;"
                        class="filter-btn flex items-center justify-center w-full text-black text-md py-2 px-4 rounded-full dark:bg-p1 active"
                        data-filter="all">
                        {{ __('messages.all') }}
                    </button>
                    <button style="max-width: 200px; margin: auto;"
                        class="filter-btn flex items-center justify-center w-full text-black text-md py-2 px-4 rounded-full dark:bg-p1"
                        data-filter="معرض">
                        {{ __('messages.المعارض') }}
                    </button>
                    <button style="max-width: 200px; margin: auto;"
                        class="filter-btn flex items-center justify-center w-full text-black text-md py-2 px-4 rounded-full dark:bg-p1"
                        data-filter="مناسبة">
                        {{ __('messages.المناسبات') }}
                    </button>
                </div>
                <div class="pt-5">
                    <div id="events-container">
                        @if ($events->isNotEmpty())
                        @foreach ($events as $event)
                        <div class="flex flex-col gap-4 event-card" style="margin-bottom: 29px;
    overflow: hidden;
    position: relative;
    box-shadow: 0px 1px 2px 0px rgb(58 58 58 / 62%), 0px 1px 3px 0px rgb(58 58 58 / 36%);
    border-radius: 15px;"
                            data-event-type="{{ $event->type }}" style="margin-bottom: 10px;">
                            <div class="rounded-2xl overflow-hidden quiz-link">
                                <div class="p-2 bg-white dark:bg-color10">
                                    <div id="container-type">
                                        <span>{{ $event->type }}</span>
                                    </div>
                                    <div style="position: relative; top: -30px;"
                                        class="border-b border-dashed border-black dark:border-color24 border-opacity-10 flex justify-between items-center">
                                        <img src="{{ asset('storage/' . $event->avatar) }}" class="fly-img" alt="">
                                    </div>

                                    <div style="position: relative; top: -18px;"
                                        class="text-center pb-4 border-b border-dashed border-black dark:border-color24 border-opacity-10">
                                        <p class="font-semibold text-sm">
                                            {!! app()->getLocale() == 'en'
                                            ? $event->title_en
                                            : (app()->getLocale() == 'zh'
                                            ? $event->title_zh
                                            : $event->title_ar) !!}
                                        </p>
                                        <p class="text-xs pt-2">
                                            {!! app()->getLocale() == 'en'
                                            ? $event->description_en
                                            : (app()->getLocale() == 'zh'
                                            ? $event->description_zh
                                            : $event->description_ar) !!}
                                        </p>
                                    </div>

                                    <div
                                        style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px;">
                                        <div style="font-size: 14px;">
                                            <i class="fa-solid fa-calendar-days"></i> {{ $event->start_date }}
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-arrow-left-long"></i>
                                        </div>
                                        <div style="font-size: 14px;">
                                            <i class="fa-solid fa-calendar-days"></i> {{ $event->end_date }}
                                        </div>
                                    </div>
                                    <?php
                                                    if($event->start_date > now()) {
                                                        $background = 'background: brown;';
                                                    } else {
                                                        $background = 'background: darkolivegreen;';
                                                    }
                                                ?>
                                    <div style="{{ $background }} position: relative; top: -4px; color: white; padding: 10px 0px; border-radius: 15px;"
                                        class="flex justify-between items-center flex-col">
                                        @if($event->start_date > now())
                                        <p>باقي للبدء</p>
                                        <div class="countdown-display" data-end-date="{{ $event->start_date }}">
                                        </div>
                                        @elseif($event->start_date < now()) <p>باقي للإنتهاء</p>
                                            <div class="countdown-display" data-end-date="{{ $event->end_date }}">
                                            </div>
                                            @else
                                            <p>حدث منتهي</p>
                                            @endif
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

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                        const filterButtons = document.querySelectorAll('.filter-btn');
                        const eventCards = document.querySelectorAll('.event-card');
                        const eventsContainer = document.querySelector('#events-container');
                        const emptyContainer = document.querySelector('#empty-container');

                        filterButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                // Remove 'active' class from all buttons and add to the clicked one
                                filterButtons.forEach(btn => btn.classList.remove('active'));
                                this.classList.add('active');

                                const filterValue = this.getAttribute('data-filter');
                                let visibleEvents = 0;

                                // Filter event cards
                                eventCards.forEach(card => {
                                    const eventType = card.getAttribute('data-event-type');
                                    if (filterValue === 'all' || eventType === filterValue) {
                                        card.style.display = 'block';
                                        visibleEvents++;
                                    } else {
                                        card.style.display = 'none';
                                    }
                                });

                                // Show or hide the empty container based on visible events
                                if (visibleEvents === 0) {
                                    emptyContainer.style.display = 'block';
                                } else {
                                    emptyContainer.style.display = 'none';
                                }
                            });
                        });

                        // Check if no events exist initially
                        if (eventCards.length === 0) {
                            emptyContainer.style.display = 'block';
                        }
                    });
                    // This function updates the countdown timer for a single element
                    function updateCountdown(element) {
                        const endDateString = element.getAttribute('data-end-date');
                        const endDate = new Date(endDateString);
                        const now = new Date();
                        const timeDifference = endDate.getTime() - now.getTime();

                        if (timeDifference < 0) {
                            element.textContent = 'انتهى!';
                            return;
                        }
                        const days = Math.floor(timeDifference / (1000 * 60 *
                            60 * 24));
                        const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const
                            minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeDifference %
                            (1000 * 60)) / 1000);
                        element.innerHTML = ` <div style="text-align: center;">
        <p class="font-bold text-md">${days}</p>
        <p class="text-xs">يوم</p>
        </div>
        <div style="text-align: center;">
            <p class="font-bold text-md">${hours}</p>
            <p class="text-xs">ساعة</p>
        </div>
        <div style="text-align: center;">
            <p class="font-bold text-md">${minutes}</p>
            <p class="text-xs">دقيقة</p>
        </div>
        <div style="text-align: center;">
            <p class="font-bold text-md">${seconds}</p>
            <p class="text-xs">ثانية</p>
        </div>
        `;
                    }

                    // Update all countdowns on the page
                    document.addEventListener('DOMContentLoaded', () => {
                        const countdowns = document.querySelectorAll('.countdown-display');
                        countdowns.forEach(countdown => {
                            // Run the update immediately, then every second
                            updateCountdown(countdown);
                            setInterval(() => updateCountdown(countdown), 1000);
                        });
                    });
            </script>
        </div>
    </div>

</body>
@endsection