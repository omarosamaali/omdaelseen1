@extends('layouts.mobile')

@section('title', 'البلاغات')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/assets/css/reports.css') }}">
<style>
    .filter-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
    }

    .filter-select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #f3f4f6;
        border-radius: 1rem;
        font-size: 1rem;
        background: white;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
</style>

<x-china-header :title="__('messages.البلاغات')" :route="route('mobile.profile.profile')" />
<div style="padding-top: 79px;" class="min-h-screen">
    <div class="container">
        <div class="filter-container">
            <div class="filter-group">
                <label class="filter-label" for="typeFilter">نوع البلاغ</label>
                <select id="typeFilter" class="filter-select">
                    <option value="all">الكل</option>
                    <option value="place">بلاغ مكان</option>
                    <option value="review">بلاغ مراجعة</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label" for="statusFilter">حالة البلاغ</label>
                <select id="statusFilter" class="filter-select">
                    <option value="all">الكل</option>
                    <option value="pending">في الانتظار</option>
                    <option value="resolved">تم الحل</option>
                    <option value="dismissed">مرفوض</option>
                </select>
            </div>
        </div>

        @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم بنجاح',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'موافق',
                        confirmButtonColor: '#10b981',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
        </script>
        @endif
        @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'موافق',
                        confirmButtonColor: '#dc2626',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
        </script>
        @endif

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
                data-title="{{ $report->place->name_ar ?? '' }}" data-user="{{ $report->user->name ?? '' }}"
                data-type="place" data-status="{{ $report->status ?? 'pending' }}">
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
                                <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                data-title="{{ $report->place->name_ar ?? '' }}" data-user="{{ $report->user->name ?? '' }}"
                data-type="review"
                data-status="{{ $report->status == 1 ? 'pending' : ($report->status == 0 ? 'resolved' : 'dismissed') }}">
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
                                <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

<!-- إضافة SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Filter functionality
    function applyFilters() {
        const typeFilter = document.getElementById('typeFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        const reportCards = document.querySelectorAll('.report-card');

        reportCards.forEach(card => {
            const type = card.getAttribute('data-type');
            const status = card.getAttribute('data-status');

            const matchesType = typeFilter === 'all' || type === typeFilter;
            const matchesStatus = statusFilter === 'all' || status === statusFilter;

            if (matchesType && matchesStatus) {
                card.style.display = 'block';
                card.style.animation = 'fadeInUp 0.3s ease forwards';
            } else {
                card.style.display = 'none';
            }
        });
    }

    document.getElementById('typeFilter')?.addEventListener('change', applyFilters);
    document.getElementById('statusFilter')?.addEventListener('change', applyFilters);

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