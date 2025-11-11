@extends('layouts.mobile')

@section('title', 'عمدة الصين | China Omda')

@section('content')
<style>
    html {
        /* direction: ltr; */
    }

    .unread-badge {
        background-color: maroon;
        color: white;
        font-size: 0.65rem;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 9999px;
        min-width: 1.2rem;
        text-align: center;
    }
</style>

<body class="relative -z-20">
    <x-china-header :title="__('messages.all_chats')" :route="route('mobile.welcome')" />
    <div style="padding-top: 65px;"
        class="container min-h-dvh relative overflow-hidden py-8 dark:text-white dark:bg-color1">
        <div class="px-6 flex flex-col gap-5 pt-5">
            @foreach ($chats as $chat)
            <a href="{{ route('mobile.admin.chat', $chat['user']->id) }}" class="flex justify-between items-center">
                <div class="flex justify-start items-center gap-3">
                    <div class="relative border border-p1 p-1 rounded-full">
                        <img src="{{ $chat['user']->avatar ? asset('storage/' . $chat['user']->avatar) : asset('assets/assets/images/default.jpg') }}"
                            alt="{{ $chat['user']->name }}" class="size-10 rounded-full bg-color8" />
                        @if ($chat['unread_count'] > 0)
                        <div class="unread-badge absolute -right-1.5 bottom-1">
                            {{ $chat['unread_count'] }}
                        </div>
                        @endif
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