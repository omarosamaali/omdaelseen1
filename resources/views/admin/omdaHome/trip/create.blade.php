@extends($layout)

@section('content')
    <div class="py-4" style="margin-top: 30px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-right mb-4 font-bold text-xl">إضافة رحلة</h2>
<form action="{{ route('admin.places.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-4 text-right">
            <label for="title_ar" class="block text-gray-700 font-bold mb-2">العنوان بالعربي *</label>
            <input type="text" name="title_ar" id="title_ar" value="{{ old('title_ar') }}"
                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
            @error('title_ar')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="title_en" class="block text-gray-700 font-bold mb-2">العنوان بالإنجليزي *</label>
            <input type="text" name="title_en" id="title_en" value="{{ old('title_en') }}"
                class="w-full border-gray-300 rounded-md shadow-sm" required>
            @error('title_en')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="title_ch" class="block text-gray-700 font-bold mb-2">العنوان بالصيني *</label>
            <input type="text" name="title_ch" id="title_ch" value="{{ old('title_ch') }}"
                class="w-full border-gray-300 rounded-md shadow-sm" required>
            @error('title_ch')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="departure_date" class="block text-gray-700 font-bold mb-2">تاريخ المغادرة *</label>
            <input type="date" name="departure_date" id="departure_date" value="{{ old('departure_date') }}"
                class="w-full border-gray-300 rounded-md shadow-sm" required>
            @error('departure_date')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="return_date" class="block text-gray-700 font-bold mb-2">تاريخ العودة *</label>
            <input type="date" name="return_date" id="return_date" value="{{ old('return_date') }}"
                class="w-full border-gray-300 rounded-md shadow-sm" required>
            @error('return_date')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="hotel_ar" class="block text-gray-700 font-bold mb-2">فندق الإقامة بالعربي *</label>
            <input type="text" name="hotel_ar" id="hotel_ar" value="{{ old('hotel_ar') }}"
                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
            @error('hotel_ar')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="hotel_en" class="block text-gray-700 font-bold mb-2">فندق الإقامة بالإنجليزي *</label>
            <input type="text" name="hotel_en" id="hotel_en" value="{{ old('hotel_en') }}"
                class="w-full border-gray-300 rounded-md shadow-sm" required>
            @error('hotel_en')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="hotel_ch" class="block text-gray-700 font-bold mb-2">فندق الإقامة بالصيني *</label>
            <input type="text" name="hotel_ch" id="hotel_ch" value="{{ old('hotel_ch') }}"
                class="w-full border-gray-300 rounded-md shadow-sm" required>
            @error('hotel_ch')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="transportation_type" class="block text-gray-700 font-bold mb-2">مركبة خاصة *</label>
            <select name="transportation_type" id="transportation_type"
                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                <option disabled selected>اختر المركبة</option>
                <option value="shared_bus">حافلة خاصة مشتركة</option>
                <option value="private_car">سيارة خاصة</option>
                <option value="no_transportation">بدون مواصلات</option>
                <option value="airport_only">من وإلي المطار فقط</option>
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
                <option value="group">رحلة جماعية</option>
                <option value="traders_only">للتجار فقط</option>
                <option value="trade_and_tourism">للتجارة والسياحة</option>
                <option value="tourism_only">للسياحة فقط</option>
                <option value="family">عائلية</option>
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
        <option value="shared">مشتركة</option>
        <option value="private">خاصة</option>
        <option value="by_choice">حسب الاختيار</option>
    </select>
    @error('room_type')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

<div id="room_prices_fields" class="hidden">
    <div class="mb-4 text-right">
        <label for="shared_room_price" class="block text-gray-700 font-bold mb-2">سعر الغرفة المشتركة</label>
        <input type="number" name="shared_room_price" id="shared_room_price" value="{{ old('shared_room_price') }}"
            class="w-full border-gray-300 rounded-md shadow-sm">
        @error('shared_room_price')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4 text-right">
        <label for="private_room_price" class="block text-gray-700 font-bold mb-2">سعر الغرفة الخاصة</label>
        <input type="number" name="private_room_price" id="private_room_price" value="{{ old('private_room_price') }}"
            class="w-full border-gray-300 rounded-md shadow-sm">
        @error('private_room_price')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
