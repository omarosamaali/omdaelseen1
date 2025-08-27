@extends('layouts.mobile')

@section('title', 'مستكشفي الصين | China Discover')
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">

@section('content')
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">

    <div class="header-container">
        <img src="{{ asset('assets/assets/images/header-bg.png') }}" alt="">
        <a href="my-profile.html" class="profile-link dark:bg-color10">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <div class="logo-register">مستكشفي الصين</div>
    </div>

    <div style="width: 100%; display: block; margin-top: 100px;">
        @if ($banners->isNotEmpty())
        @foreach ($banners as $banner)
        <img class="fav-image" src="{{ asset('storage/' . $banner->avatar) }}" alt="">
        @endforeach
        @endif
    </div>

    <div>
        <div class="continaer--title">
            <h6 class="categories">التصنيفات</h6>
            <a href={{ route('mobile.china-discovers.all-places') }} class="show--all">عرض الجميع</a>
        </div>

        <div style="display: flex; align-items: center; justify-content: flex-start; gap: 10px; margin: 10px;">
            <a href="{{ route('mobile.china-discovers.index') }}" style="flex-shrink: 0; text-decoration: none; color: inherit; text-align: center;">
                <div style="width: 99px; flex-shrink: 0;">
                    <img style="width: 70%; text-align: center; margin: auto; max-height: 73px;" src="{{ asset('assets/assets/images/logo.png') }}" alt="الجميع">
                    <p style="padding-top: 9px; font-size: 15px;">الجميع</p>
                </div>
            </a>

            <div class="slider-container" style="display: flex; overflow-x: auto; scroll-snap-type: x mandatory; gap: 10px; padding: 10px; scrollbar-width: none; -ms-overflow-style: none;">
                @foreach ($explorers as $explorer)
                <a href="{{ route('mobile.china-discovers.index', $explorer->id) }}" style="flex-shrink: 0; text-decoration: none; color: inherit; text-align: center; scroll-snap-align: start;">
                    <div style="width: 99px; flex-shrink: 0;">
                        <img style="width: 100%; border-radius: 15px;" src="{{ asset('storage/' . $explorer->avatar) }}" alt="{{ $explorer->name_ar }}">
                        <p style="padding-top: 9px; font-size: 15px;">{{ $explorer->name_ar }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <a href="{{ route('mobile.china-discovers.create') }}" class="add-place-button">إضافة مكان جديد</a>
    @if (session('success'))
    <div id="success-alert" style="background: #85d185; color: green; margin: 20px 20px 4px;" class="bg-green-500 text-white p-4 rounded-xl my-4 text-center">
        {{ session('success') }}
    </div>
    @endif

    <div class="slider-container">
        <div class="slider" id="placesSlider">
            @forelse ($places as $place)
            <div class="place-card">
                <img src="{{ asset('storage/' . $place->avatar) }}" alt="{{ $place->name_ar }}">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    @if ($place->mainCategory)
                    <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}" alt="{{ $place->mainCategory->name_ar }}">
                    <span>{{ $place->mainCategory->name_ar }}</span>
                    @else
                    <img src="{{ asset('storage/placeholders/no-category.png') }}" alt="بدون تصنيف">
                    <span>بدون تصنيف</span>
                    @endif
                </div>
                <div class="place-name">{{ $place->name_ar }}</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>
            @empty
            <div class="empty-message-container" style="text-align: center; width: 100%; padding: 20px;">
                <p style="color: #6c757d; font-size: 18px;">لا يوجد أماكن للعرض حاليًا.</p>
            </div>
            @endforelse
        </div>
    </div>

    <div class="continaer--title" style="margin-top: 30px;">
        <a class="show--all">عرض الجميع</a>
        <h6 class="categories">أحدث الأماكن</h6>
    </div>

    <div class="slider-container">
        <div class="slider" id="placesSlider">
            @foreach ($latestPlaces as $place)
            <div class="place-card">
                <img src="{{ asset('storage/' . $place->avatar) }}" alt="{{ $place->name_ar }}">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    @if ($place->mainCategory)
                    <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}" alt="{{ $place->mainCategory->name_ar }}">
                    <span>{{ $place->mainCategory->name_ar }}</span>
                    @else
                    <img src="{{ asset('storage/placeholders/no-category.png') }}" alt="بدون تصنيف">
                    <span>بدون تصنيف</span>
                    @endif
                </div>
                <div class="place-name">{{ $place->name_ar }}</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>
            @endforeach
        </div>
    </div>

    <div class="continaer--title" style="margin-top: 30px;">
        <a class="show--all">عرض الجميع</a>
        <h6 class="categories">أماكن مشهورة</h6>
    </div>

    <div class="slider-container">
        <div class="slider" id="placesSlider">
            @foreach ($latestPlaces as $place)
            <div class="place-card">
                <img src="{{ asset('storage/' . $place->avatar) }}" alt="{{ $place->name_ar }}">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    @if ($place->mainCategory)
                    <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}" alt="{{ $place->mainCategory->name_ar }}">
                    <span>{{ $place->mainCategory->name_ar }}</span>
                    @else
                    <img src="{{ asset('storage/placeholders/no-category.png') }}" alt="بدون تصنيف">
                    <span>بدون تصنيف</span>
                    @endif
                </div>
                <div class="place-name">{{ $place->name_ar }}</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>
            @endforeach
        </div>
    </div>

</div>

