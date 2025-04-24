@extends($layout)

@section('content')
<h2 class="text-right mb-4 font-bold text-xl" style="display: flex; margin-top: 50px; margin-right: 50px;">إضافة بنر</h2>
<div style="display: flex; flex-direction: row-reverse; position: relative; z-index: 1;">
    <div class="container py-4 mx-auto max-w-4xl" style="position: relative; right: -50px; background: white; border-radius: 10px; padding: 20px;">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title_ar" class="block text-sm font-medium text-gray-700">العنوان (عربي)</label>
                <input type="text" name="title_ar" id="title_ar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('title_ar') border-red-500 @enderror" value="{{ old('title_ar') }}">
                @error('title_ar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="title_en" class="block text-sm font-medium text-gray-700">العنوان (إنجليزي)</label>
                <input type="text" name="title_en" id="title_en" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('title_en') border-red-500 @enderror" value="{{ old('title_en') }}">
                @error('title_en')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="title_zh" class="block text-sm font-medium text-gray-700">العنوان (صيني)</label>
                <input type="text" name="title_zh" id="title_zh" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('title_zh') border-red-500 @enderror" value="{{ old('title_zh') }}">
                @error('title_zh')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700">موقع البنر</label>
                <select name="location" id="location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('location') border-red-500 @enderror" required>
                    <option value="website_home" {{ old('location') == 'website_home' ? 'selected' : '' }}>الصفحة الرئيسية للموقع</option>
                    <option value="mobile_app" {{ old('location') == 'mobile_app' ? 'selected' : '' }}>تطبيق الهاتف</option>
                    <option value="both" {{ old('location') == 'both' ? 'selected' : '' }}>كلاهما</option>
                </select>
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="avatar" class="block text-sm font-medium text-gray-700">صورة البنر</label>
                <input type="file" name="avatar" id="avatar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('avatar') border-red-500 @enderror">
                @error('avatar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="is_active" class="block text-sm font-medium text-gray-700">الحالة</label>
                <select name="is_active" id="is_active" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('is_active') border-red-500 @enderror" required>
                    <option value="نشط" {{ old('is_active') == 'نشط' ? 'selected' : '' }}>نشط</option>
                    <option value="غير نشط" {{ old('is_active') == 'غير نشط' ? 'selected' : '' }}>غير نشط</option>
                </select>
                @error('is_active')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">تاريخ البدء</label>
                <input type="datetime-local" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('start_date') border-red-500 @enderror" value="{{ old('start_date') }}">
                @error('start_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">تاريخ الانتهاء</label>
                <input type="datetime-local" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('end_date') border-red-500 @enderror" value="{{ old('end_date') }}">
                @error('end_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">إضافة البنر</button>
            </div>
        </form>
    </div>
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

        $('#title_ar').on('input', function() {
            debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#title_en'), $('#title_zh')]);
        });

        $('#title_en').on('input', function() {
            debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#title_ar'), $('#title_zh')]);
        });

        $('#title_zh').on('input', function() {
            debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#title_ar'), $('#title_en')]);
        });
    });
</script>
@endsection