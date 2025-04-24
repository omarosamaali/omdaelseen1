@extends($layout)

@section('content')
<div class="py-4 text-end" style="margin-top: 30px; max-width: 800px; margin-right: auto; margin-left: auto;">
    <h2 class="text-2xl font-bold mb-4">تفاصيل كلمة المساعدة</h2>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">الكلمة (عربي):</label>
            <p class="mt-1 text-gray-900">{{ $helpWord->word_ar }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">الكلمة (إنجليزي):</label>
            <p class="mt-1 text-gray-900">{{ $helpWord->word_en }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">الكلمة (صيني):</label>
            <p class="mt-1 text-gray-900">
                {{ $helpWord->word_zh }}
                @if($helpWord->word_zh)
                    <span class="speak-btn" data-text="{{ $helpWord->word_zh }}" title="تشغيل النطق" style="cursor: pointer; margin-right: 10px;">
                        <svg class="w-5 h-5 text-blue-600 inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 3a1 1 0 0 1 1 1v6.586l1.707-1.707a1 1 0 0 1 1.414 1.414l-3.414 3.414a1 1 0 0 1-1.414 0L9.879 10.293a1 1 0 0 1 1.414-1.414L13 10.586V4a1 1 0 0 1 1-1z"/>
                            <path d="M5 8a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1zm14 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z"/>
                        </svg>
                    </span>
                @endif
            </p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">الحالة:</label>
            <p class="mt-1 text-gray-900 {{ $helpWord->status == 'نشط' ? 'text-green-600' : 'text-red-600' }}">{{ $helpWord->status }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">الترتيب:</label>
            <p class="mt-1 text-gray-900">{{ $helpWord->order }}</p>
        </div>
        <div class="text-center">
            <a href="{{ route('admin.help_words.edit', $helpWord->id) }}" class="bg-black text-white px-4 py-2 rounded-md">تعديل</a>
            <a href="{{ route('admin.help_words.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md">رجوع</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تشغيل النطق الصوتي للكلمة الصينية
            const speakButton = document.querySelector('.speak-btn');
            if (speakButton) {
                speakButton.addEventListener('click', function() {
                    const text = this.getAttribute('data-text');
                    if (text) {
                        const utterance = new SpeechSynthesisUtterance(text);
                        utterance.lang = 'zh-CN'; // اللغة الصينية
                        utterance.volume = 1;
                        utterance.rate = 1;
                        utterance.pitch = 1;
                        window.speechSynthesis.speak(utterance);
                    }
                });
            }
        });
    </script>
</div>
@endsection