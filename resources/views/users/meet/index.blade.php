@extends('layouts.appOmdahome')

@section('content')
<style>
    .exhibition-container {
        margin-top: 60px;
        margin-bottom: 60px;
        display: flex;
        flex-direction: row-reverse;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 40px;
        margin-right: 0px;
    }

    .exhibition-image {
        max-width: 280px;
        max-height: 280px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .exhibition-details {
        background-color: #ffffff;
        padding: 20px 25px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.07);
        max-width: 700px;
        border-right: 5px solid #c00000;
    }

    .exhibition-title {
        color: #071739;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .exhibition-dates {
        color: #777;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .exhibition-description {
        font-size: 16px;
        color: #333;
        line-height: 1.7;
    }
</style>

@if($event && $event->type === 'مناسبة')
<div class="container exhibition-container">
    <div>
        <img src="{{ asset('storage/' . $event->avatar) }}" alt="صورة المعرض" class="exhibition-image">
    </div>
    <div class="exhibition-details">
        <div class="exhibition-title">{{ $event->title_ar }}</div>
        <div class="exhibition-dates">
            <span>من {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span> -
            <span>إلى {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</span>
        </div>
        <div class="exhibition-description">
            {{ $event->description_ar }}
        </div>
    </div>
</div>
@else
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center" style="color: rgb(0, 0, 0); display: flex; align-items: center; font-weight: bold; justify-content: center; margin-top: 200px; font-size: 35px; margin-right: -500px;">
            <h1>لا يوجد معرض</h1>
        </div>
    </div>
@endif

@endsection
