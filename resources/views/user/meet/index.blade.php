@extends('layouts.appOmdahome')

@section('content')
    <style>
        .exhibition-container {
            margin-top: 20px;
            margin-right: 68px;
            margin-bottom: 60px;
            display: flex;
            flex-direction: row-reverse;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 40px;
        }

        .exhibition-item {
            max-width: 400px;
            flex-direction: row-reverse;
            align-items: center;
            gap: 20px;
            position: relative;
        }

        .exhibition-item p {
            position: absolute;
            right: 0px;
            height: 48px;
            min-width: 83px;
            top: 0px;
            border-top-right-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: red;
            border-bottom-left-radius: 30px;
            border-top-left-radius: 30px;
        }

        .exhibition-image {
            min-width: 383px;
            height: 212px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .exhibition-details {
            background-color: #f8faff;
            padding: 10px 20px;
            height: 168px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .exhibition-title {
            color: #071739;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .exhibition-dates {
            color: #777;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .exhibition-description {
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            background-color: #071739;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            z-index: 1000;
            font-size: 16px;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.3s, transform 0.3s;
        }

        .notification.success {
            background-color: #4CAF50;
        }

        .notification.error {
            background-color: #f44336;
        }

        .notification-icon {
            margin-left: 10px;
            font-size: 20px;
        }

        .notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* إضافة أنماط جديدة لشريط البحث والمناطق */
        .search-container {
            margin: 20px 68px 30px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .search-box {
            width: 80%;
            max-width: 600px;
            position: relative;
            margin-bottom: 30px;
        }

        .search-input {
            width: 100%;
            padding: 12px 45px 12px 20px;
            border-radius: 30px;
            border: 2px solid #071739;
            font-size: 16px;
            text-align: right;
            direction: rtl;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #071739;
            font-size: 20px;
        }

        .regions-container {
            display: flex;
            flex-direction: row-reverse;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
            width: 100%;
        }

        .region-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
            padding: 10px;
            border-radius: 8px;
        }

        .region-item:hover {
            background-color: #f0f4ff;
        }

        .region-item.active {
            background-color: #e0e7ff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .region-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #071739;
        }

        .region-name {
            margin-top: 8px;
            font-size: 14px;
            color: #071739;
            font-weight: bold;
            text-align: center;
        }

        .active-filters {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        .filter-badge {
            background-color: #071739;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .clear-filter {
            cursor: pointer;
            font-weight: bold;
        }

        /* المؤشر عند عدم وجود مناسبات */
        .no-exhibitions {
            width: 100%;
            text-align: center;
            padding: 100px 0;
            color: #071739;
            font-size: 22px;
            font-weight: bold;
        }

        /* أسلوب زر مشاهدة الجميع */
        .view-all-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #071739;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            margin: 10px auto;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .view-all-btn:hover {
            background-color: #1e40af;
        }
    </style>

    <h1
        style="color: #071739; font-weight: bold; margin-bottom: 20px; font-size: 35px; margin-right: 200px; margin-top: 50px;">
        جميع المناسبات المتاحة
    </h1>

    <!-- شريط البحث الجديد -->
    <div class="search-container">
        <div class="search-box">
            <input type="text" id="search-input" class="search-input" placeholder="البحث عن المناسبات...">
            <i class="fas fa-search search-icon"></i>
        </div>

        <!-- عرض المناطق للتصفية -->
        <div class="regions-container">
            <div class="region-item all-regions active" data-region-id="all">
                <x-iconAll />
                <div class="region-name">جميع المناطق</div>
            </div>
            @php
                $allRegions = \App\Models\Regions::all();
            @endphp
            @foreach ($allRegions as $region)
                <div class="region-item" data-region-id="{{ $region->id }}">
                    @if ($region->avatar)
                        <img src="{{ asset('storage/' . $region->avatar) }}" alt="{{ $region->name_ar }}"
                            class="region-image">
                    @else
                        <img src="{{ asset('storage/default-image.png') }}" alt="صورة افتراضية" class="region-image">
                    @endif
                    <div class="region-name">{{ $region->name_ar }}</div>
                </div>
            @endforeach
        </div>

        <!-- عرض الفلاتر النشطة -->
        <div class="active-filters" id="active-filters" style="display: none;">
            <div class="filter-badge" id="region-filter">
                <span id="selected-region-name">جميع المناطق</span>
                <span class="clear-filter" onclick="clearRegionFilter()">×</span>
            </div>
            <div class="filter-badge" id="search-filter" style="display: none;">
                <span id="search-term"></span>
                <span class="clear-filter" onclick="clearSearchFilter()">×</span>
            </div>
        </div>

        <!-- زر مشاهدة الجميع (يظهر فقط إذا كان هناك interest_id) -->
        @if (request()->query('interest_id'))
            <div style="text-align: center; margin-bottom: 20px;">
                <a href="{{ route('users.meet.index') }}" class="view-all-btn">مشاهدة الجميع</a>
            </div>
        @endif
    </div>

    <div class="container exhibition-container" id="exhibitions-container">
        @php
            // Get the interest_id from the URL
            $interestId = request()->query('interest_id');

            // Filter $events based on interest_id if it exists
            if ($interestId) {
                $filteredEvents = $events->where('id', $interestId)->where('type', 'مناسبة');
            } else {
                $filteredEvents = $events->where('type', 'مناسبة');
            }
        @endphp

        @if ($filteredEvents->isEmpty())
            <div class="no-exhibitions">
                لا يوجد مناسبات
            </div>
        @else
            @foreach ($filteredEvents as $event)
                <div class="exhibition-item" data-region-id="{{ $event->region_id ?? 'none' }}">
                    <div>
                        <img src="{{ asset('storage/' . $event->avatar) }}" alt="{{ $event->title_ar }}"
                            class="exhibition-image">
                        <p style="position: absolute; right: 0px; color: white;">
                            {{ $event->region ? $event->region->name_ar : 'غير محدد' }}
                            @if ($event->region && $event->region->avatar)
                                <img style="min-width: 39px; height: 39px; border-radius: 50%;"
                                    src="{{ asset('storage/' . $event->region->avatar) }}"
                                    alt="{{ $event->region->name_ar }}" class="exhibition-image">
                            @else
                                <img style="min-width: 39px; height: 39px; border-radius: 50%;"
                                    src="{{ asset('storage/default-image.png') }}" alt="صورة افتراضية"
                                    class="exhibition-image">
                            @endif
                        </p>
                    </div>
                    <div class="exhibition-details">
                        <div class="exhibition-title">

                            {{ Str::limit($event->title_ar, 28) }}

                        </div>
                        <div class="exhibition-dates">
                            <span>من {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span> -
                            <span>إلى {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</span>
                        </div>
                        <div class="exhibition-description" style="margin-bottom: 20px;">
                            {{ Str::limit($event->description_ar, 50) }}
                        </div>
                        <div style="display: flex; align-items: center; justify-content: space-between; bottom: -33px; ">
                            <a href="{{ route('users.meet.show', $event->id) }}"
                                style="background: #071739; color: #fff; padding: 4px 11px; border-radius: 4px; text-decoration: none;">
                                المزيد
                            </a>
                            <button class="add-interest-btn" data-interest-type="event"
                                data-interest-id="{{ $event->id }}" data-event-type="{{ $event->type }}"
                                style="font-weight: bold; background-color: rgb(54, 148, 0); padding: 3px; width: 33px; border-radius: 10px; color:white; text-align: center; display: flex; align-items: center; justify-content: center;">
                                +
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initAddInterestButtons();
            initRegionFilters();
            initSearchFilter();
        });

        function initAddInterestButtons() {
            const addInterestButtons = document.querySelectorAll('.add-interest-btn');
            addInterestButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const interestType = this.getAttribute('data-interest-type');
                    const interestId = this.getAttribute('data-interest-id');
                    const eventType = this.getAttribute('data-event-type');
                    const btn = this;

                    btn.disabled = true;

                    fetch('/api/user-interests', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            },
                            body: JSON.stringify({
                                interest_type: interestType,
                                interest_id: interestId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                let message = interestType === 'help_word' ?
                                    'تم إضافة الكلمة إلى اهتماماتك بنجاح!' :
                                    `تم إضافة ${eventType} إلى اهتماماتك بنجاح!`;
                                showNotification(message, 'success');
                                btn.style.backgroundColor = '#ccc';
                                btn.textContent = '✓';
                            } else {
                                showNotification(data.message || 'فشل إضافة الإهتمام', 'error');
                                btn.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('حدث خطأ أثناء إضافة الإهتمام.', 'error');
                            btn.disabled = false;
                        });
                });
            });
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;

            const icon = document.createElement('span');
            icon.className = 'notification-icon';
            icon.textContent = type === 'success' ? '✓' : '✗';

            const text = document.createElement('span');
            text.textContent = message;

            notification.appendChild(icon);
            notification.appendChild(text);

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('show');
            }, 10);

            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // تهيئة فلتر المناطق
        function initRegionFilters() {
            const regionItems = document.querySelectorAll('.region-item');
            const exhibitionItems = document.querySelectorAll('.exhibition-item');
            const activeFilters = document.getElementById('active-filters');
            const regionFilter = document.getElementById('region-filter');
            const selectedRegionName = document.getElementById('selected-region-name');

            regionItems.forEach(item => {
                item.addEventListener('click', function() {
                    // إزالة الكلاس النشط من جميع المناطق
                    regionItems.forEach(ri => ri.classList.remove('active'));
                    // إضافة الكلاس النشط للمنطقة المختارة
                    this.classList.add('active');

                    const regionId = this.getAttribute('data-region-id');
                    const regionName = this.querySelector('.region-name').textContent;

                    // تحديث شارة الفلتر
                    if (regionId === 'all') {
                        regionFilter.style.display = 'none';
                        if (document.getElementById('search-filter').style.display === 'none') {
                            activeFilters.style.display = 'none';
                        }
                    } else {
                        selectedRegionName.textContent = regionName;
                        regionFilter.style.display = 'flex';
                        activeFilters.style.display = 'flex';
                    }

                    applyFilters();
                });
            });
        }

        // تهيئة فلتر البحث
        function initSearchFilter() {
            const searchInput = document.getElementById('search-input');
            const searchFilter = document.getElementById('search-filter');
            const searchTerm = document.getElementById('search-term');
            const activeFilters = document.getElementById('active-filters');

            searchInput.addEventListener('input', function() {
                const term = this.value.trim();

                if (term) {
                    searchTerm.textContent = `"${term}"`;
                    searchFilter.style.display = 'flex';
                    activeFilters.style.display = 'flex';
                } else {
                    searchFilter.style.display = 'none';
                    if (document.getElementById('region-filter').style.display === 'none') {
                        activeFilters.style.display = 'none';
                    }
                }

                applyFilters();
            });
        }

        // تطبيق الفلاتر
        function applyFilters() {
            const exhibitionItems = document.querySelectorAll('.exhibition-item');
            const exhibitionsContainer = document.getElementById('exhibitions-container');
            const searchTerm = document.getElementById('search-input').value.trim().toLowerCase();
            const activeRegionItem = document.querySelector('.region-item.active');
            const regionId = activeRegionItem.getAttribute('data-region-id');

            let visibleCount = 0;

            exhibitionItems.forEach(item => {
                const itemRegionId = item.getAttribute('data-region-id');
                const title = item.querySelector('.exhibition-title').textContent.toLowerCase();
                const description = item.querySelector('.exhibition-description').textContent.toLowerCase();

                const matchesRegion = regionId === 'all' || itemRegionId === regionId;
                const matchesSearch = !searchTerm || title.includes(searchTerm) || description.includes(searchTerm);

                if (matchesRegion && matchesSearch) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // التحقق إذا لم يتم العثور على مناسبات
            if (visibleCount === 0) {
                // إزالة رسالة عدم وجود مناسبات إذا كانت موجودة
                const existingNoExhibitions = exhibitionsContainer.querySelector('.no-exhibitions');
                if (existingNoExhibitions) {
                    existingNoExhibitions.remove();
                }

                // إنشاء وإضافة رسالة عدم وجود مناسبات
                const noExhibitions = document.createElement('div');
                noExhibitions.className = 'no-exhibitions';
                noExhibitions.textContent = 'لا توجد مناسبات تطابق معايير البحث';
                exhibitionsContainer.appendChild(noExhibitions);
            } else {
                // إزالة رسالة عدم وجود مناسبات إذا كانت موجودة
                const existingNoExhibitions = exhibitionsContainer.querySelector('.no-exhibitions');
                if (existingNoExhibitions) {
                    existingNoExhibitions.remove();
                }
            }
        }

        // مسح فلتر المنطقة
        function clearRegionFilter() {
            const allRegionsItem = document.querySelector('.region-item[data-region-id="all"]');
            const regionItems = document.querySelectorAll('.region-item');
            const regionFilter = document.getElementById('region-filter');
            const activeFilters = document.getElementById('active-filters');

            // إزالة الكلاس النشط من جميع المناطق
            regionItems.forEach(ri => ri.classList.remove('active'));
            // إضافة الكلاس النشط لزر "جميع المناطق"
            allRegionsItem.classList.add('active');

            // إخفاء شارة فلتر المنطقة
            regionFilter.style.display = 'none';

            // إخفاء قسم الفلاتر النشطة إذا كان فلتر البحث أيضاً غير نشط
            if (document.getElementById('search-filter').style.display === 'none') {
                activeFilters.style.display = 'none';
            }

            applyFilters();
        }

        // مسح فلتر البحث
        function clearSearchFilter() {
            const searchInput = document.getElementById('search-input');
            const searchFilter = document.getElementById('search-filter');
            const activeFilters = document.getElementById('active-filters');

            // مسح حقل البحث
            searchInput.value = '';

            // إخفاء شارة فلتر البحث
            searchFilter.style.display = 'none';

            // إخفاء قسم الفلاتر النشطة إذا كان فلتر المنطقة أيضاً غير نشط
            if (document.getElementById('region-filter').style.display === 'none') {
                activeFilters.style.display = 'none';
            }

            applyFilters();
        }
    </script>
@endsection
