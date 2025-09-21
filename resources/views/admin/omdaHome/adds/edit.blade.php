@extends($layout)

@section('content')
    <div class="py-4 text-end" style="margin-top: 30px; max-width: 800px; margin-right: auto; margin-left: auto;">
        <h2 class="text-right text-2xl font-bold mb-4">تعديل الإضافة</h2>
<form action="{{ route('admin.omdaHome.adds.update', $add->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="mb-4">
        <label for="type_ar" class="block text-sm font-medium text-gray-700 text-right">النوع (عربي)</label>
        <input type="text" name="type_ar" id="type_ar"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
            value="{{ old('type_ar', $add->type_ar) }}" required>
        @error('type_ar')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="mb-4">
        <label for="type_en" class="block text-sm font-medium text-gray-700 text-right">النوع (إنجليزي)</label>
        <input type="text" name="type_en" id="type_en"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            value="{{ old('type_en', $add->type_en) }}">
        @error('type_en')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="mb-4">
        <label for="type_zh" class="block text-sm font-medium text-gray-700 text-right">النوع (صيني)</label>
        <input type="text" name="type_zh" id="type_zh"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            value="{{ old('type_zh', $add->type_zh) }}">
        @error('type_zh')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="image" class="block text-sm font-medium text-gray-700 text-right">الصورة</label>
        
        <!-- عرض الصورة الحالية -->
        @if($add->image)
            <div class="mb-2">
                <p class="text-sm text-gray-600 text-right mb-1">الصورة الحالية:</p>
                <img src="{{ asset('storage/' . $add->image) }}" alt="الصورة الحالية" 
                     class="w-48 h-48 object-cover rounded-md shadow-sm">
            </div>
        @endif
        
        <input type="file" name="image" id="image" class="mt-1 block w-full" accept="image/*">
        <p class="text-xs text-gray-500 mt-1 text-right">اتركه فارغاً إذا كنت لا تريد تغيير الصورة</p>
        @error('image')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        
        <!-- معاينة الصورة الجديدة -->
        <div id="image-preview" class="mt-2">
            <img id="image-display" src="#" alt="صورة المعاينة الجديدة" 
                 class="hidden w-48 h-48 object-cover rounded-md shadow-sm">
        </div>
    </div>
    
    <div class="mb-4">
        <label for="details_ar" class="block text-sm font-medium text-gray-700 text-right">التفاصيل (عربي)</label>
        <textarea name="details_ar" id="details_ar"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4" required>{{ old('details_ar', $add->details_ar) }}</textarea>
        @error('details_ar')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="mb-4">
        <label for="details_en" class="block text-sm font-medium text-gray-700 text-right">التفاصيل (إنجليزي)</label>
        <textarea name="details_en" id="details_en"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4">{{ old('details_en', $add->details_en) }}</textarea>
        @error('details_en')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="mb-4">
        <label for="details_zh" class="block text-sm font-medium text-gray-700 text-right">التفاصيل (صيني)</label>
        <textarea name="details_zh" id="details_zh"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4">{{ old('details_zh', $add->details_zh) }}</textarea>
        @error('details_zh')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="mb-4">
        <label for="price" class="block text-sm font-medium text-gray-700 text-right">المبلغ</label>
        <input type="number" name="price" id="price"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
            value="{{ old('price', $add->price) }}" required>
        @error('price')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="mb-4">
        <label for="status" class="block text-sm font-medium text-gray-700 text-right">الحالة</label>
        <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="active" {{ old('status', $add->status) == 'active' ? 'selected' : '' }}>نشط</option>
            <option value="inactive" {{ old('status', $add->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
        </select>
        @error('status')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="text-center">
        <button type="submit" class="bg-black text-white px-4 py-2 rounded-md ml-2">تحديث</button>
        <a href="{{ route('admin.omdaHome.adds.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded-md">إلغاء</a>
    </div>
</form>

<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const imageDisplay = document.getElementById('image-display');
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                imageDisplay.src = event.target.result;
                imageDisplay.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imageDisplay.src = "#";
            imageDisplay.classList.add('hidden');
        }
    });
</script>
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

            const debouncedTranslate = debounce(translateText, 500);

            $('#type_ar').on('input', function() {
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#type_en'), $('#type_zh')]);
            });

            $('#type_en').on('input', function() {
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#type_ar'), $('#type_zh')]);
            });

            $('#type_zh').on('input', function() {
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#type_ar'), $('#type_en')]);
            });

            
            // ترجمة التفاصيل
            $('#details_ar').on('input', function() {
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#details_en'), $('#details_zh')]);
            });

            $('#details_en').on('input', function() {
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#details_ar'), $('#details_zh')]);
            });

            $('#details_zh').on('input', function() {
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#details_ar'), $('#details_en')]);
            });

        });
    </script>
@endsection