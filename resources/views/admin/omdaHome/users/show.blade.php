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

<div style="display: flex
;
    flex-direction: row-reverse;
    margin-right: 77px !important;
    position: relative;
    margin: 0px 20px;
    z-index: 9999999999999;">
    <!-- البطاقة اليمنى لعرض المعلومات الأساسية -->
    <div style="height: fit-content; background: white; border-radius: 10px; padding: 20px; margin-top: 24px; width: 400px;">
        <div>
            <div class="info-label">الصلاحية</div>
            <div class="info-value">{{ $usser->role == 'admin' ? 'مدير' : ($usser->role == 'user' ? 'مستخدم' : ($usser->role ?? '-')) }}</div>

            <div class="info-label">تاريخ التسجيل</div>
            <div class="info-value">{{ $usser->created_at ? $usser->created_at->format('Y-m-d H:i:s') : '-' }}</div>

            <div class="info-label">تاريخ التحديث</div>
            <div class="info-value">{{ $usser->updated_at ? $usser->updated_at->format('Y-m-d H:i:s') : '-' }}</div>
        </div>
    </div>

    <!-- البطاقة اليسرى لعرض باقي التفاصيل -->
    <div class="container py-4 mx-auto max-w-4xl" style="position: relative; right: -50px; margin-top: 24px; background: white; border-radius: 10px; padding: 20px;">
        <h2 class="text-right mb-4 font-bold text-xl">تفاصيل المستخدم</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <div class="info-label">الاسم</div>
                <div class="info-value">{{ $usser->name ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">رقم الهاتف</div>
                <div class="info-value">{{ $usser->phone ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">البريد الإلكتروني</div>
                <div class="info-value">{{ $usser->email ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">الدولة</div>
                <div class="info-value">{{ $countries[$usser->country] ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">الصلاحية</div>
                <div class="info-value">{{ $usser->role == 'admin' ? 'مدير' : ($usser->role == 'user' ? 'مستخدم' : ($usser->role ?? '-')) }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">الحالة</div>
                <div class="info-value">{{ $usser->status ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <div class="info-label">الصورة الشخصية</div>
                <div class="info-value">
                    @if ($usser->avatar)
                        <a href="{{ Storage::url($usser->avatar) }}" target="_blank">عرض الصورة</a>
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection