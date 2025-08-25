@extends('layouts.mobile')

@section('title', 'تسجيل دخول | Login')

@section('content')
<div class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">
    <img src="{{ asset('assets/assets/images/header-bg-2.png') }}" alt="" class="absolute top-0 left-0 right-0 -mt-6" />
    <div class="absolute top-0 left-0 bg-p3 blur-[145px] h-[174px] w-[149px]"></div>
    <div class="absolute top-40 right-0 bg-[#0ABAC9] blur-[150px] h-[174px] w-[91px]"></div>
    <div class="absolute top-80 right-40 bg-p2 blur-[235px] h-[205px] w-[176px]"></div>
    <div class="absolute bottom-0 right-0 bg-p3 blur-[220px] h-[174px] w-[149px]"></div>
    <div class="flex justify-start items-center relative z-10">
        <div class="logo-register">
            <img src="{{ asset('assets/assets/images/logo-all.png') }}" class="image-regsiter" alt="">
        </div>
        <x-back-button href="{{ route('mobile.welcome') }}" />
    </div>
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('mobile.auth.sign-in') }}" method="POST" class="relative z-10">
        @csrf
        <div class="bg-white py-8 px-6 rounded-xl mt-12 dark:bg-color10">
            <div class="flex justify-between items-center">
                <a href="{{ route('mobile.auth.login') }}" class="text-center text-xl font-semibold text-p2 border-b-2 pb-2 border-p2 w-full dark:text-p1 dark:border-p1">
                    تسجيل الدخول</a>
                <a href="{{ route('mobile.auth.register') }}" class="text-center text-xl font-semibold text-bgColor18 border-b-2 pb-2 border-bgColor18 w-full dark:text-color18 dark:border-color18">
                    تسجيل حساب</a>
            </div>

            <div class="pt-8">
                <p class="text-sm font-semibold pb-2">البريد الإلكتروني</p>
                <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input name="email" type="text" autocomplete="off" placeholder="أدخل البريد الإلكتروني" class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                    <i class="ph ph-envelope-simple text-xl text-bgColor18 !leading-none"></i>
                </div>
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">كلمة المرور</p>
                <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input name="password" type="password" placeholder="*****" class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18 passwordField" />
                    <i class="ph ph-eye-slash text-xl text-bgColor18 !leading-none passowordShow cursor-pointer dark:text-color18"></i>
                </div>
            </div>
            <a href="{{ route('mobile.auth.forgot-password') }}" class="text-end text-p2 text-sm font-semibold block pt-2 dark:text-p1">نسيت كلمة المرور ؟</a>
        </div>
        <button type="submit" class="w-full bg-p2 rounded-full py-3 text-white text-sm font-semibold text-center block mt-8 dark:bg-p1">تسجيل دخول</button>
    </form>

</div>
@endsection
