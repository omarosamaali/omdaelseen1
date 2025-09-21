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
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="p-4 text-end" style="margin-top: 30px;">
    <div style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
        <div style="margin-left: 20px;">
            <a href="{{ route('admin.orders.createApproval', $order->id) }}"
                class="btn btn-dark px-4 py-2 mt-4 bg-black text-white rounded-md">
                موافقة جديدة
            </a>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
            <p>الموافقات</p>
            <div style="display: flex; align-items: center; gap: 10px;">
                <form id="filter-form" action="{{ route('admin.orders.approval', $order->id) }}" method="GET"
                    style="margin: 0; display:flex; gap:10px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث"
                        style="text-align: right; width: 200px; padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 30px; background-color: transparent;">
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
                    <th scope="col" class="th">رقم الموافقة</th>
                    <th scope="col" class="th">رقم المرجع</th>
                    <th scope="col" class="th">التاريخ</th>
                    <th scope="col" class="th">العنوان</th>
                    <th scope="col" class="th">الحالة</th>
                    <th scope="col" class="th">أجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($approvals as $approval)
                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                    <td class="th">{{ $approval->approval_number }}</td>
                    <td class="th">{{ $order->reference_number }}</td>
                    <td class="th">{{ $approval->approval_date }}</td>
                    <td class="th">{{ $approval->title }}</td>
                    <td class="th">{{ $approval->status }}</td>
                    <td class="th" style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.orders.showApproval', $approval->id) }}"
                            class="font-medium text-blue-600">
                            <svg class="w-6 h-6 text-blue-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        <a href="{{ route('admin.orders.editApproval', $approval->id) }}"
                            class="font-medium text-green-600">
                            <i class="fa-solid fa-edit" style="font-size: 18px;"></i>
                        </a>
                        <form action="{{ route('admin.orders.destroyApproval', $approval->id) }}" method="POST"
                            style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الموافقة؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600">
                                <i class="fa-solid fa-trash" style="font-size: 18px;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection