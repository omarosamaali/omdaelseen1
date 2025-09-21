@extends($layout)

@section('content')
    <div class="py-4 text-end" style="margin-top: 30px; max-width: 800px; margin-right: auto; margin-left: auto;">
        <h2 class="text-right text-2xl font-bold mb-4">إضافة فعالية جديدة للرحلة: {{ $trip->title_ar }}</h2>
    <form action="{{ route('admin.omdaHome.trip.create_table.store', $trip->id) }}" method="POST" enctype="multipart/form-data" id="activityForm">
    @csrf
    <div class="mb-4 text-right">
        <label for="date" class="block text-gray-700 font-bold mb-2">التاريخ *</label>
        <select name="date" id="date" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
            <option disabled selected>اختر</option>
            @php
                $start = new \DateTime($trip->departure_date);
                $end = new \DateTime($trip->return_date);
                $interval = new \DateInterval('P1D');
                $dates = new \DatePeriod($start, $interval, $end->modify('+1 day'));
            @endphp
            @foreach ($dates as $date)
                <option value="{{ $date->format('Y-m-d') }}" {{ old('date') == $date->format('Y-m-d') ? 'selected' : '' }}>
                    {{ $date->format('d-m-Y') }}
                </option>
            @endforeach
        </select>
        @error('date')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4 text-right">
        <label for="period" class="block text-gray-700 font-bold mb-2">الفترة *</label>
        <select name="period" id="period" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
            <option disabled {{ old('period') ? '' : 'selected' }}>اختر</option>
            <option value="morning" {{ old('period') == 'morning' ? 'selected' : '' }}>الصباح</option>
            <option value="afternoon" {{ old('period') == 'afternoon' ? 'selected' : '' }}>الظهر</option>
            <option value="evening" {{ old('period') == 'evening' ? 'selected' : '' }}>المساء</option>
        </select>
        @error('period')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4 text-right">
        <label for="is_place_related" class="block text-gray-700 font-bold mb-2">هل الفعالية مرتبطة بمكان؟ *</label>
        <select name="is_place_related" id="is_place_related" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
            <option value="0" {{ old('is_place_related', 0) == 0 ? 'selected' : '' }}>لا</option>
            <option value="1" {{ old('is_place_related', 0) == 1 ? 'selected' : '' }}>نعم</option>
        </select>
        @error('is_place_related')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div id="place_select" class="mb-4 text-right {{ old('is_place_related', 0) == 1 ? '' : 'hidden' }}">
        <label for="place_id" class="block text-gray-700 font-bold mb-2">اختر المكان *</label>
        <select name="place_id" id="place_id" class="w-full border-gray-300 rounded-md shadow-sm text-right">
            <option value="" disabled selected>اختر مكانًا</option>
            @foreach ($places as $place)
                <option value="{{ $place->id }}" {{ old('place_id') == $place->id ? 'selected' : '' }}>
                    {{ $place->name_ar }}
                </option>
            @endforeach
        </select>
        @error('place_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div id="place_manual" class="mb-4 text-right {{ old('is_place_related', 0) == 0 ? '' : 'hidden' }}">
        {{-- حقل الصورة --}}
        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-bold mb-2">
                صورة المكان <span class="text-red-500">*</span>
            </label>

            <!-- معاينة الصورة -->
            <div id="imagePreview" class="mb-2" style="display: none;">
                <img id="previewImg" src="" alt="معاينة الصورة"
                    style="max-width: 200px; max-height: 200px; border-radius: 8px;">
            </div>

            <input type="file" name="image" id="image"
                accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                class="w-full border-gray-300 rounded-md shadow-sm @error('image') border-red-500 @enderror"
                onchange="previewImage(this)">

            @error('image')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <small class="text-gray-500 block mt-1">
                أنواع الملفات المدعومة: JPG, JPEG, PNG, GIF, WEBP (حد أقصى: 2MB)
            </small>
        </div>

        <div class="mb-4">
            <label for="place_name_ar" class="block text-gray-700 font-bold mb-2">
                اسم المكان (عربي) <span class="text-red-500">*</span>
            </label>
            <input type="text" name="place_name_ar" id="place_name_ar" value="{{ old('place_name_ar') }}"
                class="w-full border-gray-300 rounded-md shadow-sm text-right @error('place_name_ar') border-red-500 @enderror">
            @error('place_name_ar')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="place_name_en" class="block text-gray-700 font-bold mb-2">
                اسم المكان (إنجليزي) <span class="text-red-500">*</span>
            </label>
            <input type="text" name="place_name_en" id="place_name_en" value="{{ old('place_name_en') }}"
                class="w-full border-gray-300 rounded-md shadow-sm @error('place_name_en') border-red-500 @enderror">
            @error('place_name_en')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="place_name_zh" class="block text-gray-700 font-bold mb-2">اسم المكان (صيني)</label>
            <input type="text" name="place_name_zh" id="place_name_zh" value="{{ old('place_name_zh') }}"
                class="w-full border-gray-300 rounded-md shadow-sm @error('place_name_zh') border-red-500 @enderror">
            @error('place_name_zh')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="details_ar" class="block text-gray-700 font-bold mb-2">
                التفاصيل (عربي) <span class="text-red-500">*</span>
            </label>
            <textarea name="details_ar" id="details_ar" class="w-full border-gray-300 rounded-md shadow-sm text-right @error('details_ar') border-red-500 @enderror"
                rows="4">{{ old('details_ar') }}</textarea>
            @error('details_ar')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="details_en" class="block text-gray-700 font-bold mb-2">التفاصيل (إنجليزي)</label>
            <textarea name="details_en" id="details_en" class="w-full border-gray-300 rounded-md shadow-sm @error('details_en') border-red-500 @enderror" 
                rows="4">{{ old('details_en') }}</textarea>
            @error('details_en')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="details_zh" class="block text-gray-700 font-bold mb-2">التفاصيل (صيني)</label>
            <textarea name="details_zh" id="details_zh" class="w-full border-gray-300 rounded-md shadow-sm @error('details_zh') border-red-500 @enderror" 
                rows="4">{{ old('details_zh') }}</textarea>
            @error('details_zh')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="mb-4 text-right">
        <label for="status" class="block text-gray-700 font-bold mb-2">الحالة *</label>
        <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشط</option>
            <option value="inactive" {{ old('status', 'active') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
        </select>
        @error('status')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="text-center">
        <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">حفظ</button>
        <button type="submit" name="add_more" value="1" class="bg-blue-500 text-white px-4 py-2 rounded-md">المزيد</button>
        <a href="{{ route('admin.omdaHome.trip.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md">إلغاء</a>
    </div>
</form>
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);

            const file = input.files[0];
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

            if (!allowedTypes.includes(file.type)) {
                alert('يرجى رفع صورة صالحة (JPG, PNG, GIF, WEBP)');
                input.value = '';
                preview.style.display = 'none';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert('حجم الصورة كبير جداً. يجب أن يكون أقل من 2 ميجابايت');
                input.value = '';
                preview.style.display = 'none';
                return;
            }
        }
    }
