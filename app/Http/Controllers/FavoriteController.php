<?php

namespace App\Http\Controllers;

use App\Models\Places;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();
        $placeId = $request->place_id;
        $place = Places::findOrFail($placeId);

        // Toggle favorite status
        $user->favoritePlaces()->toggle($placeId);
        $isFavorited = $user->favoritePlaces()->where('place_id', $placeId)->exists();

        if ($isFavorited) {
            // Send notification to admins
            $adminTokens = User::where('role', 'admin')
                ->whereNotNull('fcm_token')
                ->pluck('fcm_token')
                ->toArray();

            Log::info('=== FCM Debug Info for Favorite ===');
            Log::info('Admin users with FCM tokens: ' . count($adminTokens));
            Log::info('Admin tokens:', $adminTokens);

            if (count($adminTokens) > 0) {
                $notificationData = [
                    'title' => '❤️ مكان تم إضافته للمفضلة',
                    'body' => $place->name_ar,
                    'type' => 'place_favorited',
                    'place_id' => $place->id,
                    'place_name' => $place->name_ar,
                ];

                Log::info('Notification data:', $notificationData);
                $response = $this->sendFirebaseNotification($adminTokens, $notificationData);
                Log::info('FCM Send result: ' . ($response ? 'SUCCESS' : 'FAILED'));
            } else {
                Log::warning('No admin users with FCM tokens found!');
            }

            return response()->json(['status' => 'added', 'message' => 'تمت الإضافة إلى المفضلة.']);
        } else {
            return response()->json(['status' => 'removed', 'message' => 'تمت الإزالة من المفضلة.']);
        }
    }

    private function sendFirebaseNotification(array $tokens, array $data)
    {
        try {
            $serviceAccountPath = storage_path('app/firebase/omdachina25-firebase-adminsdk.json');
            if (!file_exists($serviceAccountPath)) {
                Log::error('Firebase service account file not found');
                return false;
            }

            $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);
            $accessToken = $this->createJWTToken($serviceAccount);
            if (!$accessToken) {
                Log::error('Failed to create JWT token');
                return false;
            }

            $url = "https://fcm.googleapis.com/v1/projects/{$serviceAccount['project_id']}/messages:send";
            $successCount = 0;

            foreach ($tokens as $token) {
                $payload = [
                    "message" => [
                        "token" => $token,
                        "notification" => [
                            "title" => $data['title'],
                            "body" => $data['body'],
                        ],
                        "data" => [
                            "type" => $data['type'] ?? '',
                            "place_id" => (string)($data['place_id'] ?? ''),
                            "place_name" => $data['place_name'] ?? '',
                            "click_action" => "FLUTTER_NOTIFICATION_CLICK"
                        ]
                    ]
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Authorization: Bearer {$accessToken}",
                    "Content-Type: application/json",
                ]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                Log::info("FCM Response for token:", ['http_code' => $httpCode, 'response' => $response]);
                if ($httpCode === 200) {
                    $successCount++;
                }
            }

            Log::info("FCM Summary: {$successCount} success, " . (count($tokens) - $successCount) . " failed");
            return $successCount > 0;
        } catch (\Exception $e) {
            Log::error('FCM Error: ' . $e->getMessage());
            return false;
        }
    }

    private function createJWTToken($serviceAccount)
    {
        try {
            $tokenUrl = 'https://oauth2.googleapis.com/token';
            $postData = [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $this->createJWT($serviceAccount)
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $tokenUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded'
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $tokenData = json_decode($response, true);
                return $tokenData['access_token'] ?? null;
            }

            Log::error('OAuth token error:', ['response' => $response, 'code' => $httpCode]);
            return null;
        } catch (\Exception $e) {
            Log::error('JWT creation error: ' . $e->getMessage());
            return null;
        }
    }

    private function createJWT($serviceAccount)
    {
        $header = json_encode([
            'alg' => 'RS256',
            'typ' => 'JWT'
        ]);

        $now = time();
        $payload = json_encode([
            'iss' => $serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ]);

        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = '';
        openssl_sign(
            $base64Header . '.' . $base64Payload,
            $signature,
            $serviceAccount['private_key'],
            'SHA256'
        );

        $base64Signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64Header . '.' . $base64Payload . '.' . $base64Signature;
    }
}
