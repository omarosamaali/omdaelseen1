@extends($layout)

@section('content')

<div style="display: flex;
    flex-direction: row-reverse;
    margin-right: 77px !important;
    position: relative;
    margin: 0px 20px;
    z-z-index: 1;">        
        <div style="height: fit-content; background: white; border-radius: 10px; padding: 20px; margin-top: 24px; width: 400px;">
    <div>
        <div class="info-label" style="margin-bottom: 10px;">الحالة</div>
        <div class="info-value">
            @if($branch->status == 'active' || $branch->status == 'نشط')
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">نشط</span>
            @else
                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">غير نشط</span>
            @endif
        </div>

        <div class="info-label" style="margin-top: 10px;">عدد الأماكن</div>
        <div class="info-value">{{ $branch->places ?? 0 }}</div>

        <div class="info-label">تاريخ الإضافة</div>
        <div class="info-value">{{ $branch->created_at ? $branch->created_at->format('Y-m-d H:i:s') : '-' }}</div>

        <div class="info-label">تاريخ التحديث</div>
        <div class="info-value">{{ $branch->updated_at ? $branch->updated_at->format('Y-m-d H:i:s') : '-' }}</div>
    </div>
</div>
        <div class="container py-4 mx-auto max-w-4xl"
            style="position: relative; right: -50px; margin-top: 24px; background: white; border-radius: 10px; padding: 20px;">
            <h2 class="text-right mb-4 font-bold text-xl">تعديل تصنيف فرعي</h2>
            <form action="{{ route('admin.branches.update', $branch->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">الإسم بالعربي</label>
                        <input type="text" id="name_ar" name="name_ar"
                            class="input-field @error('name_ar') border-red-500 @enderror"
                            value="{{ old('name_ar', $branch->name_ar) }}" required>
                        @error('name_ar')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">الإسم بالإنجليزي</label>
                        <input type="text" id="name_en" name="name_en"
                            class="input-field @error('name_en') border-red-500 @enderror"
                            value="{{ old('name_en', $branch->name_en) }}" required>
                        @error('name_en')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">الإسم بالصيني</label>
                        <input type="text" id="name_ch" name="name_ch"
                            class="input-field @error('name_ch') border-red-500 @enderror"
                            value="{{ old('name_ch', $branch->name_ch) }}" required>
                        @error('name_ch')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">الحالة</label>
                        <select name="status" style="direction: ltr;"
                            class="input-field @error('status') border-red-500 @enderror rtl-select">
                            <option value="نشط" {{ old('status', $branch->status) == 'active' || old('status', $branch->status) == 'نشط' ? 'selected' : '' }}>
                                نشط
                            </option>
                            <option value="غير نشط" {{ old('status', $branch->status) == 'inactive' || old('status', $branch->status) == 'غير نشط' ? 'selected' : '' }}>
                                غير نشط
                            </option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parent_id" class="block text-sm font-medium text-gray-700">التصنيف الرئيسي</label>
                        <select name="parent_id" id="parent_id"
                            class="input-field @error('parent_id') border-red-500 @enderror">
                            <option value="">-- اختر التصنيف الرئيسي --</option>
                            @foreach($mainCategories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('parent_id', $branch->main) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name_ar }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">الصورة الشخصية</label>
                        <input type="file" name="avatar"
                            class="input-field @error('avatar') border-red-500 @enderror">
                        @if($branch->avatar)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $branch->avatar) }}"
                                    alt="{{ $branch->name_ar }}"
                                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                            </div>
                        @endif
                        @error('avatar')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="submit"
                        class="btn btn-dark px-4 py-2 bg-black text-white rounded-md">تحديث</button>
                    <a href="{{ route('admin.branches.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">العودة</a>
                </div>
            </form>
        </div>
    </div>

    <!-- إضافة jQuery -->
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