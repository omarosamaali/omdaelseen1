<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('حذف الحساب') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته بشكل دائم. قبل حذف حسابك، يرجى تنزيل أي بيانات أو معلومات ترغب في الاحتفاظ بها.') }}
        </p>
    </header>

    <x-danger-button x-data="" style="    z-index: 9999999999999999;
    position: relative;"  x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('حذف الحساب') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('هل أنت متأكد أنك تريد حذف حسابك؟') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته بشكل دائم. يرجى إدخال كلمة المرور الخاصة بك لتأكيد أنك ترغب في حذف حسابك نهائيًا.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('كلمة المرور') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4" placeholder="{{ __('كلمة المرور') }}" />

                <x-input-error messages="البيانات المدخلة غير صحيحة" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('إلغاء') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" >
                    {{ __('حذف الحساب') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

