@extends($layout)

@section('content')
<div class="py-4 text-end" style="margin-top: 30px; max-width: 800px; margin-right: auto; margin-left: auto;">
    <h2 class="text-2xl font-bold mb-4" style="text-align: right;">تفاصيل الإهتمام</h2>
    <div class="bg-white p-6 rounded-lg shadow-md" style="text-align: right;">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">المستخدم:</label>
            <p class="mt-1 text-gray-900">{{ $userInterest->user->name ?? 'غير معروف' }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">القسم:</label>
            <p class="mt-1 text-gray-900">{{ $userInterest->interest_type_name }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">العنصر:</label>
            <p class="mt-1 text-gray-900">
                    {{ $userInterest->interest->title_ar ?? $userInterest->interest->word_ar ?? 'غير معروف' }}
         
            </p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">تاريخ الإضافة:</label>
            <p class="mt-1 text-gray-900">{{ $userInterest->created_at->format('Y-m-d H:i') }}</p>
        </div>
        <div class="text-center">
            <a href="{{ route('admin.user_interests.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md">رجوع</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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