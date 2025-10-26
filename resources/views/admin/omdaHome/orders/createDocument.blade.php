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
        <h2 class="text-right mb-4 font-bold text-xl">إضافة مستند جديد</h2>
        <form action="{{ route('admin.orders.storeDocument', $order->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            
            <input type="hidden" name="order_type" value="{{ $orderType }}">
@if (($orderType == App\Models\UnpaidTripRequests::class || $orderType == App\Models\TripRegistration::class) &&
isset($order->trip) && $order->trip && $order->trip->id)
<input type="hidden" name="trip_id" value="{{ $order->trip->id }}">
@endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">رقم المستند</label>
                    <input type="text" id="document_number" name="document_number"
                        class="input-field @error('document_number') border-red-500 @enderror"
                        value="{{ old('document_number', $documentNumber) }}" required>
                    @error('document_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">تاريخ المستند</label>
                    <input type="date" id="document_date" name="document_date"
                        class="input-field @error('document_date') border-red-500 @enderror"
                        value="{{ old('document_date', now()->format('Y-m-d')) }}" required>
                    @error('document_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">العنوان</label>
                    <input type="text" id="title" name="title"
                        class="input-field @error('title') border-red-500 @enderror"
                        value="{{ old('title', 'المستند') }}"
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

            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">إضافة ملف (اختياري)</label>
                <input type="file" id="file" name="file" class="input-field @error('file') border-red-500 @enderror"
                    accept=".pdf,.doc,.docx,.jpg,.png">
                @error('file')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-dark px-4 py-2 mt-4 bg-black text-white rounded-md">إضافة</button>
        </form>
    </div>
</div>
@endsection