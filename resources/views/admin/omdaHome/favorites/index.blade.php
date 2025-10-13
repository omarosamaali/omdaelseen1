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
        <div style="display: flex; flex-direction: row-reverse; justify-content: start;">
            <div
                style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
                <p>الإهتمامات</p>
                <div class="custom-select" style="position: relative; width: fit-content;">
                    <div style="position: relative;">
                        <span
                            style="position: absolute; top: 50%; transform: translateY(-50%); right: 0.75rem; color: #9ca3af; pointer-events: none;">
                            <svg style="width: 20px; color:rgb(129, 126, 126);" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </span>
                        <input aria-autocomplete="off" autocomplete="off" type="text" id="faq_search" name="faq_search"
                            style="text-align: right; width: 100%; padding: 0.5rem 2.5rem 0.5rem 0.5rem; border: 1px solid #d1d5db; border-radius: 30px; background-color: transparent;"
                            placeholder="بحث" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
            <table id="$favorites_table" class="w-full text-sm text-left rtl:text-right text-gray-500"
                style="background: #c9c9c9;">
                <thead class="text-xs text-gray-700 uppercase">
                    <tr>
                        <th scope="col" class="th">الرقم</th>
                        <th scope="col" class="th">الإسم</th>
                        <th scope="col" class="th">عدد الأماكن</th>
                        <th scope="col" class="th">أجراءات</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($favorites as $favorite)
                    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                        @php
                        if(!isset($counter)) {
                        $counter = 1;
                        }
                        @endphp
                        <td class="th">{{ $counter }}</td>
                        @php $counter++; @endphp
                        <td class="th">{{ $favorite->user->name }}</td>
                        <td class="th">{{ $favorite->place_count }}</td>
                        <td class="th" style="display: flex;">
                            <a href="{{ route('admin.favorites.show', $favorite->user->id) }}" class="font-medium text-blue-600">
                                <svg class="w-6 h-6 text-green-800" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg> 
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('faq_search');
            const table = document.getElementById('$favorites_table');
            const rows = table.querySelectorAll('tbody tr');

            searchInput.addEventListener('input', function() {
                const term = this.value.trim().toLowerCase();
                rows.forEach(row => {
                    const questionCell = row.querySelectorAll('td')[1]; // The question_ar column
                    if (!questionCell) return;

                    const question = questionCell.innerText.trim().toLowerCase();

                    if (question.includes(term) || term === '') {
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