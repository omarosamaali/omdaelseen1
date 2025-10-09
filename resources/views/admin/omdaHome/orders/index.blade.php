@extends($layout)

@section('content')
<style>
    .th {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
        text-align: right;
    }

    .input-field {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        text-align: right;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="p-4 text-end" style="margin-top: 30px;">
    <div style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
        <div style="margin-left: 20px;">
            <a href="{{ route('admin.orders.create') }}"
                class="btn btn-dark px-4 py-2 mt-4 bg-black text-white rounded-md">
                طلب جديد
            </a>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
            <p>الطلبات</p>
            <div style="display: flex; align-items: center; gap: 10px;">
                <form id="filter-form" action="{{ route('admin.orders.index') }}" method="GET"
                    style="margin: 0; display:flex; gap:10px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث"
                        class="input-field" style="width: 200px;">
                    <select name="status" class="input-field" style="text-align: center;" onchange="this.form.submit()">
                        <option value="">جميع الحالات</option>
                        <option value="في المراجعة" {{ request('status')=='في المراجعة' ? 'selected' : '' }}>في المراجعة
                        </option>
                        <option value="بإنتظار الدفع" {{ request('status')=='بإنتظار الدفع' ? 'selected' : '' }}>بإنتظار
                            الدفع</option>
                        <option value="بإنتظار مستندات" {{ request('status')=='بإنتظار مستندات' ? 'selected' : '' }}>
                            بإنتظار مستندات</option>
                        <option value="تحت الإجراء" {{ request('status')=='تحت الإجراء' ? 'selected' : '' }}>تحت الإجراء
                        </option>
                        <option value="ملغي" {{ request('status')=='ملغي' ? 'selected' : '' }}>ملغي</option>
                        <option value="مكرر" {{ request('status')=='مكرر' ? 'selected' : '' }}>مكرر</option>
                        <option value="منتهي" {{ request('status')=='منتهي' ? 'selected' : '' }}>منتهي</option>
                        <option value="تحتاج لموافقة" {{ request('status')=='تحتاج لموافقة' ? 'selected' : '' }}>تحتاج
                            لموافقة</option>
                        <option value="التجهيز للشحن" {{ old('status')=='التجهيز للشحن' ? 'selected' : '' }}>التجهيز
                            للشحن</option>
                        <option value="تم الشحن" {{ old('status')=='تم الشحن' ? 'selected' : '' }}>تم الشحن</option>
                        <option value="تم الاستلام في الصين" {{ request('status')=='تم الاستلام في الصين' ? 'selected'
                            : '' }}>تم الاستلام في الصين</option>
                        <option value="تم الاستلام بالامارات" {{ request('status')=='تم الاستلام بالامارات' ? 'selected'
                            : '' }}>تم الاستلام بالامارات</option>
                        <option value="تم الاستلام من قبل العميل" {{ request('status')=='تم الاستلام من قبل العميل'
                            ? 'selected' : '' }}>تم الاستلام من قبل العميل</option>
                    </select>
                    <button type="submit" style="display:none"></button>
                </form>
            </div>
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
        <table id="explorers_table" class="w-full text-sm text-left rtl:text-right text-gray-500"
            style="background: #c9c9c9;">
            <thead class="text-xs text-gray-700 uppercase">
                <tr>
                    <th scope="col" class="th">رقم المرجع</th>
                    <th scope="col" class="th">التاريخ والوقت</th>
                    <th scope="col" class="th">نوع الطلب</th>
                    <th scope="col" class="th">العنوان</th>
                    <th scope="col" class="th">العميل</th>
                    <th scope="col" class="th">حالة</th>
                    <th scope="col" class="th">أجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $trip)
                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                    <td class="th">{{ $trip->order_number }}</td>
                    <td class="th">{{ $trip->created_at }}</td>
                    <td class="th">رحلة</td>
                    <td class="th">رحلة خاصة</td>
                    <td class="th">{{ $trip->user->name }}</td>
                    <td class="th status-cell" data-id="{{ $trip->id }}">{{ $trip->payment_status == 'paid' ? 'مدفوعة' :
                        'غير مدفوعة' }}</td>
                    <td class="th" style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.orders.bookingShow', $trip->id) }}" class="font-medium text-green-600">
                            <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        <button onclick="showClientData({{ json_encode($trip->user) }})"
                            class="font-medium text-blue-600">
                            <i class="fa-regular fa-id-badge" style="font-size: 18px;"></i>
                        </button>
                        <a href="{{ route('admin.orders.invoice', $trip->id) }}" class="text-yellow-600">
                            <i class="fa-solid fa-file-invoice" style="font-size: 18px;"></i>
                        </a>
                        <a href="{{ route('admin.orders.document', $trip->id) }}" class="text-purple-600">
                            <i class="fa-regular fa-folder-open" style="font-size: 18px;"></i>
                        </a>
                        <a href="{{ route('admin.orders.shippingNote', $trip->id) }}" class="text-orange-600">
                            <i class="fa-solid fa-truck" style="font-size: 18px;"></i>
                        </a>
                        <a href="{{ route('admin.orders.approval', $trip->id) }}" class="text-green-600">
                            <i class="fa-solid fa-check-circle" style="font-size: 18px;"></i>
                        </a>
                        <button class="text-indigo-600">
                            <i class="fa-regular fa-envelope" style="font-size: 18px;"></i>
                        </button>
                        <button
                            onclick="showStatusModal('{{ $trip->id }}', 'App\\Models\\TripRequest', '{{ $trip->status }}')"
                            class="text-red-600">
                            <i class="fa-solid fa-pen-to-square" style="font-size: 18px;"></i>
                        </button>
                        <a href="{{ route('admin.orders.note', $trip->id) }}" class="text-blue-600">
                            <i class="fa-solid fa-sticky-note" style="font-size: 18px;"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                @foreach ($trip_requests as $trip)
                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                    <td class="th">{{ $trip->reference_number }}</td>
                    <td class="th">{{ $trip->created_at }}</td>
                    <td class="th">رحلة</td>
                    <td class="th">رحلة خاصة</td>
                    <td class="th">{{ $trip->user->name }}</td>
                    <td class="th status-cell" data-id="{{ $trip->id }}">{{ $trip->status }}</td>
                    <td class="th" style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.orders.show', $trip->id) }}" class="font-medium text-green-600">
                            <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        <button onclick="showClientData({{ json_encode($trip->user) }})"
                            class="font-medium text-blue-600">
                            <i class="fa-regular fa-id-badge" style="font-size: 18px;"></i>
                        </button>
                        <a href="{{ route('admin.orders.invoice', $trip->id) }}" class="text-yellow-600">
                            <i class="fa-solid fa-file-invoice" style="font-size: 18px;"></i>
                        </a>
                        <a href="{{ route('admin.orders.document', $trip->id) }}" class="text-purple-600">
                            <i class="fa-regular fa-folder-open" style="font-size: 18px;"></i>
                        </a>
                        <a href="{{ route('admin.orders.shippingNote', $trip->id) }}" class="text-orange-600">
                            <i class="fa-solid fa-truck" style="font-size: 18px;"></i>
                        </a>
                        <a href="{{ route('admin.orders.approval', $trip->id) }}" class="text-green-600">
                            <i class="fa-solid fa-check-circle" style="font-size: 18px;"></i>
                        </a>
                        <a href="{{ route('mobile.profile.actions.userAdminChatTrip', $trip->id) }}"
                            class="text-indigo-600">
                            <i class="fa-regular fa-envelope" style="font-size: 18px;"></i>
                        </a>
                        <button
                            onclick="showStatusModal('{{ $trip->id }}', 'App\\Models\\TripRequest', '{{ $trip->status }}')"
                            class="text-red-600">
                            <i class="fa-solid fa-pen-to-square" style="font-size: 18px;"></i>
                        </button>
                        <a href="{{ route('admin.orders.note', $trip->id) }}" class="text-blue-600">
                            <i class="fa-solid fa-sticky-note" style="font-size: 18px;"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                @foreach ($products as $trip)
                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                    <td class="th">{{ $trip->reference_number }}</td>
                    <td class="th">{{ $trip->created_at }}</td>
                    <td class="th">منتج خاص</td>
                    <td class="th">منتجات</td>
                    <td class="th">{{ $trip->user->name }}</td>
                    <td class="th status-cell" data-id="{{ $trip->id }}">{{ $trip->status }}</td>
                    <td class="th" style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.orders.show-product', $trip->id) }}"
                            class="font-medium text-green-600">
                            <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        <button onclick="showClientData({{ json_encode($trip->user) }})"
                            class="font-medium text-blue-600">
                            <i class="fa-regular fa-id-badge" style="font-size: 18px;"></i>
                        </button>
                        <a href="{{ route('admin.orders.invoice', $trip->id) }}" class="text-yellow-600">
                            <i class="fa-solid fa-file-invoice" style="font-size: 18px;"></i>
                        </a>
                        <a href="{{ route('admin.orders.document', $trip->id) }}" class="text-purple-600">
                            <i class="fa-regular fa-folder-open" style="font-size: 18px;"></i>
                        </a>
                        <a href="{{ route('admin.orders.shippingNote', $trip->id) }}" class="text-orange-600">
                            <i class="fa-solid fa-truck" style="font-size: 18px;"></i>
                        </a>
                        <a href="{{ route('admin.orders.approval', $trip->id) }}" class="text-green-600">
                            <i class="fa-solid fa-check-circle" style="font-size: 18px;"></i>
                        </a>
                        <a href="{{ route('mobile.profile.actions.userAdminChat', $trip->id) }}"
                            class="text-indigo-600">
                            <i class="fa-regular fa-envelope" style="font-size: 18px;"></i>
                        </a>
                        <button
                            onclick="showStatusModal('{{ $trip->id }}', 'App\\Models\\Product', '{{ $trip->status }}')"
                            class="text-red-600">
                            <i class="fa-solid fa-pen-to-square" style="font-size: 18px;"></i>
                        </button>
                        <a href="{{ route('admin.orders.note', $trip->id) }}" class="text-blue-600">
                            <i class="fa-solid fa-sticky-note" style="font-size: 18px;"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Client Modal -->
