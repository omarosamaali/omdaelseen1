<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
    <title>تأكيد الحجز</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f4;">
    <div style="text-align: center; padding: 20px; font-family: Arial, sans-serif;">
        <img src="https://chinaomda.com/public/assets/assets/images/sgin-logo.png" alt="عمدة الصين"
            style="max-width: 150px; margin-bottom: 20px;">

        <div
            style="text-align: right; background: #f9f9f9; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto;">
            <h3 style="color: #006400;">✅ تم الاشتراك في الرحلة بنجاح</h3>

            <p>عزيزي/عزيزتي <strong>{{ $customerName }}</strong>,</p>

            <p>نشكرك على حجزك معنا! تم تأكيد حجزك بنجاح.</p>

            <div style="background: white; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <h4 style="color: #006400; margin-top: 0;">تفاصيل الحجز:</h4>
                <p><strong>رقم الطلب:</strong> {{ $orderNumber }}</p>
                <p><strong>الرحلة:</strong> {{ $tripTitle }}</p>
                <p><strong>نوع الغرفة:</strong> {{ $roomType }}</p>
                <p><strong>المبلغ المدفوع:</strong> {{ number_format($amount, 2) }} AED</p>
                <p><strong>تاريخ الحجز:</strong> {{ $bookingDate }}</p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $tripUrl }}" style="background-color: #006400; 
                          color: white; 
                          padding: 12px 30px; 
                          text-decoration: none; 
                          border-radius: 5px; 
                          display: inline-block;
                          font-weight: bold;">
                    عرض تفاصيل الرحلة 🎒
                </a>
            </div>

            <p style="background: #fff3cd; padding: 10px; border-radius: 5px; border-right: 4px solid #ffc107;">
                💡 <strong>ملاحظة:</strong> سيتم التواصل معك قريباً لتأكيد تفاصيل السفر.
            </p>

            <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">

            <p style="font-size: 12px; color: #777;">
                في حالة وجود أي استفسار، يرجى التواصل معنا.<br>
                شكراً لاختيارك عمدة الصين 💙
            </p>
        </div>
    </div>
</body>

</html>