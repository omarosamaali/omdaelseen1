@extends('layouts.appOmdahome')

@section('content')
<div class="contact-container">
    <h2 class="contact-title">تواصل معنا</h2>
    <p class="contact-subtitle">املأ النموذج أدناه وسيتم التواصل معك في أقرب وقت ممكن</p>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <form id="contactForm" action="{{ route('contact.submit') }}" method="POST" class="contact-form">
        @csrf
        <div class="form-group">
            <label for="name">الاسم الكامل</label>
            <input type="text" id="name" name="name" required placeholder="أدخل اسمك الكامل" value="{{ old('name') }}">
            <span class="error" id="nameError">@error('name') {{ $message }} @enderror</span>
        </div>

        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" required placeholder="أدخل بريدك الإلكتروني" value="{{ old('email') }}">
            <span class="error" id="emailError">@error('email') {{ $message }} @enderror</span>
        </div>

        <div class="form-group">
            <label for="phone">رقم الهاتف</label>
            <input type="tel" id="phone" name="phone" required placeholder="أدخل رقم هاتفك" value="{{ old('phone') }}">
            <span class="error" id="phoneError">@error('phone') {{ $message }} @enderror</span>
        </div>

        <div class="form-group">
            <label for="message">الرسالة</label>
            <textarea id="message" name="message" required placeholder="اكتب رسالتك هنا">{{ old('message') }}</textarea>
            <span class="error" id="messageError">@error('message') {{ $message }} @enderror</span>
        </div>

        <div class="form-group checkbox-group">
            <label>
                <input type="checkbox" id="accept_terms" name="accept_terms" {{ old('accept_terms') ? 'checked' : '' }} required>
                أوافق على <a href="/terms" target="_blank">الشروط والأحكام</a>
            </label>
            <span class="error" id="termsError">@error('accept_terms') {{ $message }} @enderror</span>
        </div>

        <button type="submit" class="submit-button">إرسال الرسالة</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const messageInput = document.getElementById('message');
    const termsInput = document.getElementById('accept_terms');

    form.addEventListener('submit', function (e) {
        let hasError = false;

        // Reset error messages
        document.querySelectorAll('.error').forEach(error => error.textContent = '');

        // Name validation
        if (!nameInput.value.trim()) {
            document.getElementById('nameError').textContent = 'الاسم مطلوب';
            hasError = true;
        }

        // Email validation
        if (!emailInput.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
            document.getElementById('emailError').textContent = 'البريد الإلكتروني غير صالح';
            hasError = true;
        }

        // Phone validation
        if (!phoneInput.value.trim() || !/^\+?\d{10,15}$/.test(phoneInput.value.replace(/\s/g, ''))) {
            document.getElementById('phoneError').textContent = 'رقم الهاتف غير صالح';
            hasError = true;
        }

        // Message validation
        if (!messageInput.value.trim()) {
            document.getElementById('messageError').textContent = 'الرسالة مطلوبة';
            hasError = true;
        }

        // Terms validation
        if (!termsInput.checked) {
            document.getElementById('termsError').textContent = 'يجب الموافقة على الشروط والأحكام';
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
        }
    });
});
</script>


<style>
.contact-container {
    max-width: 800px;
    margin: 3rem auto;
    padding: 0 1rem;
    text-align: right;
}

.contact-title {
    text-align: center;
    font-size: 1.75rem;
    font-weight: bold;
    color: #071739;
    margin-bottom: 1rem;
}

.contact-subtitle {
    text-align: center;
    font-size: 1rem;
    color: #4b5563;
    margin-bottom: 2rem;
}

.success-message {
    background: #d4edda;
    color: #155724;
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1.5rem;
    text-align: center;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 1rem;
    font-weight: 600;
    color: #071739;
    margin-bottom: 0.5rem;
}

.form-group input,
.form-group textarea {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 1rem;
    color: #333;
    background: #fff;
    direction: rtl;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #071739;
    box-shadow: 0 0 0 3px rgba(7, 23, 57, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.checkboxlamr-group {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.checkbox-group label {
    font-size: 0.875rem;
    color: #4b5563;
}

.checkbox-group a {
    color: #071739;
    text-decoration: underline;
}

.error {
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block; /* Ensure error messages are visible */
}

.submit-button {
    padding: 0.75rem 1.5rem;
    background: #071739;
    color: #fff;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: background 0.3s ease;
}

.submit-button:hover {
    background: #0a2257;
}

@media (max-width: 640px) {
    .contact-container {
        padding: 0 0.5rem;
    }

    .contact-title {
        font-size: 1.5rem;
    }
}
</style>

@endsection