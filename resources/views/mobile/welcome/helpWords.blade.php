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
    }.audio-player {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f7f7f7;
    border: 1px solid #ddd;
    border-radius: 9999px;
    padding: 6px 12px;
    cursor: pointer;
    width: 100px;
    transition: background 0.2s;
    }
    
    .audio-player:hover {
    background: #eaeaea;
    }
    
    .audio-player .play-icon {
    font-size: 16px;
    }
    
    .audio-player .progress-bar {
    flex-grow: 1;
    height: 4px;
    background: #ddd;
    border-radius: 4px;
    overflow: hidden;
    position: relative;
    }
    
    .audio-player .progress-bar span {
    display: block;
    height: 100%;
    width: 0;
    background: #000;
    border-radius: 4px;
    transition: width 0.2s linear;
    }
</style>

<body class="relative -z-20">
    <x-china-header :title="__('messages.الكلمات')" :route="route('mobile.welcome')" />
    <div style="padding-top: 90px;"  class="container min-h-dvh relative overflow-hidden py-8 dark:text-white -z-10 dark:bg-color1">
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
                <!-- Player Tool -->
                <div class="audio-player" onclick="toggleSpeak(this, '{{ $word->word_zh }}')">
                    <i class="fa-solid fa-play play-icon text-gray-700"></i>
                    <div class="progress-bar"><span></span></div>
                </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <!-- Words End -->
    </div>

    <script>
        let voicesReady = false;
        if (!('speechSynthesis' in window)) {
        alert('النطق غير مدعوم في هذا المتصفح 😔');
        return;
        }
        // تحميل الأصوات أول ما الصفحة تفتح
        function loadVoices() {
            const voices = speechSynthesis.getVoices();
            if (voices.length > 0) {
                voicesReady = true;
                console.log('Available voices:', voices.map(v => v.name + ' (' + v.lang + ')'));
            }
        }
        
        // Firefox محتاج الـ event ده
        speechSynthesis.onvoiceschanged = loadVoices;
        loadVoices();
        
        function speakWord(text) {
            if (!text) return;
            
            // Firefox بيحتاج نوقف الكلام بطريقة مختلفة
            if (speechSynthesis.speaking || speechSynthesis.pending) {
                speechSynthesis.cancel();
                // Firefox محتاج delay أكبر بعد cancel
                setTimeout(() => doSpeak(text), 300);
            } else {
                doSpeak(text);
            }
        }
        
        function doSpeak(text) {
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'zh-CN';
            utterance.rate = 1;
            utterance.volume = 1;
            
            const voices = speechSynthesis.getVoices();
            // Firefox بياخد أول صوت متاح لو مفيش صيني
            const zhVoice = voices.find(v => v.lang.includes('zh')) || voices[0];
            if (zhVoice) {
                utterance.voice = zhVoice;
                console.log('Using:', zhVoice.name);
            }
            
            utterance.onstart = () => console.log('Started speaking');
            utterance.onend = () => console.log('Finished speaking');
            utterance.onerror = (e) => console.error('Speech error:', e);
            
            speechSynthesis.speak(utterance);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('word-search');
            const wordContainer = document.getElementById('word-container');
            const noResultsMessage = `<p class="text-center text-sm text-gray-500"><x-empty /></p>`;

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
            }
        });
    </script>
<script>
    let speaking = false;
let currentEl = null;

function toggleSpeak(el, text) {
    // لو في صوت شغال حالياً
    if (speaking) {
        speechSynthesis.cancel();
        speaking = false;
        if (currentEl) {
            resetPlayer(currentEl);
        }
        return;
    }

    // شغل الصوت الجديد
    const utter = new SpeechSynthesisUtterance(text);
    utter.lang = 'zh-CN';
    utter.rate = 1;
    utter.volume = 1;
    speaking = true;
    currentEl = el;

    // غيّر شكل الزر
    el.querySelector('.play-icon').className = 'fa-solid fa-pause play-icon text-green-600';
    animateProgress(el);

    utter.onend = () => {
        speaking = false;
        resetPlayer(el);
    };

    utter.onerror = () => {
        speaking = false;
        resetPlayer(el);
    };

    speechSynthesis.speak(utter);
}

function resetPlayer(el) {
    if (!el) return;
    el.querySelector('.play-icon').className = 'fa-solid fa-play play-icon text-gray-700';
    el.querySelector('.progress-bar span').style.width = '0%';
}

function animateProgress(el) {
    const bar = el.querySelector('.progress-bar span');
    let width = 0;
    const interval = setInterval(() => {
        if (!speaking || width >= 100) {
            clearInterval(interval);
            bar.style.width = '0%';
            return;
        }
        width += 3;
        bar.style.width = width + '%';
    }, 200);
}
</script>
    <script src="{{ asset('assets/assets/js/faq.js') }}"></script>
    <script defer src="{{ asset('assets/assets/js/index.js') }}"></script>
</body>
@endsection