<div id="clientModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex justify-center items-center"
    style="z-index: 9999999;">
    <div class="bg-white rounded-lg p-6 w-96">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-lg font-semibold text-gray-900">بيانات العميل</h3>
            <button onclick="document.getElementById('clientModal').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div class="mt-4 text-gray-700">
            <div style="display: flex; align-items: center; gap: 10px;">
                <p><img id="clientAvatar" src="" alt="Avatar" class="user-avatar mb-4"></p>
                <p><span id="clientName"></span></p>
            </div>
            <p><strong>الدولة:</strong> <span id="clientCountry"></span></p>
            <p><strong>عدد الأماكن:</strong> <span id="clientPlaces"></span></p>
            <p><strong>عدد الطلبات:</strong> <span id="clientTrips"></span></p>
            <p><strong>عدد المتابعين:</strong> <span id="clientFollowers"></span></p>
            <p><strong>الحالة:</strong> <span id="clientStatus"></span></p>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex justify-center items-center"
    style="z-index: 9999999;">
    <div class="bg-white rounded-lg p-6 w-96">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-lg font-semibold text-gray-900">إجراء الحالة</h3>
            <button onclick="document.getElementById('statusModal').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <form id="statusForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="order_type" id="orderType">
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">الحالة</label>
                <select name="status" id="statusSelect" style="text-align: center !important;"
                    class="!text-center input-field" required>
                    <option value="">اختر الحالة</option>
                    <option value="في المراجعة">في المراجعة</option>
                    <option value="بإنتظار الدفع">بإنتظار الدفع</option>
                    <option value="بإنتظار مستندات">بإنتظار مستندات</option>
                    <option value="تحت الإجراء">تحت الإجراء</option>
                    <option value="ملغي">ملغي</option>
                    <option value="مكرر">مكرر</option>
                    <option value="منتهي">منتهي</option>
                    <option value="تم الاستلام في الصين">تم الاستلام في الصين</option>
                    <option value="تم الاستلام بالامارات">تم الاستلام بالامارات</option>
                    <option value="تم الاستلام من قبل العميل">تم الاستلام من قبل العميل</option>
                </select>
            </div>
            <div class="mt-4 flex justify-end gap-4">
                <button type="button" onclick="document.getElementById('statusModal').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">إلغاء</button>
                <button type="submit" class="px-4 py-2 bg-black text-white rounded-md">تحديث</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showClientData(client) {
        document.getElementById('clientModal').classList.remove('hidden');
        document.getElementById('clientAvatar').src = client.avatar ? '/storage/' + client.avatar : 'https://via.placeholder.com/70';
        document.getElementById('clientName').innerText = client.name || 'غير متاح';
        document.getElementById('clientCountry').innerText = client.country ? client.country : 'غير متاح';
        document.getElementById('clientPlaces').innerText = client.places_count ?? 0;
        document.getElementById('clientTrips').innerText = client.trip_requests_count ?? 0;
        document.getElementById('clientFollowers').innerText = client.followers_count ?? 0;
        document.getElementById('clientStatus').innerText = client.status == '1' ? 'فعال' : 'غير فعال';
    }

    function showStatusModal(id, orderType, currentStatus) {
        document.getElementById('statusModal').classList.remove('hidden');
        document.getElementById('orderType').value = orderType;
        document.getElementById('statusSelect').value = currentStatus;
        document.getElementById('statusForm').action = `/admin/orders/status/${id}`;
    }

    document.getElementById('statusForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST', // Laravel expects POST for _method=PUT
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('statusModal').classList.add('hidden');
                const statusCell = document.querySelector(`td.status-cell[data-id="${form.action.split('/').pop()}"]`);
                statusCell.innerText = formData.get('status');
                alert(data.success);
            } else {
                alert('حدث خطأ أثناء تحديث الحالة');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تحديث الحالة');
        });
    });
</script>
@endsection