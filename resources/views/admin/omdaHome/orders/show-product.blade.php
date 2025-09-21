@extends($layout)

@section('content')
<style>
    .info-label {
        font-weight: bold;
        color: #374151;
        /* Dark gray */
        margin-bottom: 0.5rem;
    }

    .info-value {
        color: #6b7280;
        /* Medium gray */
        margin-bottom: 1rem;
    }

    .user-avatar {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        /* Circular avatar */
        border: 3px solid #e5e7eb;
        /* Light gray border */
    }

    /* Styles for the new trip request cards */
    .trip-card {
        background-color: white;
        border-radius: 0.5rem;
        /* 8px */
        padding: 1rem;
        /* 16px */
        margin-bottom: 1rem;
        /* 16px */
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: box-shadow 0.2s ease-in-out;
    }

    .trip-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        /* 4px 12px */
        border-radius: 9999px;
        /* Pill shape */
        font-size: 0.75rem;
        /* 12px */
        font-weight: 500;
    }
</style>

<div class="container mx-auto py-8 px-4">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <div class="lg:col-span-1 bg-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-xl font-bold mb-4 text-gray-800">بيانات العميل</h2>
            <div class="flex flex-col items-center">
                @if ($trip_request->user && $trip_request->user->avatar)
                <img src="{{ asset('storage/' . $trip_request->user->avatar) }}" alt="{{ $trip_request->user->name }}"
                    class="user-avatar mb-4">
                @else
                <div class="user-avatar mb-4 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">لا توجد صورة</span>
                </div>
                @endif
                <div class="info-label">اسم العميل</div>
                <div class="info-value text-lg font-semibold">{{ $trip_request->user->name ?? '-' }}</div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">تفاصيل الطلب الحالي</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="info-label">رقم المرجع</div>
                    <div class="info-value font-mono">{{ $trip_request->reference_number ?? '-' }}</div>
                </div>
                <div>
                    <div class="info-label">الحالة</div>
                    <div class="info-value">
                        <span class="status-badge bg-green-100 text-green-800">
                            {{ $trip_request->status }}
                        </span>
                    </div>
                </div>
                <div>
                    <div class="info-label">عدد المنتجات</div>
                    <div class="info-value">{{ $trip_request->number_of_products ?? 0 }}</div>
                </div>
                <div>
                    <div class="info-label">تاريخ الإضافة</div>
                    <div class="info-value">
                        {{ $trip_request->created_at
                        ? $trip_request->created_at->format('Y-m-d
                        H:i')
                        : '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-lg shadow-md mb-8 p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">المنتجات التي تخص هذا الطلب</h2>

        <div class="grid grid-cols-1 gap-4">
            @forelse ($trip_request->orderProducts as $orderProduct)
            <div class="border border-gray-200 rounded-lg p-4 shadow-lg w-fit">
                @if ($orderProduct->images)
                @php
                $images = json_decode($orderProduct->images, true);
                @endphp
                @if (count($images) > 0)
                <div>
                    <img src="{{ asset('storage/' . $images[0]) }}" class="w-full h-32 object-cover rounded-lg border"
                        alt="صورة المنتج الأولى">
                </div>
                @endif
                @endif
                <h3 class="text-lg font-semibold text-gray-700 mb-2">
                    {{ $orderProduct->name }}
                </h3>

                <p><strong>الكمية:</strong> {{ $orderProduct->quantity }}</p>

                @if ($orderProduct->price)
                <p><strong>السعر:</strong> {{ number_format($orderProduct->price, 2) }} ج.م</p>
                @endif

                @if ($orderProduct->link)
                <p><strong>الرابط:</strong>
                    <a href="{{ $orderProduct->link }}" target="_blank" class="text-blue-500 underline">
                        اضغط هنا
                    </a>
                </p>
                @endif

                @if ($orderProduct->size)
                <p><strong>المقاس:</strong> {{ $orderProduct->size }}</p>
                @endif

                @if ($orderProduct->color)
                <p><strong>اللون:</strong> {{ $orderProduct->color }}</p>
                @endif

                @if ($orderProduct->notes)
                <p><strong>ملاحظات:</strong> {{ $orderProduct->notes }}</p>
                @endif
            </div>
            @empty
            <p class="text-gray-500 text-center">لا يوجد منتجات مرتبطة بهذا الطلب</p>
            @endforelse
        </div>
    </div>

    <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">تفاصيل الطلب </h2>
        <div class="grid grid-cols-1 gap-4">
            <div>
                <div class="info-label">نوع الطلب</div>
                <div class="info-value font-mono">منتج خاص</div>
            </div>
            <div>
                <div class="info-label">ماذا تفعل إذا كان السعر الإجمالي للعنصر أعلى من المتوقع؟</div>
                <?php
                    if ($trip_request->price_unexpected == 'call_me') {
                        $price_unexpected = 'اتصل بي إذا كان السعر أعلى';
                    } elseif ($trip_request->price_unexpected == 'buy_anyway') {
                        $price_unexpected = 'شراء بغض النظر عن السعر';
                    } elseif ($trip_request->price_unexpected == 'buy_within_10_percent') {
                        $price_unexpected = 'الشراء في غضون 10٪ من السعر المتوقع';
                    }
                    ?>
                <div class="info-value">{{ $price_unexpected }}</div>
            </div>
            <div>
                <div class="info-label">ماذا تفعل إذا كان أي من العناصر غير متوفر؟</div>
                <?php
                    if ($trip_request->item_unavailable == 'contact_me') {
                        $item_unavailable = 'تواصل معي';
                    } elseif ($trip_request->item_unavailable == 'cancel_and_buy_available') {
                        $item_unavailable = 'إلغاء المنتج الغير متوفر وأشتري المنتجات المتوفرة فقط';
                    }
                    ?>
                <div class="info-value">{{ $item_unavailable }}</div>
            </div>
            <div>
                <div class="info-label">ماذا تفعل إذا لم يقبل البائع الإرجاع / الاسترداد حتى لو كان
                    المنتج
                    معيبًا؟</div>
                <?php
                    if ($trip_request->no_returns == 'no_problem_buy') {
                        $no_returns = 'لا توجد مشكلة اشتري المنتج';
                    } elseif ($trip_request->no_returns == 'contact_me') {
                        $no_returns = 'تواصل معي';
                    }
                    ?>
                <div class="info-value">{{ $no_returns }}</div>
            </div>
            <div>
                <div class="info-label">ماذا تفعل إذا كانت السلعة تستغرق من أسبوع إلى أسبوعين ليتم شحنها من البائع؟
                </div>
                <?php
                    if ($trip_request->no_problem == 'no_problem_wait') {
                        $no_problem = 'لا توجد مشكلة اشتري المنتج';
                    } elseif ($trip_request->no_problem == 'cancel_product') {
                        $no_problem = 'قم بإلغائها';
                    } elseif ($trip_request->no_problem == 'change_product') {
                        $no_problem = 'غيرها لمنتج آخر';
                    } elseif ($trip_request->no_problem == 'contact_another_seller') {
                        $no_problem = 'تواصل مع تاجر آخر تتوفر لديه نفس المنتجات';
                    }
                    ?>
                <div class="info-value">{{ $no_problem }}</div>
            </div>
            <div>
                <div class="info-label">ماذا تفعل إذا كان الطلب يحتوي على عناصر تحمل علامات تجارية ولا يمكن شحنها إلا مع
                    شركات صريحة
                    معينة؟
                </div>
                <?php
                    if ($trip_request->same_company == 'no_problem_change') {
                        $same_company = 'ليس لدي مانع لتبديل شركة الشحن';
                    } elseif ($trip_request->same_company == 'cancel_product') {
                        $same_company = 'إلغاء المنتجات التي تحتوي أسماء العلامات التجارية';
                    } elseif ($trip_request->same_company == 'change_product') {
                        $same_company = 'غيرها لمنتج آخر';
                    } elseif ($trip_request->same_company == 'change_product') {
                        $same_company = 'استبدال المنتجات التي تحمل أسماء العلامات التجارية بمنتجات أخرى
                                                                                                                    مشابهة';
                    }
                    ?>
                <div class="info-value">{{ $same_company }}</div>
            </div>
            <div>
                <div class="info-label">
                    ماذا تفعل اذا كان الطلب يحتوي على عناصر او منتجات تحتوي على بطاريات تعرقل الشحن؟ </div>
                <?php
                    if ($trip_request->batteries == 'remove_battery') {
                        $batteries = 'ازالة البطارية من المنتج وشحن المنتج بدون بطارية';
                    } elseif ($trip_request->batteries == 'cancel_product') {
                        $batteries = 'إلغاء المنتج';
                    } elseif ($trip_request->batteries == 'change_product') {
                        $batteries = 'تغيير المنتج بمنتج آخر';
                    } elseif ($trip_request->batteries == 'contact_another_seller') {
                        $batteries = 'المحاولة مع شركات شحن أخرى وحتى لو كانت تطلب مبالغ عالية';
                    } elseif ($trip_request->batteries == 'contact_me') {
                    $batteries = 'تواصل معي';
                    }
                    ?>
                <div class="info-value">{{ $batteries }}</div>
            </div>
            <div>
                <div class="info-label">
                    معاينة المنتجات بمكتب الصين قبل الإرسال وجهات الاستلام؟</div>
                <?php
                                if ($trip_request->see_product == 'yes') {
                                    $see_product = 'نعم أوافق على فتح المنتجات ومعاينتها واعتمادها قبل الإرسال';
                                } elseif ($trip_request->see_product == 'no') {
                                    $see_product = 'لا أوافق ارسال المنتج من المصنع أو التاجر مباشرة';
                                }
                                ?>
                <div class="info-value">{{ $see_product }}</div>
            </div>
        </div>
    </div>

    <div class="mt-8 flex justify-start">
        <a href="{{ route('admin.orders.index') }}"
            class="px-5 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">العودة إلى القائمة</a>
    </div>

</div>
@endsection