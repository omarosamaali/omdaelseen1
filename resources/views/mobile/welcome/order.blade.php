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

    <div class="container min-h-dvh relative overflow-hidden py-8 dark:text-white -z-10 dark:bg-color1">
        <div class="faqCategory pt-10 px-6">
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
                @if($orders->isNotEmpty())
                @foreach ($orders as $order)
                <div class="flex flex-col gap-4" style="margin-bottom: 10px;">
                    <div class="rounded-2xl overflow-hidden quiz-link">
                        <div class="p-2 bg-white dark:bg-color10">

                            <!-- الصورة -->
                            <div style="position: relative; top: -30px;"
                                class="border-b border-dashed border-black dark:border-color24 border-opacity-10 flex justify-between items-center">
                                <img src="{{ asset('storage/' . $order->image) }}" class="fly-img" alt="">
                            </div>

                            <!-- التفاصيل -->
                            <div style="position: relative; top: -18px;"
                                class="text-center pb-4 border-b border-dashed border-black dark:border-color24 border-opacity-10 ">
                                <p class="font-semibold text-sm">
                                    {!! app()->getLocale() == 'en'
                                    ? $order->type_en
                                    : (app()->getLocale() == 'zh'
                                    ? $order->type_zh
                                    : $order->type_ar) !!}
                                </p>
                                <p class="text-xs pt-2">
                                    {!! app()->getLocale() == 'en'
                                    ? $order->details_en
                                    : (app()->getLocale() == 'zh'
                                    ? $order->details_zh
                                    : $order->details_ar) !!}
                                </p>
                            </div>
                            <div style="position: relative; top: -4px;" class="flex flex-col gap-2 items-center">

<form action="{{ route('mobile.payment.start') }}" method="POST" style="width: 100%;">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    @php
$feePercent = 7.9 / 100;
$fixedFee = 1;
$paymentGatewayFee = ($order->price * $feePercent) + $fixedFee;
$total = $order->price + $paymentGatewayFee;    @endphp
    <input type="hidden" name="amount" value="{{ $total }}">
    <button type="submit"
        class="flex items-center justify-center w-full text-white text-md bg-p2 py-2 px-4 rounded-full dark:bg-p1">
        {{ __('messages.value') }} {{ $order->price }}
    </button>
</form> 

</div>

                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div>
                    <x-empty />
                </div>
                @endif
            </div>
        </div>

    </div>
    </div>

</body>
@endsection