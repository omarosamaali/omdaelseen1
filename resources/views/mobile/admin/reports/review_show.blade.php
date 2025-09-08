@extends('layouts.mobile')
<title>تفاصيل بلاغ المراجعة</title>
@section('content')
    <style>
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            text-align: center;
            min-width: 80px;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #f59e0b;
        }

        .status-resolved {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .status-dismissed {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        .action-btn {
            display: block;
            padding: 0.875rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            width: 100%;
            text-align: center;
            margin: 0.5rem 0;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-accept {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .btn-accept:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
        }

        .btn-dismiss {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-dismiss:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
        }

        .btn-back {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #4b5563, #374151);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(107, 114, 128, 0.3);
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.75rem;
            border-left: 4px solid;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .alert-success {
            background-color: #ecfdf5;
            border-color: #10b981;
            color: #065f46;
        }

        .alert-danger {
            background-color: #fef2f2;
            border-color: #dc2626;
            color: #991b1b;
        }

        .info-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
        }

        .info-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }

        .info-value {
            color: #6b7280;
            font-size: 1rem;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .report-id {
            background: #f3f4f6;
            color: #6b7280;
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .place-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
        }

        .timestamp {
            background: #f9fafb;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
            text-align: center;
            margin-bottom: 1rem;
        }

        .actions-container {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 1rem;
            margin-bottom: 1rem;
        }

        .warning-text {
            background: #fffbeb;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            text-align: center;
            font-size: 0.875rem;
        }

        .images-gallery {
            display: flex;
            overflow-x: auto;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-bottom: 0.5rem;
            scrollbar-width: thin;
            scrollbar-color: #d1d5db transparent;
        }

        .images-gallery::-webkit-scrollbar {
            height: 6px;
        }

        .images-gallery::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 3px;
        }

        .images-gallery::-webkit-scrollbar-track {
            background: transparent;
        }

        .star-rating {
            display: inline-flex;
            direction: ltr;
        }

        .star {
            width: 20px;
            height: 20px;
            margin-right: 2px;
            fill: #d1d5db;
        }

        .star.filled {
            fill: #facc15;
        }
    </style>

    <div class="flex justify-start items-center relative z-10">
        <div class="logo-register">
            <img src="{{ asset('assets/assets/images/logo-all.png') }}" class="image-regsiter" alt="">
        </div>
        <x-back-button href="{{ route('mobile.reports.index') }}" />
    </div>

    <div class="container mx-auto px-4 py-6 max-w-md">
        <!-- عنوان الصفحة مع معرف البلاغ -->
        <div class="page-header">
            <h2 class="font-bold text-xl">تفاصيل بلاغ المراجعة</h2>
            <span class="report-id">#{{ $report->id }}</span>
        </div>

        <!-- الوقت والتاريخ -->
        <div class="timestamp">
            <i class="fas fa-clock ml-2"></i>
            تم الإرسال: {{ $report->created_at->format('d/m/Y - H:i') }}
        </div>

        <!-- رسائل النجاح أو الخطأ -->
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle ml-2"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle ml-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- حالة البلاغ -->
        <div class="info-card">
            <div class="info-label">
                <i class="fas fa-flag ml-2"></i>
                حالة البلاغ
            </div>
            <div class="text-center mt-2">
                @if ($report->status == 1)
                    <span class="status-badge status-pending">
                        <i class="fas fa-hourglass-half ml-1"></i>
                        في الانتظار
                    </span>
                @elseif($report->status == 0)
                    <span class="status-badge status-resolved">
                        <i class="fas fa-check ml-1"></i>
                        تم الحل
                    </span>
                @elseif($report->status == 'dismissed')
                    <span class="status-badge status-dismissed">
                        <i class="fas fa-times ml-1"></i>
                        مرفوض
                    </span>
                @else
                    <span class="status-badge status-pending">
                        <i class="fas fa-question ml-1"></i>
                        غير محدد
                    </span>
                @endif
            </div>
        </div>

        <!-- معلومات المُبلِغ -->
        <div class="info-card">
            <h3 class="text-lg font-bold mb-3 text-right">
                <i class="fas fa-user ml-2"></i>
                معلومات المُبلِغ
            </h3>
            <div class="info-item">
                <div class="info-label">الاسم</div>
                <div class="info-value">{{ $report->user->name ?? 'مستخدم محذوف' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">البريد الإلكتروني</div>
                <div class="info-value">{{ $report->user->email ?? 'غير متاح' }}</div>
            </div>
        </div>

        <!-- تفاصيل التقييم -->
        @if ($report->rating)
            <div class="info-card">
                <h3 class="text-lg font-bold mb-3 text-right">
                    <i class="fas fa-star ml-2"></i>
                    تفاصيل التقييم
                </h3>
                <div class="info-item">
                    <div class="info-label">نص التقييم</div>
                    <div class="info-value">{{ $report->rating->comment ?? 'لا يوجد نص تقييم' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">التقييم</div>
                    <div class="info-value">
                        <div class="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="star {{ $i <= $report->rating->rating ? 'filled' : '' }}"
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.416 3.967 1.48-8.279-6.064-5.828 8.332-1.151z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">مقدم التقييم</div>
                    <div class="info-value">{{ $report->rating->user->name ?? 'مستخدم محذوف' }}</div>
                </div>
            </div>
        @else
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle ml-2"></i>
                <strong>تحذير:</strong> التقييم المُبلغ عنه غير موجود أو تم حذفه
            </div>
        @endif

        <!-- معلومات المكان -->
        @if ($report->place)
            <div class="info-card">
                <h3 class="text-lg font-bold mb-3 text-right">
                    <i class="fas fa-map-marker-alt ml-2"></i>
                    معلومات المكان
                </h3>
                <div class="info-item">
                    <div class="info-label">الاسم بالعربي</div>
                    <div class="info-value">{{ $report->place->name_ar ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">الاسم بالإنجليزي</div>
                    <div class="info-value">{{ $report->place->name_en ?? '-' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">حالة المكان</div>
                    <div class="info-value">
                        @if ($report->place->status == 'active')
                            <span class="text-green-600 font-medium">
                                <i class="fas fa-check-circle ml-1"></i>
                                نشط
                            </span>
                        @else
                            <span class="text-red-600 font-medium">
                                <i class="fas fa-times-circle ml-1"></i>
                                غير نشط
                            </span>
                        @endif
                    </div>
                </div>
                @if ($report->place->user)
                    <div class="info-item">
                        <div class="info-label">صاحب المكان</div>
                        <div class="info-value">{{ $report->place->user->name }}</div>
                    </div>
                @endif
                @if ($report->place->avatar)
                    <div class="info-item">
                        <div class="info-label">صورة المكان</div>
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $report->place->avatar) }}"
                                alt="{{ $report->place->name_ar }}" class="place-image">
                        </div>
                    </div>
                @endif
                @if (
                    $report->place &&
                    $report->place->additional_images &&
                    is_array(json_decode($report->place->additional_images, true))
                )
                    <div class="images-gallery">
                        @foreach (json_decode($report->place->additional_images, true) as $image)
                            <img src="{{ asset('storage/' . $image) }}"
                                alt="{{ $report->place->name_ar ?? 'مكان غير متوفر' }}"
                                class="place-image">
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle ml-2"></i>
                <strong>تحذير:</strong> المكان المُبلغ عنه غير موجود أو تم حذفه
            </div>
        @endif

        <!-- إجراءات البلاغ -->
        @if ($report->status == 1)
            <div class="actions-container">
                <h3 class="text-lg font-bold mb-3 text-right">
                    <i class="fas fa-cogs ml-2"></i>
                    إجراءات البلاغ
                </h3>
                <div class="warning-text">
                    <i class="fas fa-info-circle ml-1"></i>
                    تأكد من مراجعة البلاغ بعناية قبل اتخاذ أي إجراء
                </div>
                <form method="POST" action="{{ route('mobile.reports.review_accept', $report->id) }}">
                    @csrf
                    <button type="submit" class="action-btn btn-accept"
                        onclick="return confirm('هل أنت متأكد من قبول بلاغ المراجعة؟\n\nسيتم إخفاء التقييم مؤقتًا حتى يتم المراجعة.')">
                        <i class="fas fa-check ml-2"></i>
                        قبول البلاغ
                    </button>
                </form>
                <form method="POST" action="{{ route('mobile.reports.review_dismiss', $report->id) }}">
                    @csrf
                    <button type="submit" class="action-btn btn-dismiss"
                        onclick="return confirm('هل أنت متأكد من رفض بلاغ المراجعة؟\n\nسيبقى التقييم نشطًا.')">
                        <i class="fas fa-times ml-2"></i>
                        رفض البلاغ
                    </button>
                </form>
            </div>
        @endif

        <!-- معلومات إضافية للبلاغات المكتملة -->
        @if ($report->status != 1)
            <div class="info-card">
                <h3 class="text-lg font-bold mb-3 text-right">
                    <i class="fas fa-history ml-2"></i>
                    معلومات الإجراء
                </h3>
                <div class="info-item">
                    <div class="info-label">تاريخ الإجراء</div>
                    <div class="info-value">{{ $report->resolved_at ? $report->resolved_at->format('d/m/Y - H:i') : 'غير متاح' }}</div>
                </div>
                @if ($report->resolved_by)
                    <div class="info-item">
                        <div class="info-label">تم الإجراء بواسطة</div>
                        <div class="info-value">{{ $report->resolver ? $report->resolver->name : 'غير معروف' }}</div>
                    </div>
                @endif
            </div>
        @endif

        <!-- زر العودة -->
        <div class="mt-6">
            <a href="{{ route('mobile.reports.index') }}" class="action-btn btn-back">
                <i class="fas fa-arrow-right ml-2"></i>
                العودة للقائمة
            </a>
        </div>
    </div>

    <!-- إضافة Font Awesome للأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection