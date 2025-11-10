@extends($layout)

@section('content')
<div class="py-12" style="margin-top: 30px;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="font-bold text-2xl mb-6 text-center text-gray-800">
                    {{ $trip->title_ar }}
                </h2>
                <p class="text-center text-gray-600 mb-6">تفاصيل الرحلة الكاملة</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-right">
                    {{-- قسم التفاصيل الأساسية --}}
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                        <h3 class="font-semibold text-lg mb-2 text-gray-700 border-b pb-2">تفاصيل الرحلة</h3>
                        <p class="mb-1"><strong>عنوان الرحلة:</strong> {{ $trip->title_ar }}</p>
                        <img src="{{ asset('images/trips/' . $trip->image) }}" alt="">
                        <p class="mb-1"><strong>تاريخ المغادرة:</strong> {{ $trip->departure_date->format('Y-m-d') }}
                        </p>
                        <p class="mb-1"><strong>تاريخ العودة:</strong> {{ $trip->return_date->format('Y-m-d') }}</p>
                        <p class="mb-1"><strong>نوع الرحلة:</strong>
                            @php
                            $trip_type_map = [
                            'group' => 'رحلة جماعية',
                            'traders_only' => 'للتجار فقط',
                            'trade_and_tourism' => 'للتجارة والسياحة',
                            'tourism_only' => 'للسياحة فقط',
                            'family' => 'عائلية',
                            ];
                            @endphp
                            {{ $trip_type_map[$trip->trip_type] ?? $trip->trip_type }}
                        </p>
                        <?php
                            if ($trip->room_type == 'shared') {
                                $room_type = 'مشتركة';
                            } elseif ($trip->room_type == 'private') {
                                $room_type = 'خاصة';
                            } elseif ($trip->room_type == 'by_choice') {
                                $room_type = 'حسب الاختيار';
                            }
                            ?>
                        <p class="mb-1"><strong>نوع الغرفة:</strong> {{ $room_type }}</p>
                        <?php
                            if ($trip->transportation_type == 'shared_bus') {
                                $transportation_type = 'حافلة خاصة مشتركة';
                            } elseif ($trip->transportation_type == 'private_car') {
                                $transportation_type = 'سيارة خاصة';
                            } elseif ($trip->transportation_type == 'no_transportation') {
                                $transportation_type = 'بدون مواصلات';
                            } elseif ($trip->transportation_type == 'airport_only') {
                                $transportation_type = 'من وإلي المطار فقط';
                            }
                            ?>
                        <p class="mb-1"><strong>نوع المركبة:</strong> {{ $transportation_type }}</p>
                    </div>

                    {{-- قسم الترجمات --}}
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                        <h3 class="font-semibold text-lg mb-2 text-gray-700 border-b pb-2">الترجمات</h3>
                        <p class="mb-1"><strong>العنوان بالعربية:</strong> {{ $trip->title_ar }}</p>
                        <p class="mb-1"><strong>العنوان بالإنجليزية:</strong> {{ $trip->title_en }}</p>
                        <p class="mb-1"><strong>العنوان بالصينية:</strong> {{ $trip->title_ch }}</p>
                        <p class="mb-1"><strong>الفندق بالعربية:</strong> {{ $trip->hotel_ar }}</p>
                        <p class="mb-1"><strong>الفندق بالإنجليزية:</strong> {{ $trip->hotel_en }}</p>
                        <p class="mb-1"><strong>الفندق بالصينية:</strong> {{ $trip->hotel_ch }}</p>
                    </div>

                    {{-- قسم الخدمات والمميزات --}}
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                        <h3 class="font-semibold text-lg mb-2 text-gray-700 border-b pb-2">الخدمات والمرافق</h3>
                        <p class="mb-1"><strong>اسم الفندق:</strong> {{ $trip->hotel_ar }}</p>
                        <?php
                            if ($trip->translators == 'group_translator') {
                                $translators = 'للمجموعة';
                            } elseif ($trip->translators == 'private_translator') {
                                $translators = 'خاص لكل شخص';
                            } elseif ($trip->translators == 'none') {
                                $translators = 'لا يوجد';
                            }
                            ?>
                        <p class="mb-1"><strong>مترجمون:</strong> {{ $translators }}</p>
                        <p class="mb-1">
                            <strong>وجبات الطعام:</strong>
                            @if (!empty($trip->meals))
                            @php
                            $mealsTranslations = [
                            'breakfast' => 'فطار',
                            'lunch' => 'غداء',
                            'dinner' => 'عشاء',
                            ];
                            $translatedMeals = [];
                            // Loop through each meal in the array and get its Arabic translation
                            foreach ($trip->meals as $meal) {
                            if (isset($mealsTranslations[$meal])) {
                            $translatedMeals[] = $mealsTranslations[$meal];
                            }
                            }
                            @endphp
                            {{ implode(', ', $translatedMeals) }}
                            @else
                            غير متوفر
                            @endif
                        </p>
                        <p class="mb-1"><strong>استقبال من المطار:</strong>
                            {{ $trip->airport_pickup ? 'نعم' : 'لا' }}</p>
                        <p class="mb-1"><strong>مرافق مشرف:</strong> {{ $trip->supervisor ? 'نعم' : 'لا' }}</p>
                        <p class="mb-1"><strong>زيارة مصانع:</strong> {{ $trip->factory_visit ? 'نعم' : 'لا' }}</p>
                        <p class="mb-1"><strong>زيارة مواقع سياحية:</strong>
                            {{ $trip->tourist_sites_visit ? 'نعم' : 'لا' }}</p>
                        <p class="mb-1"><strong>زيارة أسواق:</strong> {{ $trip->markets_visit ? 'نعم' : 'لا' }}</p>
                        <p class="mb-1"><strong>التذاكر مشمولة:</strong> {{ $trip->tickets_included ? 'نعم' : 'لا' }}
                        </p>
                        <p class="mb-1"><strong>قابلة للدفع:</strong> {{ $trip->is_paid == 'yes' ? 'نعم' : 'لا' }}
                        </p>
                    </div>

                    {{-- قسم التفاصيل المالية --}}
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                        <h3 class="font-semibold text-lg mb-2 text-gray-700 border-b pb-2">التفاصيل المالية</h3>
                        <p class="mb-1"><strong>سعر الرحلة:</strong> {{ $trip->price }}</p>
                        <p class="mb-1"><strong>سعر الغرفة المشتركة:</strong>
                            {{ $trip->shared_room_price ?? 'غير محدد' }}</p>
                        <p class="mb-1"><strong>سعر الغرفة الخاصة:</strong>
                            {{ $trip->private_room_price ?? 'غير محدد' }}</p>
                        <p class="mb-1"><strong>الحالة:</strong> {{ $trip->status == 'active' ? 'نشط' : 'غير نشط' }}
                        </p>
                        <p class="mb-1"><strong>عدد المشتركين:</strong> {{ $trip->number_of_participants ?? '0' }}
                        </p>
                        <p class="mb-1"><strong>بانتظار الدفع:</strong> {{ $trip->pending_payments ?? '0' }}</p>
                        <p class="mb-1"><strong>قابلة للدفع:</strong> {{ $trip->is_paid == 'yes' ? 'نعم' : 'لا' }}</p>
                    </div>
                </div>

                {{-- قسم مميزات الرحلة --}}
                @if ($trip->trip_features)
                <div class="mt-8 bg-gray-100 p-4 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-lg mb-4 text-right text-gray-700 border-b pb-2">مميزات الرحلة</h3>
                    <ul class="list-disc list-inside text-right text-gray-600">
                        @php
                        $features = $trip->trip_features;
                        // التحقق مما إذا كانت البيانات سلسلة نصية (بسبب البيانات القديمة)
                        if (is_string($features)) {
                        $features = json_decode($features, true);
                        }
                        @endphp

                        @forelse ($features as $feature_id)
                        @php
                        // التأكد من أن القيمة رقم قبل البحث عنها
                        if (is_numeric($feature_id)) {
                        $feature = \App\Models\TripFeatures::find($feature_id);
                        } else {
                        $feature = null;
                        }
                        @endphp
                        @if ($feature)
                        <li>{{ $feature->name_ar }}</li>
                        @endif
                        @empty
                        <li>لا توجد مميزات مُضافة.</li>
                        @endforelse
                    </ul>
                </div>
                @endif

                {{-- قسم إرشادات الرحلة --}}
                @if($trip->trip_guidelines)
                <div class="mt-6 bg-gray-100 p-4 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-lg mb-4 text-right text-gray-700 border-b pb-2">إرشادات الرحلة</h3>
                    <ul class="list-disc list-inside text-right text-gray-600">
                        @php
                        $guidelines = $trip->trip_guidelines;
                        // التحقق مما إذا كانت البيانات سلسلة نصية
                        if (is_string($guidelines)) {
                        $guidelines = json_decode($guidelines, true);
                        }
                        @endphp

                        @forelse ($guidelines as $guideline_id)
                        @php
                        // التأكد من أن القيمة رقم قبل البحث عنها
                        if (is_numeric($guideline_id)) {
                        $guideline = \App\Models\TripGuideline::find($guideline_id);
                        } else {
                        $guideline = null;
                        }
                        @endphp
                        @if ($guideline)
                        <li>{{ $guideline->name_ar }}</li>
                        @endif
                        @empty
                        <li>لا توجد إرشادات مُضافة.</li>
                        @endforelse
                    </ul>
                </div>
                @endif

                {{-- قسم المشتركين في الرحلة --}}
                @if($participants->count() > 0)
                <div class="mt-8 bg-gray-100 p-4 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-lg mb-4 text-right text-gray-700 border-b pb-2">المشتركين في الرحلة
                    </h3>

                    <table class="min-w-full border border-gray-300 text-right">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-2 px-3 border-b">#</th>
                                <th class="py-2 px-3 border-b">الاسم</th>
                                <th class="py-2 px-3 border-b">البريد الإلكتروني</th>
                                <th class="py-2 px-3 border-b">رقم الهاتف</th>
                                <th class="py-2 px-3 border-b">نوع الغرفة</th>
                                <th class="py-2 px-3 border-b">المبلغ</th>
                                <th class="py-2 px-3 border-b">الحالة</th>
                                <th class="py-2 px-3 border-b">تاريخ الدفع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($participants as $index => $registration)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-3 border-b">{{ $index + 1 }}</td>
                                <td class="py-2 px-3 border-b">{{ $registration->user->name ?? 'غير معروف' }}</td>
                                <td class="py-2 px-3 border-b">{{ $registration->user->email ?? '-' }}</td>
                                <td class="py-2 px-3 border-b">{{ $registration->user->phone ?? '-' }}</td>
                                <td class="py-2 px-3 border-b">
                                    @if($registration->room_type == 'shared')
                                    مشتركة
                                    @elseif($registration->room_type == 'private')
                                    خاصة
                                    @else
                                    غير محدد
                                    @endif
                                </td>
                                <td class="py-2 px-3 border-b flex">{{ $registration->amount }} <svg
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path d="M8 7V17H12C14.8 17 17 14.8 17 12C17 9.2 14.8 7 12 7H8Z" stroke="#000"
                                            stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M6.5 11H18.5" stroke="#000" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M6.5 13H12.5H18.5" stroke="#000" stroke-width="1.5"
                                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg></td>
                                <td class="py-2 px-3 border-b">
                                    @if($registration->status == 'paid')
                                    <span class="text-green-600 font-semibold">مدفوع</span>
                                    @elseif($registration->status == 'pending')
                                    <span class="text-yellow-600 font-semibold">بانتظار الدفع</span>
                                    @else
                                    <span class="text-red-600 font-semibold">فشل</span>
                                    @endif
                                </td>
                                <td>{{ $registration->created_at->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="mt-8 bg-gray-100 p-4 rounded-lg shadow-sm">
                    <h3 class="font-semibold text-lg mb-4 text-right text-gray-700 border-b pb-2">المشتركين في الرحلة
                    </h3>
                    <p class="text-gray-600 text-right">لا يوجد مشتركين بعد.</p>
                </div>
                @endif
                <div class="mt-8 flex justify-end">
                    <a href="{{ url()->previous() }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                        العودة
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection