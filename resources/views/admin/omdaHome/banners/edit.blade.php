@extends($layout)

@section('content')
<h2 class="text-right mb-4 font-bold text-xl" style="display: flex; margin-top: 50px; margin-right: 50px; ">تعديل بنر</h2>
<div style="display: flex; flex-direction: row-reverse; position: relative; z-index: 1;">
    <div class="container py-4 mx-auto max-w-4xl" style="position: relative; right: -50px;  background: white; border-radius: 10px; padding: 20px;">
    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title_ar" class="block text-sm font-medium text-gray-700">العنوان (عربي)</label>
            <input type="text" name="title_ar" id="title_ar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('title_ar', $banner->title_ar) }}">
        </div>
        <div class="mb-4">
            <label for="title_en" class="block text-sm font-medium text-gray-700">العنوان (إنجليزي)</label>
            <input type="text" name="title_en" id="title_en" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('title_en', $banner->title_en) }}">
        </div>
        <div class="mb-4">
            <label for="title_zh" class="block text-sm font-medium text-gray-700">العنوان (صيني)</label>
            <input type="text" name="title_zh" id="title_zh" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('title_zh', $banner->title_zh) }}">
        </div>
        <div class="mb-4">
            <label for="location" class="block text-sm font-medium text-gray-700">موقع البنر</label>
            <select name="location" id="location" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="website_home" {{ old('location', $banner->location) == 'website_home' ? 'selected' : '' }}>تطبيق الويب</option>
                <option value="mobile_app" {{ old('location', $banner->location) == 'mobile_app' ? 'selected' : '' }}>تطبيق الهاتف</option>
                <option value="both" {{ old('location', $banner->location) == 'both' ? 'selected' : '' }}>كلاهما</option>
            </select>
            @error('location')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="avatar" class="block text-sm font-medium text-gray-700">صورة البنر</label>
            @if ($banner->avatar)
                <img src="{{ asset('storage/' . $banner->avatar) }}" alt="Banner Image" style="width: 100px; height: 100px; margin-bottom: 10px;">
                <button type="button" onclick="deleteImage({{ $banner->id }})" class="text-red-600">حذف الصورة</button>
            @endif
            <input type="file" name="avatar" id="avatar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('avatar')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="is_active" class="block text-sm font-medium text-gray-700">الحالة</label>
            <select name="is_active" id="is_active" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="نشط" {{ old('is_active', $banner->is_active) == 'نشط' ? 'selected' : '' }}>نشط</option>
                <option value="غير نشط" {{ old('is_active', $banner->is_active) == 'غير نشط' ? 'selected' : '' }}>غير نشط</option>
            </select>
            @error('is_active')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="start_date" class="block text-sm font-medium text-gray-700">تاريخ البدء</label>
            <input type="datetime-local" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('start_date', $banner->start_date ? $banner->start_date->format('Y-m-d\TH:i') : '') }}">
            @error('start_date')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="end_date" class="block text-sm font-medium text-gray-700">تاريخ الانتهاء</label>
            <input type="datetime-local" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('end_date', $banner->end_date ? $banner->end_date->format('Y-m-d\TH:i') : '') }}">
            @error('end_date')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">تحديث البنر</button>
        </div>
    </form>
</div>

<script>
    function deleteImage(bannerId) {
        if (confirm('هل أنت متأكد من حذف الصورة؟')) {
            fetch('{{ route('admin.banners.delete-image') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ banner_id: bannerId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
</script>
@endsection