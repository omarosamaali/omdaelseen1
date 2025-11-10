@extends('layouts.mobile')

@section('title', 'تفاصيل المكان | Place Info')
<link rel="stylesheet" href="{{ asset('assets/assets/css/info_place.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .tab-details-content-headpone {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .tab-details-content-headpone:hover {
        background: #3b3129;
    }

    .error-message {
        color: red;
        padding: 10px;
        margin: 10px 0;
        background: #ffe6e6;
        border-radius: 5px;
        display: none;
    }

    .success-message {
        color: green;
        padding: 10px;
        margin: 10px 0;
        background: #e0f7e0;
        border-radius: 5px;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .success-message.show {
        opacity: 1;
    }

    .heart-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        z-index: 10;
        transition: transform 0.2s ease-in-out;
    }

    .heart-icon:hover {
        transform: scale(1.2);
    }

    .heart-icon.favorited i {
        color: #e91e63 !important;
    }

    .review-actions {
        display: flex;
        gap: 10px;
    }

    .edit-review-btn,
    .delete-review-btn,
    .report-review-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #3b3129;
    }

    .report-review-btn {
        background: red;
        color: white;
        border-radius: 5px;
        padding: 2px;
    }

    .edit-review-btn:hover,
    .delete-review-btn:hover,
    .report-review-btn:hover {
        color: maroon;
    }

    .report-review-btn.reported {
        background: gray;
        cursor: default;
    }

    .rating-icon {
        position: absolute;
        top: 24px;
        left: 79px;
        right: unset;
        color: #f9a50f;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .analysis-contianer {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .analysis-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 16px;
    }

    .value {
        font-weight: bold;
        color: #333;
    }

    .home-icon {
        display: none !important;
    }

    #container-header {
        justify-content: end !important;
    }
</style>

