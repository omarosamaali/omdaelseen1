@extends($layout)

@section('content')
<style>
    .info-label {
        font-weight: bold;
        color: #374151;
        margin-bottom: 0.3rem;
    }

    .info-value {
        color: #6b7280;
        margin-bottom: 1rem;
        word-wrap: break-word;
        white-space: pre-wrap;
    }

    .explorer-avatar {
        width: 200px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #e5e7eb;
    }
</style>

<div class="flex flex-row-reverse gap-6 mx-10 my-10">

    <div style="background: white; border-radius: 10px; padding: 20px; width: 350px;">
        <div class="info-label">الحالة</div>
        <div class="my-5">
            @if($event->status == 'نشط' || $event->status == 'active')
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full">نشط</span>
            @else
            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full">غير نشط</span>
            @endif
        </div>

        <div class="info-label">النوع</div>
        <div class="info-value">{{ $event->type ?? '-' }}</div>

        <div class="info-label">تاريخ البدء</div>
        <div class="info-value">{{ $event->start_date ?? '-' }}</div>

        <div class="info-label">تاريخ الانتهاء</div>
        <div class="info-value">{{ $event->end_date ?? '-' }}</div>

        <div class="info-label">تاريخ الإضافة</div>
        <div class="info-value">{{ $event->created_at?->format('Y-m-d H:i') ?? '-' }}</div>

        <div class="info-label">آخر تحديث</div>
        <div class="info-value">{{ $event->updated_at?->format('Y-m-d H:i') ?? '-' }}</div>
    </div>

    <div class="flex-1 bg-white rounded-lg p-6">
        <h2 class="text-right mb-6 font-bold text-xl">تفاصيل الحدث / المعرض</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <div class="info-label">العنوان (عربي)</div>
                <div class="info-value">{{ $event->title_ar ?? '-' }}</div>
            </div>

            <div>
                <div class="info-label">العنوان (إنجليزي)</div>
                <div class="info-value">{{ $event->title_en ?? '-' }}</div>
            </div>

            <div>
                <div class="info-label">العنوان (صيني)</div>
                <div class="info-value">{{ $event->title_zh ?? '-' }}</div>
            </div>

            {{-- الوصف --}}
            <div class="col-span-2">
                <div class="info-label">الوصف (عربي)</div>
                <div class="info-value">{{ $event->description_ar ?? '-' }}</div>
            </div>

            <div class="col-span-2">
                <div class="info-label">الوصف (إنجليزي)</div>
                <div class="info-value">{{ $event->description_en ?? '-' }}</div>
            </div>

            <div class="col-span-2">
                <div class="info-label">الوصف (صيني)</div>
                <div class="info-value">{{ $event->description_zh ?? '-' }}</div>
            </div>

            <div class="col-span-2">
                <div class="info-label">الصورة</div>
                <div class="info-value">
                    @if($event->avatar)
                    <img src="{{ asset('storage/' . $event->avatar) }}" alt="صورة الحدث"
                        class="explorer-avatar cursor-pointer"
                        onclick="openImageModal('{{ asset('storage/' . $event->avatar) }}')">
                    @else
                    <span class="text-gray-400">لا توجد صورة</span>
                    @endif
                </div>
            </div>

            <div id="imageModal"
                class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
                <div class="relative">
                    <img id="modalImage" src="" alt="صورة الحدث" class="max-w-[90vw] max-h-[80vh] rounded-lg shadow-lg">
                    <button onclick="closeImageModal()"
                        class="absolute top-2 right-2 bg-black bg-opacity-60 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl font-bold">
                        &times;
                    </button>
                </div>
            </div>



        </div>
        <div class="mt-8 flex justify-between gap-2 w-full">
            <a href="{{ route('admin.events.edit', $event->id) }}"
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">تعديل</a>
            <a href="{{ route('admin.events.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">العودة</a>
        </div>
    </div>

    <script>
        function openImageModal(src) {
                    document.getElementById('modalImage').src = src;
                    document.getElementById('imageModal').classList.remove('hidden');
                }
            
                function closeImageModal() {
                    document.getElementById('imageModal').classList.add('hidden');
                }
            
                document.getElementById('imageModal').addEventListener('click', function (e) {
                    if (e.target.id === 'imageModal') closeImageModal();
                });
    </script>
</div>
@endsection