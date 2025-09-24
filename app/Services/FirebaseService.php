<?php

namespace App\Services;

use Google\Client;
use GuzzleHttp\Client as HttpClient;

class FirebaseService
{
    private function getAccessToken()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/firebase-adminsdk.json'));
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $token = $client->fetchAccessTokenWithAssertion();
        return $token['access_token'];
    }

    public function sendNotificationToAll($title, $body)
    {
        $accessToken = $this->getAccessToken();

        $http = new HttpClient();

        $response = $http->post('https://fcm.googleapis.com/v1/projects/omdachina25/messages:send', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'message' => [
                    'topic' => 'all_users', // 🔔 أي حد مشترك في الـ topic ده هيوصله إشعار
                    'notification' => [
                        'title' => $title,
                        'body'  => $body,
                    ],
                ],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
