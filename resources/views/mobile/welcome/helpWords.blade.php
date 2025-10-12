@extends('layouts.mobile')

@section('title', 'عمدة الصين | الكلمات')

@section('content')
<style>
    .fa-question {
        transform: rotateY(190deg);
    }

    body {
        position: relative !important;
    }

    .tab-button .item.active {
        background-color: #000;
        color: #fff;
        padding: 8px 16px;
        border-radius: 9999px;
    }

    .empty-img {
        height: 374px;
        width: 100%;
    }

    .speak-button.playing {
        background-color: #ef4444 !important;
        animation: pulse 1s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.7;
        }
    }
</style>

<x-china-header :title="__('messages.الكلمات')" :route="route('mobile.welcome')" />
<div style="padding-top: 90px;"
    class="container min-h-dvh relative overflow-hidden py-8 dark:text-white -z-10 dark:bg-color1">
    <p class="text-2xl font-semibold text-center pt-18">{{ __('messages.اضغط لسماع الكلمة') }}</p>
    <div class="faqCategory pt-20">
        @if(app()->getLocale() == 'ar' || app()->getLocale() == 'zh')
        <ul class="flex justify-center items-center tab-button gap-2">
            <li class=" item cursor-pointer shadow border {{ $word_type == 'تحية وتعريف' ? 'active' : '' }}">
                <a href="{{ route('mobile.helpWords', 'تحية وتعريف') }}">{{ __('messages.تحية') }}</a>
            </li>
            <li class=" item cursor-pointer shadow border {{ $word_type == 'أسئلة' ? 'active' : '' }}">
                <a href="{{ route('mobile.helpWords', 'أسئلة') }}">{{ __('messages.أسئلة') }}</a>
            </li>
            <li class=" item cursor-pointer shadow border {{ $word_type == 'طلب أو تقديم مساعدة' ? 'active' : '' }}">
                <a href="{{ route('mobile.helpWords', 'طلب أو تقديم مساعدة') }}">{{ __('messages.طلب') }}</a>
            </li>
            <li class=" item cursor-pointer shadow border {{ $word_type == 'السفر' ? 'active' : '' }}">
                <a href="{{ route('mobile.helpWords', 'السفر') }}">{{ __('messages.السفر') }}</a>
            </li>
            <li class=" item cursor-pointer shadow border {{ $word_type == 'التسوق' ? 'active' : '' }}">
                <a href="{{ route('mobile.helpWords', 'التسوق') }}">{{ __('messages.التسوق') }}</a>
            </li>
        </ul>
        @else
        <ul style="flex-direction: column;" class="flex justify-center items-center tab-button gap-2">
            <div style="display: flex; flex-direction: row; align-items: center; justify-content: center; gap: 15px;">

                <li class=" item cursor-pointer shadow border {{ $word_type == 'تحية وتعريف' ? 'active' : '' }}">
                    <a href="{{ route('mobile.helpWords', 'تحية وتعريف') }}">{{ __('messages.تحية') }}</a>
                </li>
                <li class=" item cursor-pointer shadow border {{ $word_type == 'أسئلة' ? 'active' : '' }}">
                    <a href="{{ route('mobile.helpWords', 'أسئلة') }}">{{ __('messages.أسئلة') }}</a>
                </li>
                <li class=" item cursor-pointer shadow border {{ $word_type == 'طلب أو تقديم مساعدة' ? 'active' : '' }}">
                    <a href="{{ route('mobile.helpWords', 'طلب أو تقديم مساعدة') }}">{{ __('messages.طلب') }}</a>
                </li>
            </div>
            <div style="display: flex; flex-direction: row; align-items: center; justify-content: center; gap: 15px;">
                <li class=" item cursor-pointer shadow border {{ $word_type == 'السفر' ? 'active' : '' }}">
                    <a href="{{ route('mobile.helpWords', 'السفر') }}">{{ __('messages.السفر') }}</a>
                </li>
                <li class=" item cursor-pointer shadow border {{ $word_type == 'التسوق' ? 'active' : '' }}">
                    <a href="{{ route('mobile.helpWords', 'التسوق') }}">{{ __('messages.التسوق') }}</a>
                </li>
            </div>
        </ul>
        @endif

    </div>
    <!-- Search Box End -->

    <!-- Words Start -->
    <div class="pt-6 px-2">
        <div class="flex flex-col gap-2 pt-4" id="word-container">
            @if ($helpWords->isEmpty())
            <p class="text-center text-sm text-gray-500">
                <x-empty />
            </p>
            @else
            @foreach ($helpWords as $word)
            <div class="flex justify-between items-center py-3 px-5 rounded-2xl bg-white border border-color21 dark:bg-color11 dark:border-color24"
                data-word-ar="{{ $word->word_ar }}" data-word-en="{{ $word->word_en }}"
                data-word-zh="{{ $word->word_zh }}">
                <div class="flex flex-col justify-start items-center gap-3">
                    @if (in_array(app()->getLocale(), ['ar', 'en']))
                    <p class="font-semibold text-sm">{{ $word->translated_word }}</p>
                    @endif
                    <p class="font-semibold text-sm">{{ $word->word_zh }}</p>
                </div>

                <!-- زر التشغيل -->

                <button type="button" class="play-audio-button" data-audio-id="audio-{{ $word->id }}">
                    <i class="fas fa-volume-up"></i>
                </button>

                <audio id="audio-{{ $word->id }}" hidden>
                    <source src="{{ asset('storage/' . $word->audio_zh) }}" type="audio/ogg">
                    <source src="{{ asset('storage/' . $word->audio_zh) }}" type="audio/mpeg">
                </audio>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
    // 1. الحصول على جميع الأزرار التي تحمل الفئة "play-audio-button"
    var playButtons = document.querySelectorAll('.play-audio-button');

    // 2. المرور على كل زر وربط وظيفة التشغيل به
    playButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // أ. الحصول على المعرّف الفريد للملف الصوتي من سمة البيانات
            var audioId = this.getAttribute('data-audio-id');
            
            // ب. الحصول على عنصر مشغل الصوت المخفي باستخدام المعرّف الفريد
            var audioPlayer = document.getElementById(audioId);

            if (audioPlayer) {
                // ج. إيقاف وإعادة ضبط التشغيل قبل البدء (لتجنب المشاكل)
                audioPlayer.pause();
                audioPlayer.currentTime = 0; 
                
                // د. التشغيل
                audioPlayer.play().catch(error => {
                    console.error("Audio playback failed:", error);
                    // رسالة توضيحية للمستخدم في حال فشل التشغيل التلقائي
                });
            } else {
                console.error("Audio player not found with ID:", audioId);
            }
        });
    });
});
                </script>
            </div>
            @endforeach @endif
        </div>
    </div>
    <!-- Words End -->
