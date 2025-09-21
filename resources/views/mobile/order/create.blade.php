@extends('layouts.mobile')

@section('title', 'طلب جديد | New Order')
<link rel="stylesheet" href="{{ asset('assets/assets/css/add-place.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/create-trip-form.css') }}">
@section('content')

<div class="container dark:text-white dark:bg-color1">
    <img src="{{ asset('assets/images/header-bg-2.png') }}" class="absolute header-bg" alt="" />
    <div class="absolute top-0 left-0 bg-p3 bg-blur-145"></div>
    <div class="absolute top-40 right-0 bg-[#0ABAC9] bg-blur-150"></div>
    <div class="absolute top-80 right-40 bg-p2 bg-blur-235"></div>
    <div class="absolute bottom-0 right-0 bg-p3 bg-blur-220"></div>

    <div id="selectionModal" class="fixed inset-0 bg-white bg-opacity-50 items-center justify-center z-50">
        <x-china-header :title="__('messages.special_request')" :route="route('mobile.welcome')" />

        <div class="bg-white shadow border dark:bg-color9 rounded-xl p-6 w-11/12 max-w-md"
            style="top: 20%; position: relative; margin: auto; width: 70%;">
            <h2 class="text-xl font-semibold text-center mb-4">اختر الخيار</h2>
            <div class="flex flex-col gap-4">
                <a href="{{ route('mobile.order.product.create') }}"
                    class="text-center bg-p2 dark:bg-p1 text-white py-2 px-4 rounded-lg hover:bg-opacity-90">
                    منتج
                </a>
                <button id="tripBtn" class="bg-p2 dark:bg-p1 text-white py-2 px-4 rounded-lg hover:bg-opacity-90">
                    طلب رحلة
                </button>
            </div>
        </div>
    </div>
    <x-china-header :title="'طلب جديد'" :route="route('mobile.order')" />
    <div class="relative z-30 px-6">
        <div id="productForm" class="p-6 rounded-xl bg-white dark:bg-color9 mt-12 border border-color21 hidden">
            <div id="successMessage" class="success-message" style="display: none;">
                تم إضافة المكان بنجاح
            </div>
            <div id="translationStatus" class="translation-status" style="display: none;">
                <p class="text-sm text-blue-600">جاري الترجمة</p>
            </div>
        </div>

        <div id="tripForm" class="p-6 rounded-xl bg-white dark:bg-color9 mt-12 border border-color21 hidden">
            <form action="{{ route('trip-requests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <p class="text-sm font-semibold pb-2">رقم المرجع</p>
                    <div
                        class="flex justify-between items-centerborder border-color21 rounded-xl dark:border-color18 gap-3 bg-gray-100 dark:bg-gray-700">
                        <input type="text" name="reference_number" id="reference_number"
                            class="modal-input text-gray-600 dark:text-gray-300 font-mono" value="" readonly />
                    </div>
                </div>
                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2"><span class="text-red-500">*</span> عدد المسافرين</p>
                    <div
                        class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                        <input type="number" name="travelers_count" id="travelers_count"
                            placeholder="أدخل عدد المسافرين" class="modal-input" value="{{ old('travelers_count') }}"
                            min="1" max="50" required />
                        <i class="ph ph-users text-p2 dark:text-p1"></i>
                    </div>
                    @error('travelers_count')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2"><span class="text-red-500">*</span> الاهتمامات</p>
                    <div class="dropdown-container">
                        <div
                            class="selected-items border border-gray-300 rounded-md p-2 bg-white flex flex-wrap min-h-[40px]">
                            <input type="text" id="searchInput" class="border-none outline-none flex-grow p-1"
                                placeholder="ابحث أو اختر...">
                        </div>
                        <div id="dropdownMenu" class="dropdown-menu">
                            <div id="optionsList" class="p-2">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="interests" id="interestsInput" value="" />
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <button type="submit" class="confirm-button">إرسال طلب الرحلة</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const options = @js($availableExplorers);
const searchInput = document.getElementById('searchInput');
const dropdownMenu = document.getElementById('dropdownMenu');
const optionsList = document.getElementById('optionsList');
const selectedItems = document.querySelector('.selected-items');
const interestsInput = document.getElementById('interestsInput');
let selectedOptions = [];

function filterOptions(query) {
    const queryLower = query.toLowerCase();
    const filtered = options.filter(option => {
        if (typeof option.name !== 'string' || option.name === null || option.name === undefined) {
            return false;
        }
        return option.name.toLowerCase().includes(queryLower) && !selectedOptions.includes(option.id);
    });
    renderOptions(filtered);
}

