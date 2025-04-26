@extends('layouts.appOmdahome')

@section('content')
    <div class="help-container">
        <h2 class="help-title">كلمات مساعدة</h2>

        {{-- حقل البحث --}}
        <div class="search-container"
            style="margin-bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <input type="text" id="searchInput" onkeyup="searchWords()" placeholder="ابحث عن كلمة..."
                style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 80%; max-width: 400px; text-align: right;">
            {{-- لو عايز زر بحث منفصل --}}
            {{-- <button onclick="searchWords()" style="padding: 10px 15px; background-color: #071739; color: white; border: none; border-radius: 5px; margin-right: 10px; cursor: pointer;">بحث</button> --}}
        </div>

        <div class="help-list" id="helpList">
            @foreach ($help_words as $index => $faq)
                <div class="help-item">
                    <h3 class="help-word"> <span style="font-weight: bold; color: red;">بالعربية</span> <br />
                        {{ $faq->word_ar }} </h3>
                    <h3 class="help-word"> <span style="font-weight: bold; color: red;">بالإنجليزية</span> <br />
                        {{ $faq->word_en }} </h3>
                    <h3 class="help-word">
                        <span style="font-weight: bold; color: red;">بالصينية</span> <br /> {{ $faq->word_zh }}
                        @if ($faq->word_zh)
                            <svg class="text-blue-600 speak-btn" data-text="{{ $faq->word_zh }}" title="تشغيل النطق"
                                style="width: 24px; height: 24px; margin: auto; cursor: pointer; color: #1e40af;"
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
margin: 3rem auto;
    padding: 0 1rem;        }

        .help-title {
            text-align: center;
            font-size: 1.75rem;
            font-weight: bold;
            color: #071739;
            margin-bottom: 2rem;
        }

        .help-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            width: 1015px;
            gap: 20px;
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
        function searchWords() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const helpList = document.getElementById('helpList');
            const helpItems = helpList.getElementsByClassName('help-item');

            for (let i = 0; i < helpItems.length; i++) {
                const wordAr = helpItems[i].querySelector('.help-word:nth-child(1)').textContent.toUpperCase();
                const wordEn = helpItems[i].querySelector('.help-word:nth-child(2)').textContent.toUpperCase();
                const wordZh = helpItems[i].querySelector('.help-word:nth-child(3)').textContent.toUpperCase();

                if (wordAr.includes(filter) || wordEn.includes(filter) || wordZh.includes(filter)) {
                    helpItems[i].style.display = "";
                } else {
                    helpItems[i].style.display = "none";
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // ... كود النطق الصوتي اللي كان موجود ...

            // تحميل الأصوات (قد يتطلب بعض المتصفحات تحميل الأصوات أولاً)
            window.speechSynthesis.onvoiceschanged = function() {
                const voices = window.speechSynthesis.getVoices();
                console.log('الأصوات المتاحة:', voices);
            };
        });
    </script>
@endsection
