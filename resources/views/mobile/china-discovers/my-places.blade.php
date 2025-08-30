@extends('layouts.mobile')

@section('title', 'أماكني | My places')
<link rel="stylesheet" href="{{ asset('assets/assets/css/my-places.css') }}">
<link rel="stylesheet" href="{{ asset('assets/assets/css/china-discover.css') }}">

@section('content')

<div class="container min-h-dvh relative overflow-hidden pb-8 dark:text-white dark:bg-black">

    <div class="header-container">
        <img src="{{ asset('assets/assets/images/header-bg.png') }}" alt="">
        <a href="{{ route('mobile.profile.profile') }}" class="profile-link dark:bg-color10">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <div class="logo-register">أماكني</div>
    </div>


    <div style="margin-top: 90px;">
@foreach($myPlaces as $place)
<div class="container---features">
    <div style="width: 100%; height: 183px;">

        <div class="container-like">
            <i class="fa-solid fa-heart" style="font-size: 20px; color: red;"></i>
            {{ $place->likes ?? 0 }}
        </div>

        <div class="container-comments">
            <i class="fa-solid fa-message" style="font-size: 20px; color: green;"></i>
            {{ $place->comments_count ?? 0 }}
        </div>

        <div class="container-rate">
            <i class="fa-solid fa-star" style="font-size: 20px; color: orange;"></i>
            {{ $place->rating ?? 0 }}
        </div>

        <img style="width: 100%; border-top-right-radius: 12px; border-top-left-radius: 12px; height: 213px;" 
        src="{{ asset('storage/' . $place->avatar) }}" alt="">
        <p style="text-align: center; padding: 9px 0px; font-size: 15px; position: relative; top: -110px; background-color: rgba(255, 255, 255, 0.5);">
            {{ $place->title ?? 'اماكن سياحية' }}
        </p>
    </div>

    <div class="container--features" style="margin-top: 10px; direction: rtl;">
        <div>
            <img src="{{ asset('storage/' . $place->region->avatar) }}" alt="">
            <p>{{ $place->region->name_ar ?? 'المنطقة' }}</p>
        </div>
        <div>
            <img src="{{ asset('storage/' . $place->mainCategory->avatar) }}" alt="">
            <p>{{ $place->mainCategory->name_ar ?? 'رئيسي' }}</p>
        </div>
        <div>
            <img src="{{ asset('storage/' . $place->subCategory->avatar) }}" alt="">
            <p>{{ $place->subCategory->name_ar ?? 'فرعي' }}</p>
        </div>
    </div>
</div>
@endforeach


        <div class="container---features">
            <div class="bg-opacity">
                <span>مكان مخالف</span>
            </div>
            <div style="width: 100%; height: 183px;">
                <!-- <div style="position: absolute; top: 37px; display: flex; align-items: center; gap: 15px;">
              <i class="ph ph-heart"
                style="position: absolute; top: -31px; text-align: center; padding-top: 9px; left: 20px; font-size: 30px;"></i>
            </div> -->
                <img style="width: 100%; border-top-right-radius: 12px; border-top-left-radius: 12px; height: 200px;" src="./assets/images/bg.jpeg" alt="">
                <p style="text-align: center; padding: 9px 0px; font-size: 15px; position: relative; top: -60px; background-color: rgba(255, 255, 255, 0.5);">
                    اماكن سياحية</p>
            </div>

            <div class="container--features" style="margin-top: 10px; direction: rtl;">
                <div>
                    <img src="./assets/images/gallery-img-9.png" alt="">
                    <p>المنطقة</p>
                </div>
                <div>
                    <img src="./assets/images/gallery-img-9.png" alt="">
                    <p>رئيسي</p>
                </div>
                <div>
                    <img src="./assets/images/gallery-img-9.png" alt="">
                    <p>فرعي</p>
                </div>
            </div>

        </div>

    </div>

</div>



@endsection
