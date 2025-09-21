<!-- ملف mobile/auth/auto-payment.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ $csrf_token }}">
    <title>جاري التحويل للدفع...</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loading-container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 90%;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .loading-subtext {
            font-size: 14px;
            color: #666;
        }

        .trip-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-right: 4px solid #667eea;
        }

        .trip-title {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>

<body>
    <div class="loading-container">
        <div class="success-message">
            ✅ تم إنشاء حسابك بنجاح!
        </div>

        <div class="trip-info">
            <div class="trip-title">{{ $trip->title_ar ?? $trip->title_en }}</div>
            <div style="font-size: 12px; color: #666;">
                المغادرة: {{ \Carbon\Carbon::parse($trip->departure_date)->format('d/m/Y') }} |
                العودة: {{ \Carbon\Carbon::parse($trip->return_date)->format('d/m/Y') }}
            </div>
        </div>

        <div class="spinner"></div>
        <div class="loading-text">جاري التحويل لصفحة الدفع...</div>
        <div class="loading-subtext">سيتم توجيهك خلال ثوانٍ قليلة</div>

        <!-- الفورم المخفي للدفع التلقائي -->
        <form id="auto-payment-form" method="POST" action="{{ $payment_url }}" style="display: none;">
            @csrf
        </form>
    </div>

    <script>
        // تشغيل الفورم تلقائياً بعد ثانيتين
        setTimeout(function() {
            document.getElementById('auto-payment-form').submit();
        }, 2000);
        
        // backup: إذا لم يعمل auto-submit
        setTimeout(function() {
            window.location.href = "{{ route('mobile.auth.done') }}";
        }, 10000);
    </script>
</body>

</html>