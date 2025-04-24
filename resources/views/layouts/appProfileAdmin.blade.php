<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>عمدة الصين | China Omda</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/fav.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Cairo', sans-serif !important;
            background-color: #e29609;
        }

        /* تصميم الـ Sidebar */
        .sidebar {
            position: fixed;
            top: 218px;
            right: 0px;
            width: 250px;
            border-radius: 61px;
            text-align: center;
            height: 481px;
            padding: 20px;
            z-index: 0;
            direction: rtl;
            justify-content: start;
            display: flex;
            overflow-y: auto;
        }

        .sidebar ul {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: start;
            width: 100%;
        }

        .sidebar ul li {
            margin-bottom: 10px;
            width: 100%;
        }

        .sidebar ul li a,
        .menu-item {
            display: flex;
            width: 180px;
            text-align: right;
            justify-content: start;
            align-items: center;
            gap: 10px;
            color: #333;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            padding: 2px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .sidebar ul li a:hover,
        .menu-item:hover {
            background-color: #ffffff;
            color: #82535e;
        }

        /* Highlight active link */
        .sidebar ul li a.active,
        .menu-item.active {
            background-color: #ffffff;
            color: #82535e;
            font-weight: 600;
        }

        .sidebar-icon {
            width: 20px;
            height: 20px;
        }

        /* تصميم القوائم الفرعية */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            width: 100%;
            list-style: none;
            padding-right: 20px;
        }

        .submenu li {
            margin-bottom: 5px !important;
        }

        .submenu li a {
            font-size: 14px;
            padding: 2px 10px;
            width: 173px;
        }

        .submenu li a.active {
            background-color: #f0f0f0;
            color: #82535e;
            font-weight: 600;
        }

        .submenu.active {
            max-height: 500px;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .arrow {
            margin-right: 5px;
            transition: transform 0.3s;
            font-size: 10px;
        }

        .arrow.active {
            transform: rotate(180deg);
        }

        /* ضبط الـ Container عشان يتجنب الـ Sidebar */
        .container {
            margin-right: 270px;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .container {
                margin-right: 0;
            }
        }

        #middle {
            width: 156px;
            margin-top: -16px;
            margin-bottom: 50px;
            z-index: 9;
        }

        #middle img {
            position: fixed;
            top: -8px;
            width: 156px;
            right: 166px;
        }

        @media (max-width: 1300px) {
            main {
                position: relative;
                right: 98px !important;
            }
        }

        @media (max-width: 1075px) {
            main {
                max-width: 500px !important;
            }
        }

        @media (max-width: 870px) {
            #middle img {
                display: none;
            }

            main {
                right: 28px !important;
            }
        }

        .logo-container {
            display: none;
        }

        @media (max-width:760px) {
            #app {
                display: none !important;
            }

            .logo-container {
                display: none;
            }
        }

        .logo-container img {
            width: 200px;
            height: 200px;
            position: absolute;
            top: 0px;
            left: 50%;
            transform: translateX(-50%);
        }

        .logo-pc {
            color: white;
            text-align: center;
            font-size: 31px;
            font-weight: 600;
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
        }

        .logo-pc-h3 {
            color: white;
            text-align: center;
            font-size: 31px;
            font-weight: 600;
            position: absolute;
            bottom: 120px;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
        }

        .google-play {
            bottom: 0px;
            position: absolute;
            align-items: center;
            justify-content: space-between;
            display: flex;
            width: 93%;
            padding: 20px;
            align-items: center;
            margin: auto;
        }

        .logo-title {
            width: 70%;
            z-index: 99;
            color: #be3d1e;
            text-align: center;
            font-size: 46px;
            font-weight: normal !important;
            position: absolute;
            top: 30%;
            line-height: 1.4;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .google-play svg {
            width: 50px;
            height: 50px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            margin-bottom: 20px;
            position: fixed;
            top: 106px;
            right: 3%;
        }

        .user-profile img {
            width: 60px;
            height: 60px;
            border: 2px solid #ffa900;
            border-radius: 50%;
            padding: 3px;
        }

        .user-profile p {
            color: rgb(0, 0, 0);
            margin-top: 5px;
            text-align: center;
        }

        .user-profile span {
            color: #c00000;
        }

        .input-field {
            background-color: #F9FAFB !important;
            border: 1px solid #D1D5DB !important;
            color: #111827 !important;
            font-size: 0.875rem !important;
            border-radius: 0.375rem !important;
            padding: 0.625rem 1rem !important;
            width: 100% !important;
            margin-top: 5px;
        }

        .input-field:focus {
            border-color: #3B82F6 !important;
            ring: 2px solid rgba(59, 130, 246, 0.5) !important;
        }

        .rtl-select {
            direction: rtl;
            text-align: right;
        }

        .rtl-select option {
            text-align: right;
        }

        .rtl-select::-ms-expand {
            left: 0;
        }

        .rtl-select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-position: left center;
            padding-left: 30px;
        }

        footer {
            position: fixed;
            top: 96%;
            width: 100%;
            height: 100%;
            left: -35%;
            z-index: 99999999;
        }

        ul li img {
            width: 30px;
            height: 15px;
        }

        footer ul li a {
            color: white;
            align-items: center;
            justify-content: center;
            margin: auto;
            display: flex;
            flex-direction: row;
            gap: 5px;
        }

        footer ul {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 20px;
            align-items: center;
            justify-content: center;
            margin: auto;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-layout font-sans antialiased">

    <div class="logo-container">
        <img src="{{ asset('assets/img/logo.svg') }}" alt="">
        <div>
            <h1 class="logo-pc">هذا الموقع متوفر فقط علي أجهزة الكمبيوتر</h1>
        </div>
        <div>
            <h3 class="logo-pc-h3">
                قم بتحميل تطبيق قرية عمدة الصين علي الهاتف
            </h3>
            <div class="google-play">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48">
                        <path fill="#EA4335"
                            d="M24 9.5c3.5 0 6.6 1.3 9 3.5l6.7-6.7C35.4 2.3 30.2 0 24 0 14.6 0 6.6 5.8 2.5 14.2l7.8 6C12.4 13.2 17.7 9.5 24 9.5z" />
                        <path fill="#4285F4"
                            d="M46.1 24.5c0-1.7-.1-2.9-.4-4.2H24v7.9h12.6c-.3 2.1-1.4 5.1-4.1 7.1l6.4 5C42.9 36.6 46.1 31.3 46.1 24.5z" />
                        <path fill="#FBBC05"
                            d="M10.3 28.3C9.6 26.6 9.2 24.7 9.2 22.8s.4-3.8 1.1-5.5l-7.8-6C.8 15.2 0 18.4 0 22.8s.8 7.6 2.5 11l7.8-5.5z" />
                        <path fill="#34A853"
                            d="M24 48c6.2 0 11.4-2.1 15.2-5.7l-7.1-5.5c-2 1.4-4.6 2.2-8.1 2.2-6.3 0-11.6-4.2-13.5-9.9l-7.9 6c3.9 8.3 11.8 13.9 21.4 13.9z" />
                        <path fill="none" d="M0 0h48v48H0z" />
                    </svg>
                </a>
                <a href="">
                    <svg style="color:black;" class="w-6 h-6" aria-hidden=" molar mass="0.025g/mol"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M17.537 12.625a4.421 4.421 0 0 0 2.684 4.047 10.96 10.96 0 0 1-1.384 2.845c-.834 1.218-1.7 2.432-3.062 2.457-1.34.025-1.77-.794-3.3-.794-1.531 0-2.01.769-3.275.82-1.316.049-2.317-1.318-3.158-2.532-1.72-2.484-3.032-7.017-1.27-10.077A4.9 4.9 0 0 1 8.91 6.884c1.292-.025 2.51.869 3.3.869.789 0 2.27-1.075 3.828-.917a4.67 4.67 0 0 1 3.66 1.984 4.524 4.524 0 0 0-2.16 3.805m-2.52-7.432A4.4 4.4 0 0 0 16.06 2a4.482 4.482 0 0 0-2.945 1.516 4.185 4.185 0 0 0-1.061 3.093 3.708 3.708 0 0 0 2.967-1.416Z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div id="app" class="min-h-screen bg-gray-100">
        <img src="{{ asset('assets/img/head1.svg') }}" alt=""
            style="z-index: 9; position: fixed; width: 100%; top: 0px;">

        <header class="bg-white shadow">
            {{ $header ?? '' }}
        </header>

        <!-- Page Content -->
        <div style="display: flex; align-items: center; justify-content: center; gap: 20px;">
            <main style="margin-top: 90px; margin-bottom: 50px; direction: rtl; width: 100%; margin-right: 134px;">
                @yield('content')
            </main>
            <div id="middle">
                <img src="{{ asset('assets/img/right.svg') }}" alt="">
            </div>
            <div>
                <!-- Sidebar here -->
                <div class="user-profile">
                    <div type="button" class="flex mx-3 text-sm rounded-full md:mr-0" id="user-menu-button"
                        aria-expanded="false">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'assets/img/avatar.gif' }}"
                            alt="Avatar" class="h-20 w-20 rounded-full object-cover border">
                    </div>
                    @if (isset($user) && $user->country)
                        <img style="position: absolute; right: 6px; width: 30px; height: 20px; border-radius: 0px; border: 0px;"
                            src="https://flagcdn.com/32x24/{{ strtolower($user->country) }}.png"
                            alt="{{ $user->country }} Flag">
                    @else
                        <img style="position: absolute; right: 6px; width: 30px; height: 20px; border-radius: 0px; border: 0px;"
                            src="https://flagcdn.com/32x24/xx.png" alt="Default Flag">
                    @endif
                    <p style="margin-left: 29px;"><span style="display: block;">مرحبا </span>
                        {{ Auth::user()->name }}</p>
                </div>
                <div class="sidebar">
                    <ul>
                        <li>
                            <div class="menu-item"
                                style="display: flex; align-items: center; justify-content: space-between;">
                                <a href="{{ route('profile.edit') }}"
                                    class="{{ Route::is('profile.edit') ? 'active' : '' }}">
                                    <x-icon />
                                    الملف الشخصي
                                </a>
                            </div>
                        </li>

                        <!-- بيت العمدة -->
                        <li>
                            <div class="menu-item"
                                style="display: flex; align-items: center; justify-content: space-between;"
                                onclick="toggleSubmenu(this, 'home-submenu')">
                                <div style="display: flex; align-items: center;">
                                    <x-icon />
                                    بيت العمدة
                                </div>
                                <span class="arrow">▼</span>
                            </div>
                            <ul id="home-submenu" class="submenu">
                                <li><a href="{{ route('admin.dashboard.index') }}" class="#">
                                        <x-iconSub />
                                        لوحة التحكم</a></li>
                                <li><a href="{{ route('admin.users.index') }}"
                                        class="{{ Route::is('admin.users.index') ? 'active' : '' }}">
                                        <x-iconSub />
                                        المستخدمين</a></li>
                                <li><a href="{{ route('admin.works.index') }}"
                                        class="{{ Route::is('work') ? 'active' : '' }}">
                                        <x-iconSub />
                                        كيف نعمل</a></li>
                                <li><a href="{{ route('admin.contact-messages.index') }}"
                                        class="{{ Route::is('admin.contact-messages.*') ? 'active' : '' }}">
                                        <x-iconSub />
                                        المراسلات
                                    </a></li>
                                <li><a href="#" class="{{ Route::is('interests') ? 'active' : '' }}">
                                        <x-iconSub />
                                        الاهتمامات</a></li>
                                <li><a href="{{ route('admin.events.index') }}" class="{{ Route::is('events') ? 'active' : '' }}">
                                        <x-iconSub />معرض والمناسبات</a></li>
                                <li><a href="{{ route('admin.terms.index') }}"
                                        class="{{ Route::is('terms') ? 'active' : '' }}">
                                        <x-iconSub />الشروط والأحكام</a></li>
                                <li><a href="{{ route('admin.privacy.index') }}"
                                        class="{{ Route::is('privacy') ? 'active' : '' }}">
                                        <x-iconSub />سياسة الخصوصية</a></li>
                                <li><a href="{{ route('admin.faq.index') }}"
                                        class="{{ Route::is('faq') ? 'active' : '' }}">
                                        <x-iconSub />الأسئلة الشائعة</a></li>
                                <li><a href="{{ route('admin.about.index') }}"
                                        class="{{ Route::is('about') ? 'active' : '' }}">
                                        <x-iconSub />من نحن</a></li>
                                <li><a href="{{ route('admin.help_words.index') }}"
                                        class="{{ Route::is('help_words') ? 'active' : '' }}">
                                        <x-iconSub />كلمات مساعدة</a></li>
                                <li><a href="{{ route('admin.banners.index') }}"
                                        class="{{ Route::is('banners') ? 'active' : '' }}">
                                        <x-iconSub />البنرات</a></li>


                            </ul>
                        </li>

                        <!-- المستكشفين -->
                        <li>
                            <div class="menu-item"
                                style="display: flex; align-items: center; justify-content: space-between;"
                                onclick="toggleSubmenu(this, 'explorers-submenu')">
                                <div style="display: flex; align-items: center;">
                                    <x-icon />
                                    المستكشفين
                                </div>
                                <span class="arrow">▼</span>
                            </div>
                            <ul id="explorers-submenu" class="submenu">
                                <li><a href="{{ route('admin.dashboard.index') }}" class="#">
                                        <x-iconSub />
                                        لوحة التحكم</a></li>
                                <li><a href="{{ route('admin.explorers.index') }}"
                                        class="{{ Route::is('admin.explorers.index') ? 'active' : '' }}">
                                        <x-iconSub />

                                        التصنيف
                                        الرئيسي</a></li>
                                <li><a href="{{ route('admin.branches.index') }}"
                                        class="{{ Route::is('admin.branches.index') ? 'active' : '' }}">
                                        <x-iconSub />
                                        التصنيف
                                        الفرعي</a></li>
                                <li><a href="{{ route('admin.regions.index') }}"
                                        class="{{ Route::is('admin.regions.index') ? 'active' : '' }}">
                                        <x-iconSub />
                                        المناطق</a></li>
                                <li><a href="{{ route('admin.places.index') }}"
                                        class="{{ Route::is('admin.places.index') ? 'active' : '' }}"> <x-iconSub />
                                        قائمة
                                        الاماكن</a></li>
                                <li><a href="#" class="{{ Route::is('reports') ? 'active' : '' }}">
                                        <x-iconSub />
                                        البلاغات</a></li>
                            </ul>
                        </li>

                        <!-- السفريات -->
                        <li>
                            <div class="menu-item"
                                style="display: flex; align-items: center; justify-content: space-between;"
                                onclick="toggleSubmenu(this, 'travel-submenu')">
                                <div style="display: flex; align-items: center;">
                                    <x-icon />
                                    السفريات
                                </div>
                                <span class="arrow">▼</span>
                            </div>
                            <ul id="travel-submenu" class="submenu">
                                <li><a href="#" class="{{ Route::is('travel.dashboard') ? 'active' : '' }}">
                                        <x-iconSub />
                                        لوحة
                                        التحكم</a></li>
                                <li><a href="#" class="{{ Route::is('travel.main') ? 'active' : '' }}">
                                        <x-iconSub />
                                        التصنيف
                                        الرئيسي</a></li>
                                <li><a href="#" class="{{ Route::is('travel.sub') ? 'active' : '' }}">
                                        <x-iconSub />
                                        التصنيف
                                        الفرعي</a></li>
                                <li><a href="#" class="{{ Route::is('travel.add') ? 'active' : '' }}">
                                        <x-iconSub />
                                        اضافة رحلة</a></li>
                                <li><a href="#" class="{{ Route::is('travel.list') ? 'active' : '' }}">
                                        <x-iconSub />
                                        قائمة
                                        الرحلات</a></li>
                            </ul>
                        </li>

                        <!-- المتجر -->
                        <li>
                            <div class="menu-item"
                                style="display: flex; align-items: center; justify-content: space-between;"
                                onclick="toggleSubmenu(this, 'store-submenu')">
                                <div style="display: flex; align-items: center;">
                                    <x-icon />
                                    المتجر
                                </div>
                                <span class="arrow">▼</span>
                            </div>
                            <ul id="store-submenu" class="submenu">
                                <li><a href="#" class="{{ Route::is('store.dashboard') ? 'active' : '' }}">
                                        <x-iconSub />
                                        لوحة
                                        التحكم</a></li>
                                <li><a href="#" class="{{ Route::is('store.main') ? 'active' : '' }}">
                                        <x-iconSub />
                                        التصنيف
                                        الرئيسي</a></li>
                                <li><a href="#" class="{{ Route::is('store.sub') ? 'active' : '' }}">
                                        <x-iconSub />
                                        التصنيف
                                        الفرعي</a></li>
                                <li><a href="#" class="{{ Route::is('store.products') ? 'active' : '' }}">
                                        <x-iconSub />
                                        قائمة
                                        المنتجات</a></li>
                                <li><a href="#" class="{{ Route::is('store.add') ? 'active' : '' }}">
                                        <x-iconSub />
                                        اضافة
                                        منتجات</a></li>
                                <li><a href="#" class="{{ Route::is('store.reports') ? 'active' : '' }}">
                                        <x-iconSub />
                                        البلاغات</a></li>
                            </ul>
                        </li>

                        <!-- الطلبات -->
                        <li>
                            <div class="menu-item"
                                style="display: flex; align-items: center; justify-content: space-between;"
                                onclick="toggleSubmenu(this, 'orders-submenu')">
                                <div style="display: flex; align-items: center;">
                                    <x-icon />
                                    الطلبات
                                </div>
                                <span class="arrow">▼</span>
                            </div>
                            <ul id="orders-submenu" class="submenu">
                                <li><a href="#" class="{{ Route::is('orders.new') ? 'active' : '' }}">
                                        <x-iconSub />
                                        طلبات
                                        جديدة</a></li>
                                <li><a href="#" class="{{ Route::is('orders.progress') ? 'active' : '' }}">
                                        <x-iconSub />
                                        طلبات قيد
                                        الاجراء</a></li>
                                <li><a href="#" class="{{ Route::is('orders.paid') ? 'active' : '' }}">
                                        <x-iconSub />
                                        تم
                                        الدفع</a></li>
                                <li><a href="#" class="{{ Route::is('orders.preparing') ? 'active' : '' }}">
                                        <x-iconSub />
                                        جاري التجهيز
                                        للشحن</a></li>
                                <li><a href="#" class="{{ Route::is('orders.shipped') ? 'active' : '' }}">
                                        <x-iconSub />
                                        طلبات
                                        تم
                                        شحنها</a></li>
                                <li><a href="#" class="{{ Route::is('orders.completed') ? 'active' : '' }}">
                                        <x-iconSub />
                                        طلبات
                                        منتهية</a></li>
                                <li><a href="#" class="{{ Route::is('orders.review') ? 'active' : '' }}">
                                        <x-iconSub />
                                        طلبات
                                        يتم
                                        دراستها</a></li>
                                <li><a href="#" class="{{ Route::is('orders.payment') ? 'active' : '' }}">
                                        <x-iconSub />
                                        طلبات
                                        للدفع</a></li>
                                <li><a href="#" class="{{ Route::is('orders.cancelled') ? 'active' : '' }}">
                                        <x-iconSub />
                                        طلبات
                                        ملغية</a></li>
                            </ul>
                        </li>

                        <!-- السمسار -->
                        <li>
                            <div class="menu-item"
                                style="display: flex; align-items: center; justify-content: space-between;"
                                onclick="toggleSubmenu(this, 'broker-submenu')">
                                <div style="display: flex; align-items: center;">
                                    <x-icon />
                                    السمسار
                                </div>
                                <span class="arrow">▼</span>
                            </div>
                            <ul id="broker-submenu" class="submenu">
                                <li><a href="#" class="{{ Route::is('broker.dashboard') ? 'active' : '' }}">
                                        <x-iconSub />
                                        لوحة
                                        التحكم</a></li>
                                <li><a href="#" class="{{ Route::is('broker.main') ? 'active' : '' }}">
                                        <x-iconSub />
                                        التصنيف
                                        الرئيسي</a></li>
                                <li><a href="#" class="{{ Route::is('broker.sub') ? 'active' : '' }}">
                                        <x-iconSub />
                                        التصنيف
                                        الفرعي</a></li>
                                <li><a href="#" class="{{ Route::is('broker.projects') ? 'active' : '' }}">
                                        <x-iconSub />
                                        قائمة
                                        المشاريع</a></li>
                                <li><a href="#" class="{{ Route::is('broker.add') ? 'active' : '' }}">
                                        <x-iconSub />
                                        اضافة
                                        مشروع</a></li>
                                <li><a href="#" class="{{ Route::is('broker.reports') ? 'active' : '' }}">
                                        <x-iconSub />
                                        البلاغات</a></li>
                            </ul>
                        </li>

                        <!-- تسجيل الخروج -->
                        <li>
                            <a href="{{ route('logout') }}" class="{{ Route::is('logout') ? 'active' : '' }}"
                                style="display: flex; align-items: center; justify-content: space-between;"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div style="display: flex; align-items: center;">
                                    <x-icon />
                                    تسجيل الخروج
                                </div>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div style="position: relative;">
            <img src="{{ asset('assets/img/foot1.svg') }}" alt=""
                style="z-index: 999999999999999999; position: fixed; width: 100%; bottom: 0px;">
            <footer>
                <ul>
                    <li><a href="#">English
                            <img src="{{ asset('assets/img/en.png') }}" alt="uae flag" class="lang-icon" />
                        </a></li>
                    <li><a href="#">中文 <img src="{{ asset('assets/img/ch.png') }}" alt="uae flag"
                                class="lang-icon" />
                        </a></li>
                    <li>
                        <a href="#" class="">
                            العربية
                            <img src="{{ asset('assets/img/uae.webp') }}" alt="uae flag" class="lang-icon" />
                        </a>
                    </li>
                </ul>
            </footer>
        </div>
    </div>

    <script>
        function toggleSubmenu(element, id) {
            const submenu = document.getElementById(id);
            const arrow = element.querySelector('.arrow');

            // تبديل حالة القائمة الفرعية
            submenu.classList.toggle('active');
            arrow.classList.toggle('active');

            // إذا كانت القائمة مفتوحة، نخزن معرفها في sessionStorage
            if (submenu.classList.contains('active')) {
                sessionStorage.setItem('openSubmenu', id);
            } else {
                // إذا تم إغلاقها، نزيل المعرف من sessionStorage
                sessionStorage.removeItem('openSubmenu');
            }

            // إغلاق القوائم الفرعية الأخرى
            const allSubmenus = document.querySelectorAll('.submenu');
            const allArrows = document.querySelectorAll('.arrow');

            allSubmenus.forEach(item => {
                if (item.id !== id && item.classList.contains('active')) {
                    item.classList.remove('active');
                }
            });

            allArrows.forEach(item => {
                if (item !== arrow && item.classList.contains('active')) {
                    item.classList.remove('active');
                }
            });
        }

        // استعادة حالة القائمة الفرعية عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', () => {
            const openSubmenuId = sessionStorage.getItem('openSubmenu');
            if (openSubmenuId) {
                const submenu = document.getElementById(openSubmenuId);
                if (submenu) {
                    submenu.classList.add('active');
                    const menuItem = submenu.closest('li').querySelector('.menu-item');
                    if (menuItem) {
                        const arrow = menuItem.querySelector('.arrow');
                        if (arrow) {
                            arrow.classList.add('active');
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
