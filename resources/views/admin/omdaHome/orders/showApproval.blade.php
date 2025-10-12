@extends($layout)

@section('content')
<style>
    .th {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
        text-align: right;
    }

    .detail-label {
        font-weight: bold;
        color: #4B5563;
    }

    .detail-value {
        color: #1F2937;
    }

    .card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .approval-image {
        max-width: 100%;
        max-height: 400px;
        object-fit: contain;
        margin-top: 10px;
        border-radius: 5px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="p-4 text-end" style="margin-top: 30px;">
    <div class="container py-4 mx-auto max-w-4xl">
        <h2 class="text-right mb-4 font-bold text-xl">تفاصيل الموافقة</h2>

        <div class="card text-right">
            <div class="mb-4">
                <span class="detail-label">رقم الموافقة:</span>
                <span class="detail-value">{{ $approval->approval_number }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">رقم المرجع:</span>
                <span class="detail-value">{{ $order->reference_number }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">تاريخ الموافقة:</span>
                <span class="detail-value">{{ $approval->approval_date }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">العنوان:</span>
                <span class="detail-value">{{ $approval->title }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">التفاصيل:</span>
                <span class="detail-value">{{ $approval->details }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">الملف:</span>
                @if ($approval->file_path)
                @php
                $extension = strtolower(pathinfo($approval->file_path, PATHINFO_EXTENSION));
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png']);
                @endphp
                @if ($isImage)
                <div>
                    <img src="{{ Storage::url($approval->file_path) }}" alt="Approval Image" class="approval-image">
                    <div class="mt-2" style="display: flex; gap: 10px;">
                        <a href="{{ Storage::url($approval->file_path) }}" class="detail-value text-blue-600"
                            download>تحميل الأصلي</a>
                        <button class="detail-value text-gray-600" disabled>تحميل كـ PDF (غير متاح)</button>
                    </div>
                </div>
                @else
                <a href="{{ Storage::url($approval->file_path) }}" class="detail-value text-blue-600" download>تحميل
                    الملف</a>
                @endif
                @else
                <span class="detail-value">لا يوجد ملف</span>
                @endif
            </div>
            <div class="mb-4">
                <span class="detail-label">الحالة:</span>
                <span class="detail-value">{{ $approval->status }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">نوع الطلب:</span>
                <span class="detail-value">{{ $approval->order_type == 'App\\Models\\TripRequest' ? 'رحلة' : 'منتج خاص'
                    }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">اسم العميل:</span>
                <span class="detail-value">{{ $order->user->name ?? 'غير متاح' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection