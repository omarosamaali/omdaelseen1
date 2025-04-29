@extends($layout)

@section('content')
<div class="py-4" style="margin-top: 30px;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-right mb-4 font-bold text-xl">إضافة مكان جديد</h2>
                
                <form action="{{ route('admin.places.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4 text-right">
                            <label for="name_ar" class="block text-gray-700 font-bold mb-2">الاسم بالعربي *</label>
                            <input type="text" name="name_ar" id="name_ar" value="{{ old('name_ar') }}" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                            @error('name_ar')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 text-right">
                            <label for="name_en" class="block text-gray-700 font-bold mb-2">الاسم بالإنجليزي *</label>
                            <input type="text" name="name_en" id="name_en" value="{{ old('name_en') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('name_en')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 text-right">
                            <label for="name_ch" class="block text-gray-700 font-bold mb-2">الاسم بالصيني *</label>
                            <input type="text" name="name_ch" id="name_ch" value="{{ old('name_ch') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('name_ch')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 text-right">
                            <label for="main_category_id" class="block text-gray-700 font-bold mb-2">التصنيف الرئيسي *</label>
                            <select name="main_category_id" id="main_category_id" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                <option value="">اختر التصنيف الرئيسي</option>
                                @foreach($explorers as $explorer)
                                    <option value="{{ $explorer->id }}" {{ old('main_category_id') == $explorer->id ? 'selected' : '' }}>
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
                            <select name="sub_category_id" id="sub_category_id" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                <option value="">اختر التصنيف الفرعي</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" data-main="{{ $branch->main }}" {{ old('sub_category_id') == $branch->id ? 'selected' : '' }}>
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
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                        {{ $region->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                            @error('region_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 text-right">
                            <label for="link" class="block text-gray-700 font-bold mb-2">رابط المكان *</label>
                            <input type="url" name="link" id="link" value="{{ old('link') }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('link')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 text-right">
                            <label for="map_type" class="block text-gray-700 font-bold mb-2">نوع الخريطة *</label>
                            <select name="map_type" id="map_type" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                <option value="google" {{ old('map_type') == 'google' ? 'selected' : '' }}>Google</option>
                                <option value="apple" {{ old('map_type') == 'apple' ? 'selected' : '' }}>Apple</option>
                                <option value="baidu" {{ old('map_type') == 'baidu' ? 'selected' : '' }}>Baidu</option>
                            </select>
                            @error('map_type')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 text-right">
                            <label for="phone" class="block text-gray-700 font-bold mb-2">رقم الهاتف</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full border-gray-300 rounded-md shadow-sm text-right">
                            @error('phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 text-right">
                            <label for="email" class="block text-gray-700 font-bold mb-2">البريد الإلكتروني</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 text-right">
                            <label for="status" class="block text-gray-700 font-bold mb-2">الحالة *</label>
                            <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                <option value="نشط" {{ old('status') == 'نشط' ? 'selected' : '' }}>نشط</option>
                                <option value="غير نشط" {{ old('status') == 'غير نشط' ? 'selected' : '' }}>غير نشط</option>
                                <option value="محظور" {{ old('status') == 'محظور' ? 'selected' : '' }}>محظور</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 text-right col-span-2">
                            <label for="avatar" class="block text-gray-700 font-bold mb-2">الصورة *</label>
                            <input type="file" name="avatar" id="avatar" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('avatar')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 text-right col-span-2">
                            <label for="additional_images" class="block text-gray-700 font-bold mb-2">صور إضافية</label>
                            <input type="file" name="additional_images[]" id="additional_images" class="w-full border-gray-300 rounded-md shadow-sm" multiple>
                            @error('additional_images.*')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 text-right col-span-2">
                            <label for="details" class="block text-gray-700 font-bold mb-2">التفاصيل</label>
                            <textarea name="details" id="details" rows="4" class="w-full border-gray-300 rounded-md shadow-sm text-right">{{ old('details') }}</textarea>
                            @error('details')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">حفظ</button>
                        <a href="{{ route('admin.places.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">إلغاء</a>  
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainCategorySelect = document.getElementById('main_category_id');
        const subCategorySelect = document.getElementById('sub_category_id');
        
        function filterSubCategories() {
            const mainCategoryId = mainCategorySelect.value;
            subCategorySelect.innerHTML = '<option value="">اختر التصنيف الفرعي</option>';
            
            if (!mainCategoryId) return;
            
            const subCategoryOptions = Array.from(document.querySelectorAll('#sub_category_id option[data-main]'));
            const matchingOptions = subCategoryOptions.filter(option => option.dataset.main == mainCategoryId);
            
            if (matchingOptions.length === 0) {
                subCategorySelect.innerHTML = '<option value="">لا توجد تصنيفات فرعية متاحة</option>';
                return;
            }
            
            matchingOptions.forEach(option => {
                const clonedOption = option.cloneNode(true);
                subCategorySelect.appendChild(clonedOption);
            });
        }
        
        mainCategorySelect.addEventListener('change', filterSubCategories);
        filterSubCategories();
    });
</script> --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
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