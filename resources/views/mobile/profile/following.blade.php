@extends('layouts.mobile')

@section('title', 'أتابع | My Following')
<link href="{{ asset('assets/assets/css/followers.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<x-china-header :title="__('messages.أتابع')" :route="route('mobile.profile.profile')" />
<div class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">
    <img src="{{ asset('assets/assets/images/leader-bg.png') }}" alt=""
        class="fixed top-0 left-0 right-0 w-full -mt-44" />
    <div class="relative z-20">
        <div class="flex justify-center items-center gap-4 relative">
            <a href="{{ route('mobile.profile.profile') }}"
                class="absolute-left-0 bg-white size-8 rounded-full flex justify-center items-center text-xl dark:bg-color10">
                <i class="ph ph-caret-left"></i>
            </a>
            <h2 class="text-2xl font-semibold text-white text-center">المتابعين</h2>
        </div>

        <div class="flex flex-col" style="gap: 16px; padding-top: 20px; direction: rtl;">
            <div class="flex flex-col gap-4" style="padding-top: 30px; direction: rtl;">
                <div class="flex flex-col gap-4" style="direction: rtl;">
                    <div class="flex flex-col gap-4" style="direction: rtl;">
                        @forelse ($myFollowings as $myFollower)
                        <div style="box-shadow: 0px 0px 0px 3px #c6c6c6;"
                            class="follow-item flex justify-between items-center bg-white dark:bg-color9 py-4 px-5 rounded-2xl">
                            <div class="flex justify-start items-center gap-3">
                                <p class="font-semibold">{{ $loop->iteration }}</p>
                                <img src="{{ asset('storage/' . $myFollower->following->avatar) }}"
                                    alt="{{ $myFollower->following->explorer_name }}" class="size-10 rounded-full" />
                                <p class="font-semibold flex justify-start items-center gap-1">
                                    {{ $myFollower->following->explorer_name }} - {{ $myFollower->following->id }}
                                </p>
                            </div>

                            <button
                                class="toggle-follow-btn flex justify-center items-center gap-2 py-1.5 px-4 rounded-full"
                                data-user-id="{{ $myFollower->following_id }}"
                                data-following="{{ $myFollower->is_following_back ? 'true' : 'false' }}"
                                style="position: relative; top: 7px; background-color: {{ $myFollower->is_following_back ? '#fee2e2' : '#dcfce7' }}; color: red;">
                                <i class="fa-solid fa-user-xmark" style="color: red;"></i>
                            </button>
                        </div>
                        @empty
                        <x-empty />
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
            const buttons = document.querySelectorAll(".toggle-follow-btn");
        
            buttons.forEach(btn => {
                btn.addEventListener("click", async function () {
                    const userId = this.dataset.userId;
                    const parentCard = this.closest(".follow-item");
                    this.disabled = true;
        
                    try {
                        const response = await fetch(`/followers/toggle/${userId}`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                "Accept": "application/json"
                            }
                        });
        
                        if (!response.ok) throw new Error("Request failed");
        
                        // احذف الكرت مباشرة
                        parentCard.remove();
        
                    } catch (error) {
                        console.error("Error:", error);
                    } finally {
                        this.disabled = false;
                    }
                });
            });
        });
</script>
@endsection