<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('معلومات الحساب') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('قم بتحديث معلومات حسابك وبريدك الإلكتروني.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
            enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">{{ __('الصورة الشخصية') }}</label>
<div class="mt-2">
    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'data:image/png;base64,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' }}" alt="Avatar" class="h-20 w-20 rounded-full object-cover border">
</div>
</div><div>
    <x-input-label for="avatar" :value="__('تغيير الصورة الشخصية')" />
    <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" />
    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
</div>


        <div>
            
            <x-input-label for="name" :value="__('الاسم')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" autofocus autocomplete="name" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
            <x-text-input disabled id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('بريدك الإلكتروني غير مفعل.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('اضغط هنا لإعادة إرسال رسالة التحقق.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('تم إرسال رابط تحقق جديد إلى بريدك الإلكتروني.') }}
                </p>
                @endif
            </div>
            @endif
        </div>
<div class="phone-input-container">
    <label for="phone">رقم الهاتف</label>
    <div class="phone-input-wrapper">
        <!-- International code field -->
        <input type="text" id="country_code" name="country_code" placeholder="+XXX" 
               style="width: 80px; text-align: center; border-radius: 5px 0 0 5px;" 
               value="+20" />
        
        <!-- Main phone number field -->
        <input type="text" id="phone" name="phone" placeholder="XXXXXXXXXX" 
               style="flex: 1; border-radius: 0 5px 5px 0; border-right: none;" 
               value="1016934863" />
    </div>
    <span class="error-message" id="phone-error"></span>
</div>

<style>
    .phone-input-wrapper {
        display: flex;
        direction: ltr;
        margin-top: 5px;
    }
    
    .phone-input-wrapper input {
        padding: 8px 12px;
        border: 1px solid #ccc;
        outline: none;
    }
    
    .phone-input-wrapper input:focus {
        border-color: #3b82f6;
    }
    
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 5px;
        display: block;
    }
</style>

        <div style="">
            <x-input-label for="country" :value="__('الدولة')" />
            <div class="custom-select" style="z-index: 1; position: relative; width: 100%;">
                <input aria-autocomplete="off" autocomplete="new-country" type="text" id="country_search" name="country_search_fake" style="text-align: center; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem;" placeholder="إختر الدولة" required>


                <div id="country_dropdown" style="display: none; z-index: 1; position: absolute; top: 100%; left: 0; width: 100%; max-height: 200px; overflow-y: auto; background: white; border: 1px solid #d1d5db; border-radius: 0.375rem; z-index: 1000;">

                    @foreach ($countries as $code => $name)
                    <div class="country-option" data-value="{{ $code }}" style="padding: 0.5rem; cursor: pointer; text-align: center;">
                        {{ $name }}</div>
                    @endforeach
                </div>
            </div>
            <!-- حقل مخفي لإرسال القيمة للـ backend -->
            <input type="hidden" name="country" id="country_value">

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('country_search');
                const dropdown = document.getElementById('country_dropdown');
                const options = document.querySelectorAll('.country-option');
                const hiddenInput = document.getElementById('country_value');

                // فتح القايمة لما تضغط على حقل البحث
                searchInput.addEventListener('focus', function() {
                    dropdown.style.display = 'block';
                });

                // فلترة الخيارات بناءً على البحث
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.trim().toLowerCase();

                    options.forEach(option => {
                        const countryName = option.textContent.toLowerCase();
                        if (countryName.includes(searchTerm) || searchTerm === '') {
                            option.style.display = '';
                        } else {
                            option.style.display = 'none';
                        }
                    });
                });

                // اختيار دولة من القايمة
                options.forEach(option => {
                    option.addEventListener('click', function() {
                        searchInput.value = this.textContent;
                        hiddenInput.value = this.getAttribute('data-value');
                        dropdown.style.display = 'none';
                    });
                });

                // إغلاق القايمة لما تضغط برا
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.style.display = 'none';
                    }
                });
            });

        </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('country_search');
        const dropdown = document.getElementById('country_dropdown');
        const options = document.querySelectorAll('.country-option');
        const hiddenInput = document.getElementById('country_value');

        // Initialize the selected country
        const userCountry = "{{ $user->country }}";
        if (userCountry) {
            hiddenInput.value = userCountry;
            // Find the country name that matches the code
            options.forEach(option => {
                if (option.getAttribute('data-value') === userCountry) {
                    searchInput.value = option.textContent.trim();
                }
            });
        }

        // Rest of your existing code...
        // ...
    });

</script>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('حفظ') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('تم الحفظ.') }}</p>
            @endif
        </div>
    </form>
</section>
