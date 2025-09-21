@extends($layout)
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<style>
    .delete-image-btn {
        background-color: #ef4444;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 14px;
        margin-top: 5px;
        transition: background-color 0.2s;
    }

    .delete-image-btn:hover {
        background-color: #dc2626;
    }

    .image-container {
        position: relative;
        display: inline-block;
    }

</style>

<div class="py-4" style="margin-top: 30px;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-right mb-4 font-bold text-xl">تعديل المكان</h2>

                <form action="{{ route('admin.places.update', $place->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4 text-right">
                            <label for="name_ar" class="block text-gray-700 font-bold mb-2">الاسم بالعربي *</label>
                            <input type="text" name="name_ar" id="name_ar" value="{{ old('name_ar', $place->name_ar) }}" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                            @error('name_ar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="name_en" class="block text-gray-700 font-bold mb-2">الاسم بالإنجليزي *</label>
                            <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $place->name_en) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('name_en')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="name_ch" class="block text-gray-700 font-bold mb-2">الاسم بالصيني *</label>
                            <input type="text" name="name_ch" id="name_ch" value="{{ old('name_ch', $place->name_ch) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('name_ch')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

<div class="mb-4 text-right">
    <label for="main_category_id" class="block text-gray-700 font-bold mb-2">التصنيف الرئيسي *</label>
    <select name="main_category_id" id="main_category_id" class="w-full border-gray-300 rounded-md shadow-sm text-right"
        required>
        <option value="" disabled>اختر التصنيف الرئيسي</option>
        @foreach ($explorers as $explorer)
        <option value="{{ $explorer->id }}" {{ old('main_category_id', $place->main_category_id) == $explorer->id ?
            'selected' : '' }}>
            {{ $explorer->name_ar }}
        </option>
        @endforeach
    </select>
    @error('main_category_id')
    <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

