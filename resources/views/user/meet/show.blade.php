@extends('layouts.appOmdahome')

@section('content')
<style>
    .news-container {
        margin-top: 60px;
        margin-right: auto;
        margin-left: auto;
        margin-bottom: 60px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .news-image-container { /* حاوية جديدة للصورة عشان نتحكم في أبعادها */
        width: 1112px; /* حدد العرض الثابت اللي عايزه */
        height: 400px; /* حدد الارتفاع الثابت اللي عايزه */
        margin-bottom: 30px;
        overflow: hidden; /* عشان لو الصورة أكبر من الحاوية، الجزء الزيادة يختفي */
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .news-image {
        width: 100%; /* خلي الصورة تاخد كامل عرض الحاوية */
        height: 100%; /* خلي الصورة تاخد كامل ارتفاع الحاوية */
        object-fit: cover; /* قص الصورة عشان تغطي الحاوية بالكامل مع الحفاظ على أبعادها */
    }

    .news-details {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.07);
        width: 80%;
        border-right: 5px solid #007bff;
        text-align: right;
    }

    .news-title {
        color: #071739;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .news-dates {
        color: #777;
        font-size: 16px;
        margin-bottom: 15px;
    }

    .news-description {
        font-size: 18px;
        color: #333;
        line-height: 1.8;
        margin-bottom: 30px;
        white-space: pre-line;
    }
</style>

<div class="container news-container">
    @if($event)
        <div class="news-image-container">
            <img src="{{ asset('storage/' . $event->avatar) }}" alt="{{ $event->title_ar }}" class="news-image">
        </div>
        <div class="news-details">
            <h1 class="news-title">{{ $event->title_ar }}</h1>
            <div class="news-dates">
                <span>تاريخ البدء: {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                <br>
                <span>تاريخ الانتهاء: {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</span>
            </div>
            <div class="news-description">
                {{ $event->description_ar }}
            </div>
        </div>
    @else
        <div class="col-md-12 text-center" style="color: rgb(0, 0, 0); display: flex; align-items: center; font-weight: bold; justify-content: center; margin-top: 200px; font-size: 35px; margin-right: 0;">
            <h1>الخبر غير موجود</h1>
        </div>
    @endif
</div>

@endsection