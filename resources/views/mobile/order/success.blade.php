<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head><link rel="icon" href="{{ asset('assets/assets/images/logo.png') }}" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم بنجاح!</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-container {
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: #4CAF50;
            border-radius: 50%;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bounceIn 0.8s ease-out;
            box-shadow: 0 10px 30px rgba(76, 175, 80, 0.3);
            position: relative;
            /* إضافة للحركة النبضية */
        }

        .success-icon::before {
            content: '✓';
            color: white;
            font-size: 50px;
            font-weight: bold;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-message {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
            animation: fadeIn 1s ease-out 0.3s both;
        }

        .reference-label {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        .reference-number {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
            background: #f0f8f0;
            padding: 15px 25px;
            border-radius: 10px;
            border: 2px solid #e8f5e8;
            margin: 0 auto;
            display: inline-block;
            animation: fadeIn 1s ease-out 0.7s both;
            letter-spacing: 1px;
            white-space: nowrap;
            /* منع الكود من الانقسام */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .back-button {
            margin-top: 40px;
            animation: fadeIn 1s ease-out 0.9s both;
        }

        .btn {
            background: #4CAF50;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        /* Mobile responsive */
        @media (max-width: 480px) {
            .success-icon {
                width: 80px;
                height: 80px;
            }

            .success-icon::before {
                font-size: 40px;
            }

            .success-message {
                font-size: 18px;
            }

            .reference-number {
                font-size: 20px;
                padding: 12px 20px;
            }
        }

        .success-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border: 3px solid rgba(76, 175, 80, 0.3);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(1.3);
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div class="success-container">
        <div class="success-icon"></div>

        <div class="success-message">
            تم إرسال الطلب الخاص بك بنجاح
        </div>

        <div class="reference-label">
            رقم المرجع
        </div>

        <div class="reference-number" id="referenceDisplay">
            #{{ session('reference_number') }}
        </div>
        
        <div class="back-button">
            <a href="{{ route('mobile.welcome') }}" class="btn">العودة للرئيسية</a>
        </div>
    </div>
</body>

</html>