<div class="mb-4 text-right">
    <label for="sub_category_id" class="block text-gray-700 font-bold mb-2">التصنيف الفرعي *</label>
    <select name="sub_category_id" id="sub_category_id" class="w-full border-gray-300 rounded-md shadow-sm text-right"
        required>
        <option value="" disabled>اختر التصنيف الفرعي</option>
        @foreach ($branches as $branch)
        <option value="{{ $branch->id }}" data-main="{{ $branch->main_category_id }}" {{ old('sub_category_id', $place->
            sub_category_id) == $branch->id ? 'selected' : '' }}>
            {{ $branch->name_ar }}
        </option>
        @endforeach
    </select>
    @error('sub_category_id')
    <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

                        <div class="mb-4 text-right">
                            <label for="region_id" class="block text-gray-700 font-bold mb-2">المنطقة *</label>
                            <select name="region_id" id="region_id" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                <option value="">اختر المنطقة</option>
                                @foreach ($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id', $place->region_id) == $region->id ? 'selected' : '' }}>
                                    {{ $region->name_ar }}
                                </option>
                                @endforeach
                            </select>
                            @error('region_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="link" class="block text-gray-700 font-bold mb-2">الرابط *</label>
                            <input type="url" name="link" id="link" value="{{ old('link', $place->link) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('link')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="map_type" class="block text-gray-700 font-bold mb-2">نوع الخريطة *</label>
                            <select name="map_type" id="map_type" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                <option value="google" {{ old('map_type', $place->map_type) == 'google' ? 'selected' : '' }}>Google
                                </option>
                                <option value="apple" {{ old('map_type', $place->map_type) == 'apple' ? 'selected' : '' }}>Apple</option>
                                <option value="baidu" {{ old('map_type', $place->map_type) == 'baidu' ? 'selected' : '' }}>Baidu</option>
                            </select>
                            @error('map_type')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="phone" class="block text-gray-700 font-bold mb-2">رقم الهاتف</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $place->phone) }}" class="w-full border-gray-300 rounded-md shadow-sm text-right">
                            @error('phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="email" class="block text-gray-700 font-bold mb-2">البريد الإلكتروني</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $place->email) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="website" class="block text-gray-700 font-bold mb-2">الموقع الإلكتروني</label>
                            <input type="url" name="website" id="website" value="{{ old('website', $place->website) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('website')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="status" class="block text-gray-700 font-bold mb-2">الحالة *</label>
                            <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                <option value="نشط" {{ old('status', $place->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="غير نشط" {{ old('status', $place->status) == 'inactive' ? 'selected' : '' }}>غير نشط
                                </option>
                                <option value="محظور" {{ old('status', $place->status) == 'banned' ? 'selected' : '' }}>محظور</option>
                            </select>
                            @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right col-span-2">
                            <label for="avatar" class="block text-gray-700 font-bold mb-2">الصورة</label>
                            @if ($place->avatar)
                            <div class="mb-2 image-container">
                                <img src="{{ asset('storage/' . $place->avatar) }}" alt="{{ $place->name_ar }}" class="w-32 h-32 object-cover rounded-md">
                                <button type="button" class="delete-image-btn" data-image-type="avatar" data-place-id="{{ $place->id }}">حذف</button>
                            </div>
                            @endif
                            <input type="file" name="avatar" id="avatar" class="w-full border-gray-300 rounded-md shadow-sm">
                            <small class="text-gray-500">اترك الحقل فارغًا إذا كنت لا ترغب في تغيير الصورة</small>
                            @error('avatar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4 text-right col-span-2">
                            <label for="additional_images" class="block text-gray-700 font-bold mb-2">صور إضافية</label>
                            @if ($place->additional_images)
                            <div class="mb-2 flex flex-wrap gap-2">
                                @foreach (json_decode($place->additional_images, true) as $index => $image)
                                <div class="image-container">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Additional Image" class="w-32 h-32 object-cover rounded-md">
                                    <button type="button" class="delete-image-btn" data-image-type="additional" data-place-id="{{ $place->id }}" data-image-index="{{ $index }}">حذف</button>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <input type="file" name="additional_images[]" id="additional_images" class="w-full border-gray-300 rounded-md shadow-sm" multiple>
                            <small class="text-gray-500">اختر صورًا جديدة لإضافتها</small>
                            @error('additional_images.*')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4 text-right col-span-2">
                            <label for="details_ar" class="block text-sm font-medium text-gray-700">التفاصيل (بالعربي)</label>
                            <textarea name="details_ar" id="details_ar" rows="4" class="w-full border-gray-300 rounded-md shadow-sm text-right @error('details_ar') border-red-500 @enderror">{{ old('details_ar', $place->details_ar) }}</textarea>
                            @error('details_ar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- English Details -->
                        <div class="mb-4 text-right col-span-2">
                            <label for="details_en" class="block text-sm font-medium text-gray-700">التفاصيل (بالإنجليزي)</label>
                            <textarea name="details_en" id="details_en" rows="4" class="w-full border-gray-300 rounded-md shadow-sm text-right @error('details_en') border-red-500 @enderror">{{ old('details_en', $place->details_en) }}</textarea>
                            @error('details_en')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Chinese Details -->
                        <div class="mb-4 text-right col-span-2">
                            <label for="details_ch" class="block text-sm font-medium text-gray-700">التفاصيل (بالصيني)</label>
                            <textarea name="details_ch" id="details_ch" rows="4" class="w-full border-gray-300 rounded-md shadow-sm text-right @error('details_ch') border-red-500 @enderror">{{ old('details_ch', $place->details_ch) }}</textarea>
                            @error('details_ch')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">تحديث</button>
                        <a href="{{ route('admin.places.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- إضافة jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Ensure jQuery is loaded
    $(document).ready(function() {
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
        } else {
            console.log('jQuery loaded successfully:', jQuery.fn.jquery);
        }

        // Show translation status
        function showTranslationStatus(show = true, message = 'جاري الترجمة...') {
            const statusElement = $('#translationStatus'); // Use jQuery selector
            if (show) {
                statusElement.find('p').text(message); // Use .text() for text content
                statusElement.show(); // Show the element
            } else {
                statusElement.hide(); // Hide the element
            }
        }

        // Translation function
        function translateText(inputField, sourceLang, targetLangs, targetFields) {
            const text = inputField.val().trim();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            if (!text) {
                targetFields.forEach(field => field.val(''));
                showTranslationStatus(false);
                return;
            }

            showTranslationStatus(true);

            $.ajax({
                url: '{{ route('translate') }}'
                , method: 'POST'
                , headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
                , data: {
                    text: text
                    , source_lang: sourceLang
                    , target_langs: targetLangs
                }
                , success: function(response) {
                    targetFields[0].val(response[targetLangs[0]] || '');
                    targetFields[1].val(response[targetLangs[1]] || '');
                    showTranslationStatus(false);
                }
                , error: function(xhr, status, error) {
                    showTranslationStatus(true, 'فشل في الترجمة، حاول مرة أخرى لاحقًا.');
                    setTimeout(() => showTranslationStatus(false), 3000);
                }
            });
        }

        // Debounce function to limit API calls
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

        const debouncedTranslate = debounce(translateText, 500);

        // Name translations
        $('#name_ar').on('input', function() {
            debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#name_en'), $('#name_ch')]);
        });
        $('#name_en').on('input', function() {
            debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#name_ar'), $('#name_ch')]);
        });
        $('#name_ch').on('input', function() {
            debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#name_ar'), $('#name_en')]);
        });

        // Details translations
        $('#details_ar').on('input', function() {
            debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#details_en'), $('#details_ch')]);
        });
        $('#details_en').on('input', function() {
            debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#details_ar'), $('#details_ch')]);
        });
        $('#details_ch').on('input', function() {
            debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#details_ar'), $('#details_en')]);
        });

        // Handle subcategory dropdown
$('#main_category_id').on('change', function() {
const mainCategoryId = this.value;
const subCategorySelect = $('#sub_category_id');
subCategorySelect.html('<option value="" disabled selected>جاري التحميل...</option>');

if (mainCategoryId) {
$.ajax({
url: `/get-subcategories/${mainCategoryId}`,
method: 'GET',
headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
success: function(data) {
subCategorySelect.html('<option value="" disabled selected>اختر</option>');
if (data.length === 0) {
subCategorySelect.append('<option value="" disabled>لا يوجد تصنيفات فرعية</option>');
} else {
data.forEach(subcategory => {
const selected = subcategory.id == '{{ old('sub_category_id', $place->sub_category_id) }}' ? 'selected' : '';
subCategorySelect.append(`<option value="${subcategory.id}" data-main="${subcategory.main_category_id}" ${selected}>
    ${subcategory.name_ar}</option>`);
});
}
},
error: function() {
subCategorySelect.html('<option value="" disabled selected>حدث خطأ</option>');
}
});
} else {
subCategorySelect.html('<option value="" disabled selected>اختر</option>');
}
});

if ($('#main_category_id').val()) {
$('#main_category_id').trigger('change');
}    });

</script>

@endsection
