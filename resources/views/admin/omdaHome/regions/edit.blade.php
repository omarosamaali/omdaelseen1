@extends($layout)

@section('content')
<div style="display: flex; flex-direction: row-reverse; margin-right: 77px !important; position: relative; margin: 0px 20px; z-index: 9999999999999;">
    <div style="height: fit-content; background: white; border-radius: 10px; padding: 20px; margin-top: 24px; width: 400px;">
        <div>
            الحالة
            <br />
            @if($region->status == 'active' || $region->status == 'نشط')
                <span class="text-green-600">نشط</span>
            @else
                <span class="text-red-600">غير نشط</span>
            @endif
            <br />
            عدد الأماكن
            <br />
            {{ $region->places ?? '0' }}
            <br />
            تاريخ الإضافة
            <br />
            {{ $region->created_at ? $region->created_at->format('Y-m-d H:i:s') : '-' }}
            <br />
            تاريخ التحديث
            <br />
            {{ $region->updated_at ? $region->updated_at->format('Y-m-d H:i:s') : '-' }}
        </div>
    </div>
    <div class="container py-4 mx-auto max-w-4xl" style="position: relative; right: -50px; margin-top: 24px; background: white; border-radius: 10px; padding: 20px;">
        <h2 class="text-right mb-4 font-bold text-xl">تعديل بيانات المنطقة</h2>
        <form action="{{ route('admin.regions.update', $region->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2" style="column-gap: 20px;">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الاسم بالعربي</label>
                    <input type="text" id="name_ar" name="name_ar" class="input-field @error('name_ar') border-red-500 @enderror" value="{{ old('name_ar', $region->name_ar) }}" required>
                    @error('name_ar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الاسم بالإنجليزي</label>
                    <input type="text" id="name_en" name="name_en" class="input-field @error('name_en') border-red-500 @enderror" value="{{ old('name_en', $region->name_en) }}" required>
                    @error('name_en')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الاسم بالصيني</label>
                    <input type="text" id="name_ch" name="name_ch" class="input-field @error('name_ch') border-red-500 @enderror" value="{{ old('name_ch', $region->name_ch) }}" required>
                    @error('name_ch')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الحالة</label>
                    <select name="status" style="direction: ltr;" class="input-field @error('status') border-red-500 @enderror rtl-select">
                        <option value="">اختر</option>
                        <option value="active" {{ old('status', $region->status) == 'active' || old('status', $region->status) == 'نشط' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ old('status', $region->status) == 'inactive' || old('status', $region->status) == 'غير نشط' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                    @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الصورة الشخصية</label>
                    <input type="file" name="avatar" class="input-field @error('avatar') border-red-500 @enderror">
                    @if ($region->avatar)
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">الصورة الحالية:</p>
                        <img src="{{ asset('storage/' . $region->avatar) }}" alt="{{ $region->name_ar }}" style="width: 91px; height: 63px;" class="mt-2 object-cover rounded">
                    </div>
                    @endif
                    @error('avatar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-between" style="margin-top: 20px;">
                <a href="{{ route('admin.regions.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">إلغاء</a>
                <button type="submit" class="btn btn-dark px-4 py-2 bg-black text-white rounded-md">تحديث</button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('user_search');
            const table = document.getElementById('regions_table');
            const rows = table.querySelectorAll('tbody tr');

            searchInput.addEventListener('input', function() {
                const term = this.value.trim().toLowerCase();

                rows.forEach(row => {
                    const nameCell = row.querySelectorAll('td')[1];
                    if (!nameCell) return;

                    const name = nameCell.textContent.trim().toLowerCase();
                    if (name.includes(term) || term === '') {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</div>
@endsection