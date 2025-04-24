@extends($layout)

@section('content')
<div class="py-4 text-end" style="margin-top: 30px; max-width: 800px; margin-right: auto; margin-left: auto;">
    <h2 class="text-2xl font-bold mb-4">تعديل سؤال</h2>
    <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="question_ar" class="block text-sm font-medium text-gray-700">السؤال (عربي)</label>
            <input type="text" name="question_ar" id="question_ar" value="{{ old('question_ar', $faq->question_ar) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('question_ar') border-red-500 @enderror" required>
            @error('question_ar')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="question_en" class="block text-sm font-medium text-gray-700">السؤال (إنجليزي)</label>
            <input type="text" name="question_en" id="question_en" value="{{ old('question_en', $faq->question_en) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('question_en') border-red-500 @enderror">
            @error('question_en')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="question_zh" class="block text-sm font-medium text-gray-700">السؤال (صيني)</label>
            <input type="text" name="question_zh" id="question_zh" value="{{ old('question_zh', $faq->question_zh) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('question_zh') border-red-500 @enderror">
            @error('question_zh')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="answer_ar" class="block text-sm font-medium text-gray-700">الإجابة (عربي)</label>
            <textarea name="answer_ar" id="answer_ar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('answer_ar') border-red-500 @enderror" required>{{ old('answer_ar', $faq->answer_ar) }}</textarea>
            @error('answer_ar')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="answer_en" class="block text-sm font-medium text-gray-700">الإجابة (إنجليزي)</label>
            <textarea name="answer_en" id="answer_en" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('answer_en') border-red-500 @enderror">{{ old('answer_en', $faq->answer_en) }}</textarea>
            @error('answer_en')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="answer_zh" class="block text-sm font-medium text-gray-700">الإجابة (صيني)</label>
            <textarea name="answer_zh" id="answer_zh" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('answer_zh') border-red-500 @enderror">{{ old('answer_zh', $faq->answer_zh) }}</textarea>
            @error('answer_zh')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">الحالة</label>
            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror" required>
                <option value="نشط" {{ old('status', $faq->status) == 'نشط' ? 'selected' : '' }}>نشط</option>
                <option value="غير نشط" {{ old('status', $faq->status) == 'غير نشط' ? 'selected' : '' }}>غير نشط</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="order" class="block text-sm font-medium text-gray-700">الترتيب</label>
            <input type="number" name="order" id="order" value="{{ old('order', $faq->order) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('order') border-red-500 @enderror" required>
            @error('order')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="text-center">
            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">تحديث</button>
        </div>
    </form>
</div>

<!-- إضافة jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // دالة لتأخير الطلبات (debouncing)
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // دالة الترجمة
        function translateText(inputField, sourceLang, targetLangs, targetFields) {
            const text = inputField.val().trim();
            if (!text) {
                targetFields.forEach(field => field.val(''));
                return;
            }

            $.ajax({
                url: '{{ route('translate') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    text: text,
                    source_lang: sourceLang,
                    target_langs: targetLangs
                },
                success: function(response) {
                    targetFields[0].val(response[targetLangs[0]] || '');
                    targetFields[1].val(response[targetLangs[1]] || '');
                },
                error: function(xhr) {
                    console.error('Translation failed:', xhr.responseJSON?.error);
                    alert('فشل في الترجمة، حاول مرة أخرى لاحقًا.');
                }
            });
        }

        // مراقبة التغييرات في الحقول مع تأخير
        const debouncedTranslate = debounce(translateText, 500);

        // ترجمة السؤال
        $('#question_ar').on('input', function() {
            debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#question_en'), $('#question_zh')]);
        });

        $('#question_en').on('input', function() {
            debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#question_ar'), $('#question_zh')]);
        });

        $('#question_zh').on('input', function() {
            debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#question_ar'), $('#question_en')]);
        });

        // ترجمة الإجابة
        $('#answer_ar').on('input', function() {
            debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#answer_en'), $('#answer_zh')]);
        });

        $('#answer_en').on('input', function() {
            debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#answer_ar'), $('#answer_zh')]);
        });

        $('#answer_zh').on('input', function() {
            debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#answer_ar'), $('#answer_en')]);
        });
    });
</script>
@endsection