function renderOptions(filteredOptions) {
    optionsList.innerHTML = '';
    if (filteredOptions.length === 0) {
        const div = document.createElement('div');
        div.className = 'p-2 text-gray-500 text-center';
        div.textContent = 'لا توجد نتائج';
        optionsList.appendChild(div);
        return;
    }
    filteredOptions.forEach(option => {
        const div = document.createElement('div');
        div.className = 'p-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0';
        div.textContent = option.name;
        div.addEventListener('click', () => selectOption(option.id));
        optionsList.appendChild(div);
    });
}

function selectOption(optionId) {
    if (!selectedOptions.includes(optionId)) {
        selectedOptions.push(optionId);
        renderSelectedItems();
        searchInput.value = '';
        filterOptions('');
        dropdownMenu.classList.add('show');
        updateHiddenInput();
    }
}

function renderSelectedItems() {
    const items = selectedItems.querySelectorAll('.selected-item');
    items.forEach(item => item.remove());
    selectedOptions.forEach(optionId => {
        const option = options.find(opt => opt.id == optionId);
        if (option) {
            const div = document.createElement('div');
            div.className = 'selected-item';
            div.innerHTML = `
                <span class="text-sm mr-1">${option.name}</span>
                <span class="remove-item" title="حذف">×</span>
            `;
            div.querySelector('.remove-item').addEventListener('click', (e) => {
                e.stopPropagation();
                selectedOptions = selectedOptions.filter(item => item !== optionId);
                renderSelectedItems();
                updateHiddenInput();
            });
            selectedItems.insertBefore(div, searchInput);
        }
    });
}

function updateHiddenInput() {
    interestsInput.value = JSON.stringify(selectedOptions);
}

searchInput.addEventListener('focus', () => {
    filterOptions('');
    dropdownMenu.classList.add('show');
});

searchInput.addEventListener('input', () => {
    const query = searchInput.value;
    if (query.length > 0) {
        dropdownMenu.classList.add('show');
        filterOptions(query);
    } else {
        filterOptions('');
    }
});

document.addEventListener('click', (e) => {
    if (!dropdownMenu.contains(e.target) && !selectedItems.contains(e.target) && e.target !== searchInput) {
        dropdownMenu.classList.remove('show');
    }
});

renderOptions(options);
updateHiddenInput();

function generateReferenceNumber() {
    let lastNumber = localStorage.getItem('lastRefNumber') || 0;
    let nextNumber = parseInt(lastNumber) + 1;
    localStorage.setItem('lastRefNumber', nextNumber.toString());
    let paddedNumber = nextNumber.toString().padStart(10, '0');
    return 'REF' + paddedNumber;
}

function copyReferenceNumber() {
    const refNumber = document.getElementById('reference_number').value;
    if (!refNumber) {
        alert('رقم المرجع غير متوفر بعد.');
        return;
    }
    navigator.clipboard.writeText(refNumber).then(function() {
        const icon = event.target;
        icon.classList.remove('ph-copy');
        icon.classList.add('ph-check');
        setTimeout(() => {
            icon.classList.remove('ph-check');
            icon.classList.add('ph-copy');
        }, 2000);
    });
}

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

$(document).ready(function() {
    $('#selectionModal').removeClass('hidden');
    $('#productBtn').on('click', function() {
        $('#selectionModal').addClass('hidden');
        $('#productForm').removeClass('hidden');
        $('#tripForm').addClass('hidden');
    });
    $('#tripBtn').on('click', function() {
        $('#selectionModal').addClass('hidden');
        $('#tripForm').removeClass('hidden');
        $('#productForm').addClass('hidden');
        document.getElementById('reference_number').value = generateReferenceNumber();
    });
    function showTranslationStatus(show = true, message = 'جاري الترجمة...') {
        const statusElement = document.getElementById('translationStatus');
        if (show) {
            statusElement.querySelector('p').textContent = message;
            statusElement.style.display = 'block';
        } else {
            statusElement.style.display = 'none';
        }
    }
    function translateText(inputField, sourceLang, targetLangs, targetFields) {
        const text = inputField.val().trim();
        if (!text) {
            targetFields.forEach(field => field.val(''));
            showTranslationStatus(false);
            return;
        }
        showTranslationStatus(true);
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
                targetFields[0].val(response[targetLangs[0]] || '');
                targetFields[1].val(response[targetLangs[1]] || '');
                showTranslationStatus(false);
            },
            error: function(xhr) {
                showTranslationStatus(true, 'فشل في الترجمة، حاول مرة أخرى لاحقًا.');
                setTimeout(() => showTranslationStatus(false), 3000);
            }
        });
    }
});
</script>
@endsection