@section('content')
    <x-china-header :title="__('messages.place_details')" :route="url()->previous()" />
    <div class="container--header" style="padding-top: 50px;">
        {{-- {{ Auth::user()->id }}
        {{ $place->user_id }} --}}
        @if (Auth::user()->id == $place->user_id)
            <a class="report-button" href="{{ route('mobile.china-discovers.edit', $place->id) }}"
                style="min-width: fit-content; left: 82%; z-index: 999999999; margin-top: -55px;">
                {{ __('messages.update_button') }}
            </a>
        @elseif(auth()->check())
            @php
                $hasReported = App\Models\Report::where('user_id', Auth::user()->id)
                    ->where('place_id', $place->id)
                    ->exists();
            @endphp
            @if (!$hasReported)
                <button class="report-button" onclick="openReportModal()"
                    style="min-width: fit-content; position: fixed; z-index: 999999999999999999; top: 8px; right: 11px;">
                    {{ __('messages.report') }}
                </button>
            @else
                <div class="report-button"
                    style="background-color: gray; min-width: fit-content; position: fixed; z-index: 999999999999999999; top: 8px; right: 11px;">
                    {{ __('messages.already_reported') }}
                </div>
            @endif
        @endif
    </div>
    <div class="container dark:text-white dark:bg-black" style="padding-top: 50px;">

        <!-- Favorite heart icon -->
        @php
            $isFavorited = auth()->check() && auth()->user()->isFavorite($place);
        @endphp

        @if (auth()->check() && auth()->id() != $place->user_id)
            <div style="margin-top: 60px; top: 15px; left: 18px; right: unset; box-shadow: 0px 0px 4px 1px #bcafafc4;"
                class="heart-icon @if ($isFavorited) favorited @endif" data-place-id="{{ $place->id }}">
                <i class="fa @if ($isFavorited) fa-solid fa-heart @else fa-regular fa-heart @endif"
                    style="font-size: 18px;"></i>
            </div>
        @endif

        <div class="rating-icon" style="left: 65px; margin-top: 60px;">
            <i class="fa-solid fa-star" style="font-size: 18px;"></i>
            <span style="font-size: 14px; font-weight: bold; color: #000000;">
                {{ number_format($place->ratings_avg_rating ?? 0, 1) }} ({{ $place->ratings_count ?? 0 }})
            </span>
        </div>

        <div class="container--features" style="margin-bottom: 10px;">
            <div>
                <img src="{{ asset('storage/' . $place->region->avatar) }}" alt="">
                <p>
                    @if (app()->getLocale() == 'ar')
                        {{ $place->region->name_ar }}
                    @elseif (app()->getLocale() == 'en')
                        {{ $place->region->name_en }}
                    @elseif (app()->getLocale() == 'zh')
                        {{ $place->region->name_ch }}
                    @endif
                </p>
            </div>
            <div>
                <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}" alt="">
                <p>
                    @if (app()->getLocale() == 'ar')
                        {{ $place->mainCategory->name_ar }}
                    @elseif (app()->getLocale() == 'en')
                        {{ $place->mainCategory->name_en }}
                    @elseif (app()->getLocale() == 'zh')
                        {{ $place->mainCategory->name_ch }}
                    @endif
                </p>
            </div>
            <div>
                <img src="{{ asset('storage/' . $place->subCategory->avatar) }}" alt="">
                <p>
                    @if (app()->getLocale() == 'ar')
                        {{ $place->subCategory->name_ar }}
                    @elseif (app()->getLocale() == 'en')
                        {{ $place->subCategory->name_en }}
                    @elseif (app()->getLocale() == 'zh')
                        {{ $place->subCategory->name_ch }}
                    @endif
                </p>
            </div>
        </div>

        <div class="main-image-container">
            <div>
                <img class="main-image" src="{{ asset('storage/' . $place->avatar) }}" alt="">
                <p class="place-name-cn">{{ $place->name_ch }}</p>
                <p class="place-name-ar">{{ $place->name_ar }}</p>
                <p class="place-name-en">{{ $place->name_en }}</p>
            </div>
        </div>

        <div class="tabs-container">
            <div class="tab-buttons">
                <button class="tab-button active details" onclick="showTab('tab1')">{{ __('messages.details') }}</button>
                <button class="tab-button" onclick="showTab('tab2')">{{ __('messages.gallery') }}</button>
                <button class="tab-button rating" onclick="showTab('tab3')">{{ __('messages.rating') }}</button>
            </div>
            <div id="tab3" class="tab-content">
                <div class="overall-rating">
                    <div class="rating-summary">
                        <div class="average-rating">
                            <span class="avg-number" id="avgRating">0</span>
                            <div class="avg-stars" id="avgStars">
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                            </div>
                            <span class="total-reviews" id="totalReviews">(0 {{ __('messages.rating') }})</span>
                        </div>
                    </div>
                </div>
                <!-- Check if user can add a rating -->
                @if (auth()->check() &&
                        !App\Models\Rating::where('user_id', Auth::user()->id)->where('place_id', $place->id)->exists())
                    <div class="add-rating-section">
                        <h4 class="add-rating-title">{{ __('messages.add_your_rating') }}</h4>
                        <div class="rating-boxes">
                            <div class="rating-box" onclick="openRatingModal(1)" data-rating="1">
                                <i class="fa-regular fa-star rating-star"></i>
                                <span class="rating-number">1</span>
                            </div>
                            <div class="rating-box" onclick="openRatingModal(2)" data-rating="2">
                                <i class="fa-regular fa-star rating-star"></i>
                                <span class="rating-number">2</span>
                            </div>
                            <div class="rating-box" onclick="openRatingModal(3)" data-rating="3">
                                <i class="fa-regular fa-star rating-star"></i>
                                <span class="rating-number">3</span>
                            </div>
                            <div class="rating-box" onclick="openRatingModal(4)" data-rating="4">
                                <i class="fa-regular fa-star rating-star"></i>
                                <span class="rating-number">4</span>
                            </div>
                            <div class="rating-box" onclick="openRatingModal(5)" data-rating="5">
                                <i class="fa-regular fa-star rating-star"></i>
                                <span class="rating-number">5</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="already-rated-message">
                        <p>{{ __('messages.already_rated') }}!</p>
                    </div>
                @endif

                <div class="reviews-section">
                    <div id="successMessage" class="success-message"></div>
                    {{-- <div id="errorMessage" class="error-message"></div> --}}
                    <h4 class="reviews-title">{{ __('messages.visitor_reviews') }}</h4>
                    <div id="reviewsList" class="reviews-list"></div>
                </div>
            </div>
            <div id="tab2" class="tab-content" style="display: none;">
                <div class="gallery-images">
                    @php
                    $images = json_decode($place->additional_images, true) ?? []; @endphp
                    @foreach ($images as $image)
                        <img src="{{ asset('storage/' . $image) }}" alt="Additional Image"
                            onclick="openImageModal(this.src)">
                    @endforeach
                </div>
            </div>
            <div id="tab1" class="tab-content">
                <div>
                    <h6>{{ __('messages.explorer_data') }}</h6>
                </div>
                <div style="justify-content: space-between;" class="tab-details-content">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <img src="{{ asset('storage/' . $place->user->avatar) }}" alt="">
                        <div>
                            <h3>{{ $place->user->explorer_name }}</h3>
                        </div>
                    </div>
                    @if (auth()->check() && Auth::user()->id != $place->user_id)
                        <div class="tab-details-content-headpone">
                            <i class="follow-icon fa-solid {{ Auth::user()->isFollowing($place->user) ? 'fa-user-check' : 'fa-user-plus' }}"
                                data-user-id="{{ $place->user_id }}">
                            </i>
                        </div>
                    @endif
                </div>

                <div class="analysis-contianer">
                    <p class="analysis-item">
                        <span class="value">{{ $ratingCount }}</span>
                        <i class="fa-solid fa-star" style="color: #ffd700;"></i>
                    </p>
                    <p class="analysis-item">
                        <span class="value">{{ $placesCount }}</span>
                        <i class="fa-solid fa-location-dot" style="color: #4CAF50;"></i>
                    </p>
                    <p class="analysis-item">
                        <span class="value">{{ $followersCount }}</span>
                        <i class="fa-solid fa-heart" style="color: #f44336;"></i>
                    </p>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const followIcon = document.querySelector('.follow-icon');
                        if (followIcon) {
                            followIcon.addEventListener('click', function() {
                                const userId = this.getAttribute('data-user-id');
                                toggleFollow(userId, this);
                            });
                        }
                    });

                    function toggleFollow(userId, iconElement) {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        iconElement.style.opacity = '0.5';
                        iconElement.style.pointerEvents = 'none';
                        fetch('/users/toggle-follow', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    user_id: userId
                                })
                            })
                            .then(response => {
                                console.log('Response status:', response.status); // للتشخيص
                                return response.json();
                            })
                            .then(data => {
                                console.log('Response data:', data); // للتشخيص

                                // إرجاع الـ visual state
                                iconElement.style.opacity = '1';
                                iconElement.style.pointerEvents = 'auto';

                                if (data.success) {
                                    // تغيير شكل الأيقونة بناءً على الحالة الجديدة
                                    if (data.is_following) {
                                        iconElement.classList.remove('fa-user-plus');
                                        iconElement.classList.add('fa-user-check');
                                    } else {
                                        iconElement.classList.remove('fa-user-check');
                                        iconElement.classList.add('fa-user-plus');
                                    }

                                    // رسالة نجاح اختيارية
                                    // showSuccessMessage(data.message);
                                } else {
                                    showErrorMessage(data.error || 'فشل في تحديث المتابعة');
                                }
                            })
                            .catch(error => {
                                console.error('Error toggling follow:', error);
                                iconElement.style.opacity = '1';
                                iconElement.style.pointerEvents = 'auto';
                                showErrorMessage('فشل في التواصل مع الخادم');
                            });
                    }
                </script>

                <p class="tab-details-content"><i class="fa-solid fa-id-card" style="color: #3b3129;"></i>
                    @if (app()->getLocale() == 'ar')
                        {{ $place->details_ar }}
                    @elseif(app()->getLocale() == 'en')
                        {{ $place->details_en }}
                    @elseif(app()->getLocale() == 'zh')
                        {{ $place->details_ch }}
                    @endif
                </p>
                @if ($place->phone)
                    <p class="tab-details-content"><i class="fa-solid fa-phone" style="color: #3b3129;"></i>
                        {{ $place->phone }}</p>
                @endif
                @if ($place->email)
                    <p class="tab-details-content"><i class="fa-solid fa-envelope" style="color: #3b3129;"></i>
                        {{ $place->email }}</p>
                @endif
                <p class="tab-details-link">
                    <a href="{{ $place->link }}">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ __('messages.place_link') }}
                    </a>
                </p>
            </div>
        </div>
        <div id="ratingModal" class="modal-overlay" onclick="closeModalOnOverlay(event)">
            <div class="modal">
                <button class="modal-close" onclick="closeRatingModal()">
                    <i class="fa fa-x"></i>
                </button>
                <h3 class="modal-title">
                    <i class="fa fa-chat-circle-text" style="color: maroon;"></i>
                    ما رأيك في هذا المكان؟
                </h3>
                <div class="modal-rating-display" id="modalStars">
                    <i class="fa-regular fa-star modal-star"></i>
                    <i class="fa-regular fa-star modal-star"></i>
                    <i class="fa-regular fa-star modal-star"></i>
                    <i class="fa-regular fa-star modal-star"></i>
                    <i class="fa-regular fa-star modal-star"></i>
                </div>
                <textarea id="commentInput" class="modal-comment" placeholder="شاركنا تجربتك وانطباعك عن هذا المكان... (اختياري)"></textarea>
                <div class="modal-actions">
                    <button class="modal-button cancel-button" onclick="closeRatingModal()">إلغاء</button>
                    <button class="modal-button confirm-button" onclick="confirmRating()">تأكيد التقييم</button>
                </div>
            </div>
        </div>
        <div id="imageModal" class="modal-overlay" onclick="closeImageModalOnOverlay(event)">
            <div class="image-modal">
                <button class="modal-close" onclick="closeImageModal()">
                    <i class="fa fa-x"></i>
                </button>
                <img id="modalImage" src="" alt="">
            </div>
        </div>
    </div>
    <input type="hidden" id="user-id" value="{{ auth()->check() ? Auth::user()->id : '' }}">
    <input type="hidden" id="place-id" value="{{ $place->id }}">
    <script>
        function openReportModal() {
            Swal.fire({
                title: "إبلاغ عن مخالفة",
                text: 'هل تريد الإبلاغ عن هذا المكان؟',
                showCancelButton: true,
                confirmButtonText: "نعم",
                cancelButtonText: "لا"
            }).then((result) => {
                if (result.isConfirmed) {
                    reportPlace();
                }
            });
        }

        function reportPlace() {
            const placeId = document.getElementById('place-id')?.value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch(`/places/${placeId}/report`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        // إزالة report_type
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("تم الإبلاغ!", "شكراً لك. سيتم مراجعة بلاغك.", "success");
                        const reportButton = document.querySelector('.report-button');
                        if (reportButton) {
                            reportButton.style.background = 'gray';
                            reportButton.style.cursor = 'default';
                            reportButton.textContent = 'تم الإبلاغ';
                            reportButton.onclick = null;
                        }
                    } else {
                        showErrorMessage(data.error || 'فشل في تسجيل البلاغ.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorMessage('فشل في التواصل مع الخادم.');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sliderContainer = document.querySelector('.slider-container');
            const explorerLinks = document.querySelectorAll('.explorer-link');
            const allLink = document.querySelector('.all-link');
            let isFiltering = false;
            let scrollTimeout;

            // دالة لإيجاد العنصر في المنتصف
            function getCenterElement() {
                const containerRect = sliderContainer.getBoundingClientRect();
                const containerCenter = containerRect.left + (containerRect.width / 2);
                let closestElement = null;
                let closestDistance = Infinity;

                explorerLinks.forEach(link => {
                    const linkRect = link.getBoundingClientRect();
                    const linkCenter = linkRect.left + (linkRect.width / 2);
                    const distance = Math.abs(containerCenter - linkCenter);
                    if (distance < closestDistance) {
                        closestDistance = distance;
                        closestElement = link;
                    }
                });
                return closestElement;
            }

            // تحديث الشكل النشط
            function updateActiveState(activeLink) {
                document.querySelectorAll('.explorer-name').forEach(name => {
                    name.style.color = '#000';
                });
                document.getElementById('all-link').style.color = '#000';

                if (activeLink) {
                    const explorerName = activeLink.querySelector('.explorer-name');
                    if (explorerName) explorerName.style.color = '#f99e4d';
                }
            }

            // فلترة الأماكن
            async function filterPlaces(explorerId) {
                if (isFiltering) return;
                isFiltering = true;

                try {
                    const url = explorerId ? `/mobile/china-discovers/${explorerId}` :
                    '/mobile/china-discovers';
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    // تحديث الأماكن
                    updatePlacesHTML('#placesSlider', data.places);
                    updatePlacesHTML('#latestPlacesSlider', data.latestPlaces);

                    reinitializeHeartIcons();

                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    isFiltering = false;
                }
            }
            const userStatus = {{ Auth::user()->status ?? 0 }};
            const explorUrl = "{{ __('messages.explore') }}";
            // تحديث HTML الأماكن
            function updatePlacesHTML(selector, places) {
                const slider = document.querySelector(selector);
                if (!slider) return;

                if (places.length === 0) {
                    slider.innerHTML =
                        '<div class="empty-message-container" style="text-align: center; width: 100%; padding: 20px;"><p style="color: #6c757d; font-size: 18px;">لا يوجد أماكن للعرض حاليًا.</p></div>';
                    return;
                }

                slider.innerHTML = places.map(place => `
            <div class="place-card">
                <img src="/storage/${place.avatar}" alt="${place.name_ar}">
                
                ${place.user_id !== {{ auth()->id() ?? 'null' }} ? `
                        <div class="heart-icon ${place.is_favorited ? 'favorited' : ''}" data-place-id="${place.id}">
                            <i class="fa ${place.is_favorited ? 'fa-solid' : 'fa-regular'} fa-heart" style="font-size: 18px;"></i>
                        </div>
                    ` : ''}
                
                <div class="rating-icon" style="position: absolute; top: unset !important; bottom: 20px; right: 156px; color: #f9a50f; display: flex; align-items: center; gap: 5px;">
                    <i class="fa-solid fa-star" style="font-size: 18px;"></i>
                </div>
                
                <div class="category-tag">
                    ${place.main_category ? `
                            <img src="/storage/${place.main_category.avatar}" alt="${place.main_category.name_ar}">
                            <span>${place.main_category.name_ar}</span>
                        ` : `
                            <img src="/storage/placeholders/no-category.png" alt="بدون تصنيف">
                            <span>بدون تصنيف</span>
                        `}
                </div>
                
                <div class="place-name" >
                    <span style="bottom: 50px; position: relative;"> 
                        ${place.name_ar}
                        </span>
                    </div>
                
${userStatus != 1 ? `
    ` : `
    `}
            </div>
        `).join('');
            }

            // إعادة تهيئة أيقونات القلب
            function reinitializeHeartIcons() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                document.querySelectorAll('.heart-icon').forEach(icon => {
                    icon.replaceWith(icon.cloneNode(true));
                });

                document.querySelectorAll('.heart-icon').forEach(icon => {
                    icon.addEventListener('click', function() {
                        const placeId = this.getAttribute('data-place-id');
                        const heartSvg = this.querySelector('i');

                        fetch('{{ route('favorites.toggle') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                },
                                body: JSON.stringify({
                                    place_id: placeId
                                }),
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'added') {
                                    this.classList.add('favorited');
                                    heartSvg.classList.remove('fa-regular');
                                    heartSvg.classList.add('fa-solid');
                                } else {
                                    this.classList.remove('favorited');
                                    heartSvg.classList.remove('fa-solid');
                                    heartSvg.classList.add('fa-regular');
                                }
                            });
                    });
                });
            }

            // عند انتهاء السحب
            sliderContainer.addEventListener('scroll', function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    const centerElement = getCenterElement();
                    if (centerElement) {
                        const explorerId = centerElement.getAttribute('data-explorer-id');
                        updateActiveState(centerElement);
                        filterPlaces(explorerId);
                    }
                }, 200);
            });

            // النقر على "الكل"
            allLink.addEventListener('click', function(e) {
                e.preventDefault();
                updateActiveState(null);
                document.getElementById('all-link').style.color = '#f99e4d';
                filterPlaces('');
            });

            // النقر المباشر
            explorerLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const explorerId = this.getAttribute('data-explorer-id');
                    updateActiveState(this);
                    filterPlaces(explorerId);
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            document.querySelectorAll('.heart-icon').forEach(icon => {
                icon.addEventListener('click', function() {
                    const placeId = this.getAttribute('data-place-id');
                    const iconElement = this;
                    const heartSvg = iconElement.querySelector('i');
                    fetch('{{ route('favorites.toggle') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                place_id: placeId
                            }),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.status === 'added') {
                                iconElement.classList.add('favorited');
                                heartSvg.classList.remove('fa-regular');
                                heartSvg.classList.add('fa-solid');
                            } else if (data.status === 'removed') {
                                iconElement.classList.remove('favorited');
                                heartSvg.classList.remove('fa-solid');
                                heartSvg.classList.add('fa-regular');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('حدث خطأ. يرجى تسجيل الدخول أو المحاولة مرة أخرى.');
                        });
                });
            });
        });

        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 3000);
        }

        function openModal() {
            Swal.fire({
                title: "بلاغ؟",
                text: 'هل هذا المكان مخالف',
                showCancelButton: true,
                confirmButtonText: "نعم",
                cancelButtonText: "لا"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (typeof userId === 'undefined' || userId === null) {
                        Swal.fire("خطأ!", "لا يمكن إرسال البلاغ. يرجى تسجيل الدخول أولاً.", "error");
                        return;
                    }

                    fetch(`/chef-profile/report-by-user/${userId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                report_type: 'content_report'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("تم الإبلاغ!", "شكراً لك. سيتم مراجعة بلاغك.", "success");
                                const reportBtn = document.querySelector('.report-btn');
                                if (reportBtn) {
                                    reportBtn.innerHTML = 'تم الإبلاغ';
                                    reportBtn.style.background = 'gray';
                                    reportBtn.onclick = null;
                                    reportBtn.style.cursor = 'default';
                                }
                            } else {
                                Swal.fire("حدث خطأ!", data.message || "فشل إرسال البلاغ.", "error");
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire("حدث خطأ!", "فشل في التواصل مع الخادم.", "error");
                        });
                }
            });
        }

        function toggleHeart(element) {
            element.classList.toggle('liked');
            const icon = element.querySelector('i');
            if (element.classList.contains('liked')) {
                icon.className = 'fa fa-heart-fill';
            } else {
                icon.className = 'fa fa-heart';
            }
        }

        function explorePlace(element) {
            const card = element.closest('.place-card');
            const placeName = card.querySelector('.place-name').textContent;
            const categorySpan = card.querySelector('.category-tag span');
            const category = categorySpan ? categorySpan.textContent : 'غير محدد';

            alert(`استكشف ${placeName} في فئة ${category}`);
        }
        let autoScrollIntervals = [];
        let userInteracting = [];

        function initializeTouchSupport() {
            document.querySelectorAll('.slider').forEach((slider, index) => {
                let startX = 0;
                let scrollLeft = 0;
                userInteracting[index] = false;
                slider.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].pageX - slider.offsetLeft;
                    scrollLeft = slider.scrollLeft;
                    userInteracting[index] = true;
                    if (autoScrollIntervals[index]) {
                        clearInterval(autoScrollIntervals[index]);
                    }
                });
                slider.addEventListener('touchmove', (e) => {
                    if (!startX) return;
                    e.preventDefault();
                    const x = e.touches[0].pageX - slider.offsetLeft;
                    const walk = (x - startX) * 2;
                    slider.scrollLeft = scrollLeft - walk;
                });
                slider.addEventListener('touchend', () => {
                    startX = 0;
                    setTimeout(() => {
                        userInteracting[index] = false;
                        startAutoScroll(slider, index);
                    }, 3000);
                });
                slider.addEventListener('mouseenter', () => {
                    userInteracting[index] = true;
                    if (autoScrollIntervals[index]) {
                        clearInterval(autoScrollIntervals[index]);
                    }
                });
                slider.addEventListener('mouseleave', () => {
                    setTimeout(() => {
                        userInteracting[index] = false;
                        startAutoScroll(slider, index);
                    }, 1000);
                });
            });
        }

        function startAutoScroll(slider, index) {
            if (autoScrollIntervals[index]) {
                clearInterval(autoScrollIntervals[index]);
            }
            autoScrollIntervals[index] = setInterval(() => {
                if (userInteracting[index]) return;
                const scrollAmount = 280;
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                if (slider.scrollLeft >= maxScroll - 10) {
                    slider.scrollTo({
                        left: 0,
                        behavior: 'smooth'
                    });
                } else {
                    slider.scrollTo({
                        left: slider.scrollLeft + scrollAmount,
                        behavior: 'smooth'
                    });
                }
            }, 4000 + (index * 500));
        }

        function autoScrollSliders() {
            const sliders = document.querySelectorAll('.slider');
            sliders.forEach((slider, index) => {
                userInteracting[index] = false;
                startAutoScroll(slider, index);
            });
        }

        function addScrollIndicators() {
            const sliders = document.querySelectorAll('.slider-container');
            sliders.forEach((container, containerIndex) => {
                const slider = container.querySelector('.slider');
                if (!slider) return;
                const cards = slider.querySelectorAll('.place-card, .chef-card, .recipe-card');
                if (cards.length === 0) return;
                const indicatorContainer = document.createElement('div');
                indicatorContainer.className = 'scroll-indicators';
                indicatorContainer.style.cssText = `
                display: flex;
                justify-content: center;
                gap: 8px;
                margin-top: 15px;
            `;
                const containerWidth = slider.offsetWidth || slider.parentElement.offsetWidth;
                const cardWidth = 280;
                const visibleCards = Math.max(1, Math.floor(containerWidth / cardWidth));
                const indicatorCount = Math.max(1, Math.ceil(cards.length / visibleCards));
                for (let i = 0; i < indicatorCount; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'scroll-dot';
                    dot.style.cssText = `
                    width: 8px;
                    height: 8px;
                    border-radius: 50%;
                    background: rgba(255, 181, 49, 0.3);
                    cursor: pointer;
                    transition: all 0.3s ease;
                `;
                    if (i === 0) {
                        dot.style.background = 'maroon';
                        dot.style.transform = 'scale(1.2)';
                    }
                    dot.addEventListener('click', () => {
                        const scrollPosition = i * cardWidth * visibleCards;
                        slider.scrollTo({
                            left: scrollPosition,
                            behavior: 'smooth'
                        });
                        updateIndicators(indicatorContainer, i);
                        userInteracting[containerIndex] = true;
                        setTimeout(() => {
                            userInteracting[containerIndex] = false;
                        }, 5000);
                    });
                    indicatorContainer.appendChild(dot);
                }
                const existingIndicators = container.querySelector('.scroll-indicators');
                if (existingIndicators) {
                    existingIndicators.remove();
                }
                container.appendChild(indicatorContainer);
                let scrollTimeout;
                slider.addEventListener('scroll', () => {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => {
                        const currentIndex = Math.round(slider.scrollLeft / (cardWidth *
                            visibleCards));
                        updateIndicators(indicatorContainer, Math.min(currentIndex, indicatorCount -
                            1));
                    }, 100);
                });
            });
        }

        function updateIndicators(container, activeIndex) {
            const dots = container.querySelectorAll('.scroll-dot');
            dots.forEach((dot, index) => {
                if (index === activeIndex) {
                    dot.style.background = 'maroon';
                    dot.style.transform = 'scale(1.2)';
                } else {
                    dot.style.background = 'rgba(255, 181, 49, 0.3)';
                    dot.style.transform = 'scale(1)';
                }
            });
        }

        function cleanup() {
            autoScrollIntervals.forEach(interval => {
                if (interval) clearInterval(interval);
            });
            autoScrollIntervals = [];
        }
        document.addEventListener('DOMContentLoaded', () => {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }

            function init() {
                setTimeout(() => {
                    initializeTouchSupport();
                    addScrollIndicators();
                    setTimeout(autoScrollSliders, 2000);
                }, 300);
            }
        });
        window.addEventListener('beforeunload', cleanup);
        window.addEventListener('pagehide', cleanup);

        let allReviews = [];
        let currentRating = 0;
        let isEditing = false;
        let editingReviewId = null;

        document.addEventListener('DOMContentLoaded', function() {
            const placeId = document.getElementById('place-id')?.value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!placeId || !csrfToken) {
                console.error('Missing required elements: place-id or csrf-token');
                return;
            }

            fetchReviews();
        });

        function fetchReviews() {
            const placeId = document.getElementById('place-id').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/places/${placeId}/reviews`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    allReviews = data.reviews || [];
                    updateAverageRating();
                    renderReviews();
                })
                .catch(error => {
                    console.error('Error fetching reviews:', error);
                    showErrorMessage('فشل في جلب التقييمات. حاول مرة أخرى.');
                });
        }

        function calculateAverageRating() {
            if (allReviews.length === 0) return 0;
            const sum = allReviews.reduce((acc, review) => acc + review.rating, 0);
            return (sum / allReviews.length).toFixed(1);
        }

        function updateAverageRating() {
            const avgRating = calculateAverageRating();
            const avgElement = document.getElementById('avgRating');
            const totalElement = document.getElementById('totalReviews');
            const starsElement = document.getElementById('avgStars');

            if (avgElement) avgElement.textContent = avgRating;
            if (totalElement) totalElement.textContent = `(${allReviews.length} تقييم)`;

            if (starsElement) {
                const stars = starsElement.querySelectorAll('i');
                const rating = parseFloat(avgRating);
                stars.forEach((star, index) => {
                    star.className = index < Math.floor(rating) ? 'fa-solid fa-star' :
                        index < rating ? 'fa-regular fa-star-half' :
                        'fa-regular fa-star';
                });
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffTime = Math.abs(now - date);
            const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays === 0) return 'اليوم';
            if (diffDays === 1) return 'أمس';
            if (diffDays < 7) return `منذ ${diffDays} أيام`;
            if (diffDays < 30) return `منذ ${Math.floor(diffDays / 7)} أسابيع`;
            return date.toLocaleDateString('ar-SA');
        }

        function createStars(rating) {
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += `<i class="${i <= rating ? 'fa-solid fa-star' : 'fa-regular fa-star'}"></i>`;
            }
            return starsHtml;
        }

        function renderReviews() {
            const reviewsList = document.getElementById('reviewsList');
            const currentUserId = document.getElementById('user-id')?.value;

            if (!reviewsList) return;

            if (allReviews.length === 0) {
                reviewsList.innerHTML =
                    '<div class="no-reviews">لا توجد تقييمات حتى الآن. كن أول من يقيم هذا المكان!</div>';
                return;
            }

            const sortedReviews = allReviews.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

            reviewsList.innerHTML = sortedReviews.map(review => `
            <div class="review-item ${review.isNew ? 'new-review' : ''}" data-id="${review.id}">
                <div class="review-header">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">${review.avatar}</div>
                        <div>
                            <div class="reviewer-name">${review.name}</div>
                            <div class="review-date">${formatDate(review.created_at)}</div>
                        </div>
                    </div>
                    <div class="review-rating">
                        <div class="review-stars">${createStars(review.rating)}</div>
                        <div class="review-actions">
                            ${currentUserId && review.user_id == currentUserId ? `
                                                                                            <button class="edit-review-btn" onclick="editReview(${review.id}, ${review.rating}, '${review.comment || ''}')" title="تعديل">
                                                                                                <i class="fa-solid fa-edit"></i>
                                                                                            </button>
                                                                                            <button class="delete-review-btn" onclick="deleteReview(${review.id})" title="حذف">
                                                                                                <i class="fa-solid fa-trash"></i>
                                                                                            </button>
                                                                                        ` : `
                                                                                            <button class="report-review-btn ${review.has_reported ? 'reported' : ''}" 
                                                                                                ${review.has_reported ? 'disabled' : ''} 
                                                                                                onclick="reportReview(${review.id})" 
                                                                                                title="الإبلاغ عن مخالفة">
                                                                                                ${review.has_reported ? '<i class="fa-solid fa-check"></i> تم الإبلاغ' : 'مخالفة'}
                                                                                            </button>
                                                                                        `}
                        </div>
                    </div>
                </div>
                ${review.comment ? `<div class="review-comment" id="comment-${review.id}">${review.comment}</div>` : ''}
            </div>
        `).join('');

            setTimeout(() => {
                document.querySelectorAll('.new-review').forEach(review => {
                    review.classList.remove('new-review');
                });
            }, 3000);
        }

        function reportReview(reviewId) {
            Swal.fire({
                title: "مخالفة",
                text: 'هل هذا التقييم مخالف؟',
                showCancelButton: true,
                confirmButtonText: "نعم",
                cancelButtonText: "لا"
            }).then((result) => {
                if (result.isConfirmed) {
                    const placeId = document.getElementById('place-id')?.value;
                    const userId = document.getElementById('user-id')?.value;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    fetch(`/places/${placeId}/report-review`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                report_type: 'review_report',
                                review_id: reviewId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire("تم الإبلاغ!", "شكراً لك. سيتم مراجعة بلاغك.", "success");
                                // Update the review in allReviews to mark it as reported
                                const reviewIndex = allReviews.findIndex(review => review.id == reviewId);
                                if (reviewIndex !== -1) {
                                    allReviews[reviewIndex].has_reported = true;
                                }
                                renderReviews(); // Re-render to update button state
                            } else {
                                showErrorMessage(data.error || 'فشل في تسجيل البلاغ.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showErrorMessage('فشل في التواصل مع الخادم.');
                        });
                }
            });
        }

        function openRatingModal(rating) {
            resetModalForNewRating();
            currentRating = rating;
            const modal = document.getElementById('ratingModal');

            if (!modal) return;

            const stars = modal.querySelectorAll('.modal-star');
            modal.classList.add('show');

            stars.forEach((star, index) => {
                star.classList.toggle('filled', index < rating);
            });

            updateSelectedRating(rating);
            document.getElementById('commentInput').value = '';
        }

        function updateSelectedRating(rating) {
            document.querySelectorAll('.rating-box').forEach((box, index) => {
                box.classList.toggle('selected', index + 1 <= rating);
            });
        }

        function closeRatingModal() {
            const modal = document.getElementById('ratingModal');
            if (modal) modal.classList.remove('show');
            document.querySelectorAll('.rating-box').forEach(box => box.classList.remove('selected'));
            isEditing = false;
            editingReviewId = null;
        }

        function closeModalOnOverlay(event) {
            if (event.target.classList.contains('modal-overlay')) {
                closeRatingModal();
            }
        }

        function confirmRating() {
            if (!validateRating()) return;

            const comment = document.getElementById('commentInput')?.value.trim() || null;
            const placeId = document.getElementById('place-id')?.value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const url = isEditing ? `/places/${placeId}/ratings/${editingReviewId}` : `/places/${placeId}/rate`;
            const method = isEditing ? 'PUT' : 'POST';

            fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        rating: currentRating,
                        comment
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    if (data.message) {
                        const newReview = {
                            id: isEditing ? editingReviewId : Date.now(),
                            name: "أنت",
                            rating: currentRating,
                            comment,
                            created_at: new Date().toISOString(),
                            avatar: "أ",
                            user_id: document.getElementById('user-id').value,
                            isNew: true,
                            has_reported: false // Initialize new reviews as not reported
                        };

                        if (isEditing) {
                            const reviewIndex = allReviews.findIndex(review => review.id == editingReviewId);
                            if (reviewIndex !== -1) allReviews[reviewIndex] = newReview;
                        } else {
                            allReviews.unshift(newReview);
                            document.querySelector('.add-rating-section').style.display = 'none';
                            const reviewsSection = document.querySelector('.reviews-section');
                            const existingMessage = reviewsSection.querySelector('.already-rated-message');
                            if (!existingMessage) {
                                const alreadyRatedMessage = document.createElement('div');
                                alreadyRatedMessage.className = 'already-rated-message';
                                alreadyRatedMessage.innerHTML = '<p>لقد قيّمت هذا المكان بالفعل. شكرًا على تقييمك!</p>';
                                reviewsSection.insertBefore(alreadyRatedMessage, reviewsSection.querySelector(
                                    '.reviews-title'));
                            }
                        }

                        updateAverageRating();
                        renderReviews();
                        closeRatingModal();
                        showSuccessMessage(isEditing ? 'تم تحديث تقييمك بنجاح!' : 'تم حفظ تقييمك بنجاح!');
                        fetchReviews();
                    } else {
                        showErrorMessage(data.error || 'فشل في حفظ التقييم.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorMessage('فشل في التواصل مع الخادم: ' + error.message);
                });
        }

        function showSuccessMessage(message) {
            const successMsg = document.getElementById('successMessage');
            if (successMsg) {
                successMsg.innerHTML = message + '<br />شكراً لك على مشاركة رأيك معنا';
                successMsg.classList.add('show');
                setTimeout(() => successMsg.classList.remove('show'), 3000);
            }
        }

        function showErrorMessage(message) {
            const errorMsg = document.getElementById('errorMessage');
            if (errorMsg) {
                errorMsg.innerHTML = message;
                errorMsg.style.display = 'block';
                setTimeout(() => errorMsg.style.display = 'none', 3000);
            }
        }

        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(content => content.style.display = 'none');
            document.querySelectorAll('.tab-button').forEach(button => {
                button.style.backgroundColor = 'black';
                button.style.color = 'white';
            });

            const tabElement = document.getElementById(tabId);
            if (tabElement) tabElement.style.display = 'block';

            const activeButton = document.querySelector(`[onclick="showTab('${tabId}')"]`);
            if (activeButton) {
                activeButton.style.backgroundColor = 'maroon';
                activeButton.style.color = 'white';
            }

            if (tabId === 'tab3') {
                updateAverageRating();
                renderReviews();
            }
        }

        function openImageModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            if (modal && modalImage) {
                modalImage.src = src;
                modal.classList.add('show');
            }
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            if (modal) modal.classList.remove('show');
        }

        function closeImageModalOnOverlay(event) {
            if (event.target.classList.contains('modal-overlay')) {
                closeImageModal();
            }
        }

        function validateRating() {
            if (currentRating < 1 || currentRating > 5) {
                shakeModal();
                return false;
            }
            return true;
        }

        function shakeModal() {
            const modal = document.querySelector('.modal');
            if (modal) {
                modal.style.animation = 'shake 0.5s ease-in-out';
                setTimeout(() => modal.style.animation = '', 500);
            }
        }

        function editReview(reviewId, rating, comment) {
            isEditing = true;
            editingReviewId = reviewId;
            currentRating = rating;

            const modal = document.getElementById('ratingModal');
            const commentInput = document.getElementById('commentInput');
            const confirmBtn = modal?.querySelector('.confirm-button');
            const modalTitle = modal?.querySelector('.modal-title');

            if (!modal || !commentInput || !confirmBtn || !modalTitle) return;

            commentInput.value = comment || '';
            confirmBtn.textContent = 'تحديث التقييم';
            modalTitle.innerHTML = `<i class="fa fa-edit" style="color: maroon;"></i> تعديل تقييمك`;

            const stars = modal.querySelectorAll('.modal-star');
            stars.forEach((star, index) => {
                star.classList.toggle('filled', index < rating);
            });

            updateSelectedRating(rating);
            modal.classList.add('show');
        }

        function deleteReview(reviewId) {
            Swal.fire({
                title: 'حذف التقييم',
                text: 'هل أنت متأكد من حذف تقييمك؟ لا يمكن التراجع عن هذا الإجراء.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    const placeId = document.getElementById('place-id')?.value;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    fetch(`/places/${placeId}/ratings/${reviewId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                            return response.json();
                        })
                        .then(data => {
                            if (data.message) {
                                allReviews = allReviews.filter(review => review.id != reviewId);
                                updateAverageRating();
                                renderReviews();
                                showSuccessMessage('تم حذف تقييمك بنجاح!');
                                document.querySelector('.add-rating-section').style.display = 'block';
                                document.querySelector('.already-rated-message')?.remove();
                                fetchReviews();
                            } else {
                                showErrorMessage(data.error || 'فشل في حذف التقييم.');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting review:', error);
                            showErrorMessage('فشل في التواصل مع الخادم: ' + error.message);
                        });
                }
            });
        }

        function resetModalForNewRating() {
            const modal = document.getElementById('ratingModal');
            const confirmBtn = modal?.querySelector('.confirm-button');
            const modalTitle = modal?.querySelector('.modal-title');

            if (confirmBtn) confirmBtn.textContent = 'تأكيد التقييم';
            if (modalTitle) modalTitle.innerHTML =
                `<i class="fa fa-chat-circle-text" style="color: maroon;"></i> ما رأيك في هذا المكان؟`;
            isEditing = false;
            editingReviewId = null;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.querySelector('.modal');
            if (modal) modal.addEventListener('click', event => event.stopPropagation());

            const imageModal = document.querySelector('.image-modal');
            if (imageModal) imageModal.addEventListener('click', event => event.stopPropagation());
        });

        window.onload = function() {
            showTab('tab1');
        };
    </script>
@endsection
