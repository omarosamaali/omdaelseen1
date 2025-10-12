<div id="image-modal" class="image-modal">
    <span class="close-button">&times;</span>
    <img class="modal-content" id="modal-image">
</div>
@extends('layouts.mobile')

@section('title', 'الطلبات | Orders')
<link rel="stylesheet" href="{{ asset('assets/assets/css/orders.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    body {
        background-color: #eee;
    }

    .user-avatar {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #e5e7eb;
    }

    .image-modal {
        opacity: 1;
        display: none;
        position: fixed;
        z-index: 1000;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .close-button {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close-button:hover,
    .close-button:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    .swiper-slide img {
        cursor: pointer;
    }

    .swiper {
        width: 100%;
        max-width: 268px;
        margin: 0 auto;
    }

    .swiper-slide img {
        width: 100%;
        height: 200px;
        object-fit: unset;
        border-radius: 8px;
    }

    .swiper-button-prev,
    .swiper-button-next {
        color: #0ABAC9;
    }

    .swiper-pagination-bullet-active {
        background-color: #0ABAC9;
    }
</style>
@section('content')
<x-china-header :title="__('messages.تفاصيل الطلب')" :route="url()->previous()" />
<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">
    <div class="container">
        <div class="container mx-auto py-8 px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-1 bg-white rounded-lg shadow-md p-6 text-center">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">بيانات العميل</h2>
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('storage/' . $product?->user->avatar) }}" alt="عمدة الصين"
                            class="user-avatar mb-4">
                        <div class="info-label">اسم العميل</div>
                        <div class="info-value text-lg font-semibold">{{ $product?->user->name }}</div>
                    </div>
                </div>
                <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">تفاصيل الطلب الحالي</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="info-label">رقم المرجع</div>
                            <div class="info-value font-mono">{{ $product->reference_number }}</div>
                        </div>
                        <div>
                            <div class="info-label">الحالة</div>
                            <div class="info-value">
                                <span class="status-badge bg-green-100 text-green-800">
                                    {{ $product->status }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="info-label">العنوان</div>
                            <div class="info-value">طلب منتج</div>
                        </div>
                        <div>
                            <div class="info-label">عدد المنتجات</div>
                            <div class="info-value">{{ $product->number_of_products }}</div>
                        </div>
                        <div>
                            <div class="info-label">تاريخ الإضافة</div>
                            <div class="info-value">{{ $product->created_at }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white rounded-lg shadow-md mb-8 p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-800">المنتجات التي تخص هذا الطلب</h2>
                <div class="grid grid-cols-1 gap-4">
                    @forelse ($product->orderProducts as $orderProduct)
                    <div class="border border-gray-200 rounded-lg p-4 shadow-lg w-full" style="height: fit-content;">
                        @if($orderProduct->images)
                        @php
                        $images = json_decode($orderProduct->images, true);
                        @endphp
                        @if(is_array($images) && count($images) > 0)
                        <div class="swiper product-slider-{{ $orderProduct->id }} mb-4">
                            <div class="swiper-wrapper">
                                @foreach($images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $image) }}"
                                        class="w-full h-32 object-cover rounded-lg border" alt="صورة المنتج">
                                </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                        @else
                        <p class="text-gray-500 text-center">لا توجد صور لهذا المنتج</p>
                        @endif
                        @else
                        <p class="text-gray-500 text-center">لا توجد صور لهذا المنتج</p>
                        @endif

                        <h3 class="text-lg font-semibold text-gray-700 mb-2">
                            {{ $orderProduct->name }}
                        </h3>

                        <p><strong>الكمية:</strong> {{ $orderProduct->quantity }}</p>

                        @if($orderProduct->price)
                        <p><strong>السعر:</strong> {{ number_format($orderProduct->price, 2) }} ج.م</p>
                        @endif

                        @if($orderProduct->link)
                        <p><strong>الرابط:</strong>
                            <a href="{{ $orderProduct->link }}" target="_blank" class="text-blue-500 underline">
                                اضغط هنا
                            </a>
                        </p>
                        @endif

                        @if($orderProduct->size)
                        <p><strong>المقاس:</strong> {{ $orderProduct->size }}</p>
                        @endif

                        @if($orderProduct->color)
                        <p><strong>اللون:</strong> {{ $orderProduct->color }}</p>
                        @endif

                        @if($orderProduct->notes)
                        <p><strong>ملاحظات:</strong> {{ $orderProduct->notes }}</p>
                        @endif
                    </div>
                    @empty
                    <p class="text-gray-500 text-center">لا يوجد منتجات مرتبطة بهذا الطلب</p>
                    @endforelse
                </div>
            </div>

            <div class="lg:col-span-2 bg-white rounded-lg shadow-md my-8 p-6">
                <div>
                    <div class="info-label font-bold">ماذا تفعل إذا كان السعر الإجمالي للعنصر أعلى من المتوقع؟</div>
                    <?php
                                            if ($product->price_unexpected == 'call_me') {
                                                $price_unexpected = 'اتصل بي إذا كان السعر أعلى';
                                            } elseif ($product->price_unexpected == 'buy_anyway') {
                                                $price_unexpected = 'شراء بغض النظر عن السعر';
                                            } elseif ($product->price_unexpected == 'buy_within_10_percent') {
                                                $price_unexpected = 'الشراء في غضون 10٪ من السعر المتوقع';
                                            }
                                            ?>
                    <div class="info-value pb-2">- {{ $price_unexpected }}</div>
                </div>
                <div>
                    <div class="info-label font-bold">ماذا تفعل إذا كان أي من العناصر غير متوفر؟</div>
                    <?php
                                            if ($product->item_unavailable == 'contact_me') {
                                                $item_unavailable = 'تواصل معي';
                                            } elseif ($product->item_unavailable == 'cancel_and_buy_available') {
                                                $item_unavailable = 'إلغاء المنتج الغير متوفر وأشتري المنتجات المتوفرة فقط';
                                            }
                                            ?>
                    <div class="info-value pb-2">-{{ $item_unavailable }}</div>
                </div>
                <div>
                    <div class="info-label font-bold">
                        ماذا تفعل إذا لم يقبل البائع الإرجاع / الاسترداد حتى لو كان
                        المنتج
                        معيبًا؟ </div>
                    <?php
                                                                if ($product->no_returns == 'no_problem_buy') {
                                                                    $no_returns = 'لا توجد مشكلة اشتري المنتج';
                                                                } elseif ($product->no_returns == 'contact_me') {
                                                                    $no_returns = 'تواصل معي';
                                                                } elseif ($product->no_returns == 'cancel_product') {
                                                                    $no_returns = 'الغي المنتج';
                                                                }
                                                                ?>
                    <div class="info-value pb-2">- {{ $no_returns }}</div>
                </div>
                <div>
                    <div class="info-label font-bold">ماذا تفعل إذا كانت السلعة تستغرق من أسبوع إلى أسبوعين ليتم شحنها
                        من البائع؟
                    </div>
                    <?php
                                            if ($product->no_problem == 'no_problem_wait') {
                                                $no_problem = 'لا توجد مشكلة اشتري المنتج';
                                            } elseif ($product->no_problem == 'cancel_product') {
                                                $no_problem = 'قم بإلغائها';
                                            } elseif ($product->no_problem == 'change_product') {
                                                $no_problem = 'غيرها لمنتج آخر';
                                            } elseif ($product->no_problem == 'contact_another_seller') {
                                                $no_problem = 'تواصل مع تاجر آخر تتوفر لديه نفس المنتجات';
                                            }
                                            ?>
                    <div class="info-value pb-2">- {{ $no_problem }}</div>
                </div>
                <div>
                    <div class="info-label font-bold">ماذا تفعل إذا كان الطلب يحتوي على عناصر تحمل علامات تجارية ولا
                        يمكن شحنها
                        إلا مع
                        شركات صريحة
                        معينة؟
                    </div>
                    <?php
                                            if ($product->same_company == 'no_problem_change') {
                                                $same_company = 'ليس لدي مانع لتبديل شركة الشحن';
                                            } elseif ($product->same_company == 'cancel_product') {
                                                $same_company = 'إلغاء المنتجات التي تحتوي أسماء العلامات التجارية';
                                            } elseif ($product->same_company == 'change_product') {
                                                $same_company = 'غيرها لمنتج آخر';
                                            } elseif ($product->same_company == 'change_product') {
                                                $same_company = 'استبدال المنتجات التي تحمل أسماء العلامات التجارية بمنتجات أخرى
                                                                                                                                            مشابهة';
                                            }
                                            ?>
                    <div class="info-value pb-2">- {{ $same_company }}</div>
                </div>
                <div>
                    <div class="info-label font-bold">
                        ماذا تفعل اذا كان الطلب يحتوي على عناصر او منتجات تحتوي على بطاريات تعرقل الشحن؟ </div>
                    <?php
                                            if ($product->batteries == 'remove_battery') {
                                                $batteries = 'ازالة البطارية من المنتج وشحن المنتج بدون بطارية';
                                            } elseif ($product->batteries == 'cancel_product') {
                                                $batteries = 'إلغاء المنتج';
                                            } elseif ($product->batteries == 'change_product') {
                                                $batteries = 'تغيير المنتج بمنتج آخر';
                                            } elseif ($product->batteries == 'contact_another_seller') {
                                                $batteries = 'المحاولة مع شركات شحن أخرى وحتى لو كانت تطلب مبالغ عالية';
                                            } elseif ($product->batteries == 'contact_me') {
                                            $batteries = 'تواصل معي';
                                            }
                                            ?>
                    <div class="info-value pb-2">- {{ $batteries }}</div>
                </div>
                <div>
                    <div class="info-label font-bold">
                        معاينة المنتجات بمكتب الصين قبل الإرسال وجهات الاستلام؟</div>
                    <?php
                                                        if ($product->see_product == 'yes') {
                                                            $see_product = 'نعم أوافق على فتح المنتجات ومعاينتها واعتمادها قبل الإرسال';
                                                        } elseif ($product->see_product == 'no') {
                                                            $see_product = 'لا أوافق ارسال المنتج من المصنع أو التاجر مباشرة';
                                                        }
                                                        ?>
                    <div class="info-value pb-2">- {{ $see_product }}</div>
                </div>
            </div>

        </div>
    </div>
</div>


{{-- يتم دمج جميع الأكواد البرمجية هنا --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Swiper for each product slider
        @foreach ($product->orderProducts as $orderProduct)
            @if($orderProduct->images && is_array(json_decode($orderProduct->images, true)) && count(json_decode($orderProduct->images, true)) > 0)
                new Swiper('.product-slider-{{ $orderProduct->id }}', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    spaceBetween: 10,
                    slidesPerView: 1,
                });
            @endif
        @endforeach

        // Get the modal and image elements
        const modal = document.getElementById('image-modal');
        const modalImg = document.getElementById('modal-image');
        const closeBtn = document.getElementsByClassName('close-button')[0];
        
        // Add click listener to all images inside swiper slides
        document.querySelectorAll('.swiper-slide img').forEach(image => {
            image.addEventListener('click', function(event) {
                modal.style.display = "block";
                modalImg.src = this.src;
            });
        });
        
        // Close the modal when the close button is clicked
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }
        
        // Close the modal when clicking outside of the image
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });
</script>
@endsection