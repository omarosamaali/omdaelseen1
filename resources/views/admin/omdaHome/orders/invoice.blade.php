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
            <a href="{{ route('admin.orders.createInvoice', $order->id) }}"
                class="btn btn-dark px-4 py-2 mt-4 bg-black text-white rounded-md">
                فاتورة جديدة
            </a>
        </div>
        <div style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
            <p>الفواتير</p>
            <div style="display: flex; align-items: center; gap: 10px;">
                <form id="filter-form" action="{{ route('admin.orders.invoice', $order->id) }}" method="GET"
                    style="margin: 0; display:flex; gap:10px;">
                    <select name="status" id="status-filter" onchange="this.form.submit()"
                        style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 30px; background-color: transparent; text-align: center;">
                        <option value="">جميع الحالات</option>
                        <option value="مدفوعة" {{ request('status')=='مدفوعة' ? 'selected' : '' }}>مدفوعة</option>
                        <option value="غير مدفوعة" {{ request('status')=='غير مدفوعة' ? 'selected' : '' }}>غير مدفوعة
                        </option>
                        <option value="ملغية" {{ request('status')=='ملغية' ? 'selected' : '' }}>ملغية</option>
                    </select>
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
                    <th scope="col" class="th">رقم الفاتورة</th>
                    <th scope="col" class="th">رقم المرجع</th>
                    <th scope="col" class="th">التاريخ والوقت</th>
                    <th scope="col" class="th">العنوان</th>
                    <th scope="col" class="th">المبلغ</th>
                    <th scope="col" class="th">تاريخ ووقت الدفع</th>
                    <th scope="col" class="th">حالة</th>
                    <th scope="col" class="th">أجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                    <td class="th">{{ $invoice->invoice_number }}</td>
                    <td class="th">{{ $order->reference_number }}</td>
                    <td class="th">{{ $invoice->invoice_date }}</td>
                    <td class="th">{{ $invoice->title }}</td>
                    <td class="th">{{ $invoice->amount }}</td>
                    <td class="th">{{ $invoice->created_at }}</td>
                    <td class="th">{{ $invoice->status == 'paid' ? 'مدفوعة' : $invoice->status }}</td>
                    <td class="th" style="display: flex; gap: 8px;">
                        <!-- View Invoice -->
                        <a href="{{ route('admin.orders.showInvoice', $invoice->id) }}"
                            class="font-medium text-blue-600">
                            <svg class="w-6 h-6 text-blue-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2"
                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        <!-- Existing Invoice Button -->
                        {{-- <button class="text-yellow-600">
                            <i class="fa-solid fa-file-invoice" style="font-size: 18px;"></i>
                        </button> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection