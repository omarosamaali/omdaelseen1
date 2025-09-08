@extends($layout)

@section('content')
    <div class="py-4 text-end" style="margin-top: 30px; max-width: 800px; margin-right: auto; margin-left: auto;">
        <h2 class="text-right text-2xl font-bold mb-4">إضافة إرشاد جديد</h2>
        <form action="{{ route('admin.omdaHome.trip.trip-store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name_ar" class="block text-sm font-medium text-gray-700 text-right">الإرشاد (عربي)</label>
                <input type="text" name="name_ar" id="name_ar"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="name_en" class="block text-sm font-medium text-gray-700 text-right">الإرشاد (إنجليزي)</label>
                <input type="text" name="name_en" id="name_en"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="name_ch" class="block text-sm font-medium text-gray-700 text-right">الإرشاد (صيني)</label>
                <input type="text" name="name_ch" id="name_ch"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 text-right">الحالة</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    required>
                    <option value="active">نشط</option>
                    <option value="inactive">غير نشط</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="order" class="block text-sm font-medium text-gray-700 text-right">الترتيب</label>
                <input type="number" name="order" id="order"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="0" required>
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

            // ترجمة الميزة
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
