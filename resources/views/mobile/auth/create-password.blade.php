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
        <x-back-button href="{{ route('mobile.auth.otp-verification') }}" />
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
    <form action="{{ route('mobile.auth.password.update') }}" method="POST" class="relative z-10">
        @csrf <div class="bg-white py-8 px-6 rounded-xl mt-12 dark:bg-color10">
            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">كلمة المرور</p>
                <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="password" name="password" placeholder="*****" class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18 passwordField" required />
                    <i class="ph ph-eye-slash text-xl text-bgColor18 !leading-none passowordShow cursor-pointer dark:text-color18"></i>
                </div>
            </div>
            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">تأكيد كلمة المرور</p>
                <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="password" name="password_confirmation" placeholder="*****" class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18 confirmPasswordField" required />
                    <i class="ph ph-eye-slash text-xl text-bgColor18 !leading-none confirmPasswordShow cursor-pointer dark:text-color18"></i>
                </div>
            </div>
            <input type="hidden" name="email" value="{{ session('email') }}">
        </div>
        <button type="submit" class="bg-p2 rounded-full py-3 text-white text-sm font-semibold text-center block mt-12 dark:bg-p1 w-full">تأكيد</button>
    </form>
</div>
@endsection
