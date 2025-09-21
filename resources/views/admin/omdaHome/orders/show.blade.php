@extends($layout)

@section('content')
<style>
    .info-label {
        font-weight: bold;
        color: #374151;
        /* Dark gray */
        margin-bottom: 0.5rem;
    }

    .info-value {
        color: #6b7280;
        /* Medium gray */
        margin-bottom: 1rem;
    }

    .user-avatar {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        /* Circular avatar */
        border: 3px solid #e5e7eb;
        /* Light gray border */
    }

    /* Styles for the new trip request cards */
    .trip-card {
        background-color: white;
        border-radius: 0.5rem;
        /* 8px */
        padding: 1rem;
        /* 16px */
        margin-bottom: 1rem;
        /* 16px */
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: box-shadow 0.2s ease-in-out;
    }

    .trip-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        /* 4px 12px */
        border-radius: 9999px;
        /* Pill shape */
        font-size: 0.75rem;
        /* 12px */
        font-weight: 500;
    }
</style>

<div class="container mx-auto py-8 px-4">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <div class="lg:col-span-1 bg-white rounded-lg shadow-md p-6 text-center">
            <h2 class="text-xl font-bold mb-4 text-gray-800">بيانات العميل</h2>
            <div class="flex flex-col items-center">
                @if($trip_request->user && $trip_request->user->avatar)
                <img src="{{ asset('storage/' . $trip_request->user->avatar) }}" alt="{{ $trip_request->user->name }}"
                    class="user-avatar mb-4">
                @else
                <div class="user-avatar mb-4 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">لا توجد صورة</span>
                </div>
                @endif
                <div class="info-label">اسم العميل</div>
                <div class="info-value text-lg font-semibold">{{ $trip_request->user->name ?? '-' }}</div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">تفاصيل الطلب الحالي</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="info-label">رقم المرجع</div>
                    <div class="info-value font-mono">{{ $trip_request->reference_number ?? '-' }}</div>
                </div>
                <div>
                    <div class="info-label">الحالة</div>
                    <div class="info-value">
                        <span class="status-badge bg-green-100 text-green-800">
                            {{ $trip_request->status }}
                        </span>
                    </div>
                </div>
                <div>
                    <div class="info-label">عدد المسافرين</div>
                    <div class="info-value">{{ $trip_request->travelers_count ?? 0 }}</div>
                </div>
                <div>
                    <div class="info-label">تاريخ الإضافة</div>
                    <div class="info-value">{{ $trip_request->created_at ? $trip_request->created_at->format('Y-m-d
                        H:i') : '-' }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">تفاصيل الطلب الحالي</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="info-label">نوع الطلب</div>
                <div class="info-value font-mono">رحلة</div>
            </div>
            <div>
                <div class="info-label">العنوان</div>
                <div class="info-value">
                    <span class="status-badge bg-green-100 text-green-800">
                        رحلة خاصة
                    </span>
                </div>
            </div>
            <div>
                <div class="info-label">عدد الأماكن</div>
                <div class="info-value">{{ $places_count ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="mt-8 flex justify-start">
        <a href="{{ route('admin.orders.index') }}"
            class="px-5 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">العودة إلى القائمة</a>
    </div>

</div>
@endsection