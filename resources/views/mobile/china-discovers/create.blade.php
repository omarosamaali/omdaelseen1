@extends('layouts.mobile')

@section('title', 'إدخال مكان | Add Location')
<link rel="stylesheet" href="{{ asset('assets/assets/css/add-place.css') }}">

@section('content')
<div class="container dark:text-white dark:bg-color1">
    <img src="{{ asset('assets/images/header-bg-2.png') }}" class="absolute header-bg" alt="" />
    <div class="absolute top-0 left-0 bg-p3 bg-blur-145"></div>
    <div class="absolute top-40 right-0 bg-[#0ABAC9] bg-blur-150"></div>
    <div class="absolute top-80 right-40 bg-p2 bg-blur-235"></div>
    <div class="absolute bottom-0 right-0 bg-p3 bg-blur-220"></div>
    <div class="relative z-30 px-6">
        <div class="flex justify-center items-center gap-4 relative">
            <a href="{{ url('/') }}" class="absolute-left-0 bg-white size-8 rounded-full flex justify-center items-center text-xl dark:bg-color10">
                <i class="ph ph-caret-left"></i>
            </a>
            <h2 class="text-2xl font-semibold text-white text-center">إضافة مكان جديد</h2>
        </div>

        <div class="p-6 rounded-xl bg-white dark:bg-color9 mt-12 border border-color21">
            <form action="{{ route('mobile.china-discovers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mt-8 flex flex-col gap-4 justify-center items-center py-10 bg-color16 w-full rounded-xl border border-p2 dark:border-p1 dark:bg-bgColor14">
                    <label for="avatar" class="cursor-pointer">
                        <div class="bg-p2 dark:bg-p1 rounded-full p-5 flex justify-center items-center">
                            <i class="ph ph-image text-white text-2xl !leading-none"></i>
                        </div>
                        <p class="text-sm font-semibold text-p2 dark:text-p1 mt-2"><span>*</span> إضافة الصورة الرئيسية</p>
                    </label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="previewImage(event)" required />
                    <img id="imagePreview" class="image-preview hidden" src="#" alt="معاينة الصورة" />
                    @error('avatar')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="pt-8 flex flex-col gap-4">
                    <div>
                        <p class="text-sm font-semibold pb-2"><span>*</span> اسم المكان (بالعربي)</p>
                        <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="text" name="name_ar" placeholder="أدخل اسم المكان" class="modal-input" required />
                        </div>
                        @error('name_ar')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2"><span>*</span> اسم المكان (بالإنجليزي)</p>
                        <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="text" name="name_en" placeholder="أدخل اسم المكان" class="modal-input" required />
                        </div>
                        @error('name_en')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2"><span>*</span> اسم المكان (بالصيني)</p>
                        <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="text" name="name_ch" placeholder="أدخل اسم المكان" class="modal-input" required />
                        </div>
                        @error('name_ch')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">التصنيف الرئيسي</p>
                        <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <select name="main_category_id" id="main_category_id" class="modal-input" required>
                                <option value="" disabled selected>اختر </option>
                                @foreach($explorers as $explorer)
                                <option value="{{ $explorer->id }}">{{ $explorer->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('main_category_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">التصنيف الفرعي</p>
                        <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <select name="sub_category_id" id="sub_category_id" class="modal-input">
                                <option value="" disabled selected>اختر </option>
                            </select>
                        </div>
                        @error('sub_category_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">المنطقة</p>
                        <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <select name="region_id" id="region_id" class="modal-input" required>
                                <option value="" disabled selected>اختر </option>
                                @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('region_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">رابط خريطة المكان</p>
                        <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="url" name="link" placeholder="رابط المكان" class="modal-input" required />
                        </div>
                        @error('link')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">رقم الهاتف</p>
                        <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="text" name="phone" placeholder="009710000000000" class="modal-input" />
                        </div>
                        @error('phone')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">البريد الإلكتروني</p>
                        <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <input type="email" name="email" placeholder="name@domain.com" class="modal-input" />
                        </div>
                        @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <p class="text-sm font-semibold pb-2">الصور الفرعية</p>
                        <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                            <label for="additional_images" class="cursor-pointer w-full text-center">
                                <div class="bg-p2 dark:bg-p1 rounded-full p-3 inline-flex justify-center items-center">
                                    <i class="ph ph-images text-white text-xl !leading-none"></i>
                                </div>
                                <p class="text-sm font-semibold text-p2 dark:text-p1 mt-2">إضافة صور فرعية</p>
                            </label>
                            <input type="file" name="additional_images[]" id="additional_images" accept="image/*" multiple class="hidden" onchange="previewSubImages(event)" />
                        </div>
                        <div id="subImagesPreview" class="sub-images-preview flex flex-wrap gap-4 mt-4"></div>
                        @error('additional_images.*')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <button type="submit" class="confirm-button">إضافة المكان</button>
            </form>

            <div id="successMessage" class="success-message" style="display: none;">
                تم إضافة المكان بنجاح!
            </div>
        </div>
    </div>
</div>

<script>
    // Preview for the main image
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
            preview.src = "#";
            preview.classList.add('hidden');
        }
    }

    // Preview for sub images
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

    // Handle subcategory dropdown based on main category selection
    document.getElementById('main_category_id').addEventListener('change', function() {
        var mainCategoryId = this.value;
        var subCategorySelect = document.getElementById('sub_category_id');

        // تفريغ قائمة التصنيفات الفرعية قبل ملئها
        subCategorySelect.innerHTML = '<option value="" disabled selected>جاري التحميل...</option>';

        if (mainCategoryId) {
            fetch(`/get-subcategories/${mainCategoryId}`)
                .then(response => response.json())
                .then(data => {
                    subCategorySelect.innerHTML = '<option value="" disabled selected>اختر </option>';
                    if (data.length === 0) {
                        subCategorySelect.innerHTML = '<option value="" disabled selected>لا يوجد تصنيفات فرعية</option>';
                    } else {
                        data.forEach(function(subcategory) {
                            var option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.name_ar;
                            subCategorySelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching subcategories:', error);
                    subCategorySelect.innerHTML = '<option value="" disabled selected>حدث خطأ</option>';
                });
        } else {
            subCategorySelect.innerHTML = '<option value="" disabled selected>اختر </option>';
        }
    });

</script>
@endsection
