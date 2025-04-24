@extends($layout)

@section('content')
<h2 class="text-right mb-4 font-bold text-xl" style="display: flex; margin-top: 50px; margin-right: 50px;">إضافة حدث/معرض</h2>
<div style="display: flex; flex-direction: row-reverse; position: relative; z-index: 1;">
    <div class="container py-4 mx-auto max-w-4xl" style="position: relative; right: -50px; background: white; border-radius: 10px; padding: 20px;">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Arabic Fields -->
            <div class="mb-4">
                <label for="title_ar" class="block text-sm font-medium text-gray-700">العنوان (عربي)</label>
                <input type="text" name="title_ar" id="title_ar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('title_ar') border-red-500 @enderror" value="{{ old('title_ar') }}" required>
                @error('title_ar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description_ar" class="block text-sm font-medium text-gray-700">الوصف (عربي)</label>
                <textarea name="description_ar" id="description_ar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('description_ar') border-red-500 @enderror" rows="5" required>{{ old('description_ar') }}</textarea>
                @error('description_ar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- English Fields -->
            <div class="mb-4">
                <label for="title_en" class="block text-sm font-medium text-gray-700">العنوان (إنجليزي)</label>
                <input type="text" name="title_en" id="title_en" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('title_en') border-red-500 @enderror" value="{{ old('title_en') }}">
                @error('title_en')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description_en" class="block text-sm font-medium text-gray-700">الوصف (إنجليزي)</label>
                <textarea name="description_en" id="description_en" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('description_en') border-red-500 @enderror" rows="5">{{ old('description_en') }}</textarea>
                @error('description_en')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Chinese Fields -->
            <div class="mb-4">
                <label for="title_zh" class="block text-sm font-medium text-gray-700">العنوان (صيني)</label>
                <input type="text" name="title_zh" id="title_zh" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('title_zh') border-red-500 @enderror" value="{{ old('title_zh') }}">
                @error('title_zh')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description_zh" class="block text-sm font-medium text-gray-700">الوصف (صيني)</label>
                <textarea name="description_zh" id="description_zh" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('description_zh') border-red-500 @enderror" rows="5">{{ old('description_zh') }}</textarea>
                @error('description_zh')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date Fields -->
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">تاريخ البدء</label>
                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('start_date') border-red-500 @enderror" value="{{ old('start_date') }}" required>
                @error('start_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">تاريخ الانتهاء</label>
                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('end_date') border-red-500 @enderror" value="{{ old('end_date') }}" required>
                @error('end_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type Selection -->
            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">النوع</label>
                <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('type') border-red-500 @enderror" required>
                    <option value="معرض" {{ old('type') == 'معرض' ? 'selected' : '' }}>معرض</option>
                    <option value="مناسبة" {{ old('type') == 'مناسبة' ? 'selected' : '' }}>مناسبة</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Selection -->
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">الحالة</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('status') border-red-500 @enderror" required>
                    <option value="نشط" {{ old('status') == 'نشط' ? 'selected' : '' }}>نشط</option>
                    <option value="غير نشط" {{ old('status') == 'غير نشط' ? 'selected' : '' }}>غير نشط</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label for="avatar" class="block text-sm font-medium text-gray-700">الصورة</label>
                <input type="file" name="avatar" id="avatar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('avatar') border-red-500 @enderror">
                @error('avatar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">إضافة الحدث/المعرض</button>
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
                    targetFields.forEach((field, index) => {
                        field.val(response[targetLangs[index]] || '');
                    });
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

        $('#description_ar').on('input', function() {
            debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#description_en'), $('#description_zh')]);
        });

        $('#description_en').on('input', function() {
            debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#description_ar'), $('#description_zh')]);
        });

        $('#description_zh').on('input', function() {
            debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#description_ar'), $('#description_en')]);
        });

        $('#address_ar').on('input', function() {
            debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#address_en'), $('#address_zh')]);
        });

        $('#address_en').on('input', function() {
            debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#address_ar'), $('#address_zh')]);
        });

        $('#address_zh').on('input', function() {
            debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#address_ar'), $('#address_en')]);
        });
    });
</script>
@endsection