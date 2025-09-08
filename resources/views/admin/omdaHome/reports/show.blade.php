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

        .btn-accept {
            background-color: #10b981;
            color: white;
        }

        .btn-accept:hover {
            background-color: #059669;
        }

        .btn-dismiss {
            background-color: #ef4444;
            color: white;
        }

        .btn-dismiss:hover {
            background-color: #dc2626;
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

        .alert-success {
            background-color: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }

        .alert-danger {
            background-color: #fef2f2;
            border-color: #dc2626;
            color: #991b1b;
        }

        .place-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
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

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }

        .close-modal:hover,
        .close-modal:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }
            to {
                transform: scale(1)
            }
        }
    </style>

    <div style="display: flex; flex-direction: row-reverse; margin-right: 77px !important; position: relative; margin: 0px 20px; z-index: 1;">
        <div style="height: fit-content; background: white; border-radius: 10px; padding: 20px; margin-top: 24px; width: 400px;">
            <h3 class="text-right mb-4 font-bold text-lg">إجراءات البلاغ</h3>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="info-label">حالة البلاغ</div>
            <div class="info-value">
                @if ($report->status == 'pending')
                    <span class="status-badge status-pending">في الانتظار</span>
                @elseif($report->status == 'resolved')
                    <span class="status-badge status-resolved">تم الحل</span>
                @elseif($report->status == 'dismissed')
                    <span class="status-badge status-dismissed">مرفوض</span>
                @else
                    <span class="status-badge status-pending">غير محدد</span>
                @endif
            </div>
@if ($report->status == 'pending')
    <div class="flex flex-wrap">
        @if ($report instanceof \App\Models\Report)
            <form method="POST" action="{{ route('admin.reports.accept_report', $report->id) }}" class="inline">
                @csrf
                <button type="submit" class="action-btn btn-accept"
                    onclick="return confirm('هل أنت متأكد من قبول البلاغ وتعطيل المكان؟')">قبول البلاغ</button>
            </form>
            <form method="POST" action="{{ route('admin.reports.dismiss_report', $report->id) }}" class="inline">
                @csrf
                <button type="submit" class="action-btn btn-dismiss"
                    onclick="return confirm('هل أنت متأكد من رفض البلاغ؟')">رفض البلاغ</button>
            </form>
        @elseif ($report instanceof \App\Models\ReviewReport)
            <form method="POST" action="{{ route('admin.reports.review_accept', $report->id) }}" class="inline">
                @csrf
                <button type="submit" class="action-btn btn-accept"
                    onclick="return confirm('هل أنت متأكد من قبول بلاغ المراجعة؟')">قبول بلاغ المراجعة</button>
            </form>
            <form method="POST" action="{{ route('admin.reports.review_dismiss', $report->id) }}" class="inline">
                @csrf
                <button type="submit" class="action-btn btn-dismiss"
                    onclick="return confirm('هل أنت متأكد من رفض بلاغ المراجعة؟')">رفض بلاغ المراجعة</button>
            </form>
        @endif
    </div>
@endif
            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.reports.index') }}" class="action-btn btn-back">العودة</a>
            </div>
        </div>

        <div class="container py-4 mx-auto max-w-4xl"
            style="position: relative; right: -50px; margin-top: 24px; background: white; border-radius: 10px; padding: 20px;">
            <h2 class="text-right mb-4 font-bold text-xl">تفاصيل البلاغ</h2>

            @if ($report instanceof \App\Models\Report && $report->place && $report->place->status == 'active')
                <div class="alert alert-danger">
                    <strong>تحذير:</strong> هذا المكان لا يزال نشطاً في النظام
                </div>
            @elseif ($report instanceof \App\Models\Report && (!$report->place || $report->place->status == 'inactive'))
                <div class="alert alert-success">
                    <strong>ملاحظة:</strong> المكان غير نشط أو غير موجود في النظام
                </div>
            @elseif ($report instanceof \App\Models\ReviewReport)
                <div class="alert alert-info">
                    <strong>ملاحظة:</strong> هذا بلاغ مراجعة، لا يتعلق بتفعيل أو تعطيل مكان
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4 col-span-2">
                    <h3 class="text-lg font-bold mb-2">معلومات المُبلِغ</h3>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="info-label">اسم المُبلِغ</div>
                        <div class="info-value">{{ $report->user->name ?? 'مستخدم محذوف' }}</div>

                        <div class="info-label">البريد الإلكتروني</div>
                        <div class="info-value">{{ $report->user->email ?? 'غير متاح' }}</div>
                    </div>
                </div>

                @if ($report->place)
                    <div class="mb-4 col-span-2">
                        <h3 class="text-lg font-bold mb-2">معلومات المكان المُبلغ عنه</h3>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="info-label">الاسم بالعربي</div>
                            <div class="info-value">{{ $report->place->name_ar ?? '-' }}</div>

                            <div class="info-label">الاسم بالإنجليزي</div>
                            <div class="info-value">{{ $report->place->name_en ?? '-' }}</div>

                            <div class="info-label">الاسم بالصيني</div>
                            <div class="info-value">{{ $report->place->name_ch ?? '-' }}</div>

                            @if ($report instanceof \App\Models\Report)
                                <div class="info-label">حالة المكان</div>
                                <div class="info-value">{{ $report->place->status == 'active' ? 'نشط' : 'غير نشط' }}</div>
                            @endif

                            @if ($report->place->user)
                                <div class="info-label">صاحب المكان</div>
                                <div class="info-value">{{ $report->place->user->name }}</div>
                            @endif

                            <div class="info-label">التفاصيل</div>
                            <div class="info-value">{{ Str::limit($report->place->details ?? 'لا توجد تفاصيل', 100) }}</div>

                            @if ($report->place->avatar)
                                <div class="info-label">صورة المكان</div>
                                <div class="info-value">
                                    <img src="{{ asset('storage/' . $report->place->avatar) }}"
                                        alt="{{ $report->place->name_ar }}" class="explorer-avatar">
                                </div>
                            @endif

                            @if ($report->place && $report->place->additional_images && is_array(json_decode($report->place->additional_images, true)))
                                <div class="images-gallery">
                                    @foreach (json_decode($report->place->additional_images, true) as $image)
                                        <img src="{{ asset('storage/' . $image) }}"
                                            alt="{{ $report->place->name_ar ?? 'مكان غير متوفر' }}"
                                            class="place-image">
                                    @endforeach
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

                @if ($report instanceof \App\Models\ReviewReport)
                    <div class="mb-4 col-span-2">
                        <h3 class="text-lg font-bold mb-2">تفاصيل المراجعة</h3>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="info-label">نص المراجعة</div>
                            <div class="info-value">{{ $report->review_text ?? 'لا يوجد نص مراجعة' }}</div>

                            <div class="info-label">التقييم</div>
                            <div class="info-value">{{ $report->rating ?? 'غير متوفر' }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="imageModal" class="modal">
        <span class="close-modal">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("imageModal");
        var modalImg = document.getElementById("modalImage");

        // Get all images and insert the onclick attribute
        var allImages = document.querySelectorAll('.explorer-avatar, .place-image');
        allImages.forEach(function(img) {
            img.onclick = function() {
                modal.style.display = "block";
                modalImg.src = this.src;
            }
        });

        var span = document.getElementsByClassName("close-modal")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
@endsection