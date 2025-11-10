@extends($layout)

@section('content')
<div class="py-4" style="margin-top: 30px;">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-right mb-4 font-bold text-xl">تعديل رحلة: {{ $trip->title_ar }}</h2>
                <form action="{{ route('admin.omdaHome.trip.update', $trip->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <img src="{{ asset('images/trips/' . $trip->image) }}" alt="">
                        {{-- <input type="hidden" name="old_image" value="{{ $trip->image }}"> --}}
                        <div class="mb-4 text-right">
                            <label for="image" class="block text-gray-700 font-bold mb-2">البانر *</label>
                            <input type="file" name="image" id="image" value="{{ old('image', $trip->image) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                            @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="title_ar" class="block text-gray-700 font-bold mb-2">العنوان بالعربي *</label>
                            <input type="text" name="title_ar" id="title_ar"
                                value="{{ old('title_ar', $trip->title_ar) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                            @error('title_ar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="title_en" class="block text-gray-700 font-bold mb-2">العنوان بالإنجليزي
                                *</label>
                            <input type="text" name="title_en" id="title_en"
                                value="{{ old('title_en', $trip->title_en) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('title_en')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="title_ch" class="block text-gray-700 font-bold mb-2">العنوان بالصيني *</label>
                            <input type="text" name="title_ch" id="title_ch"
                                value="{{ old('title_ch', $trip->title_ch) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('title_ch')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4 text-right">
                            <label for="departure_date" class="block text-gray-700 font-bold mb-2">تاريخ المغادرة
                                *</label>
                            <input type="date" name="departure_date" id="departure_date"
                                value="{{ old('departure_date', $trip->departure_date ? $trip->departure_date->format('Y-m-d') : '') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('departure_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="return_date" class="block text-gray-700 font-bold mb-2">تاريخ العودة *</label>
                            <input type="date" name="return_date" id="return_date"
                                value="{{ old('return_date', $trip->return_date ? $trip->return_date->format('Y-m-d') : '') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('return_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="hotel_ar" class="block text-gray-700 font-bold mb-2">فندق الإقامة بالعربي
                                *</label>
                            <input type="text" name="hotel_ar" id="hotel_ar"
                                value="{{ old('hotel_ar', $trip->hotel_ar) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                            @error('hotel_ar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="hotel_en" class="block text-gray-700 font-bold mb-2">فندق الإقامة بالإنجليزي
                                *</label>
                            <input type="text" name="hotel_en" id="hotel_en"
                                value="{{ old('hotel_en', $trip->hotel_en) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('hotel_en')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="hotel_ch" class="block text-gray-700 font-bold mb-2">فندق الإقامة بالصيني
                                *</label>
                            <input type="text" name="hotel_ch" id="hotel_ch"
                                value="{{ old('hotel_ch', $trip->hotel_ch) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('hotel_ch')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="transportation_type" class="block text-gray-700 font-bold mb-2">مركبة خاصة
                                *</label>
                            <select name="transportation_type" id="transportation_type"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                <option disabled selected>اختر المركبة</option>
                                <option value="shared_bus" {{ old('transportation_type', $trip->transportation_type) ==
                                    'shared_bus' ? 'selected' : '' }}>
                                    حافلة خاصة مشتركة</option>
                                <option value="private_car" {{ old('transportation_type', $trip->transportation_type) ==
                                    'private_car' ? 'selected' : '' }}>
                                    سيارة خاصة</option>
                                <option value="no_transportation" {{ old('transportation_type', $trip->
                                    transportation_type) == 'no_transportation' ? 'selected' : '' }}>
                                    بدون مواصلات</option>
                                <option value="airport_only" {{ old('transportation_type', $trip->transportation_type)
                                    == 'airport_only' ? 'selected' : '' }}>
                                    من وإلي المطار فقط</option>
                            </select>
                            @error('transportation_type')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="trip_type" class="block text-gray-700 font-bold mb-2">نوع الرحلة *</label>
                            <select name="trip_type" id="trip_type"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                                <option disabled selected>اختر النوع</option>
                                <option value="group" {{ old('trip_type', $trip->trip_type) == 'group' ? 'selected' : ''
                                    }}>رحلة جماعية
                                </option>
                                <option value="traders_only" {{ old('trip_type', $trip->trip_type) == 'traders_only' ?
                                    'selected' : '' }}>للتجار
                                    فقط</option>
                                <option value="trade_and_tourism" {{ old('trip_type', $trip->trip_type) ==
                                    'trade_and_tourism' ? 'selected' : '' }}>
                                    للتجارة والسياحة</option>
                                <option value="tourism_only" {{ old('trip_type', $trip->trip_type) == 'tourism_only' ?
                                    'selected' : '' }}>
                                    للسياحة فقط</option>
                                <option value="family" {{ old('trip_type', $trip->trip_type) == 'family' ? 'selected' :
                                    '' }}>عائلية
                                </option>
                            </select>
                            @error('trip_type')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="room_type" class="block text-gray-700 font-bold mb-2">نوع الغرفة *</label>
                            <select name="room_type" id="room_type"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                                <option disabled selected>اختر الغرفة</option>
                                <option value="shared" {{ old('room_type', $trip->room_type) == 'shared' ? 'selected' :
                                    '' }}>مشتركة
                                </option>
                                <option value="private" {{ old('room_type', $trip->room_type) == 'private' ? 'selected'
                                    : '' }}>خاصة
                                </option>
                                <option value="by_choice" {{ old('room_type', $trip->room_type) == 'by_choice' ?
                                    'selected' : '' }}>حسب
                                    الاختيار</option>
                            </select>
                            @error('room_type')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right" id="price_field">
                            <label for="price" class="block text-gray-700 font-bold mb-2">الرسوم</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $trip->price) }}"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                            @error('price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="room_prices_fields" class="{{ $trip->room_type !== 'by_choice' ? 'hidden' : '' }}">
                            <div class="mb-4 text-right">
                                <label for="shared_room_price" class="block text-gray-700 font-bold mb-2">سعر الغرفة
                                    المشتركة</label>
                                <input type="number" name="shared_room_price" id="shared_room_price"
                                    value="{{ old('shared_room_price', $trip->shared_room_price) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm" @if ($trip->room_type ===
                                'by_choice') required @endif>
                                @error('shared_room_price')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4 text-right">
                                <label for="private_room_price" class="block text-gray-700 font-bold mb-2">سعر الغرفة
                                    الخاصة</label>
                                <input type="number" name="private_room_price" id="private_room_price"
                                    value="{{ old('private_room_price', $trip->private_room_price) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm" @if ($trip->room_type ===
                                'by_choice') required @endif>
                                @error('private_room_price')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
    const roomType = document.getElementById('room_type');
    const priceField = document.getElementById('price_field');
    const roomPricesFields = document.getElementById('room_prices_fields');

    function toggleFields() {
        if (roomType.value === 'by_choice') {
            priceField.classList.add('hidden');       // اخفي السعر
            roomPricesFields.classList.remove('hidden'); // اظهر الحقول التانية
        } else {
            priceField.classList.remove('hidden');    // اظهر السعر
            roomPricesFields.classList.add('hidden'); // اخفي الحقول التانية
        }
    }

    roomType.addEventListener('change', toggleFields);
    toggleFields(); // استدعاء أول مرة عند تحميل الصفحة
});
                        </script>
                        <div class="mb-4 text-right">
                            <label for="translators" class="block text-gray-700 font-bold mb-2">المترجمين *</label>
                            <select name="translators" id="translators"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                                <option disabled selected>اختر</option>
                                <option value="group_translator" {{ old('translators', $trip->translators) ==
                                    'group_translator' ? 'selected' : '' }}>
                                    للمجموعة</option>
                                <option value="private_translator" {{ old('translators', $trip->translators) ==
                                    'private_translator' ? 'selected' : '' }}>
                                    خاص لكل شخص</option>
                                <option value="none" {{ old('translators', $trip->translators) == 'none' ? 'selected' :
                                    '' }}>لا يوجد
                                </option>
                            </select>
                            @error('translators')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-3">
                            <label class="block text-gray-700 font-bold mb-2">وجبات الطعام *</label>
                            @php
                            $selectedMeals = old('meals', $trip->meals ?? []);
                            @endphp
                            <div class="flex items-center">
                                <input name="meals[]" type="checkbox" value="breakfast" @if (is_array($selectedMeals) &&
                                    in_array('breakfast', $selectedMeals)) checked @endif
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                <label class="ms-2 text-sm font-medium text-gray-900">إفطار</label>
                            </div>
                            <div class="flex items-center">
                                <input name="meals[]" type="checkbox" value="lunch" @if (is_array($selectedMeals) &&
                                    in_array('lunch', $selectedMeals)) checked @endif
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                <label class="ms-2 text-sm font-medium text-gray-900">غداء</label>
                            </div>
                            <div class="flex items-center">
                                <input name="meals[]" type="checkbox" value="dinner" @if (is_array($selectedMeals) &&
                                    in_array('dinner', $selectedMeals)) checked @endif
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                                <label class="ms-2 text-sm font-medium text-gray-900">عشاء</label>
                            </div>
                        </div>

                        <div class="mb-4 text-right">
                            <label for="airport_pickup" class="block text-gray-700 font-bold mb-2">استقبال بالمطار
                                *</label>
                            <select name="airport_pickup" id="airport_pickup"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                                <option disabled selected>اختر</option>
                                <option value="1" {{ old('airport_pickup', $trip->airport_pickup) == 1 ? 'selected' : ''
                                    }}>نعم
                                </option>
                                <option value="0" {{ old('airport_pickup', $trip->airport_pickup) == 0 ? 'selected' : ''
                                    }}>لا
                                </option>
                            </select>
                            @error('airport_pickup')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="supervisor" class="block text-gray-700 font-bold mb-2">مشرف من عمدة الصين
                                *</label>
                            <select name="supervisor" id="supervisor"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                                <option disabled selected>اختر</option>
                                <option value="1" {{ old('supervisor', $trip->supervisor) == 1 ? 'selected' : '' }}>نعم
                                </option>
                                <option value="0" {{ old('supervisor', $trip->supervisor) == 0 ? 'selected' : '' }}>لا
                                </option>
                            </select>
                            @error('supervisor')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="factory_visit" class="block text-gray-700 font-bold mb-2">زيارة المصانع
                                *</label>
                            <select name="factory_visit" id="factory_visit"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                                <option disabled selected>اختر</option>
                                <option value="1" {{ old('factory_visit', $trip->factory_visit) == 1 ? 'selected' : ''
                                    }}>نعم
                                </option>
                                <option value="0" {{ old('factory_visit', $trip->factory_visit) == 0 ? 'selected' : ''
                                    }}>لا</option>
                            </select>
                            @error('factory_visit')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="tourist_sites_visit" class="block text-gray-700 font-bold mb-2">زيارة الأماكن
                                السياحية *</label>
                            <select name="tourist_sites_visit" id="tourist_sites_visit"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                                <option disabled selected>اختر</option>
                                <option value="1" {{ old('tourist_sites_visit', $trip->tourist_sites_visit) == 1 ?
                                    'selected' : '' }}>
                                    نعم</option>
                                <option value="0" {{ old('tourist_sites_visit', $trip->tourist_sites_visit) == 0 ?
                                    'selected' : '' }}>
                                    لا</option>
                            </select>
                            @error('tourist_sites_visit')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="markets_visit" class="block text-gray-700 font-bold mb-2">زيارة الأسواق
                                *</label>
                            <select name="markets_visit" id="markets_visit"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                                <option disabled selected>اختر</option>
                                <option value="1" {{ old('markets_visit', $trip->markets_visit) == 1 ? 'selected' : ''
                                    }}>نعم
                                </option>
                                <option value="0" {{ old('markets_visit', $trip->markets_visit) == 0 ? 'selected' : ''
                                    }}>لا</option>
                            </select>
                            @error('markets_visit')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="tickets_included" class="block text-gray-700 font-bold mb-2">الرسوم تشمل تذاكر
                                السفر *</label>
                            <select name="tickets_included" id="tickets_included"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                                <option disabled selected>اختر</option>
                                <option value="1" {{ old('tickets_included', $trip->tickets_included) == 1 ? 'selected'
                                    : '' }}>نعم
                                </option>
                                <option value="0" {{ old('tickets_included', $trip->tickets_included) == 0 ? 'selected'
                                    : '' }}>لا
                                </option>
                            </select>
                            @error('tickets_included')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="trip_features" class="block text-gray-700 font-bold mb-2">مميزات الرحلة
                                *</label>
                            <select name="trip_features[]" id="trip_features" multiple
                                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                @foreach ($availableFeatures as $feature)
                                <option style="color: black;" value="{{ $feature->id }}" @if (in_array($feature->id,
                                    is_array($trip->trip_features) ? $trip->trip_features :
                                    (is_string($trip->trip_features) ? json_decode($trip->trip_features, true) ?? [] :
                                    []))) selected @endif>
                                    {{ $feature->name_ar }}
                                </option>
                                @endforeach
                            </select>
                            @error('trip_features')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="trip_guidelines" class="block text-gray-700 font-bold mb-2">إرشادات الرحلة
                                *</label>
                            <select name="trip_guidelines[]" id="trip_guidelines" multiple
                                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                @foreach ($availableGuidelines as $guideline)
                                <option value="{{ $guideline->id }}" @if (in_array($guideline->id,
                                    is_array($trip->trip_guidelines) ? $trip->trip_guidelines :
                                    (is_string($trip->trip_guidelines) ? json_decode($trip->trip_guidelines, true) ?? []
                                    : []))) selected @endif>
                                    {{ $guideline->name_ar }}
                                </option>
                                @endforeach
                            </select>
                            @error('trip_guidelines')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="status" class="block text-gray-700 font-bold mb-2">الحالة *</label>
                            <select name="status" id="status"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                <option value="active" {{ old('status', $trip->status) == 'active' ? 'selected' : ''
                                    }}>نشط</option>
                                <option value="inactive" {{ old('status', $trip->status) == 'inactive' ? 'selected' : ''
                                    }}>غير نشط</option>
                            </select>
                            @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 text-right">
                            <label for="is_paid" class="block text-gray-700 font-bold mb-2">قابلة للدفع *</label>
                            <select name="is_paid" id="is_paid"
                                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                                <option value="yes" {{ 'yes' ? 'selected' : '' }}>نعم</option>
                                <option value="no" {{ 'no' ? 'selected' : '' }}>لا</option>
                            </select>
                            @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">تحديث</button>
                        <a href="{{ route('admin.omdaHome.trip.index') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
            $('#trip_features').select2({
                placeholder: "اختر مميزات الرحلة",
                allowClear: true,
                dir: "rtl",
                width: '100%',
                language: {
                    noResults: function() {
                        return "لا توجد نتائج";
                    },
                    searching: function() {
                        return "جاري البحث...";
                    },
                    removeAllItems: function() {
                        return "إزالة جميع العناصر";
                    }
                }
            });

            $('#trip_guidelines').select2({
                placeholder: "اختر إرشادات الرحلة",
                allowClear: true,
                dir: "rtl",
                width: '100%',
                language: {
                    noResults: function() {
                        return "لا توجد نتائج";
                    },
                    searching: function() {
                        return "جاري البحث...";
                    },
                    removeAllItems: function() {
                        return "إزالة جميع العناصر";
                    }
                }
            });

            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            function translateText(inputField, sourceLang, targetLangs, targetFields) {
                const text = inputField.val().trim();
                if (!text) {
                    targetFields.forEach(field => field.val(''));
                    return;
                }

                $.ajax({
                    url: '{{ route('translate') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        text: text,
                        source_lang: sourceLang,
                        target_langs: targetLangs
                    },
                    success: function(response) {
                        targetFields[0].val(response[targetLangs[0]] || '');
                        targetFields[1].val(response[targetLangs[1]] || '');
                    },
                    error: function(xhr) {
                        console.error('Translation failed:', xhr.responseJSON?.error);
                        alert('فشل في الترجمة، حاول مرة أخرى لاحقًا.');
                    }
                });
            }
            const debouncedTranslate = debounce(translateText, 500);
            $('#title_ar').on('input', function() {
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#title_en'), $('#title_ch')]);
            });
            $('#title_en').on('input', function() {
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#title_ar'), $('#title_ch')]);
            });
            $('#title_ch').on('input', function() {
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#title_ar'), $('#title_en')]);
            });
            $('#hotel_ar').on('input', function() {
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#hotel_en'), $('#hotel_ch')]);
            });
            $('#hotel_en').on('input', function() {
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#hotel_ar'), $('#hotel_ch')]);
            });
            $('#hotel_ch').on('input', function() {
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#hotel_ar'), $('#hotel_en')]);
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const roomTypeSelect = document.getElementById('room_type');
            const roomPricesFields = document.getElementById('room_prices_fields');
            const sharedRoomPriceInput = document.getElementById('shared_room_price');
            const privateRoomPriceInput = document.getElementById('private_room_price');

            function toggleRoomPricesFields() {
                if (roomTypeSelect.value === 'by_choice') {
                    roomPricesFields.classList.remove('hidden');
                    sharedRoomPriceInput.setAttribute('required', 'required');
                    privateRoomPriceInput.setAttribute('required', 'required');
                } else {
                    roomPricesFields.classList.add('hidden');
                    sharedRoomPriceInput.removeAttribute('required');
                    privateRoomPriceInput.removeAttribute('required');
                }
            }
            roomTypeSelect.addEventListener('change', toggleRoomPricesFields);
            toggleRoomPricesFields();
        });
</script>
<style>
    .select2-container--default .select2-search--inline .select2-search__field,
    .select2-container--default .select2-selection--multiple {
        height: 42px !important;

    }

    .select2-container--default .select2-search--inline .select2-search__field {
        margin-top: 7px;

    }

    .select2-container .select2-selection--multiple {
        direction: rtl;
        text-align: right;
    }

    .select2-container--default .select2-search--inline .select2-search__field {
        font-family: "Cairo";
        color: black;
    }

    .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove {
        border-left: unset !important;
        position: relative;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #3b82f6;
        border: 1px solid #3b82f6;
        color: white;
        padding: 2px 8px;
        margin: 2px;
        border-radius: 4px;
        float: right;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-left: 5px;
        margin-right: 0;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #fee2e2;
    }

    .select2-dropdown {
        direction: rtl;
    }

    .select2-search--dropdown .select2-search__field {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection