@extends('layouts.appOmdahome')

@section('content')
    <style>
        .exhibition-container {
            margin-top: 60px;
            margin-right: 68px;
            margin-bottom: 60px;
            display: flex;
            flex-direction: row-reverse;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 40px;
        }

        .exhibition-item {
            max-width: 400px;
            flex-direction: row-reverse;
            align-items: center;
            gap: 20px;
        }

        .exhibition-image {
            width: 383px;
            height: 212px;
        }

        .exhibition-details {
            background-color: #f8faff;
            padding: 10px 20px;
            height: 169px;
        }

        .exhibition-title {
            color: #071739;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .exhibition-dates {
            color: #777;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .exhibition-description {
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }
    </style>

<h1 style="color: #071739; font-weight: bold; margin-bottom: 20px; font-size: 35px; margin-right: 200px; margin-top: 50px;">جميع المناسبات المتاحة</h1>
    <div class="container exhibition-container">
        @if (count($events) > 0)
            @foreach ($events as $event)
                @if ($event->type === 'مناسبة')
                    <div class="exhibition-item">
                        <div>
                            <img src="{{ asset('storage/' . $event->avatar) }}" alt="{{ $event->title_ar }}"
                                class="exhibition-image">
                        </div>
                        <div class="exhibition-details">
                            <div class="exhibition-title">{{ $event->title_ar }}</div>
                            <div class="exhibition-dates">
                                <span>من {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span> -
                                <span>إلى {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</span>
                            </div>
                            <div class="exhibition-description" style="margin-bottom: 20px;">
                                {{ Str::limit($event->description_ar, 50) }}
                            </div>
                            <div>
                                <a href="{{ route('users.meet.show', $event->id) }}"
                                    style="background: #071739; color: #fff; margin-top: 20px; padding: 4px 11px; border-radius: 4px; text-decoration: none;">
                                    المزيد
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div class="col-md-12 text-center"
                style="color: rgb(0, 0, 0); display: flex; align-items: center; font-weight: bold; justify-content: center; margin-top: 200px; font-size: 35px; margin-right: -500px;">
                <h1>لا يوجد معارض</h1>
            </div>
        @endif
    </div>

@endsection
