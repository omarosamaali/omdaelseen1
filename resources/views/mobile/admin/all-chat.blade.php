@extends('layouts.mobile')

@section('title', 'عمدة الصين | China Omda')

@section('content')
<style>
    html {
        /* direction: ltr; */
    }
</style>

<body class="relative -z-20">
    <div class="container min-h-dvh relative overflow-hidden py-8 dark:text-white dark:bg-color1">
        <!-- Absolute Items Start -->
        <img src="{{ asset('assets/assets/images/header-bg-1-2.png') }}" alt=""
            class="absolute top-0 left-0 right-0 custom-img" style="margin-top: -6rem;" />
        <div class="absolute top-0 left-0 bg-p3 blur-[145px] h-[174px] w-[149px]"></div>
        <div class="absolute top-40 right-0 bg-[#0ABAC9] blur-[150px] h-[174px] w-[91px]"></div>
        <div class="absolute top-80 right-40 bg-p2 blur-[235px] h-[205px] w-[176px]"></div>
        <div class="absolute bottom-0 right-0 bg-p3 blur-[220px] h-[174px] w-[149px]"></div>
        <!-- Absolute Items End -->
        <div class="relative z-10 px-6">
            <div class="flex justify-between items-center gap-4">
                {{-- <div class="flex justify-start items-center gap-4">
                    <a href="{{ route('mobile.admin.profile') }}"
                        class="bg-white size-8 rounded-full flex justify-center items-center text-xl dark:bg-color10">
                        <i class="ph ph-caret-left"></i>
                    </a>
                </div> --}}
                <div style="display: flex; gap: 10px;">
                    <div class="flex justify-start items-center gap-2">
                        <div class="relative">
                            <a href="{{ route('mobile.welcome') }}"
                                class="border border-color24 rounded-full flex justify-center items-center relative"
                                style="padding: 3px; width: 38px; background-color: white; height: 38px;">
                                <i class="fa fa-home"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center gap-3 pt-6" style="margin-top: 70px;">
            <div style="background-color: white; color: black; z-index: 9; margin: 0px 10px;"
                class="flex justify-start items-center gap-3 bg-color24 border border-color24 p-4 rounded-full text-white w-full">
                <i class="ph ph-magnifying-glass"></i>
                <input type="text" placeholder="إبحث بإسم المستكشف" style="color: black !important; text-align: center;"
                    class="bg-transparent outline-none w-full text-xs">
            </div>
        </div>

        <p class="font-semibold pt-5 px-6">أخر محادثات</p>

        <div class="px-6 flex flex-col gap-5 pt-5">
            @foreach ($chats as $chat)
            <a href="{{ route('mobile.admin.chat', $chat['user']->id) }}" class="flex justify-between items-center">
                <div class="flex justify-start items-center gap-3">
                    <div class="relative border border-p1 p-1 rounded-full">
                        <img src="{{ $chat['user']->avatar ? asset('storage/' . $chat['user']->avatar) : asset('assets/images/user-img-1.png') }}"
                            alt="{{ $chat['user']->name }}" class="size-10 rounded-full bg-color8" />
                        <div class="bg-white p-0.5 rounded-full absolute -right-1.5 bottom-1">
                            <div class="size-3 rounded-full bg-p3"></div>
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold">{{ $chat['user']->name }}</p>
                        <p class="text-color5 text-xs dark:text-white">
                            {{ Str::limit($chat['last_message'], 50) }}...
                            <span class="font-semibold">{{ $chat['last_message_date'] }}</span>
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</body>
@endsection