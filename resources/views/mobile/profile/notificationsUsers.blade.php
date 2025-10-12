<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/assets/images/logo.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/assets/css/swiper.min.css') }}" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <title>الإشعارات | Notifications</title>
    <link href="{{ asset('assets/assets/css/style.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const USER_ID = {{ auth()->id() ?? 'null' }};
    </script>
    @vite('resources/js/app.js')
    <style>
        .ph.ph-x {
            cursor: pointer;
            transition: .2s;
        }

        .ph.ph-x:hover {
            color: red;
        }

        /* تمييز البلاغات المختلفة */
        .notification-item {
            transition: all 0.3s ease;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        /* البلاغات العادية اللي انت عملتها */
        .notification-item[data-id^="report-"]:not([data-id*="against"]):not([data-id*="review"]) {
            background-color: rgba(59, 130, 246, 0.1);
            border-left: 4px solid #3b82f6;
        }

        /* البلاغات ضد أماكنك */
        .notification-item[data-id^="report-against-"] {
            background-color: rgba(239, 68, 68, 0.1);
            border-left: 4px solid #ef4444;
        }

        /* البلاغات ضد التقييمات */
        .notification-item[data-id^="review-report-against-"] {
            background-color: rgba(245, 101, 101, 0.1);
            border-left: 4px solid #f56565;
        }

        /* البلاغات على الأماكن اللي قيمتها */
        .notification-item[data-id^="report-place-rated-"] {
            background-color: rgba(251, 191, 36, 0.1);
            border-left: 4px solid #fbbf24;
        }

        /* تأثير hover */
        .notification-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* الأيقونات */
        .notification-item .ph {
            font-size: 18px;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .notification-item .ph-x:hover {
            color: #ef4444;
        }

        .notification-item .ph-warning:hover {
            color: #f59e0b;
        }

        .notification-item .ph-info:hover {
            color: #3b82f6;
        }
    </style>
</head>

<body>
    <x-china-header :title="__('messages.الإشعارات')" :route="url()->previous()" />
    <div class="container bg-white dark:bg-color10 p-6 min-h-screen dark:text-white relative">
        <p class="text-xl font-semibold pt-8" style="padding-top: 50px;">{{ __('messages.notifications_title') }}</p>
        <div class="flex flex-col gap-4 pt-5">
            <div id="notifications-container" class="flex flex-col gap-4 pt-5">
                {{-- البلاغات ضد اماكني --}}
                @foreach ($reportsAgainstMe as $report)
                <div class="flex justify-between items-center pb-4 border-b border-dashed border-red-400 dark:border-red-600 notification-item"
                    data-id="report-against-{{ $report->id }}">
                    @if ($report->status == 'pending')
                    <p>
                        {{ __('messages.place_reported_against_you_anonymous', [
                        'place' => optional($report->place)->{'name_' . App::getLocale()} ?? __('messages.place_name'),
                        ]) }}
                    </p>
                    @elseif($report->status == 'resolved')
                    <p>{{ __('messages.report_accepted_place_disabled', ['place' => optional($report->place)->{'name_' .
                        App::getLocale()} ?? __('messages.place_name')]) }}</p>
                    @elseif($report->status == 'dismissed')
                    <p>{{ __('messages.report_cancelled', ['place' => optional($report->place)->{'name_' .
                        App::getLocale()} ??
                        __('messages.place_name')]) }}</p>
                    @endif
                    <i class="ph ph-warning text-red-500"></i>
                </div>
                @endforeach

                {{-- البلاغات ضد تقييماتك --}}
                @foreach ($reviewReportsAgainstMe as $reviewReport)
                <div class="flex justify-between items-center pb-4 border-b border-dashed border-red-400 dark:border-red-600 notification-item"
                    data-id="review-report-against-{{ $reviewReport->id }}">
                    @if ($reviewReport->status == 1)
                    <p>
                        {{ __('messages.review_reported_against_anonymous', [
                        'place' => optional($reviewReport->place)->{'name_' . App::getLocale()} ??
                        __('messages.place_name'),
                        ]) }}
                    </p>
                    @elseif($reviewReport->status == 0)
                    <p>
                        {{ __('messages.done', [
                        'place' => optional($reviewReport->place)->{'name_' . App::getLocale()} ??
                        __('messages.place_name'),
                        ]) }}
                    </p>
                    @elseif($reviewReport->status == 2)
                    <p>
                        {{ __('messages.cancel', [
                        'place' => optional($reviewReport->place)->{'name_' . App::getLocale()} ??
                        __('messages.place_name'),
                        ]) }}
                    </p>
                    @endif
                    <i class="ph ph-warning text-red-500"></i>
                </div>
                @endforeach

                {{-- المفضلات --}}
                @foreach ($favorites as $favorite)
                <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item"
                    data-id="favorite-{{ $favorite->id }}">
                    <p>{{ __('messages.favorite_added_by_user', ['place' => $favorite->place->{'name_' .
                        App::getLocale()} ?? __('messages.place_name')]) }}
                    </p>
                    <i class="ph ph-x"></i>
                </div>
                @endforeach

                {{-- التقييمات --}}
                @foreach ($ratings as $rating)
                <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item"
                    data-id="rating-{{ $rating->id }}">
                    <p>{{ __('messages.place_rated_by_user', ['place' => $rating->place->{'name_' . App::getLocale()} ??
                        __('messages.place_name')]) }}
                    </p>
                    <i class="ph ph-x"></i>
                </div>
                @endforeach

                {{-- البلاغات اللي انت عملتها --}}
                @foreach ($reports as $report)
                <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item"
                    data-id="report-{{ $report->id }}">
                    <p> أبلغت عن {{ $report->place->{'name_' . App::getLocale()} ?? __('messages.place_name') }}
                    </p>
                    <i class="ph ph-x"></i>
                </div>
                @endforeach

            </div>
        </div>
    </div>
    <script src="{{ asset('assets/assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/apex-custom.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('assets/assets/js/plugins/plugin-custom.js') }}"></script>
    <script defer src="{{ asset('assets/assets/js/index.js') }}"></script>
    <script>
        function updateNotificationUI(payload) {
const notificationContainer = document.getElementById('notifications-container'); // ✅ بدون نقطة
if (!notificationContainer) {
console.error('Container not found!');
return;
}

const status = payload.data.status || 'pending';
let message = '';

if (status === 'pending') {
message = `تم الإبلاغ عن مكانك: ${payload.data.place_name}`;
} else if (status === 'resolved') {
message = `تم تعطيل مكانك: ${payload.data.place_name}`;
} else if (status === 'dismissed') {
message = `تم إلغاء البلاغ عن: ${payload.data.place_name}`;
}

const newNotification = `
<div class="flex justify-between items-center pb-4 border-b border-dashed border-red-400 dark:border-red-600 notification-item"
    data-id="report-against-${payload.data.report_id}">
    <p>${message}</p>
    <i class="ph ph-warning text-red-500"></i>
</div>
`;

notificationContainer.insertAdjacentHTML('afterbegin', newNotification);

// عشان زرار الـ x يشتغل حتى على العناصر الجديدة
addNotificationListeners();
}
        
        document.addEventListener('DOMContentLoaded', function() {

            function hideNotification(element) {
                element.style.display = 'none';
            }

            function markAsHidden(id) {
                let hiddenNotifications = JSON.parse(localStorage.getItem('hidden_notifications')) || [];
                if (!hiddenNotifications.includes(id)) {
                    hiddenNotifications.push(id);
                    localStorage.setItem('hidden_notifications', JSON.stringify(hiddenNotifications));
                }
                // أرسل التحديث إلى الخادم فورًا
                sendHiddenNotificationsToServer();
            }

            function showNotification(element) {
                element.style.display = '';
            }

            function checkHiddenNotifications() {
                const hiddenNotifications = JSON.parse(localStorage.getItem('hidden_notifications')) || [];
                const allNotifications = document.querySelectorAll('.notification-item');

                allNotifications.forEach(item => {
                    const id = item.getAttribute('data-id');
                    if (hiddenNotifications.includes(id)) {
                        hideNotification(item);
                    } else {
                        showNotification(item);
                    }
                });
            }

            function addNotificationListeners() {
                const closeButtons = document.querySelectorAll('.ph-x');

                closeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const parentDiv = this.closest('.notification-item');
                        const notificationId = parentDiv.getAttribute('data-id');

                        if (notificationId) {
                            markAsHidden(notificationId);
                            hideNotification(parentDiv);
                        }
                    });
                });
            }

            // دالة لإرسال الإشعارات المخفية إلى الخادم
            function sendHiddenNotificationsToServer() {
                const hiddenNotifications = localStorage.getItem('hidden_notifications');
                if (hiddenNotifications) {
                    fetch('/update-hidden-notifications', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify({
                                hidden_notifications: hiddenNotifications
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Hidden notifications updated on server:', data);
                        })
                        .catch(error => {
                            console.error('Error sending hidden notifications:', error);
                        });
                }
            }

            addNotificationListeners();
            checkHiddenNotifications();
            sendHiddenNotificationsToServer(); // أرسل البيانات عند تحميل الصفحة لأول مرة

            const input = document.getElementById('searchInput');
            const container = document.getElementById('notifications-container');
            let timer;

            input.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    let query = this.value;

                    fetch(`{{ route('mobile.notifications.search') }}?query=${query}`)
                        .then(res => res.json())
                        .then(data => {
                            container.innerHTML = '';

                            // بناء المحتوى ديناميكيًا
                            data.places.forEach(place => {
                                container.innerHTML += `
                                    <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item" data-id="place-${place.id}">
                                        <p>تم إضافة ${place.name_ar}</p>
                                        <i class="ph ph-x"></i>
                                    </div>`;
                            });

                            data.favorites.forEach(fav => {
                                container.innerHTML += `
                                    <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item" data-id="favorite-${fav.id}">
                                        <p>أضاف <span style="color: rebeccapurple; font-weight: bold;">${fav.user.name}</span> ${fav.place.name_ar} إلي المفضلة</p>
                                        <i class="ph ph-x"></i>
                                    </div>`;
                            });

                            data.ratings.forEach(rating => {
                                container.innerHTML += `
                                    <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item" data-id="rating-${rating.id}">
                                        <p>قيم <span style="color: rebeccapurple; font-weight: bold;">${rating.user.name}</span> ${rating.place.name_ar}</p>
                                        <i class="ph ph-x"></i>
                                    </div>`;
                            });

                            data.reports.forEach(rep => {
                                container.innerHTML += `
                                    <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item" data-id="report-${rep.id}">
                                        <p>تم الإبلاغ عن ${rep.place.name_ar}</p>
                                        <i class="ph ph-x"></i>
                                    </div>`;
                            });

                            data.review_reports.forEach(rep => {
                                container.innerHTML += `
                                    <div class="flex justify-between items-center pb-4 border-b border-dashed border-color21 dark:border-color24 notification-item" data-id="review_report-${rep.id}">
                                        <p>تم الإبلاغ عن تقييم يخص ${rep.place.name_ar}</p>
                                        <i class="ph ph-x"></i>
                                    </div>`;
                            });

                            if (data.places.length === 0 && data.favorites.length === 0 && data
                                .ratings.length === 0 && data.reports.length === 0 && data
                                .review_reports.length === 0) {
                                container.innerHTML =
                                    `<p class="text-center text-gray-500 dark:text-gray-400">لا توجد نتائج</p>`;
                            }

                            addNotificationListeners();
                            checkHiddenNotifications();
                        });
                }, 500);
            });
        });
    </script>
</body>

</html>