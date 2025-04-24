@extends($layout)

@section('content')
    <div style="display: flex; flex-direction: row-reverse; margin-right: 77px !important; position: relative; margin: 0px 20px; z-index: 9999999999999;">
        <div class="container py-4 mx-auto max-w-4xl" style="position: relative; right: -50px; margin-top: 100px; background: white; border-radius: 10px; padding: 20px;">
            <h2 class="text-right mb-4 font-bold text-xl">إضافة منطقة</h2>
            <form action="{{ route('admin.regions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">الإسم بالعربي</label>
                        <input type="text" id="name_ar" name="name_ar" class="input-field @error('name_ar') border-red-500 @enderror" value="{{ old('name_ar') }}" required>
                        @error('name_ar')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">الإسم بالإنجليزي</label>
                        <input type="text" id="name_en" name="name_en" class="input-field @error('name_en') border-red-500 @enderror" value="{{ old('name_en') }}" required>
                        @error('name_en')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">الإسم بالصيني</label>
                        <input type="text" id="name_ch" name="name_ch" class="input-field @error('name_ch') border-red-500 @enderror" value="{{ old('name_ch') }}" required>
                        @error('name_ch')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">الحالة</label>
                        <select name="status" style="direction: ltr;" class="input-field @error('status') border-red-500 @enderror rtl-select">
                            <option>اختر</option>
                            <option value="نشط" {{ old('status') == 'نشط' ? 'selected' : '' }}>نشط</option>
                            <option value="غير نشط" {{ old('status') == 'غير نشط' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الصورة الشخصية</label>
                    <input type="file" name="avatar" class="input-field @error('avatar') border-red-500 @enderror">
                    @error('avatar')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-dark px-4 py-2 mt-4 bg-black text-white rounded-md">إضافة</button>
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

            $('#name_ar').on('input', function() {
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#name_en'), $('#name_ch')]);
            });

            $('#name_en').on('input', function() {
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#name_ar'), $('#name_ch')]);
            });

            $('#name_ch').on('input', function() {
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#name_ar'), $('#name_en')]);
            });
        });
    </script>
@endsection