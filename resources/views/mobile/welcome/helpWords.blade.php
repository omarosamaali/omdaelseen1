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
</style>

<body class="relative -z-20">
    <x-china-header :title="__('messages.الكلمات')" :route="route('mobile.welcome')" />
    <div class="container min-h-dvh relative overflow-hidden py-8 dark:text-white -z-10 dark:bg-color1">
        <p class="text-2xl font-semibold text-center pt-18">{{ __('messages.اضغط لسماع الكلمة') }}</p>
        <div class="faqCategory pt-20">
            <ul class="flex justify-center items-center tab-button gap-2">
                <li class=" item cursor-pointer shadow border {{ $word_type == 'تحية وتعريف' ? 'active' : '' }}">
                    <a href="{{ route('mobile.helpWords', 'تحية وتعريف') }}">{{ __('messages.تحية') }}</a>
                </li>
                <li class=" item cursor-pointer shadow border {{ $word_type == 'أسئلة' ? 'active' : '' }}">
                    <a href="{{ route('mobile.helpWords', 'أسئلة') }}">{{ __('messages.أسئلة') }}</a>
                </li>
                <li
                    class=" item cursor-pointer shadow border {{ $word_type == 'طلب أو تقديم مساعدة' ? 'active' : '' }}">
                    <a href="{{ route('mobile.helpWords', 'طلب أو تقديم مساعدة') }}">{{ __('messages.طلب') }}</a>
                </li>
                <li class=" item cursor-pointer shadow border {{ $word_type == 'السفر' ? 'active' : '' }}">
                    <a href="{{ route('mobile.helpWords', 'السفر') }}">{{ __('messages.السفر') }}</a>
                </li>
                <li class=" item cursor-pointer shadow border {{ $word_type == 'التسوق' ? 'active' : '' }}">
                    <a href="{{ route('mobile.helpWords', 'التسوق') }}">{{ __('messages.التسوق') }}</a>
                </li>
            </ul>
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
                    <button onclick="speakWord('{{ $word->word_zh }}')" style="background-color: black; height: 38px;"
                        class="flex justify-center items-center p-2 rounded-full border border-color16 !leading-none text-white text-p2 speak-button"
                        data-speak-text="{{ $word->word_zh }}">
                        <i class="fa-solid fa-head-side-cough"></i>
                    </button>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <!-- Words End -->
    </div>
    </div>
    <script>
        function speakWord(text) {
        if (!text) return;

        // وقف أي صوت شغال قبل ما يبدأ الجديد
        speechSynthesis.cancel();

        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'zh-CN';
        utterance.rate = 1.0;

        // اختيار صوت صيني لو متاح
        const voices = speechSynthesis.getVoices();
        const chineseVoice = voices.find(voice => voice.lang === 'zh-CN');
        if (chineseVoice) {
            utterance.voice = chineseVoice;
        }

        speechSynthesis.speak(utterance);
    }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                // Search functionality
                const searchInput = document.getElementById('word-search');
                const wordContainer = document.getElementById('word-container');
                const noResultsMessage =
                    '<p class="text-center text-sm text-gray-500"><x-empty /></p>';

                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.trim().toLowerCase();
                    const wordItems = wordContainer.querySelectorAll('.flex.justify-between.items-center');
                    let hasVisibleItems = false;

                    wordItems.forEach(item => {
                        const wordAr = item.getAttribute('data-word-ar').toLowerCase();
                        const wordEn = item.getAttribute('data-word-en').toLowerCase();
                        const wordZh = item.getAttribute('data-word-zh').toLowerCase();

                        if (wordAr.includes(searchTerm) || wordEn.includes(searchTerm) || wordZh
                            .includes(searchTerm)) {
                            item.style.display = 'flex';
                            hasVisibleItems = true;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Show or hide "no results" message
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

                // Text-to-Speech functionality
                const speakButtons = document.querySelectorAll('.speak-button');
                speakButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const text = this.getAttribute('data-speak-text');
                        if (text) {
const utterance = new SpeechSynthesisUtterance(text);
utterance.lang = 'zh-CN';

const voices = speechSynthesis.getVoices();
const chineseVoice = voices.find(voice => voice.lang === 'zh-CN');
if (chineseVoice) {
utterance.voice = chineseVoice;
}

speechSynthesis.speak(utterance);                        }
                    });
                });
            });
    </script>
    <script src="{{ asset('assets/assets/js/faq.js') }}"></script>
    <script defer src="{{ asset('assets/assets/js/index.js') }}"></script>
</body>
@endsection