@extends('layouts.mobile')

@section('title', 'إدخال مكان | Add Location')
<link rel="stylesheet" href="{{ asset('assets/assets/css/add-place.css') }}">

@section('content')
<x-china-header :title="__('messages.add_new_place')" :route="route('mobile.china-discovers.index')" />
<div class="container dark:text-white dark:bg-color1" style="padding-top: 90px;">
    <div class="relative z-30 px-6">
        <div class="p-6 rounded-xl bg-white dark:bg-color9 border border-color21">
            <form action="{{ route('mobile.china-discovers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div
                    class="mt-8 flex flex-col gap-4 justify-center items-center py-10 bg-color16 w-full rounded-xl border border-p2 dark:border-p1 dark:bg-bgColor14">
                    <label for="avatar" class="cursor-pointer">
                        <div class="bg-p2 dark:bg-p1 rounded-full p-5 flex justify-center items-center">
                            <i class="ph ph-image text-white text-2xl !leading-none"></i>
                        </div>
                        <p class="text-sm font-semibold text-p2 dark:text-p1 mt-2"><span>*</span> {{
                            __('messages.add_main_image') }}</p>
                    </label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden"
                        onchange="previewImage(event)" required />
                    <img id="imagePreview" class="image-preview hidden" src="#"
                        alt="{{ __('messages.image_preview') }}" />
                    @error('avatar')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="pt-8 flex flex-col gap-4">
                    {{-- حقل اسم المكان بالعربي --}}
                    <div class="{{ app()->getLocale() == 'ar' ? '' : 'hidden' }}">
                        <p class="text-sm font-semibold pb-2"><span>*</span> {{ __('messages.place_name_ar') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="text" name="name_ar" id="name_ar"
                                placeholder="{{ __('messages.enter_place_name') }}" class="modal-input"
                                value="{{ old('name_ar') }}" {{ app()->getLocale() == 'ar' ? 'required' : '' }} />
                        </div>
                        @error('name_ar')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    {{-- حقل اسم المكان بالإنجليزي --}}
                    <div class="{{ app()->getLocale() == 'en' ? '' : 'hidden' }}">
                        <p class="text-sm font-semibold pb-2"><span>*</span> {{ __('messages.place_name_en') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="text" name="name_en" id="name_en"
                                placeholder="{{ __('messages.enter_place_name') }}" class="modal-input"
                                value="{{ old('name_en') }}" {{ app()->getLocale() == 'en' ? 'required' : '' }} />
                        </div>
                        @error('name_en')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    {{-- حقل اسم المكان بالصيني --}}
                    <div class="{{ app()->getLocale() == 'zh' ? '' : 'hidden' }}">
                        <p class="text-sm font-semibold pb-2"><span>*</span> {{ __('messages.place_name_ch') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="text" name="name_ch" id="name_ch"
                                placeholder="{{ __('messages.enter_place_name') }}" class="modal-input"
                                value="{{ old('name_ch') }}" {{ app()->getLocale() == 'zh' ? 'required' : '' }} />
                        </div>
                        @error('name_ch')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    {{-- حقل تفاصيل المكان بالعربي --}}
                    <div class="{{ app()->getLocale() == 'ar' ? '' : 'hidden' }}">
                        <p class="text-sm font-semibold pb-2">{{ __('messages.place_details_ar') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <textarea name="details_ar" id="details_ar"
                                placeholder="{{ __('messages.enter_place_details') }}" class="modal-input"
                                rows="4">{{ old('details_ar') }}</textarea>
                        </div>
                        @error('details_ar')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    {{-- حقل تفاصيل المكان بالإنجليزي --}}
                    <div class="{{ app()->getLocale() == 'en' ? '' : 'hidden' }}">
                        <p class="text-sm font-semibold pb-2">{{ __('messages.place_details_en') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <textarea name="details_en" id="details_en"
                                placeholder="{{ __('messages.enter_place_details') }}" class="modal-input"
                                rows="4">{{ old('details_en') }}</textarea>
                        </div>
                        @error('details_en')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    {{-- حقل تفاصيل المكان بالصيني --}}
                    <div class="{{ app()->getLocale() == 'zh' ? '' : 'hidden' }}">
                        <p class="text-sm font-semibold pb-2">{{ __('messages.place_details_ch') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <textarea name="details_ch" id="details_ch"
                                placeholder="{{ __('messages.enter_place_details') }}" class="modal-input"
                                rows="4">{{ old('details_ch') }}</textarea>
                        </div>
                        @error('details_ch')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    {{-- الحقول المخفية للترجمة التلقائية --}}
                    <input type="hidden" name="name_ar" id="hidden_name_ar" value="{{ old('name_ar') }}" />
                    <input type="hidden" name="name_en" id="hidden_name_en" value="{{ old('name_en') }}" />
                    <input type="hidden" name="name_ch" id="hidden_name_ch" value="{{ old('name_ch') }}" />
                    <input type="hidden" name="details_ar" id="hidden_details_ar" value="{{ old('details_ar') }}" />
                    <input type="hidden" name="details_en" id="hidden_details_en" value="{{ old('details_en') }}" />
                    <input type="hidden" name="details_ch" id="hidden_details_ch" value="{{ old('details_ch') }}" />

                    <div>
                        <p class="text-sm font-semibold pb-2">{{ __('messages.main_category') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <select name="main_category_id" id="main_category_id" class="modal-input" required>
                                <option value="" disabled selected>{{ __('messages.choose') }}</option>
                                @foreach($explorers as $explorer)
                                <option value="{{ $explorer->id }}" {{ old('main_category_id')==$explorer->id ?
                                    'selected' : '' }}>
                                    {{ app()->getLocale() == 'en' ? $explorer->name_en : (app()->getLocale() == 'zh' ?
                                    $explorer->name_ch : $explorer->name_ar) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('main_category_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">{{ __('messages.sub_category') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <select name="sub_category_id" id="sub_category_id" class="modal-input">
                                <option value="" disabled selected>{{ __('messages.choose') }}</option>
                            </select>
                        </div>
                        @error('sub_category_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">{{ __('messages.region') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <select name="region_id" id="region_id" class="modal-input" required>
                                <option value="" disabled selected>{{ __('messages.choose') }}</option>
                                @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id')==$region->id ? 'selected' : '' }}>
                                    {{ app()->getLocale() == 'en' ? $region->name_en : (app()->getLocale() == 'zh' ?
                                    $region->name_ch : $region->name_ar) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('region_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">{{ __('messages.place_map_link') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="url" name="link" placeholder="{{ __('messages.place_link') }}"
                                class="modal-input" value="{{ old('link') }}" required />
                        </div>
                        @error('link')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">{{ __('messages.phone_number') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="text" name="phone" placeholder="{{ __('messages.phone_placeholder') }}"
                                class="modal-input" value="{{ old('phone') }}" />
                        </div>
                        @error('phone')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">{{ __('messages.website') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="url" name="website" placeholder="{{ __('messages.website_placeholder') }}"
                                class="modal-input" value="{{ old('website') }}" />
                        </div>
                        @error('website')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">{{ __('messages.email') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="email" name="email" placeholder="{{ __('messages.email_placeholder') }}"
                                class="modal-input" value="{{ old('email') }}" />
                        </div>
                        @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">{{ __('messages.additional_images') }}</p>
                        <div
                            class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <label for="additional_images" class="cursor-pointer w-full text-center">
                                <div class="bg-p2 dark:bg-p1 rounded-full p-3 inline-flex justify-center items-center">
                                    <i class="ph ph-images text-white text-xl !leading-none"></i>
                                </div>
                                <p class="text-sm font-semibold text-p2 dark:text-p1 mt-2">{{
                                    __('messages.add_additional_images') }}</p>
                            </label>
                            <input type="file" name="additional_images[]" id="additional_images" accept="image/*"
                                multiple class="hidden" onchange="previewSubImages(event)" />
                        </div>
                        <div id="subImagesPreview" class="sub-images-preview flex flex-wrap gap-4 mt-4"></div>
                        @error('additional_images.*')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <button type="submit" class="confirm-button">{{ __('messages.add_place') }}</button>
            </form>

            <div id="successMessage" class="success-message" style="display: none;">
                {{ __('messages.place_added_success') }}
            </div>

            <div id="translationStatus" class="translation-status" style="display: none;">
                <p class="text-sm text-blue-600">{{ __('messages.translating') }}</p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const currentLang = '{{ app()->getLocale() }}';
    
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

    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.classList.add('hidden');
        }
    }

    function previewSubImages(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('subImagesPreview');
        previewContainer.innerHTML = '';
        if (files.length > 0) {
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'sub-image w-24 h-24 object-cover rounded-lg';
                    img.alt = `صورة فرعية ${index + 1}`;
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    $(document).ready(function() {
        console.log('Current language:', currentLang);

        function showTranslationStatus(show = true, message = 'جاري الترجمة...') {
            const statusElement = document.getElementById('translationStatus');
            if (show) {
                statusElement.querySelector('p').textContent = message;
                statusElement.style.display = 'block';
            } else {
                statusElement.style.display = 'none';
            }
        }

        function translateText(inputField, sourceLang, targetLangs, hiddenFields) {
            const text = inputField.val().trim();
            if (!text) {
                hiddenFields.forEach(field => field.val(''));
                showTranslationStatus(false);
                return;
            }

            showTranslationStatus(true);
            console.log('Translating:', { text, sourceLang, targetLangs });

            $.ajax({
                url: '{{ route('translate') }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}',
                    text: text,
                    source_lang: sourceLang,
                    target_langs: targetLangs,
                },
                success: function(response) {
                    console.log('Translation successful:', response);
                    hiddenFields[0].val(response[targetLangs[0]] || '');
                    hiddenFields[1].val(response[targetLangs[1]] || '');
                    showTranslationStatus(false);
                },
                error: function(xhr) {
                    console.error('Translation failed:', xhr.responseJSON?.error);
                    showTranslationStatus(true, 'فشل في الترجمة، حاول مرة أخرى لاحقًا.');
                    setTimeout(() => showTranslationStatus(false), 3000);
                }
            });
        }

        const debouncedTranslate = debounce(translateText, 500);

        // الترجمة حسب اللغة الحالية
        if (currentLang === 'ar') {
            $('#name_ar').on('input', function() {
                const val = $(this).val();
                $('#hidden_name_ar').val(val);
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#hidden_name_en'), $('#hidden_name_ch')]);
            });
            
            $('#details_ar').on('input', function() {
                const val = $(this).val();
                $('#hidden_details_ar').val(val);
                debouncedTranslate($(this), 'ar', ['en', 'zh-CN'], [$('#hidden_details_en'), $('#hidden_details_ch')]);
            });
        } else if (currentLang === 'en') {
            $('#name_en').on('input', function() {
                const val = $(this).val();
                $('#hidden_name_en').val(val);
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#hidden_name_ar'), $('#hidden_name_ch')]);
            });
            
            $('#details_en').on('input', function() {
                const val = $(this).val();
                $('#hidden_details_en').val(val);
                debouncedTranslate($(this), 'en', ['ar', 'zh-CN'], [$('#hidden_details_ar'), $('#hidden_details_ch')]);
            });
        } else if (currentLang === 'zh') {
            $('#name_ch').on('input', function() {
                const val = $(this).val();
                $('#hidden_name_ch').val(val);
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#hidden_name_ar'), $('#hidden_name_en')]);
            });
            
            $('#details_ch').on('input', function() {
                const val = $(this).val();
                $('#hidden_details_ch').val(val);
                debouncedTranslate($(this), 'zh-CN', ['ar', 'en'], [$('#hidden_details_ar'), $('#hidden_details_en')]);
            });
        }

        $('#main_category_id').on('change', function() {
            const mainCategoryId = this.value;
            const subCategorySelect = $('#sub_category_id');
            console.log('Main category changed:', mainCategoryId);

            subCategorySelect.html('<option value="" disabled selected>جاري التحميل...</option>');

            if (mainCategoryId) {
                $.ajax({
                    url: `/get-subcategories/${mainCategoryId}`,
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        console.log('Subcategories fetched:', data);
                        subCategorySelect.html('<option value="" disabled selected>اختر</option>');
                        if (data.length === 0) {
                            subCategorySelect.html('<option value="" disabled selected>لا يوجد تصنيفات فرعية</option>');
                        } else {
                            data.forEach(subcategory => {
                                const option = $('<option>').val(subcategory.id).text(subcategory.name_ar);
                                if (subcategory.id == '{{ old("sub_category_id") }}') {
                                    option.prop('selected', true);
                                }
                                subCategorySelect.append(option);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching subcategories:', xhr.responseJSON?.error);
                        subCategorySelect.html('<option value="" disabled selected">حدث خطأ</option>');
                    }
                });
            } else {
                subCategorySelect.html('<option value="" disabled selected>اختر</option>');
            }
        });

        if ($('#main_category_id').val()) {
            $('#main_category_id').trigger('change');
        }
    });
</script>
@endsection