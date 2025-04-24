@extends($layout)

@section('content')
<div class="py-4 text-end" style="margin-top: 30px; max-width: 800px; margin-right: auto; margin-left: auto;">
    <h2 class="text-2xl font-bold mb-4">تعديل كلمة مساعدة</h2>
    <form action="{{ route('admin.help_words.update', $helpWord->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="word_ar" class="block text-sm font-medium text-gray-700">الكلمة (عربي)</label>
            <input type="text" name="word_ar" id="word_ar" value="{{ old('word_ar', $helpWord->word_ar) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('word_ar') border-red-500 @enderror" required>
            @error('word_ar')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="word_en" class="block text-sm font-medium text-gray-700">الكلمة (إنجليزي)</label>
            <input type="text" name="word_en" id="word_en" value="{{ old('word_en', $helpWord->word_en) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('word_en') border-red-500 @enderror">
            @error('word_en')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="word_zh" class="block text-sm font-medium text-gray-700">الكلمة (صيني)</label>
            <input type="text" name="word_zh" id="word_zh" value="{{ old('word_zh', $helpWord->word_zh) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('word_zh') border-red-500 @enderror">
            @error('word_zh')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">الحالة</label>
            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror" required>
                <option value="نشط" {{ old('status', $helpWord->status) == 'نشط' ? 'selected' : '' }}>نشط</option>
                <option value="غير نشط" {{ old('status', $helpWord->status) == 'غير نشط' ? 'selected' : '' }}>غير نشط</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="order" class="block text-sm font-medium text-gray-700">الترتيب</label>
            <input type="number" name="order" id="order" value="{{ old('order', $helpWord->order) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('order') border-red-500 @enderror" required>
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

        // ترجمة الكلمة
        $('#word_ar').on('input', function() {
            debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#word_en'), $('#word_zh')]);
        });

        $('#word_en').on('input', function() {
            debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#word_ar'), $('#word_zh')]);
        });

        $('#word_zh').on('input', function() {
            debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#word_ar'), $('#word_en')]);
        });
    });
</script>
@endsection