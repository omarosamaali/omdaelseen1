<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseService
{
    private $database;

    public function __construct()
    {
        $serviceAccountPath = storage_path('app/firebase-adminsdk.json');

        if (!file_exists($serviceAccountPath)) {
            throw new \Exception('Firebase service account file not found at: ' . $serviceAccountPath);
        }

        $factory = (new Factory)
            ->withServiceAccount($serviceAccountPath)
            ->withDatabaseUri('https://omdachina25-default-rtdb.firebaseio.com');

        $this->database = $factory->createDatabase();
    }

    /**
     * إرسال إشعار للأدمن في Realtime Database
     */
    public function notifyAdmin($message)
    {
        $notificationData = [
            'message' => $message,
            'timestamp' => time(),
            'read' => false
        ];

        // إضافة الإشعار في مسار admin_notifications
        $this->database
            ->getReference('notifications/admin')
            ->push($notificationData);

        return true;
    }

    /**
     * إرسال إشعار عام لكل المستخدمين
     */
    public function notifyAll($message)
    {
        $notificationData = [
            'message' => $message,
            'timestamp' => time(),
        ];

        $this->database
            ->getReference('notifications/all')
            ->push($notificationData);

        return true;
    }
}
