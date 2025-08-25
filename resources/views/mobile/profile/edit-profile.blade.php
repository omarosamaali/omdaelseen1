@extends('layouts.mobile')

@section('title', 'تعديل الحساب | Edit Profile')

@section('content')
<div class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">
    <div class="absolute top-0 left-0 bg-p3 blur-[145px] h-[174px] w-[149px]"></div>
    <div class="absolute top-40 right-0 bg-[#0ABAC9] blur-[150px] h-[174px] w-[91px]"></div>
    <div class="absolute top-80 right-40 bg-p2 blur-[235px] h-[205px] w-[176px]"></div>
    <div class="absolute bottom-0 right-0 bg-p3 blur-[220px] h-[174px] w-[149px]"></div>
    <div class="flex justify-start items-center relative z-10">
        <div class="logo-register">
            <img src="{{ asset('assets/assets/images/logo-all.png') }}" class="image-regsiter" alt="">
        </div>
        <x-back-button href="{{ route('mobile.profile.profile') }}" />
    </div>

    @if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-xl my-4 text-center">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-500 text-white p-4 rounded-xl my-4 text-center">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('mobile.profile.update') }}" method="POST" class="relative z-20" enctype="multipart/form-data">
        @csrf
        <div class="flex justify-center items-end gap-8">
            <div class="relative size-40 flex justify-center items-center" style="min-width: 132px;">
                <label for="avatar_input" class="cursor-pointer">
                    @if(Auth::user()->avatar)
                    <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="User Avatar" class="bg-[#B190B6] rounded-full overflow-hidden edit-img" />
                    @else
                    <img src="https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg?t=st=1755956485~exp=1755960085~hmac=237ad4a2dca4c1c8b053fc5bf4abbc25b225c8142b452c30501fb28ac00abc5e&w=740" alt="Default Avatar" class="bg-[#B190B6] rounded-full overflow-hidden edit-img" />
                    @endif
                    <span class="container--avatar">
                        <i style="top: 2px; justify-content: center; display: flex; z-index: 9999; position: relative;" class="ph ph-camera text-xl text-bgColor18"></i>
                    </span>
                </label>

                <input type="file" id="avatar_input" name="avatar" class="hidden">
            </div>
        </div>
        <div class="bg-white py-8 px-6 rounded-xl mt-12 dark:bg-color10">
            <div>
                <p class="text-sm font-semibold pb-2">الإسم</p>
                <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input name="name" value="{{ old('name', Auth::user()->name) }}" type="text" placeholder="الإسم" class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                    <i class="ph ph-user text-xl text-bgColor18 !leading-none"></i>
                </div>
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">البريد الإلكتروني</p>
                <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input name="email" value="{{ old('email', Auth::user()->email) }}" type="email" placeholder="أدخل البريد الإلكتروني" class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                    <i class="ph ph-envelope-simple text-xl text-bgColor18 !leading-none"></i>
                </div>
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">رقم الهاتف</p>
                <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input name="phone" value="{{ old('phone', Auth::user()->phone) }}" type="text" placeholder="رقم الهاتف المحترك" class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                    <i class="ph ph-phone text-xl text-bgColor18 !leading-none"></i>
                </div>
                @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">الدولة</p>
                <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <select name="country" class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18">
                        <option value="">اختر الدولة</option>
                        @foreach (__('countries') as $code => $name)
                        <option value="{{ $code }}" {{ old('country', Auth::user()->country) == $code ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @error('country') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>


            <div class="pt-4">
                <span style="color: red; font-size: 12px;">إتركه فارغ إذا لا تريد تغييره</span>
                <p class="text-sm font-semibold pb-2">كلمة المرور</p>
                <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input name="password" type="password" placeholder="*****" class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 
                    dark:text-color18 dark:placeholder:text-color18 passwordField" />
                    <i class="ph ph-eye-slash text-xl text-bgColor18 !leading-none passowordShow cursor-pointer dark:text-color18"></i>
                </div>
                @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4">
                <p class="text-sm font-semibold pb-2">تأكيد كلمة المرور</p>
                <div class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                    <input name="password_confirmation" type="password" placeholder="*****" class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18 confirmPasswordField" />
                    <i class="ph ph-eye-slash text-xl text-bgColor18 !leading-none confirmPasswordShow cursor-pointer dark:text-color18"></i>
                </div>
            </div>
        </div>

        <button type="submit" class="bg-p2 rounded-full py-3 text-white text-sm font-semibold text-center block mt-12 dark:bg-p1 w-full">تعديل</button>
    </form>

    <form id="delete-form" action="{{ route('mobile.profile.delete-account') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="button" onclick="showDeleteAlert()" style="width: 100%; margin-top: 20px; background-color: red;" class="rounded-full py-3 text-white text-sm font-semibold text-center block dark:bg-p1">
            حذف الحساب
        </button>
    </form>

    <script>
        function showDeleteAlert() {
            Swal.fire({
                title: 'هل أنت متأكد؟'
                , text: "لن تستطيع التراجع عن هذا الإجراء!"
                , icon: 'warning',
                // هذا هو الجزء الجديد الذي يضيف حقل الإدخال
                input: 'text'
                , inputPlaceholder: 'اكتب "Delete" للتأكيد'
                , showCancelButton: true
                , confirmButtonColor: '#d33'
                , cancelButtonColor: '#3085d6'
                , confirmButtonText: 'نعم، احذف الحساب!'
                , cancelButtonText: 'إلغاء'
                , reverseButtons: true,
                // هذا الجزء يتحقق من القيمة المدخلة
                preConfirm: (inputValue) => {
                    if (inputValue !== 'Delete') {
                        Swal.showValidationMessage(
                            `الرجاء كتابة "Delete" بشكل صحيح.`
                        );
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if the user confirms
                    document.getElementById('delete-form').submit();
                }
            });
        }

    </script>
</div>
@endsection