<script>
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.display = 'none';
        }, 3000);
    }

    function openModal() {
        Swal.fire({
            title: "بلاغ؟"
            , text: 'هل هذا المكان مخالف'
            , showCancelButton: true
            , confirmButtonText: "نعم"
            , cancelButtonText: "لا"
        }).then((result) => {
            if (result.isConfirmed) {
                if (typeof userId === 'undefined' || userId === null) {
                    Swal.fire("خطأ!", "لا يمكن إرسال البلاغ. يرجى تسجيل الدخول أولاً.", "error");
                    return;
                }

                fetch(`/chef-profile/report-by-user/${userId}`, {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            , 'Accept': 'application/json'
                        }
                        , body: JSON.stringify({
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
            icon.className = 'ph ph-heart-fill';
        } else {
            icon.className = 'ph ph-heart';
        }
    }

    function explorePlace(element) {
        const card = element.closest('.place-card');
        const placeName = card.querySelector('.place-name').textContent;
        const categorySpan = card.querySelector('.category-tag span');
        const category = categorySpan ? categorySpan.textContent : 'غير محدد';

        alert(`استكشف ${placeName} في فئة ${category}`);
    }

    // متغيرات عامة للتحكم في التمرير التلقائي
    let autoScrollIntervals = [];
    let userInteracting = [];

    // Touch/drag support for mobile
    function initializeTouchSupport() {
        document.querySelectorAll('.slider').forEach((slider, index) => {
            let startX = 0;
            let scrollLeft = 0;
            userInteracting[index] = false;

            slider.addEventListener('touchstart', (e) => {
                startX = e.touches[0].pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
                userInteracting[index] = true;

                // إيقاف التمرير التلقائي عند التفاعل
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

                // إعادة تشغيل التمرير التلقائي بعد 3 ثواني من التوقف
                setTimeout(() => {
                    userInteracting[index] = false;
                    startAutoScroll(slider, index);
                }, 3000);
            });

            // إيقاف التمرير عند hover على سطح المكتب
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

    // دالة بدء التمرير التلقائي لسلايدر واحد
    function startAutoScroll(slider, index) {
        if (autoScrollIntervals[index]) {
            clearInterval(autoScrollIntervals[index]);
        }

        autoScrollIntervals[index] = setInterval(() => {
            if (userInteracting[index]) return;

            const scrollAmount = 280; // عرض الكارد + المسافة
            const maxScroll = slider.scrollWidth - slider.clientWidth;

            if (slider.scrollLeft >= maxScroll - 10) { // هامش صغير
                slider.scrollTo({
                    left: 0
                    , behavior: 'smooth'
                });
            } else {
                slider.scrollTo({
                    left: slider.scrollLeft + scrollAmount
                    , behavior: 'smooth'
                });
            }
        }, 4000 + (index * 500)); // توقيت مختلف لكل سلايدر
    }

    // Auto-scroll function for all sliders
    function autoScrollSliders() {
        const sliders = document.querySelectorAll('.slider');

        sliders.forEach((slider, index) => {
            userInteracting[index] = false;
            startAutoScroll(slider, index);
        });
    }

    // Add scroll indicators
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

            // حساب عدد المؤشرات
            const containerWidth = slider.offsetWidth || slider.parentElement.offsetWidth;
            const cardWidth = 280; // عرض الكارد المفترض
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
                    dot.style.background = '#ffb531';
                    dot.style.transform = 'scale(1.2)';
                }

                dot.addEventListener('click', () => {
                    const scrollPosition = i * cardWidth * visibleCards;
                    slider.scrollTo({
                        left: scrollPosition
                        , behavior: 'smooth'
                    });
                    updateIndicators(indicatorContainer, i);

                    // إيقاف التمرير التلقائي مؤقتاً
                    userInteracting[containerIndex] = true;
                    setTimeout(() => {
                        userInteracting[containerIndex] = false;
                    }, 5000);
                });

                indicatorContainer.appendChild(dot);
            }

            // التحقق من عدم وجود مؤشرات مسبقاً
            const existingIndicators = container.querySelector('.scroll-indicators');
            if (existingIndicators) {
                existingIndicators.remove();
            }

            container.appendChild(indicatorContainer);

            // تحديث المؤشرات عند التمرير
            let scrollTimeout;
            slider.addEventListener('scroll', () => {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    const currentIndex = Math.round(slider.scrollLeft / (cardWidth * visibleCards));
                    updateIndicators(indicatorContainer, Math.min(currentIndex, indicatorCount - 1));
                }, 100);
            });
        });
    }

    function updateIndicators(container, activeIndex) {
        const dots = container.querySelectorAll('.scroll-dot');
        dots.forEach((dot, index) => {
            if (index === activeIndex) {
                dot.style.background = '#ffb531';
                dot.style.transform = 'scale(1.2)';
            } else {
                dot.style.background = 'rgba(255, 181, 49, 0.3)';
                dot.style.transform = 'scale(1)';
            }
        });
    }

    // تنظيف الـ intervals عند مغادرة الصفحة
    function cleanup() {
        autoScrollIntervals.forEach(interval => {
            if (interval) clearInterval(interval);
        });
        autoScrollIntervals = [];
    }

    // Initialize everything after DOM loads
    document.addEventListener('DOMContentLoaded', () => {
        // انتظار تحميل الصور والمحتوى
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }

        function init() {
            setTimeout(() => {
                initializeTouchSupport();
                addScrollIndicators();

                // بدء التمرير التلقائي بعد تأخير
                setTimeout(autoScrollSliders, 2000);
            }, 300);
        }
    });

    // تنظيف عند مغادرة الصفحة
    window.addEventListener('beforeunload', cleanup);
    window.addEventListener('pagehide', cleanup);

</script>

@endsection
