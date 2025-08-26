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
        <img class="fav-image" src="{{ asset('storage/' . $banners->avatar) }}" alt="">
    </div>
    <div class="continaer--title">
        <a class="show--all">عرض الجميع</a>
        <h6 class="categories">التصنيفات</h6>
    </div>

    <div style="display: flex; gap: 10px; margin: 10px; justify-content: center;">
        <div style="width: fit-content;">
            <img style="width: 99px; border-radius: 15px;" src="./assets/images/premium-features-3.png" alt="">
            <p style="text-align: center; padding-top: 9px; font-size: 15px;">تصنيف رئيسي 2</p>
        </div>

        <div style="width: fit-content;">
            <img style="width: 99px; border-radius: 15px;" src="./assets/images/premium-features-2.png" alt="">
            <p style="text-align: center; padding-top: 9px; font-size: 15px;"> تصنيف رئيسي 1 </p>
        </div>

        <div style="width: fit-content;">
            <img style="width: 99px; border-radius: 15px;" src="./assets/images/premium-features-1.png" alt="">
            <p style="text-align: center; padding-top: 9px; font-size: 15px;">الجميع</p>
        </div>
    </div>

    <button class="add-place-button">إضافة مكان جديد</button>

    <!-- Slider Section -->
    <div class="slider-container">
        <div class="slider" id="placesSlider">

            <!-- Place Card 1 -->
            <div class="place-card">
                <img src="https://img.freepik.com/free-photo/restaurant-interior_1127-3394.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="مطعم فاخر">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    <img src="https://img.freepik.com/free-vector/fork-knife-icon_1308-99922.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="مطعم">
                    <span>مطاعم</span>
                </div>
                <div class="place-name">مطعم التنين الذهبي</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

            <!-- Place Card 2 -->
            <div class="place-card">
                <img src="https://img.freepik.com/free-photo/luxury-classic-modern-bedroom-suite-hotel_105762-1787.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="فندق فاخر">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    <img src="https://img.freepik.com/free-vector/hotel-building-icon_1308-30845.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="فندق">
                    <span>فنادق</span>
                </div>
                <div class="place-name">فندق بكين الكبير</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

            <!-- Place Card 3 -->
            <div class="place-card">
                <img src="https://img.freepik.com/free-photo/ancient-chinese-architecture_1127-3276.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="معبد">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    <img src="https://img.freepik.com/free-vector/temple-building-icon_1308-31896.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="معبد">
                    <span>معابد</span>
                </div>
                <div class="place-name">معبد السماء</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

            <!-- Place Card 4 -->
            <div class="place-card">
                <img src="https://img.freepik.com/free-photo/beautiful-park-with-trees_1127-3845.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="حديقة">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    <img src="https://img.freepik.com/free-vector/tree-icon_1308-31789.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="حديقة">
                    <span>حدائق</span>
                </div>
                <div class="place-name">حديقة بيهاي</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

            <!-- Place Card 5 -->
            <div class="place-card">
                <img src="https://img.freepik.com/free-photo/museum-interior-with-artifacts_1127-3567.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="متحف">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    <img src="https://img.freepik.com/free-vector/museum-building-icon_1308-31567.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="متحف">
                    <span>متاحف</span>
                </div>
                <div class="place-name">المدينة المحرمة</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

            <!-- Place Card 6 -->
            <div class="place-card">
                <img src="https://img.freepik.com/free-photo/traditional-chinese-market_1127-3892.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="سوق">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    <img src="https://img.freepik.com/free-vector/shopping-cart-icon_1308-31245.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="سوق">
                    <span>أسواق</span>
                </div>
                <div class="place-name">سوق وانغ فو جينغ</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

        </div>
    </div>

    <!-- أحدث الأماكن Section -->
    <div class="continaer--title" style="margin-top: 30px;">
        <a class="show--all">عرض الجميع</a>
        <h6 class="categories">أحدث الأماكن</h6>
    </div>

    <div class="slider-container">
        <div class="slider" id="latestPlacesSlider">

            <!-- Latest Place Card 1 -->
            <div class="place-card">
                <img src="https://img.freepik.com/free-photo/modern-cafe-interior_1127-4521.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="كافيه جديد">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    <img src="https://img.freepik.com/free-vector/coffee-cup-icon_1308-31456.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="كافيه">
                    <span>كافيهات</span>
                </div>
                <div class="place-name">كافيه الياسمين الجديد</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

            <!-- Latest Place Card 2 -->
            <div class="place-card">
                <img src="https://img.freepik.com/free-photo/shopping-mall-interior_1127-4892.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="مول جديد">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    <img src="https://img.freepik.com/free-vector/shopping-bag-icon_1308-31123.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="مول">
                    <span>مولات</span>
                </div>
                <div class="place-name">مول شنغهاي الجديد</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

            <!-- Latest Place Card 3 -->
            <div class="place-card">
                <img src="https://img.freepik.com/free-photo/gym-interior-equipment_1127-3745.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="جيم جديد">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    <img src="https://img.freepik.com/free-vector/dumbbell-icon_1308-31234.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="جيم">
                    <span>رياضة</span>
                </div>
                <div class="place-name">نادي التنين الرياضي</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

            <!-- Latest Place Card 4 -->
            <div class="place-card">
                <img src="https://img.freepik.com/free-photo/spa-wellness-center_1127-4231.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="سبا جديد">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag">
                    <img src="https://img.freepik.com/free-vector/spa-icon_1308-31567.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="سبا">
                    <span>استجمام</span>
                </div>
                <div class="place-name">سبا اللوتس الهادئ</div>
                <button class="explore-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

        </div>
    </div>

    <!-- أماكن مشهورة Section -->
    <div class="continaer--title" style="margin-top: 30px;">
        <a class="show--all">عرض الجميع</a>
        <h6 class="categories">أماكن مشهورة</h6>
    </div>

    <div class="slider-container">
        <div class="slider" id="popularPlacesSlider">

            <!-- Popular Place Card 1 -->
            <div class="place-card popular-card">
                <img src="https://img.freepik.com/free-photo/great-wall-china-sunset_1127-2341.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="سور الصين العظيم">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag popular-tag">
                    <img src="https://img.freepik.com/free-vector/star-icon_1308-31789.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="مشهور">
                    <span>مشهور ⭐</span>
                </div>
                <div class="place-name">سور الصين العظيم</div>
                <button class="explore-btn popular-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

            <!-- Popular Place Card 2 -->
            <div class="place-card popular-card">
                <img src="https://cdn-front.freepik.com/home/authenticated/cover-cards/photo.webp?im=AspectCrop=(333,300),xPosition=0.75" alt="المدينة المحرمة">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag popular-tag">
                    <img src="https://img.freepik.com/free-vector/crown-icon_1308-31456.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="تاريخي">
                    <span>تاريخي ⭐</span>
                </div>
                <div class="place-name">القصر الإمبراطوري</div>
                <button class="explore-btn popular-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

            <!-- Popular Place Card 3 -->
            <div class="place-card popular-card">
                <img src="https://img.freepik.com/free-photo/terracotta-warriors-china_1127-3421.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="محاربو التراكوتا">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag popular-tag">
                    <img src="https://img.freepik.com/free-vector/warrior-icon_1308-31234.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="أثري">
                    <span>أثري ⭐</span>
                </div>
                <div class="place-name">محاربو التراكوتا</div>
                <button class="explore-btn popular-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

            <!-- Popular Place Card 4 -->
            <div class="place-card popular-card">
                <img src="https://img.freepik.com/free-photo/li-river-guilin-china_1127-4567.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="نهر لي">
                <div class="heart-icon" onclick="toggleHeart(this)">
                    <i class="ph ph-heart" style="font-size: 18px;"></i>
                </div>
                <div class="category-tag popular-tag">
                    <img src="https://img.freepik.com/free-vector/mountain-icon_1308-31567.jpg?uid=R118249704&ga=GA1.1.696324772.1728654570&semt=ais_hybrid&w=740" alt="طبيعة">
                    <span>طبيعة ⭐</span>
                </div>
                <div class="place-name">نهر لي الساحر</div>
                <button class="explore-btn popular-btn" onclick="explorePlace(this)">استكشف</button>
            </div>

        </div>
    </div>

</div>

<script>
    function openModal() {
        Swal.fire({
            title: "بلاغ؟"
            , text: 'هل هذا المكان مخالف'
            , showCancelButton: true
            , confirmButtonText: "نعم"
            , cancelButtonText: "لا"
        }).then((result) => {
            let reportType = '';
            if (result.isConfirmed) {
                reportType = 'content_report';
            } else if (result.isDenied) {
                reportType = 'fake_account';
            }

            if (reportType) {
                fetch(`/chef-profile/report-by-user/${userId}`, {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            , 'Accept': 'application/json'
                        }
                        , body: JSON.stringify({
                            report_type: reportType
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
        const category = card.querySelector('.category-tag span').textContent;

        alert(`استكشف ${placeName} في فئة ${category}`);
    }

    // Auto scroll functionality (optional)
    let isScrolling = false;
    const slider = document.getElementById('placesSlider');

    // Touch/drag support for mobile
    let startX = 0;
    let scrollLeft = 0;

    slider.addEventListener('touchstart', (e) => {
        startX = e.touches[0].pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('touchmove', (e) => {
        if (!startX) return;
        const x = e.touches[0].pageX - slider.offsetLeft;
        const walk = (x - startX) * 2;
        slider.scrollLeft = scrollLeft - walk;
    });

    slider.addEventListener('touchend', () => {
        startX = 0;
    });

    // Auto-scroll function for all sliders
    function autoScrollSliders() {
        const sliders = document.querySelectorAll('.slider');

        sliders.forEach((slider, index) => {
            setInterval(() => {
                const scrollAmount = 220; // width of one card + gap
                const maxScroll = slider.scrollWidth - slider.clientWidth;

                if (slider.scrollLeft >= maxScroll) {
                    slider.scrollLeft = 0; // Reset to start
                } else {
                    slider.scrollLeft += scrollAmount;
                }
            }, 4000 + (index * 1000)); // Different timing for each slider
        });
    }

    // Start auto-scroll after page loads
    window.addEventListener('load', () => {
        setTimeout(autoScrollSliders, 2000);
    });

    // Pause auto-scroll on hover
    document.querySelectorAll('.slider').forEach(slider => {
        slider.addEventListener('mouseenter', () => {
            slider.style.scrollBehavior = 'auto';
        });

        slider.addEventListener('mouseleave', () => {
            slider.style.scrollBehavior = 'smooth';
        });
    });

    // Add scroll indicators
    function addScrollIndicators() {
        const sliders = document.querySelectorAll('.slider-container');

        sliders.forEach(container => {
            const slider = container.querySelector('.slider');
            const indicatorContainer = document.createElement('div');
            indicatorContainer.className = 'scroll-indicators';
            indicatorContainer.style.cssText = `
          display: flex;
          justify-content: center;
          gap: 8px;
          margin-top: 15px;
        `;

            // Calculate number of indicators based on cards
            const cards = slider.querySelectorAll('.place-card');
            const visibleCards = Math.floor(slider.clientWidth / 220);
            const indicatorCount = Math.ceil(cards.length / visibleCards);

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
                }

                dot.addEventListener('click', () => {
                    slider.scrollLeft = i * 220 * visibleCards;
                    updateIndicators(indicatorContainer, i);
                });

                indicatorContainer.appendChild(dot);
            }

            container.appendChild(indicatorContainer);

            // Update indicators on scroll
            slider.addEventListener('scroll', () => {
                const currentIndex = Math.round(slider.scrollLeft / (220 * visibleCards));
                updateIndicators(indicatorContainer, currentIndex);
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

    // Initialize indicators after DOM loads
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(addScrollIndicators, 100);
    });

</script>

@endsection
