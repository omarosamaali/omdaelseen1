@extends('layouts.mobile')
@section('title', 'تعديل المستخدم | Edit User')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/assets/css/edit-user.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<x-china-header :title="__('messages.المستخدمين')" :route="route('mobile.admin.users.index')" />

<body>
    <div style="padding-top: 70px;" class="container min-h-dvh relative overflow-hidden py-8 px-6 dark:text-white dark:bg-color1">
        <form action="{{ route('mobile.admin.users.update', $userad->id) }}" method="POST" enctype="multipart/form-data"
            class="relative z-20">
            @csrf
            @method('PUT')

            <div class="flex justify-center items-end gap-8">
                <div class="relative size-40 flex justify-center items-center" style="min-width: 132px;">
                    <img src="{{ $userad->avatar ? asset('storage/' . $userad->avatar) : asset('assets/assets/images/default.jpg') }}" alt=""
                        class="bg-[#B190B6] rounded-full overflow-hidden edit-img" id="user-avatar" />
                    @php
                    $src = '';
                    if ($userad->status == 1) {
                    $src = asset('assets/assets/images/user-progress-green.svg');
                    } elseif ($userad->status == 0) {
                    $src = asset('assets/assets/images/user-progress.svg');
                    } elseif ($userad->status == 2) {
                    $src = asset('assets/assets/images/user-progress-black.svg');
                    } elseif ($userad->status == 3) {
                    $src = asset('assets/assets/images/user-progress-red.svg');
                    }
                    @endphp
                    <img src="{{ $src }}" alt="" style="top: 14px;" class="absolute left-0 right-0" />
                    <label for="avatar-input" class="edit-icon cursor-pointer" style="position: absolute;">
                        <svg width="30" height="30" fill="#ffffff" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 640 640">
                            <path
                                d="M535.6 85.7C513.7 63.8 478.3 63.8 456.4 85.7L432 110.1L529.9 208L554.3 183.6C576.2 161.7 576.2 126.3 554.3 104.4L535.6 85.7zM236.4 305.7C230.3 311.8 225.6 319.3 222.9 327.6L193.3 416.4C190.4 425 192.7 434.5 199.1 441C205.5 447.5 215 449.7 223.7 446.8L312.5 417.2C320.7 414.5 328.2 409.8 334.4 403.7L496 241.9L398.1 144L236.4 305.7zM160 128C107 128 64 171 64 224L64 480C64 533 107 576 160 576L416 576C469 576 512 533 512 480L512 384C512 366.3 497.7 352 480 352C462.3 352 448 366.3 448 384L448 480C448 497.7 433.7 512 416 512L160 512C142.3 512 128 497.7 128 480L128 224C128 206.3 142.3 192 160 192L256 192C273.7 192 288 177.7 288 160C288 142.3 273.7 128 256 128L160 128z" />
                        </svg>
                    </label>
                    <input type="file" name="avatar" id="avatar-input" class="hidden" onchange="previewAvatar(event)" />
                </div>
            </div>

            <div class="bg-white py-8 px-6 rounded-xl mt-6 dark:bg-color10">
                <div>
                    <p class="text-sm font-semibold pb-2">الإسم</p>
                    <div
                        class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                        <input name="name" value="{{ old('name', $userad->name) }}" type="text" placeholder="الإسم"
                            class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                        <i class="ph ph-user text-xl text-bgColor18 !leading-none"></i>
                    </div>
                </div>

                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">البريد الإلكتروني</p>
                    <div
                        class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                        <input name="email" value="{{ old('email', $userad->email) }}" type="email"
                            placeholder="أدخل البريد الإلكتروني"
                            class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                        <i class="ph ph-envelope-simple text-xl text-bgColor18 !leading-none"></i>
                    </div>
                </div>

                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">رقم الهاتف</p>
                    <div
                        class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                        <input name="phone" value="{{ old('phone', $userad->phone) }}" type="text"
                            placeholder="رقم الهاتف المحترك"
                            class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                        <i class="ph ph-phone text-xl text-bgColor18 !leading-none"></i>
                    </div>
                </div>

                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">الدولة</p>
                    <div
                        class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                        <select name="country" id="country" style="direction: ltr;"
                            class="input-field rtl-select @error('country') border-red-500 @enderror" required>
                            <option value="">اختر الدولة</option>
                            @foreach ($countries as $code => $country)
                            <option value="{{ $code }}" {{ old('country', $userad->country) == $code ? 'selected' : ''
                                }}>
                                {{ $country }}
                            </option>
                            @endforeach
                        </select>
                        @error('country')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2"> الحالة</p>
                    <div
                        class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                        <select name="status"
                            class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18">
                            <option value="1" {{ old('status', $userad->status) == 1 ? 'selected' : '' }}>فعال
                            </option>
                            <option value="0" {{ old('status', $userad->status) == 0 ? 'selected' : '' }}>غير فعال
                            </option>
                            <option value="2" {{ old('status', $userad->status) == 2 ? 'selected' : '' }}>محظور
                            </option>
                            <option value="3" {{ old('status', $userad->status) == 3 ? 'selected' : '' }}>ملغي
                            </option>
                        </select>
                    </div>
                </div>

                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">إسم المستكشف</p>
                    <div
                        class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                        <input type="text" name="explorer_name"
                            value="{{ old('explorer_name', $userad->explorer_name) }}"
                            class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18" />
                        <i class="fa fa-location-dot text-xl text-bgColor18 !leading-none"></i>
                    </div>
                </div>

                <div class="pt-4">
                    <span style="color: red; font-size: 12px;">إتركه فارغ إذا لا تريد تغييره</span>
                    <p class="text-sm font-semibold pb-2">كلمة المرور</p>
                    <div
                        class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                        <input name="password" type="password" placeholder="*****"
                            class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18 passwordField" />
                        <i
                            class="ph ph-eye-slash text-xl text-bgColor18 !leading-none passowordShow cursor-pointer dark:text-color18"></i>
                    </div>
                </div>

                <div class="pt-4">
                    <p class="text-sm font-semibold pb-2">تأكيد كلمة المرور</p>
                    <div
                        class="flex justify-between items-center py-3 px-4 border border-color21 rounded-xl dark:border-color18 gap-3">
                        <input name="password_confirmation" type="password" placeholder="*****"
                            class="outline-none bg-transparent text-n600 text-sm placeholder:text-sm w-full placeholder:text-bgColor18 dark:text-color18 dark:placeholder:text-color18 confirmPasswordField" />
                        <i
                            class="ph ph-eye-slash text-xl text-bgColor18 !leading-none confirmPasswordShow cursor-pointer dark:text-color18"></i>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full mt-6 bg-p2 rounded-full py-3 text-white text-sm font-semibold text-center block dark:bg-p1">
                تعديل
            </button>
        </form>

        <form id="delete-form" action="{{ route('mobile.admin.users.destroy', $userad->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" onclick="confirmDelete()"
                style="width: 100%; margin-top: 20px; background-color: red;"
                class="rounded-full py-3 text-white text-sm font-semibold text-center block dark:bg-p1">
                حذف الحساب
            </button>
        </form>
    </div>

    <script>
        function confirmDelete() {
                Swal.fire({
                    title: "هل أنت متأكد؟",
                    text: "لا يمكنك التراجع عن هذا الإجراء!",
                    icon: "warning",
                    input: 'text',
                    inputPlaceholder: 'اكتب "Delete" للتأكيد',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "نعم، احذفه!",
                    cancelButtonText: "إلغاء",
                    inputValidator: (value) => {
                        if (value !== 'Delete') {
                            return 'يجب أن تكتب كلمة "Delete" للحذف!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form').submit();
                    }
                });
            }

            function previewAvatar(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    const output = document.getElementById('user-avatar');
                    output.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
    </script>
</body>
@endsection