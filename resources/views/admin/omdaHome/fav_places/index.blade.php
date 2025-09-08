{{-- resources/views/admin/omdaHome/fav_for_places/favorites.blade.php --}}
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
        <h6 class="text-right pr-6">المستخدمين الذين أضافوا {{ $place->name_ar }} للمفضلة</h6>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-width: 100%; margin: 20px">
            <table id="favorites_table" class="w-full text-sm text-left rtl:text-right text-gray-500"
                style="background: #c9c9c9;">
                <thead class="text-xs text-gray-700 uppercase">
                    <tr>
                        <th scope="col" class="th">الرقم</th>
                        <th scope="col" class="th">اسم المستخدم</th>
                        <th scope="col" class="th">الصورة</th>
                        <th scope="col" class="th">الدولة</th>
                        <th scope="col" class="th">تاريخ الإضافة للمفضلة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($favoriteUsers as $index => $user)
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="th">{{ $index + 1 }}</td>
                            <td class="th">{{ $user->name ?? 'غير معروف' }}</td>
                            <td class="th">
                                <img style="width: 40px; height: 40px; border-radius: 13px;"
                                    src="{{ asset('storage/' . ($user->avatar ?? 'default.png')) }}"
                                    alt="{{ $user->name ?? 'غير معروف' }}">
                            </td>
                            <td class="th">{{ __('countries.' . $user->country) }}</td>
                            <td class="th">{{ $user->created_at->format('Y-m-d H:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="th text-center">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    لا يوجد مستخدمين أضافوا هذا المكان للمفضلة حتى الآن.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
