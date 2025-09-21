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
            <a href="{{ route('admin.places.create') }}" class="" style="background: black; color: white;
                            padding: 10px 20px; border-radius: 5px; margin: 15px 0px; margin-left: 20px; ">إضافة
                مكان جديد</a>
            <div
                style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
                <div>الأماكن</div>
                <div class="custom-select" style="position: relative; width: fit-content; ">
                    <div style="position: relative;">
                        <span
                            style="position: absolute; top: 50%; transform: translateY(-50%); right: 0.75rem; color: #9ca3af; pointer-events: none;">
                            <svg style="width: 20px; color:rgb(129, 126, 126);" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
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
                            الإسم
                        </th>
                        <th scope="col" class="th">
                            الصورة
                        </th>
                        <th scope="col" class="th">
                            التصنيف الرئيسي
                        </th>
                        <th scope="col" class="th">
                            التصنيف الفرعي
                        </th>
                        <th scope="col" class="th">
                            المنطقة
                        </th>
                        <th scope="col" class="th">
                            تقييم
                        </th>
                        <th scope="col" class="th">
                            المفضلة
                        </th>
                        <th scope="col" class="th">
                            الأراء
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
                    @foreach ($places as $place)
                    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                        <td class="th">
                            {{ $loop->iteration + $places->firstItem() - 1 }} </td>
                        <td class="th">
                            {{ $place->name_ar }}
                        </td>
                        <td class="th">
                            <img style="width: 40px; height: 40px; border-radius: 13px;"
                                src="{{ asset('storage/' . $place->avatar) }}" alt="{{ $place->name_ar }}">
                        </td>
                        <td class="th">
                            {{ $place->mainCategory ? $place->mainCategory->name_ar : 'غير محدد' }}
                        </td>
                        <td class="th">
                            {{ $place->subCategory ? $place->subCategory->name_ar : 'غير محدد' }}
                        </td>
                        <td class="th">
                            {{ $place->region ? $place->region->name_ar : 'غير محدد' }}
                        </td>
                        <td class="th">
                            <a href="{{ route('admin.fav_for_places.index', $place) }}"
                                style="padding-right: 5px; padding-left: 0px; display: flex; border-radius: 3px; text-align: center;">
                                {{ $ratingsData[$place->id]['ratings_count'] ?? 0 }} <svg
                                    class="w-5 h-5 text-yellow-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </a>
                        </td>
                        <td class="th">
                            <a href="{{ route('admin.fav_places.index', $place) }}" style="display: flex; gap: 2px;">
                                {{ $favoritesCount[$place->id] ?? 0 }}
                                <svg class="w-5 h-5 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                </svg>
                            </a>
                        </td>
                        <td class="th">
                            <a href="{{ route('admin.fav_for_places.index', $place) }}"
                                style="background: rgb(172, 0, 0); display: block; border-radius: 3px; width: 20px; height: 20px; color:white; text-align: center;">
                                {{ $commentsCount[$place->id] ?? 0 }}
                            </a>
                        </td>
                        <td class="th">
                            <span
                                class="{{ $place->status == 'active' ? 'text-green-600' : ($place->status == 'banned' ? 'text-red-600' : 'text-gray-600') }}">
                                {{ $place->status == 'active' ? 'نشط' : ($place->status == 'inactive' ? 'غير نشط' :
                                'محظور') }}
                            </span>
                        </td>
                        <td class="th" style="display: flex; ">
                            <a href="{{ route('admin.places.show', $place->id) }}" class="font-medium text-green-600">
                                <svg class="w-6 h-6 text-green-800" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.places.edit', $place->id) }}" class="font-medium text-blue-600">
                                <svg class="w-6 h-6 text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.places.destroy', $place->id) }}"
                                onclick="return confirm('هل انت متاكد من حذف هذا')" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600">
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
            <div style="margin: 10px; direction: ltr;">
                {{ $places->links() }}
            </div>
            @if (!($places->count() > 0))
            <div
                style="padding-top: 20px; text-align: center; display: flex; align-items: center; justify-content: center; margin: auto;">
                <p>لا يوجد أماكن لهذا المستخدم</p>
            </div>
            @endif
        </div>
        {{-- {{ $places->links() }} --}}
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('user_search');
        const tableBody = document.querySelector('#places_table tbody');

        searchInput.addEventListener('input', function() {
            const term = this.value.trim();

            fetch('{{ route("admin.places.search") }}?search=' + encodeURIComponent(term), {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = data.html || `
                    <tr>
                        <td colspan="11" style="text-align: center; padding: 20px;">
                            لا يوجد أماكن مطابقة
                        </td>
                    </tr>`;
            })
            .catch(error => {
                console.error('Error:', error);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="11" style="text-align: center; padding: 20px;">
                            حدث خطأ
                        </td>
                    </tr>`;
            });
        });
    });
</script>
</div>
@endsection