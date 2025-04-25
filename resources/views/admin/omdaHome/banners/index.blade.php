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
            <a href="{{ route('admin.banners.create') }}" class="" style="background: black; color: white; padding: 10px 20px; border-radius: 5px; margin: 15px 0px; margin-left: 20px;">إضافة بنر</a>
            <div style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
                <p>البنرات</p>
                <div class="custom-select" style="position: relative; width: fit-content;">
                    <div style="position: relative;">
                        <span style="position: absolute; top: 50%; transform: translateY(-50%); right: 0.75rem; color: #9ca3af; pointer-events: none;">
                            <svg style="width: 20px; color:rgb(129, 126, 126);" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </span>
                        <input aria-autocomplete="off" autocomplete="off" type="text" id="banner_search" name="banner_search" style="text-align: right; width: 100%; padding: 0.5rem 2.5rem 0.5rem 0.5rem; border: 1px solid #d1d5db; border-radius: 30px; background-color: transparent;" placeholder="بحث" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
            <table id="banners_table" class="w-full text-sm text-left rtl:text-right text-gray-500" style="background: #c9c9c9;">
                <thead class="text-xs text-gray-700 uppercase">
                    <tr>
                        <th scope="col" class="th">الرقم</th>
                        <th scope="col" class="th">العنوان</th> <!-- Added -->
                        <th scope="col" class="th">الصورة</th>
                        <th scope="col" class="th">الموقع</th> <!-- Added -->
                        <th scope="col" class="th">الحالة</th>
                        <th scope="col" class="th">تاريخ البدء</th>
                        <th scope="col" class="th">تاريخ الانتهاء</th>
                        <th scope="col" class="th">أجراءات</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($banners as $banner)
                    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                        @php
                        if(!isset($counter)) {
                            $counter = 1;
                        }
                        @endphp
                        <td class="th">{{ $counter }}</td>
                        @php $counter++; @endphp
                        <td class="th">{{ Str::limit($banner->title_ar, 30) }}</td>
                        <td class="th">
                            @if ($banner->avatar)
                            <img style="width: 40px; height: 40px; border-radius: 13px;" src="{{ asset('storage/' . $banner->avatar) }}" alt="Banner Image">
                            @else
                            لا يوجد صورة
                            @endif
                        </td>
                        <td class="th">
                            @if ($banner->location == 'website_home')
                                الصفحة الرئيسية للموقع
                            @elseif ($banner->location == 'mobile_app')
                                تطبيق الهاتف
                            @else
                                كلاهما
                            @endif
                        </td> <!-- Added -->
                        <td class="th">
                            @if ($banner->is_active == 'نشط')
                            <span class="text-green-600">نشط</span>
                            @else
                            <span class="text-red-600">غير نشط</span>
                            @endif
                        </td>
                        <td class="th">{{ $banner->start_date ? $banner->start_date->format('Y-m-d H:i') : 'غير محدد' }}</td>
                        <td class="th">{{ $banner->end_date ? $banner->end_date->format('Y-m-d H:i') : 'غير محدد' }}</td>
                        <td class="th" style="display: flex;">
                            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="font-medium text-blue-600">
                                <svg class="w-6 h-6 text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" onclick="return confirm('هل أنت متأكد من حذف هذا؟')" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600">
                                    <svg class="w-6 h-6 text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
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
            const searchInput = document.getElementById('banner_search');
            const table = document.getElementById('banners_table');
            const rows = table.querySelectorAll('tbody tr');

            searchInput.addEventListener('input', function() {
                const term = this.value.trim().toLowerCase();
                rows.forEach(row => {
                    const contentCell = row.querySelectorAll('td')[1]; // The content_ar column
                    if (!contentCell) return;

                    // Use innerText to strip HTML tags and get plain text
                    const content = contentCell.innerText.trim().toLowerCase();

                    if (content.includes(term) || term === '') {
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