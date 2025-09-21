<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/assets/images/logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/assets/css/swiper.min.css') }}" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <title>توثيق الحساب | Account Verification</title>
    <link href="{{ asset('assets/assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <img src="{{ asset('assets/assets/images/PG-OMDA-1.png') }}" class="image-container" alt="">
    <div class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">
        <img src="{{ asset('assets/assets/images/header-bg-2.png') }}" alt=""
            class="absolute top-0 left-0 right-0 -mt-6" />
        <div class="absolute top-0 left-0 bg-p3 blur-[145px] h-[174px] w-[149px]"></div>
        <div class="absolute top-40 right-0 bg-[#0ABAC9] blur-[150px] h-[174px] w-[91px]"></div>
        <div class="absolute top-80 right-40 bg-p2 blur-[235px] h-[205px] w-[176px]"></div>
        <div class="absolute bottom-0 right-0 bg-p3 blur-[220px] h-[174px] w-[149px]"></div>
        <div class="flex justify-start items-center relative z-10">
            <div class="logo-register">
                <img src="{{ asset('assets/assets/images/logo-all.png') }}" class="image-regsiter" alt="">
            </div>
            <a href="{{ route('mobile.profile.profile') }}"
                class="bg-white p-2 rounded-full flex justify-center items-center text-xl dark:bg-color10">
                <i class="ph ph-caret-left"></i>
            </a>
        </div>
        <form action="{{ route('mobile.profile.verify-otp') }}" method="POST" class="relative z-10 otp-form">
            @csrf
            <div class="bg-white py-8 px-6 rounded-xl mt-12 dark:bg-color10">
                <div class="flex flex-col gap-3 text-center">
                    <h3 class="text-xl font-semibold">{{ __('messages.enter_verification_code') }}</h3>
                    <p class="text-bgColor18 text-sm dark:text-color18">
                        {{ __('messages.verification_code_sent_to') }}
                        <span class="text-p1">{{ Auth::user()->email }}</span>
                    </p>
                </div>
                <div class="flex justify-between items-center gap-3 w-full mx-auto py-6">
                    <input type="text" name="otp" class="w-full item otp-form-item" maxlength="4" />
                </div>
                @error('otp')
                    <p class="text-red-500 text-center text-sm mt-2">{{ $message }}</p>
                @enderror
                <p class="text-bgColor18 text-sm dark:text-white pt-2 text-center" id="resendSection">
                    {{ __('messages.no_verification_code_received') }} <span id="timer">01:00</span>
                </p>
            </div>
            <button type="submit"
                class="w-full bg-p2 rounded-full py-3 text-white text-sm font-semibold text-center block mt-12 dark:bg-p1">
                {{ __('messages.confirm_button') }}</button>
        </form>
    </div>
    <form action="{{ route('mobile.profile.send-otp') }}" style="display: none" id="resendOtpForm" method="POST">
        @csrf
    </form>
    <script>
        function startTimer() {
            let timeLeft = 60;
            const timerElement = document.getElementById('timer');
            const resendSection = document.getElementById('resendSection');
            const timer = setInterval(function() {
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    resendSection.innerHTML =
                        'لم يصلك رمز التحقق؟ <button type="button" onclick="resendOtp()" class="text-p1">إعادة إرسال</button>';
                } else {
                    let minutes = Math.floor(timeLeft / 60);
                    let seconds = timeLeft % 60;
                    timerElement.textContent =
                        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    timeLeft--;
                }
            }, 1000);
        }

        function resendOtp() {
            document.getElementById('resendOtpForm').submit();
        }
        document.addEventListener('DOMContentLoaded', startTimer);
    </script>

    <script src="{{ asset('assets/assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/apex-custom.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugin-custom.js') }}"></script>
    <script defer src="{{ asset('assets/assets/js/index.js') }}"></script>
</body>

</html>
