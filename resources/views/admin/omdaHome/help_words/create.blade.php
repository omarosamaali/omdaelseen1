@extends($layout)

@section('content')
<div class="py-4 text-end" style="margin-top: 30px; max-width: 800px; margin-right: auto; margin-left: auto;">
    <h2 class="text-2xl font-bold mb-4">إضافة كلمة مساعدة</h2>
    <form action="{{ route('admin.help_words.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="word_ar" class="block text-sm font-medium text-gray-700">الكلمة (عربي)</label>
            <input type="text" name="word_ar" id="word_ar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('word_ar') border-red-500 @enderror" required>
            @error('word_ar')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="word_en" class="block text-sm font-medium text-gray-700">الكلمة (إنجليزي) - اختياري، سيتم الترجمة تلقائيًا</label>
            <input type="text" name="word_en" id="word_en" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('word_en') border-red-500 @enderror">
            @error('word_en')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
<div class="mb-4">
    <label for="word_zh" class="block text-sm font-medium text-gray-700">الكلمة (صيني) - اختياري، سيتم الترجمة تلقائيًا</label>
    <input type="text" name="word_zh" id="word_zh" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('word_zh') border-red-500 @enderror">
    @error('word_zh')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
    <div id="audio-preview" class="mt-2" style="display: none;">
        <audio id="word_zh_audio_player" controls></audio>
        <input type="hidden" name="word_zh_audio" id="word_zh_audio">
    </div>
</div>        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">الحالة</label>
            <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror" required>
                <option value="نشط">نشط</option>
                <option value="غير نشط">غير نشط</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="order" class="block text-sm font-medium text-gray-700">الترتيب</label>
            <input type="number" name="order" id="order" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('order') border-red-500 @enderror" value="0" required>
            @error('order')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="text-center">
            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">إضافة</button>
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
                $('#audio-preview').hide();
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
                    
                    // بعد الحصول على الترجمة الصينية، قم بإنشاء الصوت
                    if (response[targetLangs[1]]) {
                        generateChineseAudio(response[targetLangs[1]]);
                    }
                },
                error: function(xhr) {
                    console.error('Translation failed:', xhr.responseJSON?.error);
                    alert('فشل في الترجمة، حاول مرة أخرى لاحقًا.');
                }
            });
        }

        // دالة لإنشاء الصوت الصيني
        function generateChineseAudio(chineseText) {
            if (!chineseText) return;
            
            $.ajax({
                url: '{{ route('generate.audio') }}', // سنقوم بإنشاء هذا المسار
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    text: chineseText
                },
                success: function(response) {
                    if (response.audio_path) {
                        // عرض مشغل الصوت
                        $('#audio-preview').show();
                        $('#word_zh_audio_player').attr('src', response.audio_path);
                        $('#word_zh_audio').val(response.audio_path);
                    }
                },
                error: function(xhr) {
                    console.error('Audio generation failed:', xhr.responseJSON?.error);
                }
            });
        }

        // مراقبة التغييرات في الحقول مع تأخير
        const debouncedTranslate = debounce(translateText, 500);

        // ترجمة الكلمة تلقائيًا عند كتابة النص العربي
        $('#word_ar').on('input', function() {
            debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#word_en'), $('#word_zh')]);
        });
    });
</script>@endsection