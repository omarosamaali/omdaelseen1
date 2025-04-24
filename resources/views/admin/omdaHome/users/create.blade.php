@extends($layout)

@section('content')
<div style="display: flex;
    flex-direction: row-reverse;
    margin-right: 77px !important;
    position: relative;
    margin: 0px 20px;
    z-index: 9999999999999;">
    <div style="height: fit-content; background: white; border-radius: 10px; padding: 20px; margin-top: 24px; width: 400px;">
        <div>
            الصلاحية
            <br />
            -
            <br />
            تاريخ التسجيل
            <br />
            -
            <br />
            تاريخ التحديث
            <br />
            -
        </div>
    </div>
    <div class="container py-4 mx-auto max-w-4xl" style="position: relative; right: -50px; margin-top: 24px; background: white; border-radius: 10px; padding: 20px;">
        <h2 class="text-right mb-4 font-bold text-xl">إضافة مستخدم جديد</h2>
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الاسم</label>
                    <input type="text" name="name" class="input-field @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>

                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">رقم الهاتف</label>
                    <input type="text" name="phone" class="input-field @error('phone') border-red-500 @enderror" value="{{ old('phone') }}">
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                    <input type="email" name="email" class="input-field @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الدولة</label>
                    <select name="country" style="direction: ltr;" class="input-field rtl-select @error('country') border-red-500 @enderror" required>

                        <option value="">اختر الدولة</option>
                        @foreach ($countries as $code => $country)
                        <option value="{{ $code }}" {{ old('country') == $code ? 'selected' : '' }}>
                            {{ $country }}</option>
                        @endforeach
                    </select>
                    @error('country')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الصلاحية</label>
                    <select name="role" class="input-field @error('role') border-red-500 @enderror rtl-select">
                        <option value="">اختر</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>مستخدم</option>
                    </select>
                    @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الحالة</label>
                    <select name="status" class="input-field @error('status') border-red-500 @enderror rtl-select">
                        <option value="">اختر</option>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>نشط</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                    @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700" style="z-index: 99999999999999; position: relative;">كلمة المرور</label>
                    <input type="text" name="password" class="input-field @error('password') border-red-500 @enderror" required>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">الصورة الشخصية</label>
                    <input type="file" name="avatar" class="input-field @error('avatar') border-red-500 @enderror">
                    @error('avatar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-dark px-4 py-2 mt-4 bg-black text-white rounded-md">إضافة</button>
        </form>
    </div>
</div>
@endsection
