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
        {{-- <h3 class="mb-4">المستخدمون</h3> --}}
        <div style="">


            <div style="display: flex; flex-direction: row-reverse; justify-content: space-between;">

                <a href="{{ route('admin.branches.create') }}" class=""
                    style="background: black; color: white;
                            padding: 10px 20px; border-radius: 5px; margin: 15px 0px; margin-left: 20px; ">إضافة
                    تصنيف فرعي</a>
                <div
                    style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
                    <p>التصنيفات الفرعية</p>
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

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
                <table id="branches_table" class="w-full text-sm text-left rtl:text-right text-gray-500" style="
    background: #c9c9c9;
">
                    <thead class="text-xs text-gray-700 uppercase ">
                        <tr>
                            <th scope="col" class="th">
                                الرقم
                            </th>
                            <th scope="col" class="th">
                                الإسم
                            </th>
                            <th scope="col" class="th">
                                الصورة
                            </th>
                            <th scope="col" class="th">
                                تصنيف رئيسي
                            </th>
                            <th scope="col" class="th">
                                أماكن
                            </th>
                            <th scope="col" class="th">
                                حالة
                            </th>
                            <th scope="col" class="th">
                                أجراءات
                            </th>

                        </tr>
                    </thead>
                    <tbody>
@foreach ($branches as $branche)
    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
        <td class="th">
            {{ $branche->id }}
        </td>
        <td class="th">
            {{ $branche->name_ar }}
        </td>
        <td class="th">
            <img style="width: 40px; height: 40px; border-radius: 13px;" src="{{ asset('storage/' . $branche->avatar) }}" alt="{{ $branche->name_ar }}">
        </td>
        <td class="th">
    {{ $branche->explorer ? $branche->explorer->name_ar : 'غير محدد' }}
        </td>
        <td class="th">
            <div style="background: rgb(172, 0, 0); border-radius: 3px; width: 20px; height: 20px; color:white; text-align: center;">
                {{ $branche->places_count }}
            </div>
        </td>
        <td class="th">
            {{ $branche->status }}
        </td>
                                <td class="th" style="display: flex; ">
                                    <a href="{{ route('admin.branches.show', $branche->id) }}"
                                        class="font-medium text-green-600">
                                        <svg class="w-6 h-6 text-green-800" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>

                                    </a>
                                    <a href="{{ route('admin.branches.edit', $branche->id) }}" class="font-medium text-blue-600">
                                        <svg class="w-6 h-6 text-blue-600" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.branches.destroy', $branche->id) }}"
                                        onclick="return confirm('هل انت متاكد من حذف هذا')" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600">
                                            <svg class="w-6 h-6 text-red-600" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- <nav style="background-color: #fff; z-index: 9999; position: relative;"
                    class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    aria-label="Table navigation">
                    <span class="text-sm font-normal text-gray-500">
                        Showing
                        <span class="font-semibold text-gray-900">1-10</span>
                        of
                        <span class="font-semibold text-gray-900">1000</span>
                    </span>
                    <ul style="flex-direction: row-reverse;" class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ">1</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page"
                                class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-primary-700 ">3</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ">...</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ">100</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav> --}}

            </div>

        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('user_search');

                const table = document.getElementById('branches_table');
                const rows = table.querySelectorAll('tbody tr');

                searchInput.addEventListener('input', function() {
                    const term = this.value.trim().toLowerCase();

                    rows.forEach(row => {
                        const nameCell = row.querySelectorAll('td')[
                            1];
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
    @endsection
