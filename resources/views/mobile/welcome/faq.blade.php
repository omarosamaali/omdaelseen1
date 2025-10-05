@extends('layouts.mobile')

@section('title', 'عمدة الصين | الأسئلة الشائعة')

@section('content')
<style>
    .fa-question {
        transform: rotateY(190deg);
    }

    body {
        position: relative !important;
    }

    .tab-button .item.active {
        background-color: #000;
        color: #fff;
        padding: 8px 16px;
        border-radius: 9999px;
    }
</style>

<x-china-header :title="__('messages.الأسئلة الشائعة')" :route="route('mobile.welcome')" />

<body class="relative -z-20">
    <div style="padding-top: 90px;"  class="container min-h-dvh relative overflow-hidden py-8 dark:text-white -z-10 dark:bg-color1">
        <div class="relative z-10 px-6">
            {{-- <div class="flex justify-between items-center gap-3 pt-16">
                <div
                    class="flex justify-start items-center gap-3 bg-color24 border border-color24 p-4 rounded-full text-white w-full">
                    <i class="ph ph-magnifying-glass"></i>
                    <input type="text" id="faq-search" placeholder="{{ __('messages.عن ماذا تريد البحث') }}"
                        class="bg-transparent outline-none bg-gray-200 placeholder:text-white w-full text-xs" />
                </div>
            </div> --}}
            <div class="faqCategory pt-8">
                <ul class="flex justify-start items-center gap-3 tab-button">
                    <li class="item cursor-pointer {{ $category == 'الطلب' ? 'active' : '' }}">
                        <a href="{{ route('mobile.faq', 'الطلب') }}">{{ __('messages.الطلب') }}</a>
                    </li>
                    <li class="item cursor-pointer {{ $category == 'الشحن' ? 'active' : '' }}">
                        <a href="{{ route('mobile.faq', 'الشحن') }}">{{ __('messages.الشحن') }}</a>
                    </li>
                    <li class="item cursor-pointer {{ $category == 'الأماكن' ? 'active' : '' }}">
                        <a href="{{ route('mobile.faq', 'الأماكن') }}">{{ __('messages.الأماكن') }}</a>
                    </li>
                    <li class="item cursor-pointer {{ $category == 'اخرى' ? 'active' : '' }}">
                        <a href="{{ route('mobile.faq', 'اخرى') }}">{{ __('messages.اخرى') }}</a>
                    </li>
                </ul>
            </div>
            <!-- Search Box End -->

            <!-- FAQs Start -->
            <div class="pt-6">
                <div class="flex flex-col gap-2" id="faq-container">
                    @if ($faqs->isEmpty())
                    <p class="text-center text-sm text-gray-500">{{ __('messages.لا توجد أسئلة في هذا التصنيف') }}
                    </p>
                    @else
                    @foreach ($faqs as $faq)
                    <div class="faq-accordion-area border border-color21 rounded-xl bg-white dark:bg-color9 cursor-pointer"
                        data-question="{{ $faq->{'question_' . app()->getLocale()} ?? $faq->question_ar }}"
                        data-answer="{{ $faq->{'answer_' . app()->getLocale()} ?? $faq->answer_ar }}">
                        <div class="faq-accordion duration-500 flex justify-between items-center p-4">
                            <h6 class="text-sm font-semibold">
                                {{ app()->getLocale() == 'en'
                                ? $faq->question_en
                                : (app()->getLocale() == 'zh'
                                ? $faq->question_zh
                                : $faq->question_ar) }}
                            </h6>
                            <div>
                                <i class="fa-solid fa-question"></i>
                            </div>
                        </div>
                        <div class="duration-500 h-0 overflow-hidden">
                            <p class="text-xs text-n500 border-t border-dashed border-n50 pt-3 mx-4 pb-4">
                                {{ app()->getLocale() == 'en'
                                ? $faq->answer_en
                                : (app()->getLocale() == 'zh'
                                ? $faq->answer_zh
                                : $faq->answer_ar) }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <!-- FAQs End -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                // Accordion functionality
                const faqItems = document.querySelectorAll('.faq-accordion-area');
                faqItems.forEach(item => {
                    const header = item.querySelector('.faq-accordion');
                    const content = item.querySelector('.faq-accordion + div');

                    header.addEventListener('click', () => {
                        const isOpen = content.classList.contains('open');

                        // Close all FAQs
                        faqItems.forEach(otherItem => {
                            const otherContent = otherItem.querySelector(
                            '.faq-accordion + div');
                            otherContent.classList.remove('open');
                            otherContent.style.height = '0px';
                        });

                        // Toggle the clicked FAQ
                        if (!isOpen) {
                            content.classList.add('open');
                            content.style.height = content.scrollHeight + 'px';
                        } else {
                            content.classList.remove('open');
                            content.style.height = '0px';
                        }
                    });
                });

                // Search functionality
                const searchInput = document.getElementById('faq-search');
                const faqContainer = document.getElementById('faq-container');
                const noResultsMessage =
                    '<p class="text-center text-sm text-gray-500">{{ __('لا توجد أسئلة مطابقة') }}</p>';

                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.trim().toLowerCase();
                    const faqItems = faqContainer.querySelectorAll('.faq-accordion-area');
                    let hasVisibleItems = false;

                    faqItems.forEach(item => {
                        const question = item.getAttribute('data-question').toLowerCase();
                        const answer = item.getAttribute('data-answer').toLowerCase();

                        // Check if search term is in question or answer
                        if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                            item.style.display = 'block';
                            hasVisibleItems = true;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Show or hide "no results" message
                    const existingNoResults = faqContainer.querySelector('.no-results');
                    if (!hasVisibleItems && searchTerm) {
                        if (!existingNoResults) {
                            const noResultsDiv = document.createElement('div');
                            noResultsDiv.className = 'no-results';
                            noResultsDiv.innerHTML = noResultsMessage;
                            faqContainer.appendChild(noResultsDiv);
                        }
                    } else if (existingNoResults) {
                        existingNoResults.remove();
                    }
                });
            });
    </script>
    <script src="{{ asset('assets/assets/js/faq.js') }}"></script>
    <script defer src="{{ asset('assets/assets/js/index.js') }}"></script>
</body>
@endsection