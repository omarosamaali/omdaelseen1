@extends($layout)

@section('content')
<div class="py-4 text-end" style="margin-top: 30px;">
    <h1 class="text-2xl font-bold mb-4" style="text-align: right; margin-right: 50px;">تفاصيل الرسالة</h1>
    <div class="bg-white shadow-md rounded-lg p-6" style="max-width: 100%; margin: 20px;">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" style="text-align: right;">
            <div>
                <label class="font-bold">الاسم:</label>
                <p>{{ $message->name }}</p>
            </div>
            <div>
                <label class="font-bold">البريد الإلكتروني:</label>
                <p>{{ $message->email }}</p>
            </div>
            <div>
                <label class="font-bold">رقم الهاتف:</label>
                <p>{{ $message->phone ?? 'غير متوفر' }}</p>
            </div>
            <div>
                <label class="font-bold">تاريخ الاستلام:</label>
                <p>{{ $message->receipt_date->format('Y-m-d H:i') }}</p>
            </div>
            <div class="mt-6">
                    <form action="{{ route('admin.contact-messages.update-status', $message->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1" style="direction: ltr; width: 100px;">
            <option value="جديد" {{ $message->status == 'جديد' ? 'selected' : '' }}>جديد</option>
            <option value="تم الرد" {{ $message->status == 'تم الرد' ? 'selected' : '' }}>تم الرد</option>
            <option value="مغلق" {{ $message->status == 'مغلق' ? 'selected' : '' }}>مغلق</option>
        </select>
    </form>
</div>
            <div>
                <label class="font-bold">الحالة:</label>
                <p>
                    @if ($message->status == 'جديد')
                        <span class="text-blue-600">جديد</span>
                    @elseif ($message->status == 'تم الرد')
                        <span class="text-green-600">تم الرد</span>
                    @else
                        <span class="text-red-600">مغلق</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="mt-4">
            <label class="font-bold">الرسالة:</label>
            <p class="mt-2 p-4 bg-gray-100 rounded">{{ $message->message }}</p>
        </div>
        <div class="mt-6">
            <a href="{{ route('admin.contact-messages.index') }}" class="bg-black text-white px-4 py-2 rounded">رجوع</a>
            <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" class="inline-block" onclick="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">حذف</button>
            </form>
        </div>
    </div>
</div>
@endsection