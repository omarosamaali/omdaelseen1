@extends($layout)

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">تفاصيل الإضافة</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-600">الإرشاد بالعربي:</p>
                    <p class="text-lg font-medium text-gray-900 mt-1">{{ $adds->type_ar }}</p>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-600">الإرشاد بالإنجليزي:</p>
                    <p class="text-lg font-medium text-gray-900 mt-1">{{ $adds->type_en ?? 'لا يوجد' }}</p>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-600">الإرشاد بالصيني:</p>
                    <p class="text-lg font-medium text-gray-900 mt-1">{{ $adds->type_zh ?? 'لا يوجد' }}</p>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-600">التفاصيل بالعربي:</p>
                    <p class="text-lg font-medium text-gray-900 mt-1">{{ $adds->details_ar ?? 'لا يوجد' }}</p>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-600">التفاصيل بالإنجليزي:</p>
                    <p class="text-lg font-medium text-gray-900 mt-1">{{ $adds->details_en ?? 'لا يوجد' }}</p>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-600">التفاصيل بالصيني:</p>
                    <p class="text-lg font-medium text-gray-900 mt-1">{{ $adds->details_zh ?? 'لا يوجد' }}</p>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-600">السعر:</p>
                    <p class="text-lg font-medium text-gray-900 mt-1">{{ $adds->price }}</p>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-600">الحالة:</p>
                    <p class="text-lg font-medium text-gray-900 mt-1">
                        {{ $adds->status == 'active' ? 'نشط' : 'غير نشط' }}
                    </p>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-600">الصورة:</p>
                    <img src="{{ asset('storage/' . $adds->image) }}" alt="Add Image" class="mt-1 max-w-full h-auto">
                </div>

                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-600">تاريخ الإنشاء:</p>
                    <p class="text-lg font-medium text-gray-900 mt-1">
                        {{ $adds->created_at ? $adds->created_at->format('Y-m-d H:i') : 'لا يوجد تاريخ' }}
                    </p>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg">
                    <p class="text-sm font-semibold text-gray-600">آخر تحديث:</p>
                    <p class="text-lg font-medium text-gray-900 mt-1">
                        {{ $adds->updated_at ? $adds->updated_at->format('Y-m-d H:i') : 'لا يوجد تاريخ' }}
                    </p>
                </div>
            </div>

            <div class="flex justify-end mt-8 gap-2">
<a href="{{ route('admin.omdaHome.adds.edit', $adds->id) }}" 
   class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">تعديل</a>                <a href="{{ route('admin.omdaHome.adds.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">العودة</a>
            </div>
        </div>
    </div>
@endsection