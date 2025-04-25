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
            z-index: 99999999999999999;
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

    <div class="py-4 text-end" style="margin-top: 30px;">
        <div style="">
            <div style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
                <a href="{{ route('admin.regions.create') }}" class=""
                    style="background: black; color: white;
                            padding: 10px 20px; border-radius: 5px; margin: 15px 0px; margin-left: 20px;">إضافة
                    منطقة</a>
                <div
                    style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
                    <p>المناطق</p>
                    <div class="custom-select" style="position: relative; width: fit-content; ">
                        <div style="position: relative;">
                            <span
                                style="position: absolute; top: 50%; transform: translateY(-50%); right: 0.75rem; color: #9ca3af; pointer-events: none;">
                                <svg style="width: 20px; color:rgb(129, 126, 126);" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                </svg>
                            </span>
                            <input aria-autocomplete="off" autocomplete="off" type="text" id="user_search"
                                name="user_search"
                                style="text-align: right; width: 100%; padding: 0.5rem 2.5rem 0.5rem 0.5rem; border: 1px solid #d1d5db; border-radius: 30px; background-color: transparent;"
                                placeholder="بحث" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
                <table id="regions_table" class="w-full text-sm text-left rtl:text-right text-gray-500"
                    style="background: #c9c9c9;">
                    <thead class="text-xs text-gray-700 uppercase ">
                        <tr>
                            <th scope="col" class="th">
                                الرقم
                            </th>
                            <th scope="col" class="th">
                                الإسم
                            </th>
                            <th scope="col" class="th">
                                الصورة
                            </th>
                            <th scope="col" class="th">
                                أماكن
                            </th>
                            <th scope="col" class="th">
                                حالة
                            </th>
                            <th scope="col" class="th">
                                أجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($regions as $region) --}}
                            <tr class="odd:bg-white even:bg-gray-50  border-b  border-gray-200">
                                <td class="th">
                                    {{-- {{ $region->id }} --}}
                                </td>
                                <td class="th">
                                    {{-- {{ $region->name_ar }} --}}
                                </td>
                                <td class="th">
                                    {{-- <img style="width: 40px; height: 40px; border-radius: 13px;"
                                        src="{{ asset('storage/' . $region->avatar) }}" alt="{{ $region->name_ar }}"> --}}
                                </td>
                                <td class="th">
                                    <div
                                        style="background: rgb(172, 0, 0); border-radius: 3px; width: 20px; height: 20px; color:white; text-align: center;">
                                        {{-- {{ $region->places_count }} --}}
                                    </div>
                                </td>
                                <td class="th">
                                    {{-- {{ $region->status }} --}}
                                </td>
                                <td class="th" style="display: flex; ">

                                </td>
                            </tr>
                        {{-- @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>



</body>

</html>