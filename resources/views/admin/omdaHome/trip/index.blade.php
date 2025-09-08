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
    <div class="py-4 text-end" style="margin-top: 30px;">

        <div style="">
            <div style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
                <a href="{{ route('admin.omdaHome.trip.create') }}" class=""
                    style="background: black; color: white;
                            padding: 10px 20px; border-radius: 5px; margin: 15px 0px; margin-left: 20px; ">إضافة
                    رحلة جديد</a>
                <div
                    style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
                    <div>الرحلات</div>
                    <div class="custom-select" style="position: relative; width: fit-content; ">
                        <div style="position: relative;">
                            <span
                                style="position: absolute; top: 50%; transform: translateY(-50%); right: 0.75rem; color: #9ca3af; pointer-events: none;">
                                <svg style="width: 20px; color:rgb(129, 126, 126);" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                </svg>
                            </span>
                            <input aria-autocomplete="off" autocomplete="off" type="text" id="user_search"
                                name="user_search"
                                style="text-align: right; width: 100%; padding: 0.5rem 2.5rem 0.5rem 0.5rem; border: 1px solid #d1d5db; border-radius: 30px; background-color: transparent;"
                                placeholder="بحث" required>
                        </div>
                    </div>

                </div>
            </div>
            <div style="display: block; text-align: center;">
                @if (request('user_id'))
                    <?php $user = \App\Models\User::find(request('user_id')); ?>
                    <p>عرض الأماكن للمستخدم: {{ $user ? $user->name : 'غير موجود' }}</p>
                @endif
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
                <table id="places_table" class="w-full text-sm text-left rtl:text-right text-gray-500"
                    style="background: #c9c9c9;">
                    <thead class="text-xs text-gray-700 uppercase ">
                        <tr>
                            <th scope="col" class="th">
                                الرقم
                            </th>
                            <th scope="col" class="th">
                                العنوان
                            </th>
                            <th scope="col" class="th">
                                تاريخ المغادرة
                            </th>
                            <th scope="col" class="th">
                                تاريخ العودة
                            </th>
                            <th scope="col" class="th">
                                نوع الرحلة
                            </th>
                            <th scope="col" class="th">
                                عدد المشتركين
                            </th>
                            <th scope="col" class="th">
                                بانتظار الدفع
                            </th>
                            <th scope="col" class="th">
                                الحالة
                            </th>
                            <th scope="col" class="th">
                                أجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="th">
                                1
                            </td>
                            <td class="th">
                                1
                            </td>
                            <td class="th">
                                2
                            </td>
                            <td class="th">
                                2
                            </td>
                            <td class="th">
                                2
                            </td>
                            <td class="th">
                                2
                            </td>
                            <td class="th">
                                2
                            </td>
                            <td class="th">
                                2
                            </td>
                            <td class="th" style="display: flex; ">
                                <a href="#" class="font-medium text-green-600">
                                    <svg class="w-6 h-6 text-green-800" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2"
                                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                        <path stroke="currentColor" stroke-width="2"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                                <a href="#" class="font-medium text-blue-600">
                                    <svg class="w-6 h-6 text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </a>

                                <form action="#" onclick="return confirm('هل انت متاكد من حذف هذا')" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600">
                                        <svg class="w-6 h-6 text-red-600" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </form>

                                <a href="{{ route('admin.omdaHome.trip.trip-table') }}" class="font-medium text-orange-600">
                                    <svg class="w-6 h-6 text-orange-600" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="orange">
                                        <path stroke="currentColor" stroke-linecap="round"
                                            d="M216 64C229.3 64 240 74.7 240 88L240 128L400 128L400 88C400 74.7 410.7 64 424 64C437.3 64 448 74.7 448 88L448 128L480 128C515.3 128 544 156.7 544 192L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 192C96 156.7 124.7 128 160 128L192 128L192 88C192 74.7 202.7 64 216 64zM216 176L160 176C151.2 176 144 183.2 144 192L144 240L496 240L496 192C496 183.2 488.8 176 480 176L216 176zM144 288L144 480C144 488.8 151.2 496 160 496L480 496C488.8 496 496 488.8 496 480L496 288L144 288z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>

                    </tbody>
                </table>
                {{-- <div style="margin: 10px; direction: ltr;">
                    {{ $places->links() }}
                </div>
                @if (!($places->count() > 0))
                    <div
                        style="padding-top: 20px; text-align: center; display: flex; align-items: center; justify-content: center; margin: auto;">
                        <p>لا يوجد أماكن لهذا المستخدم</p>
                    </div>
                @endif --}}
            </div>
            {{-- {{ $places->links() }} --}}
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('user_search');
                const table = document.getElementById('places_table');
                const rows = table.querySelectorAll('tbody tr');

                searchInput.addEventListener('input', function() {
                    const term = this.value.trim().toLowerCase();

                    rows.forEach(row => {
                        const nameCell = row.querySelectorAll('td')[1];
                        if (!nameCell) return;

                        const name = nameCell.textContent.trim().toLowerCase();
                        if (name.includes(term) || term === '') {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            });
        </script>
    </div>
@endsection
