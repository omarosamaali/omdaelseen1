@extends($layout)

@section('content')
    <div class="py-4 text-end" style="margin-top: 30px; max-width: 800px; margin-right: auto; margin-left: auto;">
        <h2 class="text-right text-2xl font-bold mb-4">إضافة فعالية جديدة</h2>
        <form action="{{ route('admin.faq.store') }}" method="POST">
            @csrf
            <div class="mb-4 text-right">
                <label for="parent_id" class="block text-gray-700 font-bold mb-2">التاريخ
                    *</label>
                <select name="sub_category_id" id="parent_id" class="w-full border-gray-300 rounded-md shadow-sm text-right">
                    <option disabled selected>اختر</option>
                    <option value="1">1-1-2025</option>
                    <option value="2">21-1-2025</option>
                </select>
                @error('parent_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 text-right">
                <label for="parent_id" class="block text-gray-700 font-bold mb-2">الفترة
                    *</label>
                <select name="sub_category_id" id="parent_id"
                    class="w-full border-gray-300 rounded-md shadow-sm text-right">
                    <option disabled selected>اختر</option>
                    <option value="1">الصباح</option>
                    <option value="2">الظهر</option>
                    <option value="3">المساء</option>
                </select>
                @error('parent_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 text-right">
                <label for="parent_id" class="block text-gray-700 font-bold mb-2">نوع الفعالية
                    *</label>
                <select name="sub_category_id" id="parent_id"
                    class="w-full border-gray-300 rounded-md shadow-sm text-right">
                    <option disabled selected>اختر</option>
                    <option value="1">من الأماكن</option>
                    <option value="2">جديد</option>
                </select>
                @error('parent_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            {{-- اذا اختار من الأماكن يظهر جميع الأماكن الذي أدخلها ليختار منها مكان --}}
            <div class="mb-4 text-right">
                <label for="parent_id" class="block text-gray-700 font-bold mb-2">اختر المكان
                    *</label>
                <select name="sub_category_id" id="parent_id"
                    class="w-full border-gray-300 rounded-md shadow-sm text-right">
                    <option disabled selected>اختر</option>
                    <option value="1">فندق</option>
                    <option value="2">مطعم</option>
                </select>
                @error('parent_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- ليكتب اسم المكان ويتم ترجمته يظهر عند اختيار جديد --}}
            <div class="mb-4 text-right">
                <label for="name_ar" class="block text-gray-700 font-bold mb-2">الفعالية بالعربي *</label>
                <input type="text" name="name_ar" id="name_ar" value="{{ old('name_ar') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                @error('name_ar')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 text-right">
                <label for="name_en" class="block text-gray-700 font-bold mb-2">الفعالية بالإنجليزي
                    *</label>
                <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm" required>
                @error('name_en')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 text-right">
                <label for="name_ch" class="block text-gray-700 font-bold mb-2">الفعالية بالصيني *</label>
                <input type="text" name="name_ch" id="name_ch" value="{{ old('name_ch') }}"
                    class="w-full border-gray-300 rounded-md shadow-sm" required>
                @error('name_ch')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 text-right">الحالة</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required>
                    <option value="نشط">نشط</option>
                    <option value="غير نشط">غير نشط</option>
                </select>
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

            // ترجمة الفعالية
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
