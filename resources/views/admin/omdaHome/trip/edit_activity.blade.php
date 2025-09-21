@extends($layout)

@section('content')
    <div class="py-4 text-end" style="margin-top: 30px; max-width: 800px; margin-right: auto; margin-left: auto;">
        <h2 class="text-right text-2xl font-bold mb-4">تعديل فعالية للرحلة: {{ $trip->title_ar }}</h2>
        <form action="{{ route('admin.trip.activities.update', ['trip' => $trip->id, 'activity' => $activity->id]) }}"
              method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4 text-right">
                <label for="date" class="block text-gray-700 font-bold mb-2">التاريخ *</label>
                <select name="date" id="date" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                    <option disabled>اختر</option>
                    @php
                        $start = new \DateTime($trip->departure_date);
                        $end = new \DateTime($trip->return_date);
                        $interval = new \DateInterval('P1D');
                        $dates = new \DatePeriod($start, $interval, $end->modify('+1 day'));
                    @endphp
                    @foreach ($dates as $date)
                        <option value="{{ $date->format('Y-m-d') }}"
                                {{ old('date', $activity->date) == $date->format('Y-m-d') ? 'selected' : '' }}>
                            {{ $date->format('d-m-Y') }}
                        </option>
                    @endforeach
                </select>
                @error('date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 text-right">
                <label for="period" class="block text-gray-700 font-bold mb-2">الفترة *</label>
                <select name="period" id="period" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                    <option disabled>اختر</option>
                    <option value="morning" {{ old('period', $activity->period) == 'morning' ? 'selected' : '' }}>
                        الصباح
                    </option>
                    <option value="afternoon" {{ old('period', $activity->period) == 'afternoon' ? 'selected' : '' }}>
                        الظهر
                    </option>
                    <option value="evening" {{ old('period', $activity->period) == 'evening' ? 'selected' : '' }}>
                        المساء
                    </option>
                </select>
                @error('period')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 text-right">
                <label for="name_ar" class="block text-gray-700 font-bold mb-2">الفعالية بالعربي *</label>
                <input type="text" name="name_ar" id="name_ar" value="{{ old('name_ar', $activity->name_ar) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                @error('name_ar')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4 text-right">
                <label for="name_en" class="block text-gray-700 font-bold mb-2">الفعالية بالإنجليزي *</label>
                <input type="text" name="name_en" id="name_en" value="{{ old('name_en', $activity->name_en) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm" required>
                @error('name_en')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4 text-right">
                <label for="name_ch" class="block text-gray-700 font-bold mb-2">الفعالية بالصيني *</label>
                <input type="text" name="name_ch" id="name_ch" value="{{ old('name_ch', $activity->name_ch) }}"
                       class="w-full border-gray-300 rounded-md shadow-sm" required>
                @error('name_ch')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 text-right">
                <label for="is_place_related" class="block text-gray-700 font-bold mb-2">هل الفعالية مرتبطة بمكان؟ *</label>
                <select name="is_place_related" id="is_place_related"
                        class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                    <option value="0" {{ old('is_place_related', $activity->is_place_related) == 0 ? 'selected' : '' }}>
                        لا
                    </option>
                    <option value="1" {{ old('is_place_related', $activity->is_place_related) == 1 ? 'selected' : '' }}>
                        نعم
                    </option>
                </select>
                @error('is_place_related')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

    <div id="place_select" class="mb-4 text-right {{ old('is_place_related', 0) == 1 ? '' : 'hidden' }}">
        <label for="place_id" class="block text-gray-700 font-bold mb-2">اختر المكان *</label>
        <select name="place_id" id="place_id" class="w-full border-gray-300 rounded-md shadow-sm text-right">
            <option value="" disabled selected>اختر مكانًا</option>
            @foreach ($places as $place)
            <option value="{{ $place->id }}" {{ old('place_id')==$place->id ? 'selected' : '' }}>
                {{ $place->name_ar }}
            </option>
            @endforeach
        </select>
        @error('place_id')
        <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>
    
    {{-- Tom Select --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new TomSelect('#place_id', {
                maxOptions: null,
                create: false,
                sortField: { field: "text", direction: "asc" },
                placeholder: 'ابحث عن مكان...'
            });
        });
    </script>

            <div id="place_manual"
                 class="mb-4 text-right {{ old('is_place_related', $activity->is_place_related) == 0 ? '' : 'hidden' }}">
                <div class="mb-4">
                    <label for="place_name_ar" class="block text-gray-700 font-bold mb-2">اسم المكان (عربي) *</label>
                    <input type="text" name="place_name_ar" id="place_name_ar"
                           value="{{ old('place_name_ar', $activity->place_name_ar) }}"
                           class="w-full border-gray-300 rounded-md shadow-sm text-right">
                    @error('place_name_ar')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="place_name_en" class="block text-gray-700 font-bold mb-2">اسم المكان (إنجليزي) *</label>
                    <input type="text" name="place_name_en" id="place_name_en"
                           value="{{ old('place_name_en', $activity->place_name_en) }}"
                           class="w-full border-gray-300 rounded-md shadow-sm">
                    @error('place_name_en')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="place_name_zh" class="block text-gray-700 font-bold mb-2">اسم المكان (صيني) *</label>
                    <input type="text" name="place_name_zh" id="place_name_zh"
                           value="{{ old('place_name_zh', $activity->place_name_zh) }}"
                           class="w-full border-gray-300 rounded-md shadow-sm">
                    @error('place_name_zh')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="details_ar" class="block text-gray-700 font-bold mb-2">التفاصيل (عربي) *</label>
                    <textarea name="details_ar" id="details_ar"
                              class="w-full border-gray-300 rounded-md shadow-sm text-right" rows="4">{{ old('details_ar', $activity->details_ar) }}</textarea>
                    @error('details_ar')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="details_en" class="block text-gray-700 font-bold mb-2">التفاصيل (إنجليزي)</label>
                    <textarea name="details_en" id="details_en"
                              class="w-full border-gray-300 rounded-md shadow-sm" rows="4">{{ old('details_en', $activity->details_en) }}</textarea>
                    @error('details_en')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="details_zh" class="block text-gray-700 font-bold mb-2">التفاصيل (صيني)</label>
                    <textarea name="details_zh" id="details_zh"
                              class="w-full border-gray-300 rounded-md shadow-sm" rows="4">{{ old('details_zh', $activity->details_zh) }}</textarea>
                    @error('details_zh')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-4 text-right">
                <label for="status" class="block text-gray-700 font-bold mb-2">الحالة *</label>
                <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm text-right" required>
                    <option value="active" {{ old('status', $activity->status) == 'active' ? 'selected' : '' }}>
                        نشط
                    </option>
                    <option value="inactive" {{ old('status', $activity->status) == 'inactive' ? 'selected' : '' }}>
                        غير نشط
                    </option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="bg-black text-white px-4 py-2 rounded-md">تحديث</button>
                <a href="{{ route('admin.omdaHome.trip.trip-table', $trip->id) }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded-md">إلغاء</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            function debounce(func, wait) {
                let timeout;
                return function (...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func(...args), wait);
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
                    success: function (response) {
                        targetFields.forEach((field, index) => field.val(response[targetLangs[index]] || ''));
                    },
                    error: function () {
                        alert('فشل في الترجمة، حاول مرة أخرى لاحقاً.');
                    }
                });
            }

            const debouncedTranslate = debounce(translateText, 500);

            $('#name_ar').on('input', function () {
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#name_en'), $('#name_ch')]);
            });

            $('#name_en').on('input', function () {
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#name_ar'), $('#name_ch')]);
            });

            $('#name_ch').on('input', function () {
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#name_ar'), $('#name_en')]);
            });

            $('#place_name_ar').on('input', function () {
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#place_name_en'), $('#place_name_zh')]);
            });

            $('#place_name_en').on('input', function () {
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#place_name_ar'), $('#place_name_zh')]);
            });

            $('#place_name_zh').on('input', function () {
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#place_name_ar'), $('#place_name_en')]);
            });

            $('#details_ar').on('input', function () {
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#details_en'), $('#details_zh')]);
            });

            $('#details_en').on('input', function () {
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#details_ar'), $('#details_zh')]);
            });

            $('#details_zh').on('input', function () {
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#details_ar'), $('#details_en')]);
            });

            $('#is_place_related').on('change', function () {
                const placeSelect = $('#place_select');
                const placeManual = $('#place_manual');
                if (this.value == '1') {
                    placeSelect.removeClass('hidden');
                    placeManual.addClass('hidden');
                    $('#place_id').prop('required', true);
                    $('#place_name_ar, #place_name_en, #place_name_zh, #details_ar, #details_en, #details_zh').prop('required', false);
                } else {
                    placeSelect.addClass('hidden');
                    placeManual.removeClass('hidden');
                    $('#place_id').prop('required', false);
                    $('#place_name_ar, #place_name_en, #place_name_zh, #details_ar').prop('required', true);
                    $('#details_en, #details_zh').prop('required', false);
                }
            });
        });
    </script>
@endsection