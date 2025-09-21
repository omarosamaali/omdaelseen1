@extends($layout)

@section('content')
<style>
    .input-field {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        text-align: right;
    }
</style>

<div style="display: flex; flex-direction: row-reverse; margin: 0 20px;">
    <div class="container py-4 mx-auto max-w-4xl"
        style="margin-top: 100px; background: white; border-radius: 10px; padding: 20px;">
        <h2 class="text-right mb-4 font-bold text-xl">إنشاء موافقة جديدة</h2>
        <form action="{{ route('admin.orders.storeApproval', $order->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_type" value="{{ $orderType }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">رقم الموافقة</label>
                    <input type="text" id="approval_number" name="approval_number"
                        class="input-field @error('approval_number') border-red-500 @enderror"
                        value="{{ old('approval_number', $approvalNumber) }}" required>
                    @error('approval_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">تاريخ الموافقة</label>
                    <input type="date" id="approval_date" name="approval_date"
                        class="input-field @error('approval_date') border-red-500 @enderror"
                        value="{{ old('approval_date') }}" required>
                    @error('approval_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">العنوان</label>
                    <input type="text" id="title" name="title"
                        class="input-field @error('title') border-red-500 @enderror" value="{{ old('title') }}"
                        required>
                    @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">التفاصيل</label>
                    <textarea rows="4" id="details" name="details"
                        class="input-field @error('details') border-red-500 @enderror"
                        required>{{ old('details') }}</textarea>
                    @error('details')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">إضافة ملف (اختياري)</label>
                    <input type="file" id="file" name="file" class="input-field @error('file') border-red-500 @enderror"
                        accept=".pdf,.doc,.docx,.jpg,.png">
                    @error('file')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-dark px-4 py-2 mt-4 bg-black text-white rounded-md">إنشاء</button>
        </form>
    </div>
</div>
@endsection