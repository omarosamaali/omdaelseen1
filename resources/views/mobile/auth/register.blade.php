@extends('layouts.mobile')

@section('title', 'تسجيل حساب | Register')

<style>
    [dir=rtl] .iti__search-input {
        height: 50px !important;
    }

    #container-header {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 9999;
    }
</style>

@section('content')
<x-china-header :title="__('messages.login')" :route="route('mobile.welcome')" />

<div style="margin-top: 50px;" class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">
    <form action="{{ route('mobile.auth.sign-up') }}" method="POST" class="relative z-20">
        @csrf

        <div class="bg-white py-8 px-6 rounded-xl dark:bg-color10">
            <div class="flex justify-between items-center">
                <a href="{{ route('mobile.auth.login') }}"
                    class="text-center text-xl font-semibold text-bgColor18 border-b-2 pb-2 border-bgColor18 w-full dark:text-color18 dark:border-color18">
                    تسجيل الدخول
                </a>
                <a href="{{ route('mobile.auth.register') }}"
                    class="text-center text-xl font-semibold text-p2 border-b-2 pb-2 border-p2 w-full dark:text-p1 dark:border-p1">
                    تسجيل حساب
                </a>
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

            <div class="pt-8">
                <p class="text-sm font-semibold pb-2">الإسم</p>
                <div
                    class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="الإسم"
                        class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                    <i class="ph ph-user text-xl text-bgColor18 !leading-none"></i>
                </div>
                @error('name')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">البريد الإلكتروني</p>
                <div
                    class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="أدخل البريد الإلكتروني"
                        class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                    <i class="ph ph-envelope-simple text-xl text-bgColor18 !leading-none"></i>
                </div>
                @error('email')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">رقم الهاتف</p>
            </div>

            <link rel="stylesheet"
                href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.11.2/build/css/intlTelInput.css">
            <div
                class="flex justify-end items-center py-3 px-1 border border-color21 rounded-xl dark:border-color18 gap-3">
                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="رقم الهاتف المحترك"
                    class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18">
            </div>
            <span id="error-msg" class="hide"></span>

            <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.11.2/build/js/intlTelInput.min.js"></script>
            <script>
                const input = document.querySelector("#phone");
                                                              window.intlTelInput(input, {
                                                                loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.11.2/build/js/utils.js"),
                                                                initialCountry: "ae",
                                                                separateDialCode: true
                                                              });
            </script>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">الدولة</p>
                <div
                    class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <select name="country"
                        class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18">
                        @foreach (__('countries') as $code => $name)
                        <option value="{{ $code }}" {{ old('country', 'AE' )==$code ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @error('country')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">كلمة المرور</p>
                <div
                    class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="password" name="password" placeholder="*****"
                        class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18 passwordField" />
                    <i
                        class="ph ph-eye-slash text-xl text-bgColor18 !leading-none passowordShow cursor-pointer dark:text-color18"></i>
                </div>
                @error('password')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">تأكيد كلمة المرور</p>
                <div
                    class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input type="password" name="password_confirmation" placeholder="*****"
                        class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18 confirmPasswordField" />
                    <i
                        class="ph ph-eye-slash text-xl text-bgColor18 !leading-none confirmPasswordShow cursor-pointer dark:text-color18"></i>
                </div>
            </div>

            <div class="pt-4">
                <label for="checkbox" class="flex justify-start items-center gap-3 text-sm cursor-pointer">
                    <input type="checkbox" name="terms" id="checkbox" class="peer hidden" />
                    <span
                        class="border border-color21 size-7 rounded-full flex justify-center items-center !leading-none text-white peer-checked:bg-p2 dark:border-color24">
                        <i class="ph ph-check"></i>
                    </span>
                    الموافقة على <a href="#">الشروط والأحكام</a>
                </label>
            </div>
        </div>

        <button type="submit"
            class="bg-p2 rounded-full py-3 text-white text-sm font-semibold text-center block mt-12 dark:bg-p1 w-full">
            تسجيل حساب
        </button>
    </form>
</div>
@endsection