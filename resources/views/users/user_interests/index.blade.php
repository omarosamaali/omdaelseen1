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
            <div style="display: flex; justify-content: space-between;">
                <div style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
                    <p>الإهتمامات</p>
                    <div class="custom-select" style="position: relative; width: fit-content;">
                        <div style="position: relative;">
                            <span style="position: absolute; top: 50%; transform: translateY(-50%); right: 0.75rem; color: #9ca3af; pointer-events: none;">
                                <svg style="width: 20px; color:rgb(129, 126, 126);" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                                </svg>
                            </span>
                            <input aria-autocomplete="off" autocomplete="off" type="text" id="interest_search" name="interest_search"
                                style="text-align: right; width: 100%; padding: 0.5rem 2.5rem 0.5rem 0.5rem; border: 1px solid #d1d5db; border-radius: 30px; background-color: transparent;"
                                placeholder="بحث" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
                <table id="interests_table" class="w-full text-sm text-left rtl:text-right text-gray-500" style="background: #c9c9c9;">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="th">الرقم</th>
                            <th scope="col" class="th">القسم</th>
                            <th scope="col" class="th">العنصر</th>
                            <th scope="col" class="th">تاريخ الإضافة</th>
                            <th scope="col" class="th">أجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userInterests as $userInterest)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                @php
                                    if (!isset($counter)) {
                                        $counter = 1;
                                    }
                                @endphp
                                <td class="th">{{ $counter }}</td>
                                @php $counter++; @endphp
                                <td class="th">{{ $userInterest->interest_type_name }}</td>
                                <td class="th">
                                    @if ($userInterest->interest)
                                        {{ $userInterest->interest->title_ar ?? ($userInterest->interest->word_ar ?? 'غير معروف') }}
                                    @else
                                        غير متوفر
                                    @endif
                                </td>
                                <td class="th">{{ $userInterest->created_at->format('Y-m-d H:i') }}</td>
                                <td class="th">
                                    <div style="display: flex; gap: 10px;">
                                        <!-- Show Button -->
                                        <a href="{{ route('user.user_interests.show', $userInterest->id) }}" class="font-medium text-blue-600">
                                            <svg class="w-6 h-6 text-green-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        <!-- Delete Button -->
                                        <form action="{{ route('user.user_interests.destroy', $userInterest->id) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا الإهتمام؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600">
                                                <svg class="w-6 h-6 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $userInterests->links() }}
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('interest_search');
                const table = document.getElementById('interests_table');
                const rows = table.querySelectorAll('tbody tr');

                searchInput.addEventListener('input', function() {
                    const term = this.value.trim().toLowerCase();
                    rows.forEach(row => {
                        const itemCell = row.querySelectorAll('td')[2]; // Interest item (adjusted index after removing user column)
                        if (!itemCell) return;

                        const item = itemCell.innerText.trim().toLowerCase();

                        if (item.includes(term) || term === '') {
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