</script>
<script>
// إخفاء/إظهار الحقول حسب اختيار المكان
document.getElementById('is_place_related').addEventListener('change', function() {
    const isPlaceRelated = this.value;
    const placeSelect = document.getElementById('place_select');
    const placeManual = document.getElementById('place_manual');
    
    if (isPlaceRelated == '1') {
        placeSelect.classList.remove('hidden');
        placeManual.classList.add('hidden');
        // جعل حقل place_id مطلوب
        document.getElementById('place_id').required = true;
        // إزالة التطلب من الحقول اليدوية
        document.getElementById('image').required = false;
        document.getElementById('place_name_ar').required = false;
        document.getElementById('place_name_en').required = false;
        document.getElementById('details_ar').required = false;
    } else {
        placeSelect.classList.add('hidden');
        placeManual.classList.remove('hidden');
        // إزالة التطلب من place_id
        document.getElementById('place_id').required = false;
        // جعل الحقول اليدوية مطلوبة
        document.getElementById('image').required = true;
        document.getElementById('place_name_ar').required = true;
        document.getElementById('place_name_en').required = true;
        document.getElementById('details_ar').required = true;
    }
});

// تطبيق الحالة الأولية
document.getElementById('is_place_related').dispatchEvent(new Event('change'));


document.getElementById('activityForm').addEventListener('submit', function(e) {
    const isPlaceRelated = document.getElementById('is_place_related').value;
    if (isPlaceRelated == '0') {
        const imageInput = document.getElementById('image');
        const placeNameAr = document.getElementById('place_name_ar').value.trim();
        const placeNameEn = document.getElementById('place_name_en').value.trim();
        const detailsAr = document.getElementById('details_ar').value.trim();

        if (!imageInput.files || imageInput.files.length === 0) {
            alert('يرجى رفع صورة للمكان');
            e.preventDefault();
            return false;
        }
        if (!placeNameAr) {
            alert('يرجى إدخال اسم المكان بالعربية');
            e.preventDefault();
            return false;
        }
        if (!placeNameEn) {
            alert('يرجى إدخال اسم المكان بالإنجليزية');
            e.preventDefault();
            return false;
        }
        if (!detailsAr) {
            alert('يرجى إدخال تفاصيل المكان بالعربية');
            e.preventDefault();
            return false;
        }
    }
});
</script>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func(...args), wait);
                };
            }

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
                        targetFields.forEach((field, index) => field.val(response[targetLangs[index]] ||
                            ''));
                    },
                    error: function() {
                        alert('فشل في الترجمة، حاول مرة أخرى لاحقاً.');
                    }
                });
            }

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

            $('#place_name_ar').on('input', function() {
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#place_name_en'), $(
                    '#place_name_zh')]);
            });

            $('#place_name_en').on('input', function() {
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#place_name_ar'), $(
                    '#place_name_zh')]);
            });

            $('#place_name_zh').on('input', function() {
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#place_name_ar'), $(
                    '#place_name_en')]);
            });

            $('#details_ar').on('input', function() {
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#details_en'), $('#details_zh')]);
            });

            $('#details_en').on('input', function() {
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#details_ar'), $('#details_zh')]);
            });

            $('#details_zh').on('input', function() {
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#details_ar'), $('#details_en')]);
            });

            $('#is_place_related').on('change', function() {
                const placeSelect = $('#place_select');
                const placeManual = $('#place_manual');
                if (this.value == '1') {
                    placeSelect.removeClass('hidden');
                    placeManual.addClass('hidden');
                    $('#place_id').prop('required', true);
                    $('#place_name_ar, #place_name_en, #place_name_zh, #details_ar, #details_en, #details_zh')
                        .prop('required', false);
                } else {
                    placeSelect.addClass('hidden');
                    placeManual.removeClass('hidden');
                    $('#place_id').prop('required', false);
                    $('#place_name_ar, #place_name_en, #place_name_zh, #details_ar').prop('required', true);
                    $('#details_en, #details_zh').prop('required', false);
                }
            });
        });
    </script>
@endsection
