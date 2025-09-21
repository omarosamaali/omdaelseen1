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
</style>

<div style="display: flex; flex-direction: row-reverse; margin-right: 77px !important; position: relative; margin: 0px 20px; z-index: 1;">
    <!-- Right Card: Status and Metadata -->
    <div style="height: fit-content; background: white; border-radius: 10px; padding: 20px; margin-top: 24px; width: 400px;">
        <div>
            <div class="info-label">الحالة</div>
            <div class="info-value">
                @if($faq->status == 'نشط')
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">نشط</span>
                @else
                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">غير نشط</span>
                @endif
            </div>

            <div class="info-label">التصنيف</div>
            <div class="info-value">{{ $faq->category ?? 'غير محدد' }}</div>

            <div class="info-label">الترتيب</div>
            <div class="info-value">{{ $faq->order ?? 0 }}</div>

            <div class="info-label">تاريخ الإضافة</div>
            <div class="info-value">{{ $faq->created_at ? $faq->created_at->format('Y-m-d H:i:s') : '-' }}</