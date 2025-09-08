@extends('layouts.appOmdahome')

@section('content')
    <div class="help-container">
        <h2 class="help-title">كلمات مساعدة</h2>
        <div class="help-list">
            @foreach ($help_words as $index => $faq)
                <div class="help-item" style="margin: auto; align-items: center; justify-content: center;">
                    <h3 class="help-word"> <span style="font-weight: bold; color: red;">بالعربية</span>
                        <br />
                        {{ $faq->word_ar }}
                    </h3>
                    <h3 class="help-word">
                        <span style="font-weight: bold; color: red;">بالإنجليزية</span>
                        <br />
                        {{ $faq->word_en }}
                    </h3>
                    <h3 class="help-word" style="">
                        <span style="font-weight: bold; color: red;">بالصينية</span>
                        <br />
                        {{ $faq->word_zh }}

                        @if ($faq->word_zh)
                            <svg class="text-blue-600 speak-btn" style="margin: auto; margin-top: 5px;"
                                data-text="{{ $faq->word_zh }}" title="تشغيل النطق"
                                style="width: 24px; height: 24px; margin-right: 10px; cursor: pointer; color: #1e40af;"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M5 8a1 1 0 0 1 1 1v3a4.006 4.006 0 0 0 4 4h4a4.006 4.006 0 0 0 4-4V9a1 1 0 1 1 2 0v3.001A6.006 6.006 0 0 1 14.001 18H13v2h2a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2h2v-2H9.999A6.006 6.006 0 0 1 4 12.001V9a1 1 0 0 1 1-1Z"
                                    clip-rule="evenodd" />
                                <path d="M7 6a4 4 0 0 1 4-4h2a4 4 0 0 1 4 4v5a4 4 0 0 1-4 4h-2a4 4 0 0 1-4-4V6Z" />
                            </svg>
                        @endif
                    </h3>
                    <button
                        style="font-weight: bold; background-color: rgb(54, 148, 0); padding: 3px; width: 33px;
                        border-radius: 10px; color:white; margin: auto; text-align: center; display: flex; align-items: center; justify-content: center;">+</button>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .help-container {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .help-title {
            text-align: center;
            font-size: 1.75rem;
            font-weight: bold;
            color: #071739;
            margin-bottom: 2rem;
        }

        .help-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(153px, 1fr));
            width: 800px;
        }

        .help-item {
            border-radius: 0.5rem;
            padding: 1.5rem;
            border: 1px solid red;
        }

        .help-word {
            font-size: 1.25rem;
            font-weight: 600;
            color: #071739;
            margin-bottom: 0.75rem;
            text-align: center;
        }

        .speak-btn {
            cursor: pointer;
            margin-right: 10px;
            transition: transform 0.2s;
        }

        .speak-btn:hover {
            transform: scale(1.1);
        }

        .help-answer {
            font-size: 1rem;
            color: #4b5563;
            line-height: 1.6;
            text-align: right;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // التحقق من دعم Web Speech API
            if (!('speechSynthesis' in window)) {
                console.error('Web Speech API غير مدعوم في هذا المتصفح.');
                alert('النطق الصوتي غير مدعوم في متصفحك. جرب متصفحًا آخر مثل Chrome أو Edge.');
                return;
            }

            // تشغيل النطق الصوتي للكلمة الصينية
            const speakButtons = document.querySelectorAll('.speak-btn');
            speakButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const text = this.getAttribute('data-text');
                    if (text) {
                        // إلغاء أي نطق سابق
                        window.speechSynthesis.cancel();

                        const utterance = new SpeechSynthesisUtterance(text);
                        utterance.lang = 'zh-CN'; // اللغة الصينية

                        // اختيار صوت صيني إذا كان متاحًا
                        const voices = window.speechSynthesis.getVoices();
                        const chineseVoice = voices.find(voice => voice.lang === 'zh-CN');
                        if (chineseVoice) {
                            utterance.voice = chineseVoice;
                        } else {
                            console.warn(
                                'لا يوجد صوت صيني متاح. تأكد من تثبيت أصوات اللغة الصينية على جهازك.'
                            );
                        }

                        utterance.volume = 1;
                        utterance.rate = 1;
                        utterance.pitch = 1;

                        // تشغيل النطق
                        window.speechSynthesis.speak(utterance);

                        // تسجيل الأخطاء إن وجدت
                        utterance.onerror = function(event) {
                            console.error('خطأ في النطق:', event.error);
                        };
                    }
                });
            });

            // تحميل الأصوات (قد يتطلب بعض المتصفحات تحميل الأصوات أولاً)
            window.speechSynthesis.onvoiceschanged = function() {
                const voices = window.speechSynthesis.getVoices();
                console.log('الأصوات المتاحة:', voices);
            };
        });
    </script>
@endsection
