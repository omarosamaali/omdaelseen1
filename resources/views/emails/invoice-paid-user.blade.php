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
            background-color: #10b981;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .invoice-details {
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

        .amount {
            font-size: 24px;
            color: #10b981;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .success-icon {
            font-size: 48px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>✅ تم الدفع بنجاح</h1>
            <p>Payment Successful</p>
        </div>

        <div class="content">
            <div class="success-icon">✅</div>

            <p>عزيزي/عزيزتي <strong>{{ $user->name ?? 'العميل' }}</strong>،</p>

            <p>نشكرك على إتمام عملية الدفع. تم استلام دفعتك بنجاح.</p>

            <div class="invoice-details">
                <h3 style="margin-top: 0; color: #111827;">تفاصيل الفاتورة</h3>

                <div class="detail-row">
                    <span class="label">رقم الفاتورة:</span>
                    <span class="value">{{ $invoice->invoice_number ?? 'غير محدد' }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">العنوان:</span>
                    <span class="value">{{ $invoice->title ?? 'بدون عنوان' }}</span>
                </div>

                <div class="detail-row">
                    <span class="label">تاريخ الفاتورة:</span>
                    <span class="value">
                        {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') :
                        'غير محدد' }}
                    </span>
                </div>

                <div class="detail-row">
                    <span class="label">تاريخ الدفع:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($invoice->paid_at)->format('Y-m-d H:i') }}</span>
                </div>
            </div>

            <div class="amount">
                المبلغ المدفوع: @php
                $feePercent = 7.9 / 100;
                $fixedFee = 1;
                $finalAmount = ($invoice->amount * (1 + $feePercent)) + $fixedFee;
                @endphp
                {{ number_format($finalAmount, 2) }}  درهم
            </div>

            {{-- <p>سيتم إرسال نسخة من الفاتورة إلى بريدك الإلكتروني.</p>

            <p>إذا كان لديك أي استفسارات، لا تتردد في التواصل معنا.</p>

            <p style="margin-top: 30px;">
                مع تحياتنا،<br>
                <strong>فريق العمل</strong>
            </p> --}}
        </div>
{{-- 
        <div class="footer">
            <p>هذا الإيميل تم إرساله تلقائياً، الرجاء عدم الرد عليه.</p>
            <p>This email was sent automatically, please do not reply.</p>
        </div> --}}
    </div>
</body>

</html>