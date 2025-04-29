@extends('layouts.appOmdahome')

@section('content')
<div class="faq-container">
    <h2 class="faq-title">الأسئلة الشائعة</h2>
    <div class="faq-accordion">
        @foreach($faqs as $index => $faq)
        <div class="faq-item {{ $index === 0 ? 'active' : '' }}">
            <div class="faq-header" id="heading{{ $index }}">
                <button style="font-weight: bold;" class="faq-button" type="button" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" data-target="#collapse{{ $index }}">
                    {{ $faq->question_ar }}
                    <span class="faq-icon" style="font-weight: bold; ">{{ $index === 0 ? '؟' : '؟' }}</span>
                </button>
            </div>
            <div id="collapse{{ $index }}" class="faq-collapse {{ $index === 0 ? 'open' : '' }}" aria-labelledby="heading{{ $index }}">
                <div class="faq-body">
                    {{ $faq->answer_ar }}
                </div>
            </div>
        </div>
        <div style="height: 1px; background-color: #905c65; width: 100%;"></div>
        @endforeach
    </div>
</div>

<style>
.faq-container {
    width: 800px;
    margin: 3rem auto;
    padding: 0 1rem;
}

.faq-title {
    text-align: center;
    font-size: 1.75rem;
    font-weight: bold;
    color: #071739;
    margin-bottom: 2rem;
}

.faq-accordion {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.faq-item {
    border-radius: 0.5rem;
    overflow: hidden;
    background-color: transparent; /* Default background for non-active items */
    transition: background-color 0.3s ease;
}

.faq-item.active {
    background-color: #ffffff; 
    color: green !important;
}

.faq-header {
    width: 100%;
}

.faq-button {
    width: 100%;
    padding: 1rem;
    border: none;
    text-align: right;
    font-size: 1.125rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: transparent;
    transition: color 0.3s ease;
}

.faq-icon {
    font-size: 1.5rem;
}

.faq-collapse {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.faq-collapse.open {
    max-height: 500px; /* Adjust based on content */
}

.faq-body {
    padding: 1rem;
    color: #4b5563;
    font-size: 1rem;
    line-height: 1.5;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const accordionButtons = document.querySelectorAll('.faq-button');

    accordionButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const collapseElement = document.querySelector(targetId);
            const faqItem = collapseElement.closest('.faq-item');
            const isOpen = collapseElement.classList.contains('open');
            const icon = this.querySelector('.faq-icon');

            // Close all accordion items and remove active class
            document.querySelectorAll('.faq-collapse').forEach(collapse => {
                collapse.classList.remove('open');
                collapse.style.maxHeight = '0';
                collapse.closest('.faq-item').classList.remove('active');
            });
            document.querySelectorAll('.faq-icon').forEach(icon => {
                icon.textContent = '؟';
            });

            // Toggle the clicked accordion item
            if (!isOpen) {
                collapseElement.classList.add('open');
                faqItem.classList.add('active');
                collapseElement.style.maxHeight = collapseElement.scrollHeight + 'px';
                icon.textContent = '؟';
            }
        });
    });

    // Ensure the first accordion item is expanded and active by default
    const firstCollapse = document.querySelector('.faq-collapse.open');
    if (firstCollapse) {
        firstCollapse.style.maxHeight = firstCollapse.scrollHeight + 'px';
        firstCollapse.closest('.faq-item').classList.add('active');
    }
});
</script>
@endsection