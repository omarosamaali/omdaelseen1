<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCMController extends Controller
{
    public function sendTestNotification()
    {
        // إنشاء Messaging object
        $factory = (new Factory)->withServiceAccount(storage_path('firebase/service-account.json'));
        $messaging = $factory->createMessaging();

        // استخدم التوكن الصح اللي ظهر عندك
        $token = 'cgekkv8PJkPn6GkY6NfgIc:APA91bGnsbQwyN_Wqd62TJ6T5ev8-H7RRUxgTQZRfcU6ImKHwMVDBiswQnVQBraAmU0nXtfzlMNx06mG0eZ5-X423gCGfOJT562eJslR9KOakKesJ0oT3zM';

        // إنشاء إشعار
        $notification = Notification::create('رسالة اختبار', 'هذا إشعار تجريبي من Laravel');

        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        // إرسال الإشعار
        $messaging->send($message);

        return 'تم إرسال الإشعار بنجاح!';
    }
}
