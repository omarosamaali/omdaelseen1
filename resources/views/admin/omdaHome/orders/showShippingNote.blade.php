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

    .note-image {
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
        <h2 class="text-right mb-4 font-bold text-xl">تفاصيل ملاحظة الشحن</h2>

        <div class="card text-right">
            <div class="mb-4">
                <span class="detail-label">رقم الشحن:</span>
                <span class="detail-value">{{ $shippingNote->note_number }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">رقم المرجع:</span>
                <span class="detail-value">{{ $order->reference_number }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">تاريخ الشحن:</span>
                <span class="detail-value">{{ $shippingNote->note_date }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">العنوان:</span>
                <span class="detail-value">{{ $shippingNote->title }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">التفاصيل:</span>
                <span class="detail-value">{{ $shippingNote->details }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">الملف:</span>
                @if ($shippingNote->file_path)
                @php
                $extension = strtolower(pathinfo($shippingNote->file_path, PATHINFO_EXTENSION));
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png']);
                @endphp
                @if ($isImage)
                <div>
                    <img src="{{ Storage::url($shippingNote->file_path) }}" alt="Shipping Note Image"
                        class="note-image">
                    <div class="mt-2" style="display: flex; gap: 10px;">
                        <a href="{{ Storage::url($shippingNote->file_path) }}" class="detail-value text-blue-600"
                            download>تحميل الأصلي</a>
                        <button class="detail-value text-gray-600" disabled>تحميل كـ PDF (غير متاح)</button>
                    </div>
                </div>
                @else
                <a href="{{ Storage::url($shippingNote->file_path) }}" class="detail-value text-blue-600" download>تحميل
                    الملف</a>
                @endif
                @else
                <span class="detail-value">لا يوجد ملف</span>
                @endif
            </div>
            <div class="mb-4">
                <span class="detail-label">الحالة:</span>
                <span class="detail-value">{{ $shippingNote->status }}</span>
            </div>
            @if($shippingNote->order_type != 'App\Models\Payment')
            <div class="mb-4">
                <span class="detail-label">نوع الطلب:</span>
                <span class="detail-value">{{ $shippingNote->order_type == 'App\\Models\\TripRequest' ? 'رحلة' : 'منتج
                    خاص' }}</span>
            </div>
            @endif
            <div class="mb-4">
                <span class="detail-label">اسم العميل:</span>
                <span class="detail-value">{{ $order->user->name ?? 'غير متاح' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection