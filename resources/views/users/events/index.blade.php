@extends('layouts.appOmdahome')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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

        .search-container {
            margin: 0 68px 30px 0;
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
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: flex-end;
            gap: 15px;
            transition: transform 0.3s ease;
            width: 100%;
        }

        .region-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 100px;
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

        .no-exhibitions {
            width: 100%;
            text-align: center;
            padding: 100px 0;
            color: #071739;
            font-size: 22px;
            font-weight: bold;
        }

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

        .regions-container-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 800px;
            margin: 0 auto 30px;
        }

        .regions-slider-container {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .region-slider-btn {
            background-color: rgb(0, 0, 0);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 15%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            margin: 0 10px;
            z-index: 2;
            position: relative;
            top: -20px;
        }

        .region-slider-btn:hover {
            background-color: rgb(20, 20, 20);
        }

        .region-slider-btn.disabled {
            background-color: rgb(102, 102, 102);
            cursor: not-allowed;
        }

        .fixed-region-item {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
            background-color: #e0e7ff;
        }

        .fixed-region-item:hover {
            background-color: #f0f4ff;
        }

        .fixed-region-item.active {
            background-color: #e0e7ff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>

    <h1 style="color: #071739; font-weight: bold; margin-bottom: 20px; font-size: 35px; margin-right: 200px; margin-top: 50px;">
        جميع المعارض المتاحة
    </h1>

    <div class="search-container">
        <div class="search-box">
            <input type="text" id="search-input" class="search-input" placeholder="البحث عن المعارض...">
            <i class="fas fa-search search-icon"></i>
        </div>

        <div class="regions-container-wrapper">
            <div class="fixed-region-item all-regions active" style="background: #edc4b5; box-shadow: none !important; right: 51px;" data-region-id="all">
                <x-iconAll />
                <div class="region-name">جميع المعارض</div>
            </div>

            <button class="region-slider-btn next-btn" id="next-region-btn">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div class="regions-slider-container">
                <div class="regions-container" id="regions-slider">
                    @php
                        $allRegions = \App\Models\Regions::all();
                        $displayCount = 5;
                    @endphp
                    @foreach ($allRegions as $region)
                        <div class="region-item" data-region-id="{{ $region->id }}">
                            @if ($region->avatar)
                                <img src="{{ asset('storage/' . $region->avatar) }}" alt="{{ $region->name_ar }}"
                                    class="region-image">
                            @else
                                <img src="{{ asset('storage/default-image.png') }}" alt="صورة افتراضية"
                                    class="region-image">
                            @endif
                            <div class="region-name">{{ $region->name_ar }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button class="region-slider-btn prev-btn" id="prev-region-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>

        @if (request()->query('interest_id'))
            <div style="text-align: center; margin-bottom: 20px;">
                <a href="{{ route('users.events.index') }}" class="view-all-btn">مشاهدة الجميع</a>
            </div>
        @endif
    </div>

    <div class="container exhibition-container" id="exhibitions-container">
        @php
            $interestId = request()->query('interest_id');
            if ($interestId) {
                $filteredEvents = $events->where('id', $interestId)->where('type', 'معرض');
            } else {
                $filteredEvents = $events->where('type', 'معرض');
            }
        @endphp

        @if ($filteredEvents->isEmpty())
            <div class="no-exhibitions">
                لا يوجد معارض
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
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <a href="{{ route('users.events.show', $event->id) }}"
                                style="background: #071739; color: #fff; padding: 4px 11px; border-radius: 4px; text-decoration: none;">
                                المزيد
                            </a>
                            <style>
                                .add-interest-btn {
                                    font-weight: bold;
                                    background-color: rgb(255, 255, 255);
                                    padding: 3px;
                                    width: 54px;
                                    position: relative;
                                    height: 53px;
                                    top: -138px;
                                    right: 8px;
                                    color: white;
                                    text-align: center;
                                    display: flex;
                                    align-items: center;
                                    box-shadow: 0px 0px 7px #c4c4c4;
                                    justify-content: center;
                                    overflow: hidden;
                                    transition: color 0.2s ease-in-out;
                                }

                                .add-interest-btn svg {
                                    position: relative;
                                    z-index: 1;
                                }

                                .add-interest-btn::before {
                                    content: '';
                                    position: absolute;
                                    bottom: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 0;
                                    background-color: #B11023;
                                    z-index: 0;
                                    transition: height 0.2s ease-in-out;
                                }

                                .add-interest-btn:hover::before {
                                    height: 100%;
                                }

                                .add-interest-btn:hover {
                                    color: white;
                                }

                                .add-interest-btn:hover i.fa-heart {
                                    border: 2px solid white !important;
                                    padding: 2px !important;
                                    border-radius: 50% !important;
                                    z-index: 99999999999999999999999999999999;
                                    color: white !important;
                                }

                                .add-interest-btn:hover i.fa-heart {
                                    color: white !important;
                                    fill: #B11023 !important;
                                }
                            </style>
                            <button class="add-interest-btn" data-interest-type="event"
                                data-interest-id="{{ $event->id }}" data-event-type="{{ $event->type }}">
                                <i class="fa-regular fa-heart" style="color: #B11023;"></i>
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
            initRegionSlider();
        });

        function initAddInterestButtons() {
            const addInterestButtons = document.querySelectorAll('.add-interest-btn');
            addInterestButtons.forEach(button => {
                const interestId = button.getAttribute('data-interest-id');
                const heartIcon = button.querySelector('i');

                fetch(`/api/user-interests/check?interest_type=event&interest_id=${interestId}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.is_added) {
                        button.setAttribute('data-added', 'true');
                        button.classList.add('added');
                        heartIcon.classList.remove('fa-regular', 'fa-heart');
                        heartIcon.classList.add('fa-solid', 'fa-heart');
                    } else {
                        button.setAttribute('data-added', 'false');
                        button.classList.remove('added');
                        heartIcon.classList.remove('fa-solid', 'fa-heart');
                        heartIcon.classList.add('fa-regular', 'fa-heart');
                    }
                })
                .catch(error => {
                    console.error('Error checking interest:', error);
                });

                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const interestType = this.getAttribute('data-interest-type');
                    const interestId = this.getAttribute('data-interest-id');
                    const eventType = this.getAttribute('data-event-type');
                    const isAdded = this.getAttribute('data-added') === 'true';
                    const btn = this;
                    const heartIcon = this.querySelector('i');

                    btn.disabled = true;

                    const method = isAdded ? 'DELETE' : 'POST';
                    const url = isAdded ? `/api/user-interests/${interestType}/${interestId}` :
                        '/api/user-interests';

                    fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: method === 'POST' ? JSON.stringify({
                            interest_type: interestType,
                            interest_id: interestId
                        }) : null
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (isAdded) {
                                showNotification(`تم إزالة ${eventType} من اهتماماتك بنجاح!`, 'success');
                                btn.classList.remove('added');
                                btn.setAttribute('data-added', 'false');
                                heartIcon.classList.remove('fa-solid', 'fa-heart');
                                heartIcon.classList.add('fa-regular', 'fa-heart');
                            } else {
                                showNotification(`تم إضافة ${eventType} إلى اهتماماتك بنجاح!`, 'success');
                                btn.classList.add('added');
                                btn.setAttribute('data-added', 'true');
                                heartIcon.classList.remove('fa-regular', 'fa-heart');
                                heartIcon.classList.add('fa-solid', 'fa-heart');
                            }
                            btn.disabled = false;
                        } else {
                            showNotification(data.message || 'فشل في تعديل الاهتمام', 'error');
                            btn.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('حدث خطأ أثناء تعديل الاهتمام.', 'error');
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

        function initRegionSlider() {
            const slider = document.getElementById('regions-slider');
            const prevBtn = document.getElementById('prev-region-btn');
            const nextBtn = document.getElementById('next-region-btn');
            const regionItems = slider.querySelectorAll('.region-item');

            let currentPosition = 0;
            const itemWidth = 195;
            const visibleItems = 5;
            const maxPosition = Math.max(0, regionItems.length - visibleItems);

            updateSliderButtons();

            prevBtn.addEventListener('click', function() {
                if (currentPosition > 0) {
                    currentPosition--;
                    updateSliderPosition();
                    updateSliderButtons();
                }
            });

            nextBtn.addEventListener('click', function() {
                if (currentPosition < maxPosition) {
                    currentPosition++;
                    updateSliderPosition();
                    updateSliderButtons();
                }
            });

            function updateSliderPosition() {
                slider.style.transform = `translateX(-${currentPosition * itemWidth}px)`;
            }

            function updateSliderButtons() {
                prevBtn.classList.toggle('disabled', currentPosition === 0);
                nextBtn.classList.toggle('disabled', currentPosition >= maxPosition);
            }
        }

        function initRegionFilters() {
            const regionItems = document.querySelectorAll('.region-item, .fixed-region-item');
            const exhibitionItems = document.querySelectorAll('.exhibition-item');

            regionItems.forEach(item => {
                item.addEventListener('click', function() {
                    regionItems.forEach(ri => ri.classList.remove('active'));
                    this.classList.add('active');

                    applyFilters();
                });
            });
        }

        function initSearchFilter() {
            const searchInput = document.getElementById('search-input');

            searchInput.addEventListener('input', function() {
                applyFilters();
            });
        }

        function applyFilters() {
            const exhibitionItems = document.querySelectorAll('.exhibition-item');
            const exhibitionsContainer = document.getElementById('exhibitions-container');
            const searchTerm = document.getElementById('search-input').value.trim().toLowerCase();
            const activeRegionItem = document.querySelector('.region-item.active, .fixed-region-item.active');
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

            if (visibleCount === 0) {
                const existingNoExhibitions = exhibitionsContainer.querySelector('.no-exhibitions');
                if (existingNoExhibitions) {
                    existingNoExhibitions.remove();
                }

                const noExhibitions = document.createElement('div');
                noExhibitions.className = 'no-exhibitions';
                noExhibitions.textContent = 'لا توجد معارض تطابق معايير البحث';
                exhibitionsContainer.appendChild(noExhibitions);
            } else {
                const existingNoExhibitions = exhibitionsContainer.querySelector('.no-exhibitions');
                if (existingNoExhibitions) {
                    existingNoExhibitions.remove();
                }
            }
        }

        function clearRegionFilter() {
            const allRegionsItem = document.querySelector('.fixed-region-item[data-region-id="all"]');
            const regionItems = document.querySelectorAll('.region-item, .fixed-region-item');

            regionItems.forEach(ri => ri.classList.remove('active'));
            allRegionsItem.classList.add('active');

            applyFilters();
        }
    </script>
@endsection