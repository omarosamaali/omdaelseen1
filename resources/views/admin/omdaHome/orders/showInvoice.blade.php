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
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="p-4 text-end" style="margin-top: 30px;">
    <div class="container py-4 mx-auto max-w-4xl">
        <h2 class="text-right mb-4 font-bold text-xl">تفاصيل الفاتورة</h2>

        <div class="card text-right">
            <div class="mb-4">
                <span class="detail-label">رقم الفاتورة:</span>
                <span class="detail-value">{{ $invoice->invoice_number }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">رقم المرجع:</span>
                <span class="detail-value">{{ $order->reference_number }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">تاريخ الفاتورة:</span>
                <span class="detail-value">{{ $invoice->invoice_date }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">العنوان:</span>
                <span class="detail-value">{{ $invoice->title }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">المبلغ:</span>
                <span class="detail-value">{{ $invoice->amount }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">تاريخ ووقت الإنشاء:</span>
                <span class="detail-value">{{ $invoice->created_at }}</span>
            </div>
            <div class="mb-4">
                <span class="detail-label">الحالة:</span>
                <span class="detail-value">{{ $invoice->status }}</span>
            </div>
            @if($invoice->order_type != 'App\Models\Payment')
            <div class="mb-4">
                <span class="detail-label">نوع الطلب:</span>
                <span class="detail-value">{{ $invoice->order_type == 'App\\Models\\TripRequest' || $invoice->order_type == 'App\\Models\\UnpaidTripRequests' ? 'رحلة' : 'منتج خاص'
                    }}
                </span>
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