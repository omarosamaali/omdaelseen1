@extends($layout)

@section('content')
    <style>
        .th {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
            text-align: right;
        }

        .speak-btn {
            cursor: pointer;
            margin-right: 10px;
        }
    </style>

    <div class="py-4 text-end" style="margin-top: 30px;">
        <div style="">
            <div style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
                <a href="{{ route('admin.help_words.create') }}" class=""
                    style="background: black; color: white; padding: 10px 20px; border-radius: 5px; margin: 15px 0px; margin-left: 20px;">إضافة
                    كلمة</a>
                <div
                    style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
                    <p>كلمات المساعدة</p>
                    <div class="custom-select" style="position: relative; width: fit-content;">
                        <div style="position: relative;">
                            <span
                                style="position: absolute; top: 50%; transform: translateY(-50%); right: 0.75rem; color: #9ca3af; pointer-events: none;">
                                <svg style="width: 20px; color:rgb(129, 126, 126);" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                </svg>
                            </span>
                            <input aria-autocomplete="off" autocomplete="off" type="text" id="word_search"
                                name="word_search"
                                style="text-align: right; width: 100%; padding: 0.5rem 2.5rem 0.5rem 0.5rem; border: 1px solid #d1d5db; border-radius: 30px; background-color: transparent;"
                                placeholder="بحث" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
                <table id="words_table" class="w-full text-sm text-left rtl:text-right text-gray-500"
                    style="background: #c9c9c9;">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="th">الرقم</th>
                            <th scope="col" class="th">نوع الكلمة</th>
                            <th scope="col" class="th">الكلمة (عربي)</th>
                            <th scope="col" class="th">الكلمة (إنجليزي)</th>
                            <th scope="col" class="th">الكلمة (صيني)</th>
                            <th scope="col" class="th">الترتيب</th>
                            <th scope="col" class="th">الحالة</th>
                            <th scope="col" class="th">أجراءات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($helpWords as $word)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                @php
                                    if (!isset($counter)) {
                                        $counter = 1;
                                    }
                                @endphp
                                <td class="th">{{ $counter }}</td>
                                <td class="th">{{ $word->word_type }}</td>
                                <td class="th">{{ $word->order }}</td>
                                @php $counter++; @endphp
                                <td class="th">{{ Str::limit($word->word_ar, 30) }}</td>
                                <td class="th">{{ Str::limit($word->word_en, 30) }}</td>
                                <td class="th" style="display: flex; align-items: center;">
                                    {{ Str::limit($word->word_zh, 30) }}
                                    @if ($word->word_zh)
                                        <svg class="text-blue-600 speak-btn" data-text="{{ $word->word_zh }}"
                                            title="تشغيل النطق" class="w-6 h-6 text-gray-800" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M5 8a1 1 0 0 1 1 1v3a4.006 4.006 0 0 0 4 4h4a4.006 4.006 0 0 0 4-4V9a1 1 0 1 1 2 0v3.001A6.006 6.006 0 0 1 14.001 18H13v2h2a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2h2v-2H9.999A6.006 6.006 0 0 1 4 12.001V9a1 1 0 0 1 1-1Z"
                                                clip-rule="evenodd" />
                                            <path
                                                d="M7 6a4 4 0 0 1 4-4h2a4 4 0 0 1 4 4v5a4 4 0 0 1-4 4h-2a4 4 0 0 1-4-4V6Z" />
                                        </svg>
                                    @endif
                                </td>
                                <td class="th">{{ $word->order }}</td>
                                <td class="th">
                                    @if ($word->status == 'نشط')
                                        <span class="text-green-600">نشط</span>
                                    @else
                                        <span class="text-red-600">غير نشط</span>
                                    @endif
                                </td>
                                <td class="th" style="display: flex;">
                                    <a href="{{ route('admin.help_words.edit', $word->id) }}"
                                        class="font-medium text-blue-600">
                                        <svg class="w-6 h-6 text-blue-600" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.help_words.destroy', $word->id) }}"
                                        onclick="return confirm('هل أنت متأكد من حذف هذا؟')" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600">
                                            <svg class="w-6 h-6 text-red-600" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // البحث في الجدول
                const searchInput = document.getElementById('word_search');
                const table = document.getElementById('words_table');
                const rows = table.querySelectorAll('tbody tr');

                searchInput.addEventListener('input', function() {
                    const term = this.value.trim().toLowerCase();
                    rows.forEach(row => {
                        const wordArCell = row.querySelectorAll('td')[1]; // الكلمة بالعربية
                        if (!wordArCell) return;

                        const wordAr = wordArCell.innerText.trim().toLowerCase();

                        if (wordAr.includes(term) || term === '') {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });

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
                                // console.error('خطأ في النطق:', event.error);
                                // alert('فشل تشغيل النطق. تأكد من تثبيت أصوات اللغة الصينية.');
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
    </div>
@endsection
