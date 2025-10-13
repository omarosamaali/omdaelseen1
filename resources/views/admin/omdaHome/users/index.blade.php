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
        <div>
            <div style="display: flex; flex-direction: row-reverse; justify-content: space-between;">
                <a href="{{ route('admin.users.create') }}" class=""
                    style="background: black; color: white;
                            padding: 10px 20px; border-radius: 5px; margin: 15px 0px; margin-left: 20px; ">إضافة
                    مستخدم</a>
                <div
                    style="display: flex; align-items: center; justify-content: space-between; gap:10px; margin-right: 20px;">
                    <p>المستخدمين</p>
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

            <div style="display: flex; justify-content: space-between; max-width: 100%; margin: 30px 20px;">
                <a style="background: rgb(201, 200, 200); text-align: center; width: 130px; color: black; font-weight:bold; border-radius: 10px; padding: 20px;"
                    href="{{ route('admin.users.index', ['filter' => 'admin', 'user_search' => request('user_search')]) }}"
                    class="filter-box {{ $currentFilter === 'admin' ? 'active' : '' }}">
                    الإدارة<br />{{ $adminsCount }}
                </a>
                <a style="background: rgb(201, 200, 200); text-align: center; width: 130px; color: black; font-weight:bold; border-radius: 10px; padding: 20px;"
                    href="{{ route('admin.users.index', ['filter' => 'user', 'user_search' => request('user_search')]) }}"
                    class="filter-box {{ $currentFilter === 'user' ? 'active' : '' }}">
                    المستخدمين<br />{{ $usersCount }}
                </a>
                
                <a href="{{ route('admin.users.index', ['filter' => 'no_requests', 'user_search' => request('user_search')]) }}"
                    style="background: rgb(201, 200, 200); text-align: center; width: 130px; color: black; font-weight:bold; border-radius: 10px; padding: 20px;">
                    بدون طلبات
                    <br />
                    {{ $usersWithNoRequests }}
                </a>

                <a style="background: rgb(201, 200, 200); text-align: center; width: 130px; color: black; font-weight:bold; border-radius: 10px; padding: 20px;"
                    href="{{ route('admin.users.index', ['filter' => 'active', 'user_search' => request('user_search')]) }}"
                    class="filter-box {{ $currentFilter === 'active' ? 'active' : '' }}">
                    النشط<br />{{ $activeUsersCount }}
                </a>
                <a href="{{ route('admin.users.index', ['filter' => 'banned', 'user_search' => request('user_search')]) }}"
                    style="background: rgb(201, 200, 200); text-align: center; width: 130px; color: black; font-weight:bold; border-radius: 10px; padding: 20px;">
                    المحظور
                    <br />
                    {{ $bannedUsersCount }}
                </a>
                <a href="{{ route('admin.users.index', ['filter' => 'deleted', 'user_search' => request('user_search')]) }}"
                    style="background: rgb(201, 200, 200); text-align: center; width: 130px; color: black; font-weight:bold; border-radius: 10px; padding: 20px;">
                    المحذوف
                    <br />
                    {{ $deletedUsersCount }}
                </a>

            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
                <table id="users_table" style="z-index: 99999; position: relative;"
                    class="w-full text-sm text-left rtl:text-right text-gray-500" style="background: #c9c9c9;">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="th">
                                الدولة
                            </th>
                            <th scope="col" class="th">
                                الإسم
                            </th>
                            <th scope="col" class="th">
                                الصلاحية
                            </th>
                            <th scope="col" class="th">
                                تاريخ التسجيل
                            </th>
                            <th scope="col" class="th">
                                الرحلات
                            </th>
                            <th scope="col" class="th">
                                المفضلة
                            </th>
                            <th scope="col" class="th">
                                التقييم
                            </th>
                            <th scope="col" class="th">
                                الأماكن
                            </th>
                            <th scope="col" class="th">
                                الحالة
                            </th>
                            <th scope="col" class="th">
                                التحكم
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="odd:bg-white even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    @if (isset($user) && $user->country)
                                        <img style="width: 30px; height: 20px; border-radius: 0px; border: 0px;"
                                            src="https://flagcdn.com/32x24/{{ strtolower($user->country) }}.png"
                                            alt="{{ $user->country }} Flag">
                                    @else
                                        <img style="width: 30px; height: 20px; border-radius: 0px; border: 0px;"
                                            src="https://flagcdn.com/32x24/xx.png" alt="Default Flag">
                                    @endif
                                </th>
                                <td class="th">
                                    {{-- {{ $user->name }} --}}
                                    {{ $user->name }}
                                </td>
                                <td class="th">
                                    {{ $user->role == 'admin' ? 'مدير' : 'مستخدم' }}
                                </td>
                                <td class="th">
                                    {{ $user->created_at }}
                                </td>
                                <td class="th">
                                    {{ $user->trips_count }}
                                </td>
                                <td class="th">
                                    {{ $user->favorites_count }}
                                </td>
                                <td class="th">
                                    {{ $user->ratings_count }}
                                </td>
                                <td class="th">
                                    <a href="{{ route('admin.places.index', ['user_id' => $user->id]) }}">
                                        {{ $user->places_count }}
                                    </a>
                                </td>
                                <td class="th">
                                    @if ($user->status == '1')
                                        نشط
                                    @elseif ($user->status == '0')
                                        غير نشط
                                    @elseif ($user->status == 'banned')
                                        محظور
                                    @else
                                        غير محدد
                                    @endif
                                </td>

                                <td class="th" style="display: flex;">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="font-medium text-green-600">
                                        <svg class="w-6 h-6 text-green-800" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                            <path stroke="currentColor" stroke-width="2"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="font-medium text-blue-600">
                                        <svg class="w-6 h-6 text-blue-600" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                        onclick="return confirm('هل انت متاكد من حذف هذا المستخدم؟')" method="POST"
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

                <div class="flex justify-center mt-4">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('user_search');
                const table = document.getElementById('users_table');
                const rows = table.querySelectorAll('tbody tr');
                searchInput.addEventListener('input', function() {
                    const term = this.value.trim().toLowerCase();
                    rows.forEach(row => {
                        const nameCell = row.querySelectorAll('td')[
                            0];
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