</div>

        <div class="mb-4 text-right">
            <label for="translators" class="block text-gray-700 font-bold mb-2">المترجمين *</label>
            <select name="translators" id="translators"
                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                <option disabled selected>اختر</option>
                <option value="group_translator">للمجموعة</option>
                <option value="private_translator">خاص لكل شخص</option>
                <option value="none">لا يوجد</option>
            </select>
            @error('translators')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex gap-3">
            <label class="block text-gray-700 font-bold mb-2">وجبات الطعام *</label>
            <div class="flex items-center">
                <input name="meals[]" type="checkbox" value="breakfast"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                <label class="ms-2 text-sm font-medium text-gray-900">فطار</label>
            </div>
            <div class="flex items-center">
                <input name="meals[]" type="checkbox" value="lunch"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                <label class="ms-2 text-sm font-medium text-gray-900">غداء</label>
            </div>
            <div class="flex items-center">
                <input name="meals[]" type="checkbox" value="dinner"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                <label class="ms-2 text-sm font-medium text-gray-900">عشاء</label>
            </div>
        </div>

        <div class="mb-4 text-right">
            <label for="airport_pickup" class="block text-gray-700 font-bold mb-2">استقبال بالمطار *</label>
            <select name="airport_pickup" id="airport_pickup"
                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                <option disabled selected>اختر</option>
                <option value="1">نعم</option>
                <option value="0">لا</option>
            </select>
            @error('airport_pickup')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="supervisor" class="block text-gray-700 font-bold mb-2">مشرف من عمدة الصين *</label>
            <select name="supervisor" id="supervisor"
                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                <option disabled selected>اختر</option>
                <option value="1">نعم</option>
                <option value="0">لا</option>
            </select>
            @error('supervisor')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="factory_visit" class="block text-gray-700 font-bold mb-2">زيارة المصانع *</label>
            <select name="factory_visit" id="factory_visit"
                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                <option disabled selected>اختر</option>
                <option value="1">نعم</option>
                <option value="0">لا</option>
            </select>
            @error('factory_visit')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="tourist_sites_visit" class="block text-gray-700 font-bold mb-2">زيارة الأماكن السياحية *</label>
            <select name="tourist_sites_visit" id="tourist_sites_visit"
                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                <option disabled selected>اختر</option>
                <option value="1">نعم</option>
                <option value="0">لا</option>
            </select>
            @error('tourist_sites_visit')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="markets_visit" class="block text-gray-700 font-bold mb-2">زيارة الأسواق *</label>
            <select name="markets_visit" id="markets_visit"
                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                <option disabled selected>اختر</option>
                <option value="1">نعم</option>
                <option value="0">لا</option>
            </select>
            @error('markets_visit')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="tickets_included" class="block text-gray-700 font-bold mb-2">الرسوم تشمل تذاكر السفر *</label>
            <select name="tickets_included" id="tickets_included"
                class="w-full border-gray-300 rounded-md shadow-sm text-right">
                <option disabled selected>اختر</option>
                <option value="1">نعم</option>
                <option value="0">لا</option>
            </select>
            @error('tickets_included')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="price" class="block text-gray-700 font-bold mb-2">الرسوم *</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}"
                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
            @error('price')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4 text-right">
            <label for="trip_features" class="block text-gray-700 font-bold mb-2">مميزات الرحلة *</label>
            <textarea name="trip_features" id="trip_features" rows="4" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ old('trip_features') }}</textarea>
            @error('trip_features')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-4 text-right">
            <label for="trip_guidelines" class="block text-gray-700 font-bold mb-2">إرشادات الرحلة *</label>
            <textarea name="trip_guidelines" id="trip_guidelines" rows="4" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ old('trip_guidelines') }}</textarea>
            @error('trip_guidelines')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 text-right">
            <label for="status" class="block text-gray-700 font-bold mb-2">الحالة *</label>
            <select name="status" id="status"
                class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                <option value="banned" {{ old('status') == 'banned' ? 'selected' : '' }}>محظور</option>
            </select>
            @error('status')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex justify-end gap-2">
        <button type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">حفظ</button>
        <a href="{{ route('admin.omdaHome.trip.index') }}"
            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">إلغاء</a>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomTypeSelect = document.getElementById('room_type');
        const roomPricesFields = document.getElementById('room_prices_fields');
        const sharedRoomPriceInput = document.getElementById('shared_room_price');
        const privateRoomPriceInput = document.getElementById('private_room_price');

        // دالة لإظهار/إخفاء الحقول وتعديل خاصية required
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

        // استمع لتغيير القيمة في قائمة "نوع الغرفة"
        roomTypeSelect.addEventListener('change', toggleRoomPricesFields);
        
        // قم بتشغيل الدالة عند تحميل الصفحة لتحديد الحالة الابتدائية
        toggleRoomPricesFields();
    });
</script>
@endsection
