@extends('layouts.appOmdahome')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* أضف هذا للأنماط الموجودة */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background-color: #071739;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            z-index: 1000;
            font-size: 16px;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.3s, transform 0.3s;
        }

        .notification.success {
            background-color: #4CAF50;
        }

        .notification.error {
            background-color: #f44336;
        }

        .notification-icon {
            margin-left: 10px;
            font-size: 20px;
        }

        .notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* أسلوب زر مشاهدة الجميع */
        .view-all-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #071739;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            margin: 10px auto;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .view-all-btn:hover {
            background-color: #1e40af;
        }
    </style>
    <div class="help-container">
        <h2 class="help-title">كلمات مساعدة</h2>

        {{-- حقل البحث --}}
        <div class="search-container"
            style="margin-bottom: 20px; display: flex; justify-content: center; align-items: center;">
            <input type="text" id="searchInput" onkeyup="searchWords()" placeholder="ابحث عن كلمة..."
                style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 80%; max-width: 400px; text-align: right;">
        </div>

        {{-- زر مشاهدة الجميع (يظهر فقط إذا كان هناك interest_id) --}}
        @if (request()->query('interest_id'))
            <div style="text-align: center; margin-bottom: 20px;">
                <a href="{{ route('help_words.index') }}" class="view-all-btn">مشاهدة الجميع</a>
            </div>
        @endif

        <div class="help-list" id="helpList">
            @php
                // Get the interest_id from the URL
                $interestId = request()->query('interest_id');

                // Filter $help_words based on interest_id if it exists
                if ($interestId) {
                    $filteredHelpWords = $help_words->where('id', $interestId);
                } else {
                    $filteredHelpWords = $help_words;
                }
            @endphp

            @if ($filteredHelpWords->isEmpty())
                <p style="text-align: center; color: #071739;">لم يتم العثور على كلمات مساعدة مطابقة.</p>
            @else
                @foreach ($filteredHelpWords as $index => $faq)
                    <div class="help-item">
                        {{-- {{ $faq->id }} --}}
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
                                        d="M5 8a1 1 0 0 1 1 1v3a4.006 4.006 0 0 0 4 4h4a4.006 4.006 0 0 0 4-4V9a1 1 0 1 1 2 0v3.001A6.006 6.006 0 0 1 14.001 18H13v2h2a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2h2v-2H9.999A6.006 6.006 0 0 1 4 12.001V9a1 1 0 1 1 1-1Z"
                                        clip-rule="evenodd" />
                                    <path d="M7 6a4 4 0 0 1 4-4h2a4 4 0 0 1 4 4v5a4 4 0 0 1-4 4h-2a4 4 0 0 1-4-4V6Z" />
                                </svg>
                            @endif
                        </h3>
                                                     <style>
                                .add-interest-btn {
                                    font-weight: bold;
                                    background-color: rgb(255, 255, 255);
                                    padding: 3px;
                                    width: 54px;
                                    position: relative;
                                    height: 53px;
                                    border-radius: 6px;
                                    /* top: -138px;
                                    right: 8px; */
                                    color: white;
                                    text-align: center;
                                    display: flex;
                                    align-items: center;
                                    box-shadow: 0px 0px 7px #c4c4c4;
                                    justify-content: center;
                                    overflow: hidden;
                                    /* Ensures the pseudo-element stays within bounds */
                                    transition: color 0.2s ease-in-out;
                                    /* Smooth text/icon color transition */
                                }

                                .add-interest-btn svg {
                                    /* fill: #B11023; */
                                    position: relative;
                                    z-index: 1;
                                    /* transition: fill 0.2s ease-in-out; */
                                }

                                .add-interest-btn::before {
                                    content: '';
                                    position: absolute;
                                    bottom: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 0;
                                    /* Start with no height */
                                    background-color: #B11023;
                                    z-index: 0;
                                    transition: height 0.2s ease-in-out;
                                    /* Animate height */
                                }

                                .add-interest-btn:hover::before {
                                    height: 100%;
                                    /* Expand to full height on hover */
                                }

                                .add-interest-btn:hover {
                                    color: white;
                                    /* Ensure text/icon color changes */
                                }

                                .add-interest-btn:hover svg {
                                    /* fill: white; */
                                }

                                .add-interest-btn:hover i.fa-heart {
                                    /* border: 2px solid white !important; */
                                    padding: 2px !important;
                                    border-radius: 50% !important;
                                    z-index: 99999999999999999999999999999999;
                                    color: white !important;
                                    /* إذا كنت تريد تغيير اللون أيضًا */
                                }

                                /* يمكنك أيضًا تعديل لون الأيقونة نفسها عند الهوفر إذا أردت */
                                .add-interest-btn:hover i.fa-heart {
                                    color: white !important;
                                    fill: #B11023 !important;
                                    /* مثال لتغيير لون الأيقونة إلى الأبيض عند الهوفر */
                                }
                            </style>

                        <button class="add-interest-btn" data-interest-type="help_word"
                            data-interest-id="{{ $faq->id }}"
                            >
                            <i class="fa-regular fa-heart" style="color: #B11023;"></i>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicialización única de todos los elementos
            initSpeakButtons();
            initAddInterestButtons();

            // Inicializar botones de habla
            function initSpeakButtons() {
                const speakButtons = document.querySelectorAll('.speak-btn');
                speakButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const text = this.getAttribute('data-text');
                        if (text) {
                            const utterance = new SpeechSynthesisUtterance(text);
                            utterance.lang = 'zh-CN';
                            utterance.volume = 1;
                            utterance.rate = 1;
                            utterance.pitch = 1;
                            window.speechSynthesis.speak(utterance);
                        }
                    });
                });
            }

            // Inicializar botones de interés
function initAddInterestButtons() {
    const addInterestButtons = document.querySelectorAll('.add-interest-btn');
    addInterestButtons.forEach(button => {
        const interestId = button.getAttribute('data-interest-id');
        const heartIcon = button.querySelector('i'); // احصل على عنصر الأيقونة داخل الزر

        // فحص حالة الإضافة عند تحميل الصفحة (إذا كنت تنفذ هذه الميزة)
        fetch(`/api/user-interests/check?interest_type=help_word&interest_id=${interestId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.is_added) {
                button.classList.add('added'); // يمكنك استخدام هذا الكلاس لتغيير الألوان
                if (heartIcon) {
                    heartIcon.classList.remove('fa-regular', 'fa-heart');
                    heartIcon.classList.add('fa-solid', 'fa-heart');
                }
            } else {
                button.classList.remove('added');
                if (heartIcon) {
                    heartIcon.classList.remove('fa-solid', 'fa-heart');
                    heartIcon.classList.add('fa-regular', 'fa-heart');
                }
            }
        })
        .catch(error => {
            console.error('Error checking interest:', error);
        });

        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const interestType = this.getAttribute('data-interest-type');
            const interestId = this.getAttribute('data-interest-id');
            const btn = this;
            const heartIcon = this.querySelector('i'); // احصل على عنصر الأيقونة عند النقر

            btn.disabled = true;

            const method = btn.classList.contains('added') ? 'DELETE' : 'POST';
            const url = btn.classList.contains('added') ? `/api/user-interests/${interestType}/${interestId}` : '/api/user-interests';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: method === 'POST' ? JSON.stringify({
                    interest_type: interestType,
                    interest_id: interestId
                }) : null
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const isAddedNow = method === 'POST';
                    showNotification(isAddedNow ? 'تم إضافة الكلمة إلى اهتماماتك بنجاح!' : 'تم إزالة الكلمة من اهتماماتك بنجاح!', 'success');
                    btn.disabled = false;

                    if (heartIcon) {
                        heartIcon.classList.toggle('fa-regular');
                        heartIcon.classList.toggle('fa-solid');
                    }
                    btn.classList.toggle('added');
                    btn.style.backgroundColor = isAddedNow ? '#ccc' : 'rgb(54, 148, 0)';
                    btn.textContent = ''; // امسح النص السابق إذا كان موجودًا
                } else {
                    showNotification(data.message || 'فشل تعديل الإهتمام', 'error');
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ أثناء تعديل الإهتمام.', 'error');
                btn.disabled = false;
            });
        });
    });
}
            // Función para mostrar notificaciones (sin cambios)
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;

                const icon = document.createElement('span');
                icon.className = 'notification-icon';
                icon.textContent = type === 'success' ? '✓' : '✗';

                const text = document.createElement('span');
                text.textContent = message;

                notification.appendChild(icon);
                notification.appendChild(text);

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.add('show');
                }, 10);

                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }
        });

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
            window.speechSynthesis.onvoiceschanged = function() {
                const voices = window.speechSynthesis.getVoices();
                console.log('الأصوات المتاحة:', voices);
            };
        });
    </script>

    <style>
        .help-container {
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
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            width: 1015px;
            gap: 20px;
        }

        .help-item {
            border-radius: 0.5rem;
            padding: 1.5rem;
            border: 1px solid red;
            background: #ffffff;
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
@endsection
