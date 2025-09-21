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

    .places-avatar {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #eaeaea;
        cursor: pointer;
        /* إضافة مؤشر للإشارة إلى إمكانية النقر */
    }

    .additional-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #eaeaea;
        cursor: pointer;
        /* إضافة مؤشر للإشارة إلى إمكانية النقر */
    }

    /* تصميم النافذة المنبثقة */
    .popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .popup-content {
        width: 52%;
        height: 70%;
        max-height: 90%;
        border-radius: 10px;
    }

    .popup-content img {
        width: 100%;
        height: 100%;
        display: block;
    }

    .popup-close {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #fff;
        color: #000;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        cursor: pointer;
    }
</style>

<div
    style="display: flex; flex-direction: row-reverse; margin-right: 77px !important; position: relative; margin: 0px 20px; z-index: 1;">
    <div
        style="height: fit-content; background: white; border-radius: 10px; padding: 20px; margin-top: 24px; width: 400px;">
        <div>
            <div class="info-label">الحالة</div>
            <div class="info-value">
                @if ($place->status == 'active' || $place->status == 'نشط')
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">نشط</span>
                @elseif($place->status == 'inactive' || $place->status == 'غير نشط')
                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">غير نشط</span>
                @else
                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">محظور</span>
                @endif
            </div>

            <div class="info-label">تم الإضافة بواسطة</div>
            <div class="info-value">{{ Auth::user()->name }}</div>

            <div class="info-label">تاريخ الإضافة</div>
            <div class="info-value">{{ $place->created_at ? $place->created_at->format('Y-m-d H:i:s') : '-' }}</div>

            <div class="info-label">تاريخ التحديث</div>
            <div class="info-value">{{ $place->updated_at ? $place->updated_at->format('Y-m-d H:i:s') : '-' }}</div>
        </div>
    </div>

    <div class="container py-4 mx-auto max-w-4xl"
        style="position: relative; right: -50px; margin-top: 24px; background: white; border-radius: 10px; padding: 20px;">
        <h2 class="text-right mb-4 font-bold text-xl">تفاصيل المكان</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <div class="info-label">الاسم بالعربي</div>
                <div class="info-value">{{ $place->name_ar ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">الاسم بالإنجليزي</div>
                <div class="info-value">{{ $place->name_en ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">الاسم بالصيني</div>
                <div class="info-value">{{ $place->name_ch ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">التصنيف الرئيسي</div>
                <div class="info-value">{{ $place->mainCategory->name_ar ?? 'لا يوجد تصنيف رئيسي' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">التصنيف الفرعي</div>
                <div class="info-value">{{ $place->subCategory->name_ar ?? 'لا يوجد تصنيف فرعي' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">المنطقة</div>
                <div class="info-value">{{ $place->region->name_ar ?? 'غير محدد' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">رابط المكان</div>
                <div class="info-value mt-5">
                    <a href="{{ $place->link }}" target="_blank"
                        class="bg-blue-500 text-white rounded-md px-4 py-2 mt-5 hover:underline">{{ $place->map_type
                        }}</a>
                </div>
            </div>
            <div class="mb-4">
                <div class="info-label">رقم الهاتف</div>
                <div class="info-value">{{ $place->phone ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">البريد الإلكتروني</div>
                <div class="info-value">{{ $place->email ?? '-' }}</div>
            </div>

            <div class="mb-4 col-span-2">
                <div class="info-label">الصورة</div>
                <div class="info-value">
                    @if ($place->avatar)
                    <img src="{{ asset('storage/' . $place->avatar) }}" alt="{{ $place->name_ar }}"
                        class="places-avatar" onclick="openPopup('{{ asset('storage/' . $place->avatar) }}')">
                    @else
                    <span class="text-gray-400">لا توجد صورة</span>
                    @endif
                </div>
            </div>
            <div class="mb-4 col-span-2">
                <div class="info-label">صور إضافية</div>
                <div class="info-value">
                    @if ($place->additional_images)
                    <div class="flex flex-wrap gap-2">
                        @foreach (json_decode($place->additional_images, true) as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="Additional Image" class="additional-image"
                            onclick="openPopup('{{ asset('storage/' . $image) }}')">
                        @endforeach
                    </div>
                    @else
                    <span class="text-gray-400">لا توجد صور إضافية</span>
                    @endif
                </div>
            </div>
            <div class="mb-4 col-span-2">
                <div class="info-label">التفاصيل بالعربي</div>
                <div class="info-value">{{ $place->details_ar ?? 'لا توجد تفاصيل' }}</div>
            </div>
            <div class="mb-4 col-span-2">
                <div class="info-label">التفاصيل الانجليزية</div>
                <div class="info-value">{{ $place->details_en ?? 'لا توجد تفاصيل' }}</div>
            </div>
            <div class="mb-4 col-span-2">
                <div class="info-label">التفاصيل بالصيني</div>
                <div class="info-value">{{ $place->details_ch ?? 'لا توجد تفاصيل' }}</div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('admin.places.edit', $place->id) }}"
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">تعديل</a>
            <a href="{{ route('admin.places.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">العودة</a>
        </div>
    </div>
</div>

<!-- النافذة المنبثقة -->
<div class="popup-overlay" id="popupOverlay">
    <div class="popup-content">
        <button class="popup-close" onclick="closePopup()">&times;</button>
        <img id="popupImage" src="" alt="Popup Image">
    </div>
</div>

<script>
    function openPopup(imageSrc) {
            const popupOverlay = document.getElementById('popupOverlay');
            const popupImage = document.getElementById('popupImage');
            popupImage.src = imageSrc;
            popupOverlay.style.display = 'flex';
        }

        function closePopup() {
            const popupOverlay = document.getElementById('popupOverlay');
            popupOverlay.style.display = 'none';
        }

        // إغلاق النافذة المنبثقة عند النقر خارج الصورة
        document.getElementById('popupOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closePopup();
            }
        });
</script>
@endsection