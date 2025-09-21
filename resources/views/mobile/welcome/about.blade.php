@extends('layouts.mobile')

@section('title', 'عمدة الصين | China Omda')

@section('content')
<style>
    .fa-question {
        transform: rotateY(190deg);
    }

    body {
        position: relative !important;
    }

    .tab-button .item.active {
        background-color: #000;
        color: #fff;
        padding: 8px 16px;
        border-radius: 9999px;
    }
</style>

<x-china-header :title="__('messages.about_us')" :route="route('mobile.welcome')" />

<body class="relative -z-20">
    <div class="container min-h-dvh relative overflow-hidden py-8 dark:text-white -z-10 dark:bg-color1">
        <div class="relative z-10 px-6">

            <div class="flex flex-col justify-center items-center text-center">
                <img src="{{ asset('storage/'. $about->avatar) }}" alt="" style="max-height: 300px;" />
                <p class="text-color5 pt-5 px-6 dark:text-bgColor5">
                    {!! app()->getLocale() == 'en'
                    ? $about->content_en
                    : (app()->getLocale() == 'zh'
                    ? $about->content_zh
                    : $about->content_ar) !!}
                </p>
                <div class="px-6 w-full">
                    <a href="index.html"
                        class="bg-p2 rounded-full py-3 text-white text-sm font-semibold text-center block mt-12 dark:bg-p1">
                        {{ __('messages.contact_us') }}</a>
                </div>
            </div>
        </div>
    </div>

</body>
@endsection