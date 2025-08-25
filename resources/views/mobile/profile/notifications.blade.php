<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/assets/images/logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/assets/css/swiper.min.css') }}" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="manifest" href="{{ asset('assets/assets/manifest.json') }}" />
    <title>الإشعارات | Notifications</title>
    <link href="{{ asset('assets/assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <img src="{{ asset('assets/assets/images/PG-OMDA-1.png') }}" class="image-container" alt="">
    <div class="container bg-white dark:bg-color10 p-6 min-h-screen dark:text-white relative">
        <div class="flex justify-start items-center gap-3">
            <div class="flex justify-start items-center gap-3 bg-color14 border border-color16 p-4 rounded-full w-full dark:border-bgColor16 dark:bg-bgColor14">
                <i class="ph ph-magnifying-glass"></i>
                <input type="text" placeholder="إبحث" class="bg-transparent outline-none placeholder:text-color1 w-full text-xs dark:text-white dark:placeholder:text-white" />
            </div>
            <x-back-button href="{{ route('mobile.profile.profile') }}" />
        </div>

        <p class="text-xl font-semibold pt-8">جديد الإشعارات</p>
        <div class="flex flex-col gap-4 pt-5">
            <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24">
                <p>Latest Movie Quizzes</p>
                <i class="ph ph-x"></i>
            </div>
            <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24">
                <p>Tech Trends Trivia</p>
                <i class="ph ph-x"></i>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/apex-custom.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugin-custom.js') }}"></script>
    <script defer src="{{ asset('assets/assets/js/index.js') }}"></script>
</body>
</html>
