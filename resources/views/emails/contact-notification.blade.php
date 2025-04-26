<!DOCTYPE html>
<html>
<head>
    <title>رسالة جديدة من نموذج الاتصال</title>
    <style>
        body {
            direction: rtl;
            text-align: right;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        strong {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>رسالة جديدة وصلت</h2>
        <p>تم استلام رسالة جديدة من خلال نموذج "تواصل معنا". التفاصيل أدناه:</p>
        <ul>
            <li><strong>الاسم:</strong> {{ $contactMessage->name }}</li>
            <li><strong>البريد الإلكتروني:</strong> {{ $contactMessage->email }}</li>
            <li><strong>رقم الهاتف:</strong> {{ $contactMessage->phone }}</li>
            <li><strong>الرسالة:</strong> {{ $contactMessage->message }}</li>
            <li><strong>تاريخ الاستلام:</strong> {{ $contactMessage->receipt_date }}</li>
        </ul>
        <p>يمكنك الرد على هذه الرسالة من لوحة التحكم.</p>
    </div>
</body>
</html>