</div>

<script>
    let currentAudio = null;
    let currentButton = null;

    // دالة تشغيل الصوت
    function playAudio(audioUrl, text, button) {
        // إيقاف الصوت السابق إذا كان يعمل
        if (currentAudio) {
            currentAudio.pause();
            currentAudio.currentTime = 0;
            if (currentButton) {
                currentButton.classList.remove('playing');
            }
        }

        // إذا كان هناك ملف صوتي محفوظ
        if (audioUrl && audioUrl !== '') {
            currentAudio = new Audio(audioUrl);
            currentButton = button;
            
            button.classList.add('playing');
            
            currentAudio.play().catch(error => {
                console.error('Error playing audio:', error);
                button.classList.remove('playing');
                // إذا فشل التشغيل، استخدم Web Speech API
                speakWithBrowser(text);
            });
            
            currentAudio.onended = function() {
                button.classList.remove('playing');
                currentAudio = null;
                currentButton = null;
            };
        } else {
            // إذا لم يكن هناك ملف صوتي، استخدم Web Speech API
            speakWithBrowser(text);
        }
    }

    // دالة النطق باستخدام المتصفح (احتياطي)
    function speakWithBrowser(text) {
        if ('speechSynthesis' in window) {
            // إيقاف أي نطق سابق
            window.speechSynthesis.cancel();
            
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'zh-CN';
            utterance.rate = 0.9;
            utterance.pitch = 1;
            
            window.speechSynthesis.speak(utterance);
        } else {
            alert('المتصفح لا يدعم تشغيل الصوت');
        }
    }

    // البحث في الكلمات وتفعيل أزرار التشغيل
    document.addEventListener('DOMContentLoaded', function() {
        // تفعيل أزرار التشغيل
        const speakButtons = document.querySelectorAll('.speak-button');
        speakButtons.forEach(button => {
            button.addEventListener('click', function() {
                const audioUrl = this.getAttribute('data-audio');
                const text = this.getAttribute('data-text');
                playAudio(audioUrl, text, this);
            });
        });

        // البحث في الكلمات
        const searchInput = document.getElementById('word-search');
        const wordContainer = document.getElementById('word-container');
        const noResultsMessage = '<p class="text-center text-sm text-gray-500">لا توجد نتائج</p>';

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.trim().toLowerCase();
                const wordItems = wordContainer.querySelectorAll('.flex.justify-between.items-center');
                let hasVisibleItems = false;

                wordItems.forEach(item => {
                    const wordAr = item.getAttribute('data-word-ar').toLowerCase();
                    const wordEn = item.getAttribute('data-word-en').toLowerCase();
                    const wordZh = item.getAttribute('data-word-zh').toLowerCase();

                    if (wordAr.includes(searchTerm) || wordEn.includes(searchTerm) || wordZh.includes(searchTerm)) {
                        item.style.display = 'flex';
                        hasVisibleItems = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // عرض أو إخفاء رسالة "لا توجد نتائج"
                const existingNoResults = wordContainer.querySelector('.no-results');
                if (!hasVisibleItems && searchTerm) {
                    if (!existingNoResults) {
                        const noResultsDiv = document.createElement('div');
                        noResultsDiv.className = 'no-results';
                        noResultsDiv.innerHTML = noResultsMessage;
                        wordContainer.appendChild(noResultsDiv);
                    }
                } else if (existingNoResults) {
                    existingNoResults.remove();
                }
            });
        }
    });
</>
@endsection