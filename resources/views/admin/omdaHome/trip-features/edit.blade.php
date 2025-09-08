@extends($layout)

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">تعديل الإرشاد</h1>

        <form action="{{ route('admin.omdaHome.trip.trip-update', $tripFeature->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name_ar" class="block text-sm font-medium text-gray-700 text-right">الإرشاد (عربي)</label>
                <input type="text" name="name_ar" id="name_ar" value="{{ old('name_ar', $tripFeature->name_ar) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('name_ar')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name_en" class="block text-sm font-medium text-gray-700 text-right">الإرشاد (إنجليزي)</label>
                <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $tripFeature->name_en) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('name_en')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name_ch" class="block text-sm font-medium text-gray-700 text-right">الإرشاد (صيني)</label>
                <input type="text" name="name_ch" id="name_ch" value="{{ old('name_ch', $tripFeature->name_ch) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('name_ch')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 text-right">الحالة</label>
                <select name="status" id="status"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="active" {{ old('status', $tripFeature->status) == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ old('status', $tripFeature->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="order" class="block text-sm font-medium text-gray-700 text-right">الترتيب</label>
                <input type="number" name="order" id="order" value="{{ old('order', $tripFeature->order) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('order')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="flex justify-end gap-2">
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">تحديث</button>
                <a href="{{ route('admin.omdaHome.trip.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">إلغاء</a>
            </div>
        </form>
    </div>
</div>
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