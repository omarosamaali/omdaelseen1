@extends('layouts.mobile')

@section('title', 'الاشتراك | Subscribe')

@section('content')
<style>
    .chair-img {
        position: fixed;
        bottom: 10px;
        margin: auto;
        align-items: center;
        justify-content: center;
        display: flex;
        width: 280px;
    }

    .logo-img {
        position: fixed;
        top: 71px;
        margin: auto;
        align-items: center;
        justify-content: center;
        display: flex;
        width: 94px;
    }

    .text-p {
        align-items: center;
        justify-content: center;
        display: flex;
        position: fixed;
        bottom: 63%;
    }

    .text-p1 {
        align-items: center;
        justify-content: center;
        display: flex;
        position: fixed;
        bottom: 59%;
    }

    .text-p2 {
        align-items: center;
        justify-content: center;
        display: flex;
        position: fixed;
        bottom: 54%;
        background: black;
        color: white;
        padding: 5px;
        border-radius: 6px;
        z-index: 99999999999999;
    }
</style>

<div class="flex justify-end items-center gap-4 relative" style="background: #050505; padding: 15px;">
    <h2 class="text-md font-semibold"
        style="color: #ffffff; position: absolute; left: 50%; transform: translateX(-50%); text-align: center; width: 100%;">
    </h2>
    <a href="https://wa.me/message/PYTTNIL5FRNIB1"
        class="size-8 rounded-full flex justify-center items-center text-xl dark:bg-color10" style="z-index: 999999;">
        <img src="{{ asset('assets/assets/images/whats-icon.png') }}" alt="">
    </a>
</div>

<div style="margin: auto; align-items: center; justify-content: center; display: flex;"
    class="container relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">
    <img src="{{ asset('assets/assets/images/logo.png') }}" alt="" class="logo-img">
    <p class="text-p">تم التسجيل بنجاح ورقم الطلب </p>
    <p class="text-p1">{{ $orderNumber }} </p>
<a href="{{ route('logout.and.register', $trip->id) }}" class="text-p2 trip-button">
    تسجيل مشترك اخر
</a>
    <img src="{{ asset('assets/assets/images/china-omda.gif') }}" alt="" class="chair-img">
</div>
@endsection