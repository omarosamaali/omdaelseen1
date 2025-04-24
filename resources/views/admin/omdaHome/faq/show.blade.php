@extends($layout)

@section('content')
<style>
    .info-label {
        font-weight: bold;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .info-value {
        color: #6b7280;
        margin-bottom: 1rem;
    }

    .container {
        max-width: 100%;
    }

    .explorer-avatar {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #eaeaea;
    }

</style>

<div style="display: flex;
    flex-direction: row-reverse;
    margin-right: 77px !important;
    position: relative;
    margin: 0px 20px;
    z-z-index: 1;">
    <div style="height: fit-content; background: white; border-radius: 10px; padding: 20px; margin-top: 24px; width: 400px;">
        <div>
            <div class="info-label">الحالة</div>
            <div class="info-value">
                @if($region->status == 'active' || $region->status == 'نشط')
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">نشط</span>
                @else
                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">غير نشط</span>
                @endif
            </div>

            <div class="info-label">عدد الأماكن</div>
            <div class="info-value">{{ $region->places ?? 0 }}</div>

            <div class="info-label">تاريخ الإضافة</div>
            <div class="info-value">{{ $region->created_at ? $region->created_at->format('Y-m-d H:i:s') : '-' }}</div>

            <div class="info-label">تاريخ التحديث</div>
            <div class="info-value">{{ $region->updated_at ? $region->updated_at->format('Y-m-d H:i:s') : '-' }}</div>
        </div>
    </div>

    <!-- البطاقة اليسرى لعرض التفاصيل الرئيسية -->
    <div class="container py-4 mx-auto max-w-4xl" style="position: relative; right: -50px; margin-top: 24px; background: white; border-radius: 10px; padding: 20px;">
        <h2 class="text-right mb-4 font-bold text-xl">تفاصيل التصنيف الرئيسي</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <div class="info-label">الاسم بالعربي</div>
                <div class="info-value">{{ $region->name_ar ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">الاسم بالإنجليزي</div>
                <div class="info-value">{{ $region->name_en ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">الاسم بالصيني</div>
                <div class="info-value">{{ $region->name_ch ?? '-' }}</div>
            </div>

            <div class="mb-4 col-span-2">
                <div class="info-label">الصورة الشخصية</div>
                <div class="info-value">
                    @if($region->avatar)
                    <img src="{{ asset('storage/' . $region->avatar) }}" alt="{{ $region->name_ar }}" class="explorer-avatar">
                    @else
                    <span class="text-gray-400">لا توجد صورة</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('admin.regions.edit', $region->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">تعديل</a>
            <a href="{{ route('admin.regions.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">العودة</a>
        </div>
    </div>
</div>
@endsection
```
