<html dir="rtl">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Cairo', sans-serif !important;
    }

    table {
        direction: rtl;
    }
</style>

<body style="background-color:#e2e1e0; font-size:100%;font-weight:400;line-height:1.4;color:#000;">
    <table
        style="direction: rtl;width:670px;margin:50px auto 0px;background-color:#fff;padding:50px;border-radius:3px;box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
        <thead>
            <tr>
                <th style="text-align:center; width: 100%;">
                    <img style="max-width: 150px;" src="https://chinaomda.com/public/assets/assets/images/sgin-logo.png"
                        alt="bachana tours">
                </th>
            </tr>
            <tr>
                <th style="text-align: center; font-size: 21px;">فاتورة دفع</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="height:35px;"></td>
            </tr>

            <tr>
                <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                    <p style="display: flex;width: 100%;text-align: right;font-size:14px;margin:0 0 6px 0;">
                        <span style="font-weight:bold;display:inline-block;min-width:150px">حالة الطلب</span>
                        <b style="color:green;">تم الدفع بنجاح</b>
                    </p>

                    <p style="display: flex;width: 100%;text-align: right;font-size:14px;margin:0 0 6px 0;">
                        <span style="font-weight:bold;display:inline-block;min-width:146px">رقم العملية</span>
                        {{ $booking->payment_intent_id }}
                    </p>

                    <p style="display: flex;width: 100%;text-align: right;font-size:14px;margin:0 0 6px 0;">
                        <span style="font-weight:bold;display:inline-block;min-width:146px">التاريخ</span>
                        {{ $booking->created_at->format('Y-m-d H:i') }}
                    </p>

                    <p
                        style="display: flex;width: 100%;text-align: right;font-size:14px;margin:0 0 0 0; display: flex; align-items: center;">
                        <span style="font-weight:bold;display:inline-block;min-width:146px">المبلغ</span>
                        {{ number_format($booking->amount, 2) }} درهم (شامل الرسوم)
                    </p>
                </td>
            </tr>

            <tr>
                <td style="height:35px;"></td>
            </tr>

            <tr>
                <td style="width:50%;padding:20px;vertical-align:top">
                    <p
                        style="display:flex;width:100%;text-align:right;align-items:center;justify-content:space-between;margin:0 0 10px 0;padding:0font-size:14px; display: flex; justify-content: space-between;">
                        <span style="font-weight:bold;font-size:13px">اسم العميل</span> {{ $user->name }}
                    </p>
                    <p
                        style="display:flex;width:100%;text-align:right;align-items:center;justify-content:space-between;margin:0 0 10px 0;padding:0font-size:14px; display: flex; justify-content: space-between;">
                        <span style="font-weight:bold;font-size:13px;">البريد الالكتروني</span> {{ $user->email }}
                    </p>
                    @if($user->phone ?? false)
                    <p
                        style="display:flex;width:100%;text-align:right;align-items:center;justify-content:space-between;margin:0 0 10px 0;padding:0font-size:14px; display: flex; justify-content: space-between;">
                        <span style="font-weight:bold;font-size:13px;">رقم الهاتف</span> {{ $user->phone }}
                    </p>
                    @endif
                    <p
                        style="display:flex;width:100%;text-align:right;align-items:center;justify-content:space-between;margin:0 0 10px 0;padding:0font-size:14px; display: flex; justify-content: space-between;">
                        <span style="font-weight:bold;font-size:13px;">رقم الطلب</span> {{ $booking->order_number }}
                    </p>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- تفاصيل الرحلة --}}
    <table
        style="direction: rtl;margin:auto;position:relative;top:-13px;width:670px;margin:-15px auto 0px;background-color:#fff;padding:20px;border-radius:3px;box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 1px #fab532;">
        <thead>
            <tr>
                <th style="text-align:right;">#</th>
                <th style="text-align:right;">التفاصيل</th>
                <th style="text-align:right;">المبلغ الأساسي</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:right;">1</td>
                <td style="text-align:right;">{{ $trip->title_ar ?? $trip->title }}</td>
                <td style="text-align:right;">{{ number_format($booking->amount - $booking->payment_gateway_fee, 2) }}
                    درهم</td>
            </tr>
        </tbody>
    </table>

    {{-- ملخص الدفع --}}
<table style="direction: rtl; margin:auto; position:relative; width:670px; 
    background-color:#fff; padding:20px; border-radius:3px;
    box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-collapse: collapse;position: relative;
    top: -26px;">
    <tr>
        <!-- العمود الأول (العناوين) -->
        <td style="vertical-align: top; text-align: right; width: 85%; ">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="border-bottom: 1px solid #ccc; text-align: right;">القيمة</th>
                </tr>
                <tr>
                    <th style="border-bottom: 1px solid #ccc; text-align: right;">رسوم بوابة الدفع</th>
                </tr>
                <tr>
                    <th style="background: maroon; color:white; border-bottom: 1px solid #ccc; text-align: right;">
                        الاجمالي</th>
                </tr>
            </table>
        </td>

        <!-- العمود الثاني (القيم) -->
        <td style="vertical-align: top; text-align: right; width: 15%;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:right;">
                        {{ number_format($booking->amount - $booking->payment_gateway_fee, 2) }}
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:right;">
                        {{ number_format($booking->payment_gateway_fee, 2) }}
                    </td>
                </tr>
                <tr>
                    <td
                        style="background:maroon; color:white; border-bottom:1px solid #ccc; border-right:1px solid #ccc; text-align:right;">
                        {{ number_format($booking->amount, 2) }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
    <div
        style="text-align:center;margin:auto;position:relative;top:-13px;border-top: solid 1px #fab532;display:flex;padding: 20px; max-width:630px; margin:-15px auto 50px; background-color:#fff;justify-content:center;">
        <div style="font-size:14px;justify-content:center;margin:auto;">
            <strong style="display:block; margin:0 0 10px 0;">مع تحيات عمدة الصين</strong>
            <a href="{{ url('/') }}" target="_blank">{{ url('/') }}</a><br><br>
            <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>
        </div>
    </div>
</body>

</html>