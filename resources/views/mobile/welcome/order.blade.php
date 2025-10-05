@extends('layouts.mobile')

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
    </style>

    <body class="relative -z-20">
        <x-china-header :title="__('messages.special_request')" :route="route('mobile.welcome')" />

        <div style="padding-top: 90px;"  class="container min-h-dvh relative overflow-hidden py-8 dark:text-white -z-10 dark:bg-color1">
                <div class="faqCategory pt-2">
                    <p class="text-center px-2">{{ __('messages.زر طلب خاص') }}</p>
                </div>

                <div class="p-4 px-6">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('mobile.order.create') }}" style="max-width: 200px; margin: auto;"
                            class="flex items-center justify-center w-full text-white text-md bg-p1 py-2 px-4 rounded-full dark:bg-p1">
                            {{ __('messages.special_request') }}
                        </a>
                    </div>
                    <div class="pt-5">
                        @foreach ($orders as $order)
                            <div class="flex flex-col gap-4" style="margin-bottom: 10px;">
                                <div class="rounded-2xl overflow-hidden quiz-link">
                                    <div class="p-2 bg-white dark:bg-color10">
                                        <div style="position: relative; top: -30px;"
                                            class="border-b border-dashed border-black dark:border-color24 border-opacity-10 flex justify-between items-center">
                                            <img src="{{ asset('storage/' . $order->image) }}" class="fly-img"
                                                alt="">
                                        </div>

                                        <div style="position: relative; top: -18px;"
                                            class="text-center pb-4 border-b border-dashed border-black dark:border-color24 border-opacity-10 ">
                                            <p class="font-semibold text-sm">
                                                {!! app()->getLocale() == 'en'
                                                    ? $order->type_en
                                                    : (app()->getLocale() == 'zh'
                                                        ? $order->type_zh
                                                        : $order->type_ar) !!}
                                            </p>
                                            <p class="text-xs pt-2"> {!! app()->getLocale() == 'en'
                                                ? $order->details_en
                                                : (app()->getLocale() == 'zh'
                                                    ? $order->details_zh
                                                    : $order->details_ar) !!}</p>
                                        </div>

                                        <div style="position: relative; top: -4px;"
                                            class="flex justify-between items-center">
                                            <button
                                                class="flex items-center justify-center w-full text-white text-md bg-p2 py-2 px-4 rounded-full dark:bg-p1">
                                                {{ __('messages.value') }} {{ $order->price }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z"
                                                        stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                    <path d="M6.5 11H18.5" stroke="#ffffff" stroke-width="1.5"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                    </path>
                                                    <path d="M6.5 13H12.5H18.5" stroke="#ffffff" stroke-width="1.5"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </body>
@endsection
