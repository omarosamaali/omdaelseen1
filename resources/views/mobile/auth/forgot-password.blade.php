@extends('layouts.mobile')

@section('title', 'إستعادة كلمة المرور | Forgot Password')

@section('content')
<div class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">
    <img src="assets/images/header-bg-2.png" alt="" class="absolute top-0 left-0 right-0 -mt-6" />
    <div class="absolute top-0 left-0 bg-p3 blur-[145px] h-[174px] w-[149px]"></div>
    <div class="absolute top-40 right-0 bg-[#0ABAC9] blur-[150px] h-[174px] w-[91px]"></div>
    <div class="absolute top-80 right-40 bg-p2 blur-[235px] h-[205px] w-[176px]"></div>
    <div class="absolute bottom-0 right-0 bg-p3 blur-[220px] h-[174px] w-[149px]"></div>
    <div class="flex justify-start items-center relative z-10">
        <div class="logo-register">
            <img src="./assets/images/logo-all.png" class="image-regsiter" alt="">
        </div>
        <x-back-button href="{{ route('mobile.auth.login') }}" />
    </div>

    <form action="{{ route('mobile.auth.forgot-password.send') }}" method="POST" class="relative z-10">
        @csrf <div class="bg-white py-8 px-6 rounded-xl mt-12 dark:bg-color10">
            <div class="pt-8">
                <p class="text-sm font-semibold pb-2">البريد الإلكتروني المسجل</p>
                <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="email" name="email" placeholder="أدخل البريد الإلكتروني" class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" required />
                    <i class="ph ph-envelope-simple text-xl text-bgColor18 !leading-none"></i>
                </div>
            </div>
        </div>
        <button type="submit" class="bg-p2 rounded-full py-3 text-white text-sm font-semibold text-center block mt-12 dark:bg-p1 w-full">متابعة</button>
    </form>

</div>
@endsection
