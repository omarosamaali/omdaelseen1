@extends('layouts.mobile')
<title>البلاغات</title>
@section('content')
    <style>
        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 1.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .page-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .report-card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid #f3f4f6;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: block;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .report-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .report-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-color: #e5e7eb;
        }

        .report-card:hover::before {
            transform: scaleX(1);
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .report-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .report-meta {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            color: #6b7280;
            gap: 0.5rem;
        }

        .meta-icon {
            width: 16px;
            height: 16px;
            opacity: 0.7;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 100px;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .status-pending {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
        }

        .status-resolved {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .status-dismissed {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.8;
        }

        .alert {
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            border-radius: 1rem;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 4px;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }

        .alert-success::before {
            background: #10b981;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            color: #991b1b;
        }

        .alert-danger::before {
            background: #dc2626;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            opacity: 0.3;
        }

        .empty-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .pagination-wrapper {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f3f4f6;
        }

        .floating-action {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .floating-action:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.6);
        }

        .search-box {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid #f3f4f6;
            border-radius: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            padding: 1rem;
            border-radius: 0.75rem;
            text-align: center;
            border: 1px solid #f3f4f6;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .filter-tabs {
            display: flex;
            background: #f8fafc;
            border-radius: 0.75rem;
            padding: 0.25rem;
            margin-bottom: 1.5rem;
            gap: 0.25rem;
        }

        .filter-tab {
            flex: 1;
            padding: 0.5rem;
            text-align: center;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
            color: #6b7280;
            text-decoration: none;
        }

        .filter-tab.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .report-card {
            animation: fadeInUp 0.5s ease forwards;
        }

        .report-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .report-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .report-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .report-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .report-card:nth-child(5) {
            animation-delay: 0.5s;
        }
    </style>

    <div class="min-h-screen">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    ❌ {{ session('error') }}
                </div>
            @endif
            <div class="flex justify-start items-center relative z-10">
                <div class="logo-register">
                    <img src="{{ asset('assets/assets/images/logo-all.png') }}" class="image-regsiter" alt="">
                </div>
                <x-back-button href="{{ route('mobile.profile.profile') }}" />
            </div>

            @if ($reports->isEmpty() && $review_reports->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="empty-title">لا توجد بلاغات</div>
                    <div>لم يتم العثور على أي بلاغات أو بلاغات مراجعة بعد</div>
                </div>
            @else
                <div id="reportsList">
                    <!-- Place Reports -->
                    @foreach ($reports as $index => $report)
                        <a href="{{ route('mobile.reports.show', $report->id) }}" class="report-card"
                            data-title="{{ $report->place->name_ar ?? '' }}" data-user="{{ $report->user->name ?? '' }}">
                            <div class="report-header">
                                <div style="flex: 1;">
                                    <div class="report-title">
                                        🏢 {{ $report->place->name_ar ?? 'مكان غير متوفر' }}
                                    </div>
                                    <div class="report-meta">
                                        <div class="meta-item">
                                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            المُبلِغ: {{ $report->user->name ?? 'مستخدم محذوف' }}
                                        </div>
                                        <div class="meta-item">
                                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $report->created_at->diffForHumans() }}
                                        </div>
                                        @if ($report->description)
                                            <div class="meta-item">
                                                <svg class="meta-icon" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                {{ Str::limit($report->description, 50) }}
                                            </div>
                                        @endif
                                        <div class="meta-item">
                                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            نوع البلاغ: بلاغ مكان
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    @if ($report->status == 'pending')
                                        <span class="status-badge status-pending">
                                            <span class="status-dot"></span>
                                            في الانتظار
                                        </span>
                                    @elseif($report->status == 'resolved')
                                        <span class="status-badge status-resolved">
                                            <span class="status-dot"></span>
                                            تم الحل
                                        </span>
                                    @elseif($report->status == 'dismissed')
                                        <span class="status-badge status-dismissed">
                                            <span class="status-dot"></span>
                                            مرفوض
                                        </span>
                                    @else
                                        <span class="status-badge status-pending">
                                            <span class="status-dot"></span>
                                            غير محدد
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach

                    <!-- Review Reports -->
                    @foreach ($review_reports as $index => $report)
                        <a href="{{ route('mobile.reports.review_show', $report->id) }}" class="report-card"
                            data-title="{{ $report->place->name_ar ?? '' }}" data-user="{{ $report->user->name ?? '' }}">
                            <div class="report-header">
                                <div style="flex: 1;">
                                    <div class="report-title">
                                        ⭐ {{ $report->place->name_ar ?? 'مكان غير متوفر' }}
                                    </div>
                                    <div class="report-meta">
                                        <div class="meta-item">
                                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            المُبلِغ: {{ $report->user->name ?? 'مستخدم محذوف' }}
                                        </div>
                                        <div class="meta-item">
                                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $report->created_at->diffForHumans() }}
                                        </div>
                                        @if ($report->rating && $report->rating->comment)
                                            <div class="meta-item">
                                                <svg class="meta-icon" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                {{ Str::limit($report->rating->comment, 50) }}
                                            </div>
                                        @endif
                                        <div class="meta-item">
                                            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            نوع البلاغ: بلاغ مراجعة
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    @if ($report->status == 1)
                                        <span class="status-badge status-pending">
                                            <span class="status-dot"></span>
                                            في الانتظار
                                        </span>
                                    @elseif($report->status == 0)
                                        <span class="status-badge status-resolved">
                                            <span class="status-dot"></span>
                                            تم الحل
                                        </span>
                                    @elseif($report->status == 'dismissed')
                                        <span class="status-badge status-dismissed">
                                            <span class="status-dot"></span>
                                            مرفوض
                                        </span>
                                    @else
                                        <span class="status-badge status-pending">
                                            <span class="status-dot"></span>
                                            غير محدد
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Pagination -->
            @if (!$reports->isEmpty())
                <div class="pagination-wrapper">
                    {{ $reports->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput')?.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const reportCards = document.querySelectorAll('.report-card');

            reportCards.forEach(card => {
                const title = card.getAttribute('data-title').toLowerCase();
                const user = card.getAttribute('data-user').toLowerCase();

                if (title.includes(searchTerm) || user.includes(searchTerm)) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.3s ease forwards';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Scroll effects
        window.addEventListener('scroll', function() {
            const floatingAction = document.querySelector('.floating-action');
            if (floatingAction) {
                if (window.scrollY > 200) {
                    floatingAction.style.transform = 'scale(0.9)';
                } else {
                    floatingAction.style.transform = 'scale(1)';
                }
            }
        });

        // Touch interactions
        document.querySelectorAll('.report-card').forEach(card => {
            card.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
            });

            card.addEventListener('touchend', function() {
                setTimeout(() => {
                    this.style.transform = 'translateY(-2px)';
                }, 100);
            });
        });
    </script>
@endsection