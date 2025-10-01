<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Google\Client;
use Illuminate\Support\Facades\Http;

class FirebaseService
{
    private $database;
    private $client;
    private $projectId;

    public function __construct()
    {
        $serviceAccountPath = storage_path('app/firebase-adminsdk.json');

        if (!file_exists($serviceAccountPath)) {
            throw new \Exception('Firebase service account file not found at: ' . $serviceAccountPath);
        }

        // Realtime Database
        $factory = (new Factory)
            ->withServiceAccount($serviceAccountPath)
            ->withDatabaseUri('https://omdachina25-default-rtdb.firebaseio.com');

        $this->database = $factory->createDatabase();

        // FCM Push Notifications
        $this->projectId = config('services.fcm.project_id', 'omdachina25');
        $this->client = new Client();
        $this->client->setAuthConfig($serviceAccountPath);
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging');
    }

    /**
     * إشعار للأدمن في Realtime Database
     */
    public function notifyAdmin($message)
    {
        $notificationData = [
            'message' => $message,
            'timestamp' => time(),
            'read' => false,
        ];

        $this->database
            ->getReference('notifications/admin')
            ->push($notificationData);

        return true;
    }

    /**
     * إشعار عام في Realtime Database
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

    /**
     * إرسال إشعار Push عبر FCM
     */
    public function sendFCM($deviceToken, $title, $body)
    {
        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $payload = [
            "message" => [
                "token" => $deviceToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                ],
            ],
        ];

        $accessToken = $this->client->fetchAccessTokenWithAssertion()['access_token'];

        $response = Http::withToken($accessToken)->post($url, $payload);

        return $response->json();
    }
}
