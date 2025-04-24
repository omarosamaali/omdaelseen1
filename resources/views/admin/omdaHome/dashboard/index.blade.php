@extends($layout)

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .th {
            padding: 1rem 1.5rem;
            text-align: right;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-card a {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .stat-card .icon {
            font-size: 2rem;
            color: #935d67;
            margin-bottom: 0.5rem;
            transition: transform 0.3s ease;
        }

        .stat-card:hover .icon {
            transform: scale(1.1);
        }

        .stat-card h3 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 600;
            color: #333;
        }

        .stat-card p {
            margin: 0.5rem 0 0;
            font-size: 0.95rem;
            color: #666;
            font-weight: 500;
        }

        .large-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .large-card h2 {
            margin: 0 0 1rem;
            font-size: 1.25rem;
            color: #333;
            text-align: right;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .stat-card h3 {
                font-size: 1.5rem;
            }

            .stat-card p {
                font-size: 0.9rem;
            }

            .stat-card .icon {
                font-size: 1.75rem;
            }
        }
    </style>
    <div class="py-4" style="margin-top: 30px;">
        <!-- الإحصائيات الصغيرة في الأعلى -->
        <div class="py-4" style="margin-top: 30px;">
            <!-- الإحصائيات الصغيرة في الأعلى -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mx-4">
                <!-- إجمالي عدد التصنيفات الرئيسية -->
                <div class="stat-card">
                    <a href="{{ route('admin.explorers.index') }}">
                        <i class="fas fa-folder-open icon"></i>
                        <h3>{{ $totalMainCategories }}</h3>
                        <p>التصنيفات الرئيسية</p>
                    </a>
                </div>

                <!-- إجمالي عدد التصنيفات الفرعية -->
                <div class="stat-card">
                    <a href="{{ route('admin.branches.index') }}">
                        <i class="fas fa-folder icon"></i>
                        <h3>{{ $totalSubCategories }}</h3>
                        <p>التصنيفات الفرعية</p>
                    </a>
                </div>

                <!-- إجمالي عدد المناطق -->
                <div class="stat-card">
                    <a href="{{ route('admin.regions.index') }}">
                        <i class="fas fa-map-marker-alt icon"></i>
                        <h3>{{ $totalRegions }}</h3>
                        <p>المناطق</p>
                    </a>
                </div>

                <!-- إجمالي عدد الأماكن -->
                <div class="stat-card">
                    <a href="{{ route('admin.places.index') }}">
                        <i class="fas fa-building icon"></i>
                        <h3>{{ $totalPlaces }}</h3>
                        <p>الأماكن</p>
                    </a>
                </div>

                <!-- إجمالي عدد المراجعات -->
                <div class="stat-card">
                    <a href="#">
                        <i class="fas fa-star icon"></i>
                        <h3>0</h3>
                        <p>المراجعات</p>
                    </a>
                </div>

                <!-- إجمالي عدد البلاغات -->
                <div class="stat-card">
                    <a href="#">
                        <i class="fas fa-exclamation-triangle icon"></i>
                        <h3>0</h3>
                        <p>البلاغات</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- الإحصائيات الكبيرة في الأسفل -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-4">
            <!-- أحدث الأماكن -->
            <div class="large-card">
                <div style="display: flex; justify-content: space-between;">
                    <h2>أحدث الأماكن</h2>
                    @if ($latestPlaces->isEmpty())
                        <p>لا توجد أماكن جديدة.</p>
                    @else
                        <a href="{{ route('admin.places.index') }}">
                            <p>الكل</p>
                        </a>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500" style="background: #c9c9c9;">
                    {{-- <thead class="text-xs text-gray-700 uppercase">
                            <tr>
                                <th scope="col" class="th">الرقم</th>
                                <th scope="col" class="th">الإسم</th>
                                <th scope="col" class="th">الصورة</th>
                                <th scope="col" class="th">التصنيف الرئيسي</th>
                                <th scope="col" class="th">التصنيف الفرعي</th>
                                <th scope="col" class="th">المنطقة</th>
                            </tr> --}}
                    </thead>
                    <tbody>
                        @foreach ($latestPlaces as $place)
                            <div class="odd:bg-white even:bg-gray-50 border-b border-gray-200"
                                style="display: flex; flex-direction: row; padding: 20px; padding-right: 0px;">
                                <div>
                                    <img style="width: 120px; height: 120px; border-radius: 5px;"
                                        src="{{ asset('storage/' . $place->avatar) }}" alt="{{ $place->name_ar }}">
                                </div>
                                <div style="display: flex; flex-direction: column; margin-right: 20px;">

                                    <div style="font-weight: bold; font-size: large;">{{ $place->name_ar }}</div>
                                    <div>
                                        التصنيف الرئيسي :
                                        {{ $place->mainCategory ? $place->mainCategory->name_ar : 'غير محدد' }}
                                    </div>
                                    <div style="padding-top: 10px; padding-bottom: 10px;">
                                        التصنيف الفرعي :
                                        {{ $place->subCategory ? $place->subCategory->name_ar : 'غير محدد' }}
                                    </div>
                                    <div>
                                        المنطقة : {{ $place->region ? $place->region->name_ar : 'غير محدد' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <!-- أحدث البلاغات -->
            <div class="large-card">
                <div style="display: flex; justify-content: space-between;">
                    <h2>أحدث البلاغات</h2>
                    {{-- @if ($latestReports->isEmpty()) --}}
                    {{-- <p>لا توجد بلاغات جديدة.</p> --}}
                    {{-- @else --}}
                    <a href="#">
                        <p>الكل</p>
                    </a>
                </div>

                <table class="w-full text-sm text-left rtl:text-right text-gray-500" style="background: #c9c9c9;">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="th">الرقم</th>
                            <th scope="col" class="th">عنوان البلاغ</th>
                            <th scope="col" class="th">تاريخ الإنشاء</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($latestReports as $report) --}}
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="th">
                                {{-- {{ $report->id }} --}}
                                0
                            </td>
                            <td class="th">
                                {{-- {{ $report->title ?? 'غير محدد' }} --}}
                                0
                            </td>
                            <td class="th">
                                {{-- {{ $report->created_at->format('Y-m-d H:i') }} --}}
                                0
                            </td>
                        </tr>
                        {{-- @endforeach --}}
                    </tbody>
                </table>
                {{-- @endif --}}
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mx-4">
            <!-- أحدث الأماكن -->
            <div class="large-card">
                <div style="display: flex; justify-content: space-between;">
                    <h2>أحدث الأماكن المفضلة</h2>
                    @if ($latestPlaces->isEmpty())
                        <p>لا توجد أماكن جديدة.</p>
                    @else
                        <a href="{{ route('admin.places.index') }}">
                            <p>الكل</p>
                        </a>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500" style="background: #c9c9c9;">
                    {{-- <thead class="text-xs text-gray-700 uppercase">
                            <tr>
                                <th scope="col" class="th">الرقم</th>
                                <th scope="col" class="th">الإسم</th>
                                <th scope="col" class="th">الصورة</th>
                                <th scope="col" class="th">التصنيف الرئيسي</th>
                                <th scope="col" class="th">التصنيف الفرعي</th>
                                <th scope="col" class="th">المنطقة</th>
                            </tr> --}}
                    </thead>
                    <tbody>
                        @foreach ($latestPlaces as $place)
                            <div class="odd:bg-white even:bg-gray-50 border-b border-gray-200"
                                style="display: flex; flex-direction: row; padding: 20px; padding-right: 0px;">
                                <div>
                                    <img style="width: 120px; height: 120px; border-radius: 5px;"
                                        src="{{ asset('storage/' . $place->avatar) }}" alt="{{ $place->name_ar }}">
                                </div>
                                <div style="display: flex; flex-direction: column; margin-right: 20px;">

                                    <div style="font-weight: bold; font-size: large;">{{ $place->name_ar }}</div>
                                    <div>
                                        التصنيف الرئيسي :
                                        {{ $place->mainCategory ? $place->mainCategory->name_ar : 'غير محدد' }}
                                    </div>
                                    <div style="padding-top: 10px; padding-bottom: 10px;">
                                        التصنيف الفرعي :
                                        {{ $place->subCategory ? $place->subCategory->name_ar : 'غير محدد' }}
                                    </div>
                                    <div>
                                        المنطقة : {{ $place->region ? $place->region->name_ar : 'غير محدد' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <!-- أحدث البلاغات -->
            <div class="large-card">
                <div style="display: flex; justify-content: space-between;">
                    <h2>أكثر أماكن المميزة</h2>
                    @if ($latestPlaces->isEmpty())
                        <p>لا توجد أماكن جديدة.</p>
                    @else
                        <a href="{{ route('admin.places.index') }}">
                            <p>الكل</p>
                        </a>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500" style="background: #c9c9c9;">
                    {{-- <thead class="text-xs text-gray-700 uppercase">
                            <tr>
                                <th scope="col" class="th">الرقم</th>
                                <th scope="col" class="th">الإسم</th>
                                <th scope="col" class="th">الصورة</th>
                                <th scope="col" class="th">التصنيف الرئيسي</th>
                                <th scope="col" class="th">التصنيف الفرعي</th>
                                <th scope="col" class="th">المنطقة</th>
                            </tr> --}}
                    </thead>
                    <tbody>
                        @foreach ($latestPlaces as $place)
                            <div class="odd:bg-white even:bg-gray-50 border-b border-gray-200"
                                style="display: flex; flex-direction: row; padding: 20px; padding-right: 0px;">
                                <div>
                                    <img style="width: 120px; height: 120px; border-radius: 5px;"
                                        src="{{ asset('storage/' . $place->avatar) }}" alt="{{ $place->name_ar }}">
                                </div>
                                <div style="display: flex; flex-direction: column; margin-right: 20px;">

                                    <div style="font-weight: bold; font-size: large;">{{ $place->name_ar }}</div>
                                    <div>
                                        التصنيف الرئيسي :
                                        {{ $place->mainCategory ? $place->mainCategory->name_ar : 'غير محدد' }}
                                    </div>
                                    <div style="padding-top: 10px; padding-bottom: 10px;">
                                        التصنيف الفرعي :
                                        {{ $place->subCategory ? $place->subCategory->name_ar : 'غير محدد' }}
                                    </div>
                                    <div>
                                        المنطقة : {{ $place->region ? $place->region->name_ar : 'غير محدد' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

        </div>
    </div>
@endsection
