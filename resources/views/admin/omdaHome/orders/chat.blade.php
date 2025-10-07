@extends($layout)

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded p-4" style="margin-top: 50px;">
    <h2 class="text-xl font-bold mb-4">💬 المحادثة بخصوص الطلب رقم {{ $trip->reference_number }}</h2>

    <div class="border rounded p-3 h-96 overflow-y-scroll mb-4 bg-gray-50">
        @foreach($messages as $msg)
        <div class="{{ $msg->is_admin ? 'text-right' : 'text-left' }} mb-3">
            <div
                class="inline-block px-3 py-2 rounded-lg {{ $msg->is_admin ? 'bg-blue-200 text-blue-900' : 'bg-gray-200 text-gray-800' }}">
                <strong>{{ $msg->sender->name }}:</strong> {{ $msg->message }}
            </div>
            <div class="text-xs text-gray-500 mt-1">{{ $msg->created_at->diffForHumans() }}</div>
        </div>
        @endforeach
    </div>

    <form action="{{ route('admin.omdaHome.orders.send', $trip->id) }}" method="POST" class="flex gap-2">
        @csrf
        <input type="text" name="message" class="flex-grow border rounded px-3 py-2" placeholder="اكتب رسالتك..."
            required>
        <button class="bg-blue-600 text-white px-4 py-2 rounded">إرسال</button>
    </form>
</div>
@endsection