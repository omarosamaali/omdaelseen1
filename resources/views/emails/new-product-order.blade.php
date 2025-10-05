<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            direction: rtl;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #2563eb;
            color: white;
            text-align: center;
            padding: 25px;
        }

        .section {
            padding: 20px 30px;
        }

        h2 {
            color: #2563eb;
            margin-bottom: 10px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
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
            text-align: left;
        }

        .product-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            margin-top: 15px;
            background: #f9fafb;
        }

        .footer {
            background-color: #f9fafb;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }

        .alert {
            background: #dbeafe;
            border-right: 5px solid #2563eb;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <div class="container" style="direction: rtl; text-align: right;">
        <div class="header">
            <h1>🛒 طلب منتجات جديد</h1>
            <p>New Product Order Received</p>
        </div>

        <div class="section">
            <div class="alert">
                <strong>تنبيه:</strong> تم استلام طلب منتجات جديد من أحد العملاء.
            </div>

            <h2>معلومات العميل</h2>
            <div class="detail-row">
                <span class="label">الاسم:</span>
                <span class="value">{{ $productOrder->user->name ?? 'غير محدد' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">البريد الإلكتروني:</span>
                <span class="value">{{ $productOrder->user->email ?? 'غير محدد' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">رقم الهاتف:</span>
                <span class="value">{{ $productOrder->user->phone ?? 'غير محدد' }}</span>
            </div>
        </div>

        <div class="section">
            <h2>تفاصيل الطلب</h2>
            <div class="detail-row">
                <span class="label">رقم المرجع:</span>
                <span class="value">{{ $productOrder->reference_number }}</span>
            </div>
            <div class="detail-row">
                <span class="label">عدد المنتجات:</span>
                <span class="value">{{ $productOrder->number_of_products }}</span>
            </div>
            <div class="detail-row">
                <span class="label">التعامل مع السعر غير المتوقع:</span>
                <span class="value">{{ $productOrder->price_unexpected }}</span>
            </div>
            <div class="detail-row">
                <span class="label">المنتج غير متوفر:</span>
                <span class="value">{{ $productOrder->item_unavailable }}</span>
            </div>
            <div class="detail-row">
                <span class="label">منتجات نفس الشركة:</span>
                <span class="value">{{ $productOrder->same_company }}</span>
            </div>
            <div class="detail-row">
                <span class="label">هل يحتوي على بطاريات؟</span>
                <span class="value">{{ $productOrder->batteries }}</span>
            </div>
        </div>

        <div class="section">
            <h2>المنتجات المطلوبة</h2>
            @foreach($productOrder->orderProducts as $product)
            <div class="product-card">
                <div><strong>الاسم:</strong> {{ $product->name }}</div>
                <div><strong>الكمية:</strong> {{ $product->quantity }}</div>
                @if($product->price)
                <div><strong>السعر:</strong> {{ $product->price }} درهم</div>
                @endif
                @if($product->link)
                <div><strong>الرابط:</strong> <a href="{{ $product->link }}">{{ $product->link }}</a></div>
                @endif
                @if($product->notes)
                <div><strong>ملاحظات:</strong> {{ $product->notes }}</div>
                @endif
                {{-- @if(!empty($product->images))
                <div style="margin-top:10px;">
                    <strong>الصور:</strong><br>
                    @foreach(json_decode($product->images, true) as $img)
                    <img src="{{ asset('storage/' . $img) }}" alt="Product Image">
                    @endforeach
                </div>
                @endif --}}
            </div>
            @endforeach
        </div>

        <div class="footer">
            تم إرسال هذا الإشعار تلقائيًا من نظام الطلبات.
        </div>
    </div>
</body>

</html>