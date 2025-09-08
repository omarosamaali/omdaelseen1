@extends($layout)

@section('content')
<div class="container mx-auto p-4">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">تفاصيل الإرشاد</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm font-semibold text-gray-600">الإرشاد بالعربي:</p>
                <p class="text-lg font-medium text-gray-900 mt-1">{{ $tripFeature->name_ar }}</p>
            </div>
            
            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm font-semibold text-gray-600">الإرشاد بالإنجليزي:</p>
                <p class="text-lg font-medium text-gray-900 mt-1">{{ $tripFeature->name_en ?? 'لا يوجد' }}</p>
            </div>
            
            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm font-semibold text-gray-600">الإرشاد بالصيني:</p>
                <p class="text-lg font-medium text-gray-900 mt-1">{{ $tripFeature->name_ch ?? 'لا يوجد' }}</p>
            </div>
            
            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm font-semibold text-gray-600">الحالة:</p>
                <p class="text-lg font-medium text-gray-900 mt-1">
                    {{ $tripFeature->status == 'active' ? 'نشط' : 'غير نشط' }}
                </p>
            </div>
            
            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm font-semibold text-gray-600">الترتيب:</p>
                <p class="text-lg font-medium text-gray-900 mt-1">{{ $tripFeature->order }}</p>
            </div>
            
<div class="bg-gray-100 p-4 rounded-lg">
    <p class="text-sm font-semibold text-gray-600">تاريخ الإنشاء:</p>
    <p class="text-lg font-medium text-gray-900 mt-1">
        {{ $tripFeature->created_at ? $tripFeature->created_at->format('Y-m-d H:i') : 'لا يوجد تاريخ' }}
    </p>
</div>
<div class="bg-gray-100 p-4 rounded-lg">
    <p class="text-sm font-semibold text-gray-600">آخر تحديث:</p>
    <p class="text-lg font-medium text-gray-900 mt-1">
        {{ $tripFeature->updated_at ? $tripFeature->updated_at->format('Y-m-d H:i') : 'لا يوجد تاريخ' }}
    </p>
</div>
        </div>

        <div class="flex justify-end mt-8 gap-2">
            <a href="{{ route('admin.omdaHome.trip-features.edit', $tripFeature)  }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">تعديل</a>
            <a href="{{ route('admin.omdaHome.trip.trip-info') }}" class="ml-4 bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">العودة</a>
        </div>
    </div>
</div>
@endsection