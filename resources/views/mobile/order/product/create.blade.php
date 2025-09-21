@extends('layouts.mobile')

@section('title', 'طلب منتج جديد | New Product Order')

<link rel="stylesheet" href="{{ asset('assets/assets/css/add-place.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/create-trip-form.css') }}">

@section('content')

<div class="container dark:text-white dark:bg-color1 pt-0 mt-0">
    <x-china-header :title="'طلب منتج جديد'" :route="route('mobile.order')" />
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    <div class="relative z-30 px-6">
        <div id="tripForm" class="p-6 rounded-xl bg-white dark:bg-color9 mt-12 border border-color21">
            <form action="{{ route('show.product.form') }}" method="POST">
                @csrf
                <div>
                    <p class="text-sm font-semibold pb-2">رقم المرجع</p>
                    <div
                        class="flex justify-between items-center border border-color21 rounded-xl dark:border-color18 gap-3 bg-gray-100 dark:bg-gray-700">
                        <input type="text" class="modal-input text-gray-600 dark:text-gray-300 font-mono"
                            id="ref-number-input" name="reference_number" value="" readonly />
                    </div>
                </div>
                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">عدد المنتجات</p>
                    <input type="number" id="num-products-input" value="1" placeholder="ادخل عدد المنتجات"
                        name="number_of_products" min="1" max="5" style="border: 2px solid #e0e0e0;"
                        class="modal-input !border" required>
                    <span style="font-size: 11px; color: gray;">اقل عدد للمنتجات 1 واقصي
                        عدد 5</span>
                </div>
                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">ماذا تفعل إذا كان السعر الإجمالي للعنصر أعلى من المتوقع؟</p>
                    <div class="flex flex-col gap-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="price_unexpected" value="call_me" class="form-radio" required>
                            <span class="ml-2 text-sm">اتصل بي إذا كان السعر أعلى</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="price_unexpected" value="buy_anyway" class="form-radio" required>
                            <span class="ml-2 text-sm">شراء بغض النظر عن السعر</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="price_unexpected" value="buy_within_10_percent" class="form-radio"
                                required>
                            <span class="ml-2 text-sm">الشراء في غضون 10٪ من السعر المتوقع</span>
                        </label>
                    </div>
                </div>
                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">ماذا تفعل إذا كان أي من العناصر غير متوفر؟</p>
                    <div class="flex flex-col gap-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="item_unavailable" value="contact_me" class="form-radio" required>
                            <span class="ml-2 text-sm">تواصل معي</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="item_unavailable" value="cancel_and_buy_available"
                                class="form-radio" required>
                            <span class="ml-2 text-sm">إلغاء المنتج الغير متوفر وأشتري المنتجات المتوفرة فقط</span>
                        </label>
                    </div>
                </div>
                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">
                        ماذا تفعل إذا لم يقبل البائع الإرجاع / الاسترداد حتى لو كان
                        المنتج
                        معيبًا؟
                    </p>
                    <div class="flex flex-col gap-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="no_returns" value="no_problem_buy" class="form-radio" required>
                            <span class="ml-2 text-sm">لا توجد مشكلة اشتري المنتج</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="no_returns" value="contact_me" class="form-radio" required>
                            <span class="ml-2 text-sm">تواصل معي</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="no_returns" value="cancel_product" class="form-radio" required>
                            <span class="ml-2 text-sm">الغي المنتج</span>
                        </label>
                    </div>
                </div>
                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">
                        ماذا تفعل إذا كانت السلعة تستغرق من أسبوع إلى أسبوعين ليتم شحنها من البائع؟
                    </p>
                    <div class="flex flex-col gap-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="no_problem" value="no_problem_wait" class="form-radio" required>
                            <span class="ml-2 text-sm">ليس لدي مانع من الانتظار</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="no_problem" value="cancel_product" class="form-radio" required>
                            <span class="ml-2 text-sm">قم بإلغائها</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="no_problem" value="change_product" class="form-radio" required>
                            <span class="ml-2 text-sm">غيرها لمنتج آخر</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="no_problem" value="contact_another_seller" class="form-radio"
                                required>
                            <span class="ml-2 text-sm">تواصل مع تاجر آخر تتوفر لديه نفس المنتجات</span>
                        </label>
                    </div>
                </div>
                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">
                        ماذا تفعل إذا كان الطلب يحتوي على عناصر تحمل علامات تجارية ولا يمكن شحنها إلا مع شركات صريحة
                        معينة؟
                    </p>
                    <div class="flex flex-col gap-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="same_company" value="no_problem_change" class="form-radio"
                                required>
                            <span class="ml-2 text-sm">ليس لدي مانع لتبديل شركة الشحن</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="same_company" value="cancel_product" class="form-radio" required>
                            <span class="ml-2 text-sm">إلغاء المنتجات التي تحتوي أسماء العلامات التجارية</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="same_company" value="change_product" class="form-radio" required>
                            <span class="ml-2 text-sm">
                                استبدال المنتجات التي تحمل أسماء العلامات التجارية بمنتجات أخرى
                                مشابهة
                            </span>
                        </label>
                    </div>
                </div>
                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">
                        ماذا تفعل اذا كان الطلب يحتوي على عناصر او منتجات تحتوي على بطاريات تعرقل الشحن؟
                    </p>
                    <div class="flex flex-col gap-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="batteries" value="remove_battery" class="form-radio" required>
                            <span class="ml-2 text-sm">ازالة البطارية من المنتج وشحن المنتج بدون بطارية</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="batteries" value="cancel_product" class="form-radio" required>
                            <span class="ml-2 text-sm">إلغاء المنتج</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="batteries" value="change_product" class="form-radio" required>
                            <span class="ml-2 text-sm">تغيير المنتج بمنتج آخر
                            </span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="batteries" value="contact_another_seller" class="form-radio"
                                required>
                            <span class="ml-2 text-sm">المحاولة مع شركات شحن أخرى وحتى لو كانت تطلب مبالغ عالية</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="batteries" value="contact_me" class="form-radio" required>
                            <span class="ml-2 text-sm">تواصل معي
                            </span>
                        </label>
                    </div>
                </div>
                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">
                        معاينة المنتجات بمكتب الصين قبل الإرسال وجهات الاستلام؟ </p>
                    <div class="flex flex-col gap-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="see_product" value="yes" class="form-radio" required>
                            <span class="ml-2 text-sm">نعم أوافق على فتح المنتجات ومعاينتها واعتمادها قبل الإرسال</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="see_product" value="no" class="form-radio" required>
                            <span class="ml-2 text-sm">لا أوافق ارسال المنتج من المصنع أو التاجر مباشرة</span>
                        </label>
                    </div>
                </div>
                <div class="pt-4">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <button type="submit" class="confirm-button">إرسال الطلب </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
            const refNumberInput = document.getElementById('ref-number-input');
            if (refNumberInput) {
                refNumberInput.value = `REF${Date.now()}`;
            }
            
            const numProductsInput = document.getElementById('num-products-input');
            if (numProductsInput) {
                numProductsInput.addEventListener('input', function () {
                    let value = parseInt(this.value, 10);
                    if (value > 5) {
                        this.value = 5;
                    }
                });
            }
        });
</script>
@endsection