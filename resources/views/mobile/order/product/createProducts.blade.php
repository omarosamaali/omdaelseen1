@extends('layouts.mobile')

@section('title', 'ادخال المنتجات | Add Products')

<link rel="stylesheet" href="{{ asset('assets/assets/css/add-place.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/create-trip-form.css') }}">

@section('content')
<div class="container dark:text-white dark:bg-color1 min-h-screen">
    <img src="{{ asset('assets/images/header-bg-2.png') }}" class="absolute header-bg" alt="" />
    <div class="absolute top-0 left-0 bg-p3 bg-blur-145"></div>
    <div class="absolute top-40 right-0 bg-[#0ABAC9] bg-blur-150"></div>
    <div class="absolute top-80 right-40 bg-p2 bg-blur-235"></div>
    <div class="absolute bottom-0 right-0 bg-p3 bg-blur-220"></div>

    <div class="relative z-30 px-6 pb-8">
        <!-- Header Section -->
        <div class="flex justify-center items-center gap-4 relative mb-8">
            <a href="{{ route('mobile.order.product.create') }}"
                class="absolute-left-0 bg-white size-10 rounded-full flex justify-center items-center text-xl dark:bg-color10 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <i class="ph ph-caret-left text-gray-600 dark:text-white"></i>
            </a>
            <div class="text-center">
                <h2 class="text-2xl font-bold text-white mb-1">طلب منتج جديد</h2>
                <p class="text-sm text-white pb-4">أدخل بيانات المنتجات المطلوبة</p>
            </div>
        </div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
        <!-- Main Form Container -->
        <div id="tripForm" class="bg-white dark:bg-color9 rounded-2xl shadow-2xl border border-color21 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-p1 to-p2 p-6 text-black">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">معلومات المنتجات</h3>
                        <p class="text-sm opacity-90 mt-1">عدد المنتجات: {{ $numberOfProducts }}</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-3">
                        <i class="ph ph-shopping-cart text-xl"></i>
                    </div>
                </div>
            </div>

            <form action="{{ route('mobile.order.product.storeProducts') }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->name }}">
                <input type="hidden" name="reference_number" value="{{ $referenceNumber }}">
                <input type="hidden" name="number_of_products" value="{{ $numberOfProducts }}">
                <input type="hidden" name="price_unexpected" value="{{ $priceUnexpected }}">
                <input type="hidden" name="item_unavailable" value="{{ $itemUnavailable }}">
                <input type="hidden" name="no_returns" value="{{ $noReturns }}">

                <div id="products-container" class="mt-6">
                    <div id="tabs-navigation" style="flex-wrap: wrap;"
                        class="flex border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-color10 rounded-t-xl p-2 overflow-x-auto scrollbar-hide">
                    </div>

                    <div id="tabs-content" class="bg-gray-50 dark:bg-color10 rounded-b-xl p-6">
                    </div>
                </div>

                <div class="pt-8 border-t border-gray-200 dark:border-gray-600 mt-6">
                    <button type="submit" class="confirm-button">
                        <i class="ph ph-check-circle text-xl"></i>
                        حفظ المنتجات وإرسال الطلب
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .modal-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
        background-color: white;
        color: #374151;
    }

    .modal-input:focus {
        outline: none;
        border-color: #0ABAC9;
        box-shadow: 0 0 0 3px rgba(10, 186, 201, 0.1);
        background-color: #fefefe;
    }

    .dark .modal-input {
        background-color: #1f2937;
        border-color: #374151;
        color: white;
    }

    .dark .modal-input:focus {
        border-color: #0ABAC9;
        background-color: #111827;
    }

    .product-tab {
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 0 2px;
        white-space: nowrap;
        min-width: fit-content;
    }

    .product-tab.active {
        background: linear-gradient(135deg, #0ABAC9, #06b6d4);
        color: white;
        box-shadow: 0 4px 12px rgba(10, 186, 201, 0.3);
    }

    .product-tab:not(.active):hover {
        background-color: #e5e7eb;
        color: #0ABAC9;
    }

    .dark .product-tab:not(.active):hover {
        background-color: #374151;
        color: #0ABAC9;
    }

    .input-group {
        position: relative;
        margin-bottom: 24px;
    }

    .input-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dark .input-label {
        color: #d1d5db;
    }

    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-input-display {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 16px;
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        background-color: #f9fafb;
        color: #6b7280;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-input-display:hover {
        border-color: #0ABAC9;
        background-color: #f0fdff;
        color: #0ABAC9;
    }

    .dark .file-input-display {
        background-color: #1f2937;
        border-color: #374151;
        color: #9ca3af;
    }

    .dark .file-input-display:hover {
        border-color: #0ABAC9;
        background-color: #0f2027;
    }

    .delete-btn {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .delete-btn:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .product-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .dark .product-card {
        background: #1f2937;
        border-color: #374151;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .icon-input {
        position: relative;
    }

    .icon-input i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 16px;
    }

    .icon-input .modal-input {
        padding-left: 40px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const numberOfProducts = {{ $numberOfProducts }};
    const tabsNavigation = document.getElementById('tabs-navigation');
    const tabsContent = document.getElementById('tabs-content');

    if (numberOfProducts > 0) {
        for (let i = 1; i <= numberOfProducts; i++) {
            const tab = document.createElement('button');
            tab.className = 'product-tab py-3 px-4 text-sm font-semibold text-gray-600 dark:text-gray-300 transition-all duration-300';
            tab.innerHTML = `
                <div class="flex items-center gap-2">
                    <i class="ph ph-package text-base"></i>
                    <span>منتج ${i}</span>
                </div>
            `;
            tab.setAttribute('data-tab', `tab-${i}`);
            tabsNavigation.appendChild(tab);

            // Create enhanced content
            const content = document.createElement('div');
            content.id = `tab-${i}`;
            content.className = 'hidden';
            content.innerHTML = `
                <div class="product-card">
                    <div class="flex items-center justify-between mb-6" style="flex-direction: column;">
                        <div class="flex items-center gap-3">
                            <div class="bg-gradient-to-r from-p1 to-p2 p-2 rounded-full text-black">
                                <i class="ph ph-package text-lg text-black"></i>
                            </div>
                            <h3 class="font-bold text-xl text-gray-800 dark:text-white">بيانات منتج ${i}</h3>
                        </div>
                        <button type="button" class="delete-btn" data-product-id="${i}">
                            <i class="ph ph-trash text-sm"></i>
                            <span>حذف المنتج</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <div class="input-group">
                                <label class="input-label">
                                    <i class="ph ph-images text-p1"></i>
                                    صور المنتج (حتى 5 صور)
                                </label>
                                <div class="file-input-wrapper">
                                    <input type="file" name="products[${i}][images][]" multiple accept="image/*" max="5" class="file-input">
                                    <div class="file-input-display">
                                        <i class="ph ph-upload-simple text-xl"></i>
                                        <span>اضغط لاختيار الصور أو اسحبها هنا</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                                        <div class="input-group">
                                            <label class="input-label">
                                                <i class="ph ph-text-t text-p1"></i>
                                                اسم المنتج
                                            </label>
                                            <div class="icon-input">
                                                <i class="ph ph-package"></i>
                                                <input type="text" name="products[${i}][name]" class="modal-input" placeholder="أدخل اسم المنتج" required>
                                            </div>
                                        </div>
                                    </div>

                        <div class="md:col-span-2">
                            <div class="input-group">
                                <label class="input-label">
                                    <i class="ph ph-link text-p1"></i>
                                    رابط المنتج
                                </label>
                                <div class="icon-input">
                                    <i class="ph ph-globe"></i>
                                    <input type="url" name="products[${i}][link]" class="modal-input" placeholder="https://example.com/product">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="input-group">
                                <label class="input-label">
                                    <i class="ph ph-hash text-p1"></i>
                                    الكمية
                                </label>
                                <div class="icon-input">
                                    <i class="ph ph-plus-minus"></i>
                                    <input type="number" name="products[${i}][quantity]" min="1" class="modal-input" placeholder="1" required>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="input-group">
                                <label class="input-label">
                                    <i class="ph ph-currency-dollar text-p1"></i>
                                    السعر المتوقع للحبة
                                </label>
                                <div class="icon-input">
                                    <i class="ph ph-money"></i>
                                    <input type="number" name="products[${i}][price]" min="0" step="0.01" class="modal-input" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="input-group">
                                <label class="input-label">
                                    <i class="ph ph-ruler text-p1"></i>
                                    الحجم
                                </label>
                                <div class="icon-input">
                                    <i class="ph ph-resize"></i>
                                    <input type="text" name="products[${i}][size]" class="modal-input" placeholder="مثال: L, XL, 42">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="input-group">
                                <label class="input-label">
                                    <i class="ph ph-palette text-p1"></i>
                                    اللون
                                </label>
                                <div class="icon-input">
                                    <i class="ph ph-drop"></i>
                                    <input type="text" name="products[${i}][color]" class="modal-input" placeholder="مثال: أحمر, أزرق, أسود">
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <div class="input-group">
                                <label class="input-label">
                                    <i class="ph ph-note text-p1"></i>
                                    تفاصيل إضافية
                                </label>
                                <textarea name="products[${i}][notes]" class="modal-input" rows="4" placeholder="أضف أي تفاصيل إضافية حول المنتج..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            tabsContent.appendChild(content);

            if (i === 1) {
                tab.classList.add('active');
                content.classList.remove('hidden');
            }

            // Enhanced tab click handler
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelectorAll('.product-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('#tabs-content > div').forEach(c => c.classList.add('hidden'));
                this.classList.add('active');
                document.getElementById(this.getAttribute('data-tab')).classList.remove('hidden');
            });
        }

        // Enhanced delete functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-btn')) {
                const btn = e.target.closest('.delete-btn');
                const productId = btn.getAttribute('data-product-id');
                
                if (confirm(`هل أنت متأكد من حذف المنتج ${productId}؟`)) {
                    const tab = document.querySelector(`[data-tab="tab-${productId}"]`);
                    const content = document.getElementById(`tab-${productId}`);
                    
                    // Remove with animation
                    tab.style.transform = 'scale(0.8)';
                    tab.style.opacity = '0';
                    content.style.transform = 'translateX(100%)';
                    content.style.opacity = '0';
                    
                    setTimeout(() => {
                        tab.remove();
                        content.remove();
                        
                        // Activate first remaining tab if current was active
                        const remainingTabs = document.querySelectorAll('.product-tab');
                        if (remainingTabs.length > 0 && !document.querySelector('.product-tab.active')) {
                            remainingTabs[0].click();
                        }
                    }, 300);
                }
            }
        });

        // File input enhancement
        document.addEventListener('change', function(e) {
            if (e.target.type === 'file') {
                const display = e.target.parentNode.querySelector('.file-input-display span');
                const files = e.target.files;
                if (files.length > 0) {
                    display.textContent = `تم اختيار ${files.length} من الصور`;
                } else {
                    display.textContent = 'اضغط لاختيار الصور أو اسحبها هنا';
                }
            }
        });
    }
});
</script>

@endsection