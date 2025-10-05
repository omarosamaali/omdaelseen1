<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مكان جديد</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f4;">
    <div style="text-align: center; padding: 20px; font-family: Arial, sans-serif;">
        <img src="https://chinaomda.com/public/assets/assets/images/sgin-logo.png" alt="عمدة الصين"
            style="max-width: 150px; margin-bottom: 20px;">

        <div
            style="text-align: right; background: #f9f9f9; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto;">
            <h3 style="color: #006400;">🎉 تم إضافة مكان جديد</h3>

            <p>مرحباً <strong>{{ $userName }}</strong>,</p>

            <p>تم إضافة مكان جديد: <strong>{{ $placeName }}</strong></p>

            <p>{{ $placeDescription }}</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $placeUrl }}" style="background-color: #006400; 
                          color: white; 
                          padding: 12px 30px; 
                          text-decoration: none; 
                          border-radius: 5px; 
                          display: inline-block;
                          font-weight: bold;">
                    عرض تفاصيل المكان 👀
                </a>
            </div>

            <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">

            <p style="font-size: 12px; color: #777;">شكراً لاستخدامك عمدة الصين 💙</p>
        </div>
    </div>
</body>

</html>