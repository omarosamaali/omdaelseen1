<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            direction: rtl;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #3b82f6;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .trip-details {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: bold;
            color: #374151;
        }

        .value {
            color: #6b7280;
        }

        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .alert {
            background-color: #dbeafe;
            border-right: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container" style="direction: rtl; text-align: right;">
        <div class="header">
            <h1>📩 تم استلام طلب رحلة جديد</h1>
            <p>New Trip Request Received</p>
        </div>

        <div class="content">
            <div class="alert">
                <strong>تنبيه:</strong> تم استلام طلب رحلة جديد من أحد العملاء
            </div>

            <h3>معلومات العميل:</h3>
            <div class="trip-details">
                <div class="detail-row">
                    <span class="label">الاسم:</span>
                    <span class="value">{{ $tripRequest->user->name ?? 'غير محدد' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">البريد الإلكتروني:</span>
                    <span class="value">{{ $tripRequest->user->email ?? 'غير محدد' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">رقم الهاتف:</span>
                    <span class="value">{{ $tripRequest->user->phone ?? 'غير محدد' }}</span>
                </div>
            </div>

            <h3>تفاصيل الرحلة:</h3>
            <div class="trip-details">
                <div class="detail-row">
                    <span class="label">رقم المرجع:</span>
                    <span class="value">{{ $tripRequest->reference_number ?? 'غير محدد' }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">عدد المسافرين:</span>
                    <span class="value">{{ $tripRequest->travelers_count ?? 'غير محدد' }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">الاهتمامات:</span>
                    <span class="value">
                        @if(!empty($tripRequest->interests))
                        {{ implode('، ', $tripRequest->interests) }}
                        @else
                        غير محدد
                        @endif
                    </span>
                </div>

                <div class="detail-row">
                    <span class="label">تاريخ الإنشاء:</span>
                    <span class="value">{{ $tripRequest->created_at ? $tripRequest->created_at->format('Y-m-d H:i') : 'غير محدد'
                        }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            تم إرسال هذا الإشعار تلقائيًا من نظام الرحلات.
        </div>
    </div>
</body>

</html>