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

    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .status-resolved {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-dismissed {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        margin: 0.25rem;
        transition: all 0.3s ease;
    }

    .btn-save {
        background-color: #10b981;
        color: white;
    }

    .btn-save:hover {
        background-color: #059669;
    }

    .btn-back {
        background-color: #6b7280;
        color: white;
    }

    .btn-back:hover {
        background-color: #4b5563;
    }

    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 0.5rem;
        border-left: 4px solid;
    }

    .alert-danger {
        background-color: #fef2f2;
        border-color: #dc2626;
        color: #991b1b;
    }

    .notes-form {
        margin-top: 2rem;
        padding: 1rem;
        background-color: #f9fafb;
        border-radius: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
    }

    .form-select {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        margin-bottom: 1rem;
        background-color: white;
    }

</style>

<div style="display: flex; flex-direction: row-reverse; margin-right: 77px !important; position: relative; margin: 0px 20px; z-index: 1;">
    <!-- البطاقة اليمنى لتحرير معلومات البلاغ -->
    <div style="height: fit-content; background: white; border-radius: 10px; padding: 20px; margin-top: 24px; width: 400px;">
        <h3 class="text-right mb-4 font-bold text-lg">تحرير معلومات البلاغ</h3>

        @if (session('success'))
        <div class="alert" style="background-color: #d1fae5; border-color: #10b981; color: #065f46;">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.reports.update', $report->id) }}">
            @csrf
            @method('PUT')

            <div class="info-label">حالة البلاغ</div>
            <select name="status" class="form-select @error('status') border-red-500 @enderror">
                <option value="pending" {{ old('status', $report->status) == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                <option value="resolved" {{ old('status', $report->status) == 'resolved' ? 'selected' : '' }}>تم الحل</option>
                <option value="dismissed" {{ old('status', $report->status) == 'dismissed' ? 'selected' : '' }}>مرفوض</option>
            </select>
            @error('status')
            <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

            <div class="info-label">الإجراء المتخذ</div>
            <select name="admin_action" class="form-select @error('admin_action') border-red-500 @enderror">
                <option value="" {{ !old('admin_action', $report->admin_action) ? 'selected' : '' }}>غير محدد</option>
                <option value="place_deleted" {{ old('admin_action', $report->admin_action) == 'place_deleted' ? 'selected' : '' }}>تم حذف المكان</option>
                <option value="warning_sent" {{ old('admin_action', $report->admin_action) == 'warning_sent' ? 'selected' : '' }}>تم إرسال تحذير</option>
                <option value="dismissed" {{ old('admin_action', $report->admin_action) == 'dismissed' ? 'selected' : '' }}>تم رفض البلاغ</option>
            </select>
            @error('admin_action')
            <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

            <div class="info-label">ملاحظات الإدارة</div>
            <textarea name="admin_notes" class="form-input @error('admin_notes') border-red-500 @enderror" rows="5">{{ old('admin_notes', $report->admin_notes) }}</textarea>
            @error('admin_notes')
            <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

            <div class="mt-6 flex justify-end gap-2">
                <button type="submit" class="action-btn btn-save">حفظ التغييرات</button>
                <a href="{{ route('admin.reports.show', $report->id) }}" class="action-btn btn-back">العودة</a>
            </div>
        </form>
    </div>

    <!-- البطاقة اليسرى لعرض التفاصيل الرئيسية -->
    <div class="container py-4 mx-auto max-w-4xl" style="position: relative; right: -50px; margin-top: 24px; background: white; border-radius: 10px; padding: 20px;">
        <h2 class="text-right mb-4 font-bold text-xl">تفاصيل البلاغ</h2>

        @if($report->place && !$report->place->deleted_at)
        <div class="alert alert-danger">
            <strong>تحذير:</strong> هذا المكان لا يزال متاحاً في النظام
        </div>
        @elseif(!$report->place || $report->place->deleted_at)
        <div class="alert" style="background-color: #d1fae5; border-color: #10b981; color: #065f46;">
            <strong>ملاحظة:</strong> تم حذف المكان من النظام
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- معلومات المبلغ -->
            <div class="mb-4 col-span-2">
                <h3 class="text-lg font-bold mb-2">معلومات المُبلِغ</h3>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="info-label">اسم المُبلِغ</div>
                    <div class="info-value">{{ $report->user->name ?? 'مستخدم محذوف' }}</div>

                    <div class="info-label">البريد الإلكتروني</div>
                    <div class="info-value">{{ $report->user->email ?? 'غير متاح' }}</div>
                </div>
            </div>

            <!-- معلومات المكان المُبلغ عنه -->
            @if($report->place)
            <div class="mb-4 col-span-2">
                <h3 class="text-lg font-bold mb-2">معلومات المكان المُبلغ عنه</h3>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="info-label">الاسم بالعربي</div>
                    <div class="info-value">{{ $report->place->name_ar ?? '-' }}</div>

                    <div class="info-label">الاسم بالإنجليزي</div>
                    <div class="info-value">{{ $report->place->name_en ?? '-' }}</div>

                    <div class="info-label">الاسم بالصيني</div>
                    <div class="info-value">{{ $report->place->name_ch ?? '-' }}</div>

                    @if($report->place->user)
                    <div class="info-label">صاحب المكان</div>
                    <div class="info-value">{{ $report->place->user->name }}</div>
                    @endif

                    <div class="info-label">التفاصيل</div>
                    <div class="info-value">{{ Str::limit($report->place->details ?? 'لا توجد تفاصيل', 100) }}</div>

                    @if($report->place->avatar)
                    <div class="info-label">صورة المكان</div>
                    <div class="info-value">
                        <img src="{{ asset('storage/' . $report->place->avatar) }}" alt="{{ $report->place->name_ar }}" class="explorer-avatar">
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="mb-4 col-span-2">
                <div class="alert alert-danger">
                    <strong>تحذير:</strong> المكان المُبلغ عنه غير موجود أو تم حذفه
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
