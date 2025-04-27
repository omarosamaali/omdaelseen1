@extends('layouts.appOmdahome')

@section('content')
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
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
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
</style>
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
        <button class="add-interest-btn" data-interest-type="help_word" data-interest-id="{{ $faq->id }}"
            style="font-weight: bold; background-color: rgb(54, 148, 0); padding: 3px; width: 33px; border-radius: 10px; color:white; margin: auto; text-align: center; display: flex; align-items: center; justify-content: center;">
            +
        </button>
    </div>
@endforeach
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
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const interestType = this.getAttribute('data-interest-type');
                const interestId = this.getAttribute('data-interest-id');
                const btn = this;
                
                // Deshabilitar botón para prevenir múltiples clics
                btn.disabled = true;
                
                fetch('/api/user-interests', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        interest_type: interestType,
                        interest_id: interestId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('تم إضافة الكلمة إلى اهتماماتك بنجاح!', 'success');
                        btn.style.backgroundColor = '#ccc';
                        btn.textContent = '✓';
                    } else {
                        showNotification(data.message || 'فشل إضافة الإهتمام', 'error');
                        btn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('حدث خطأ أثناء إضافة الإهتمام.', 'error');
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
</script>

                <script>
document.addEventListener('DOMContentLoaded', function() {
    // Eliminar todos los event listeners anteriores
    const addInterestButtons = document.querySelectorAll('.add-interest-btn');
    addInterestButtons.forEach(button => {
        // Clonar el botón para eliminar todos los event listeners
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
        
        // Añadir el nuevo event listener
        newButton.addEventListener('click', function(e) {
            // Prevenir la propagación del evento
            e.preventDefault();
            e.stopPropagation();
            
            const interestType = this.getAttribute('data-interest-type');
            const interestId = this.getAttribute('data-interest-id');
            const btn = this;

            // Deshabilitar el botón inmediatamente para prevenir clics múltiples
            btn.disabled = true;
            
            fetch('/api/user-interests', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    interest_type: interestType,
                    interest_id: interestId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('تم إضافة الكلمة إلى اهتماماتك بنجاح!', 'success');
                    btn.style.backgroundColor = '#ccc';
                    btn.textContent = '✓';
                } else {
                    showNotification('فشل إضافة الإهتمام: ' + (data.message || 'خطأ غير معروف'), 'error');
                    // Reactivar el botón si hay un error
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ أثناء إضافة الإهتمام.', 'error');
                // Reactivar el botón si hay un error
                btn.disabled = false;
            });
        });
    });
});
                        // Handle add interest buttons
// Handle add interest buttons
const addInterestButtons = document.querySelectorAll('.add-interest-btn');
addInterestButtons.forEach(button => {
    button.addEventListener('click', function() {
        const interestType = this.getAttribute('data-interest-type');
        const interestId = this.getAttribute('data-interest-id');
        const btn = this; // حفظ الزر للاستخدام لاحقاً

        fetch('/api/user-interests', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                // Add Authorization header if using Sanctum
                'Authorization': 'Bearer ' + getAuthToken()
            },
            body: JSON.stringify({
                interest_type: interestType,
                interest_id: interestId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // إظهار رسالة نجاح
                showNotification('تم إضافة الكلمة إلى اهتماماتك بنجاح!', 'success');
                btn.disabled = true; // تعطيل الزر بعد الإضافة
                btn.style.backgroundColor = '#ccc'; // تغيير لون الزر
                btn.textContent = '✓'; // تغيير النص إلى علامة صح
            } else {
                // إظهار رسالة خطأ
                showNotification('فشل إضافة الإهتمام: ' + (data.message || 'خطأ غير معروف'), 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('حدث خطأ أثناء إضافة الإهتمام.', 'error');
        });
    });
});

// دالة لإظهار الإشعارات
function showNotification(message, type = 'success') {
    // إنشاء عنصر الإشعار
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    // إضافة أيقونة حسب نوع الإشعار
    const icon = document.createElement('span');
    icon.className = 'notification-icon';
    icon.textContent = type === 'success' ? '✓' : '✗';
    
    // إضافة نص الرسالة
    const text = document.createElement('span');
    text.textContent = message;
    
    // إضافة العناصر للإشعار
    notification.appendChild(icon);
    notification.appendChild(text);
    
    // إضافة الإشعار للصفحة
    document.body.appendChild(notification);
    
    // إظهار الإشعار بتأثير حركي
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    // إخفاء الإشعار بعد 3 ثوان
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}
                        // Function to get Sanctum token (adjust based on your setup)
                        function getAuthToken() {
                            // Example: Retrieve token from localStorage or a cookie
                            return localStorage.getItem('sanctum_token') || '';
                        }
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
