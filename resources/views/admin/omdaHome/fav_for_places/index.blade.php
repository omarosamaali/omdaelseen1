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
        <h6 class="text-right pr-6">التقييمات والآراء لـ {{ $place->name_ar }}</h6>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
            <table id="regions_table" class="w-full text-sm text-left rtl:text-right text-gray-500"
                style="background: #c9c9c9;">
                <thead class="text-xs text-gray-700 uppercase">
                    <tr>
                        <th scope="col" class="th">الرقم</th>
                        <th scope="col" class="th">اسم المستخدم</th>
                        <th scope="col" class="th">الصورة</th>
                        <th scope="col" class="th">التقييم</th>
                        <th scope="col" class="th">التعليق</th>
                        <th scope="col" class="th">تاريخ التقييم</th>
                        <th scope="col" class="th">اجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ratings as $rating)
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="th">{{ $rating->id }}</td>
                            <td class="th">{{ $rating->user->name ?? 'غير معروف' }}</td>
                            <td class="th">
                                <img style="width: 40px; height: 40px; border-radius: 13px;"
                                    src="{{ asset('storage/' . ($rating->user->avatar ?? 'default.png')) }}"
                                    alt="{{ $rating->user->name_ar ?? 'غير معروف' }}">
                            </td>
                            <td class="th">
                                <div
                                    style="background: rgb(172, 0, 0); align-items: center; display: flex; border-radius: 3px; width: 30px; height: 25px; color:white; text-align: center;">
                                    <svg class="w-5 h-5 text-yellow-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                    {{ $rating->rating }}
                                </div>
                            </td>
                            <td class="th">{{ $rating->comment ?? 'لا يوجد تعليق' }}</td>
                            <td class="th" style="display: flex;">{{ $rating->created_at->format('Y-m-d H:i A') }}</td>
                            <td class="th">
                                <form action="{{ route('admin.fav_for_places.destroy', $rating->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600"
                                        onclick="return confirm('هل أنت متأكد من حذف التقييم؟');">
                                        <svg class="w-6 h-6 text-red-600" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('user_search');
            const table = document.getElementById('regions_table');
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
@endsection
