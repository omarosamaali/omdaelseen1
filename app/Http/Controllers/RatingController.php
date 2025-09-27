<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Places;
use App\Models\ReviewReport;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Support\Facades\Http;

use Kreait\Firebase\Messaging\Notification;
use Google\Client as GoogleClient;

class RatingController extends Controller
{
    private function getAccessToken()
    {
        try {
            $client = new GoogleClient();
            $firebaseCredentials = [
                'type' => env('FIREBASE_TYPE'),
                'project_id' => env('FIREBASE_PROJECT_ID'),
                'private_key_id' => env('FIREBASE_PRIVATE_KEY_ID'),
                'private_key' => str_replace('\\n', "\n", env('FIREBASE_PRIVATE_KEY')),
                'client_email' => env('FIREBASE_CLIENT_EMAIL'),
                'client_id' => env('FIREBASE_CLIENT_ID'),
                'auth_uri' => env('FIREBASE_AUTH_URI'),
                'token_uri' => env('FIREBASE_TOKEN_URI'),
                'client_secret' => '', // أضف ده

                'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
                'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-fbsvc%40' . env('FIREBASE_PROJECT_ID') . '.iam.gserviceaccount.com',
                'universe_domain' => 'googleapis.com'
            ];
            $client->setAuthConfig($firebaseCredentials);

            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

            $token = $client->fetchAccessTokenWithAssertion();

            if (isset($token['access_token'])) {
                return $token['access_token'];
            }

            \Log::error('❌ فشل الحصول على access token', ['token_response' => $token]);
            throw new \Exception('Failed to get access token from Google.');
        } catch (\Exception $e) {
            \Log::error('getAccessToken Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function reportReview(Request $request, Places $place)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'يجب تسجيل الدخول للإبلاغ عن المحتوى.'], 401);
        }

        $request->validate([
            'report_type' => 'required|string|in:review_report',
            'review_id' => 'required|exists:ratings,id',
        ]);

        // تحقق إن نفس المستخدم لم يبلغ عن نفس التقييم من قبل
        if (ReviewReport::where('user_id', Auth::id())
            ->where('place_id', $place->id)
            ->where('review_id', $request->review_id)
            ->exists()
        ) {
            return response()->json(['error' => 'لقد قمت بالإبلاغ عن هذا التقييم بالفعل.'], 422);
        }

        // سجل البلاغ
        $report = ReviewReport::create([
            'user_id' => Auth::id(),
            'place_id' => $place->id,
            'review_id' => $request->review_id,
            'report_type' => $request->report_type,
        ]);

        try {
            // جلب صاحب المكان
            $placeOwner = $place->user ?? null;

            if ($placeOwner && $placeOwner->fcm_token) {
                $this->sendFCMNotification(
                    $placeOwner->fcm_token,
                    'تم الإبلاغ عن تقييم جديد',
                    'تم الإبلاغ عن أحد التقييمات في مكانك: ' . ($place->name_ar ?? $place->name_en),
                    $place->id,
                    $request->review_id
                );
            }
        } catch (\Exception $e) {
            Log::error('فشل إرسال إشعار FCM لصاحب المكان', [
                'error' => $e->getMessage(),
                'place_id' => $place->id
            ]);
        }

        return response()->json(['success' => true, 'message' => 'تم تسجيل البلاغ بنجاح!'], 201);
    }

    private function sendFCMNotification($token, $title, $body, $placeId = null, $reviewId = null)
    {
        try {
            $accessToken = $this->getAccessToken();

            \Log::info('🔔 Sending FCM Notification', [
                'token' => $token,
                'title' => $title,
                'body'  => $body,
                'place_id' => $placeId,
                'review_id' => $reviewId
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/v1/projects/omdachina25/messages:send', [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => [
                        'type' => 'review_report',
                        'place_id' => (string) $placeId,
                        'review_id' => (string) $reviewId,
                    ],
                    'webpush' => [
                        'fcm_options' => [
                            'link' => url('/mobile/info_place/' . $placeId)
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                \Log::error('FCM Send Failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Notification Send Error: ' . $e->getMessage());
        }
    }

    public function store(Request $request, Places $place)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'يجب تسجيل الدخول لتقييم المكان.'], 401);
        }

        // ✅ التحقق من القيم المدخلة
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // ✅ منع التقييم المكرر
        if (Rating::where('user_id', Auth::id())->where('place_id', $place->id)->exists()) {
            return response()->json(['error' => 'لقد قيّمت هذا المكان بالفعل.'], 422);
        }

        // ✅ إنشاء التقييم
        $rating = Rating::create([
            'user_id' => Auth::id(),
            'place_id' => $place->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // ✅ إرسال إشعار لصاحب المكان (لو عنده FCM Token)
        try {
            $owner = $place->user; // صاحب المكان
            if ($owner && $owner->fcm_token) {
                // إنشاء array من بيانات .env
                $firebaseCredentials = [
                    'type' => env('FIREBASE_TYPE'),
                    'project_id' => env('FIREBASE_PROJECT_ID'),
                    'private_key_id' => env('FIREBASE_PRIVATE_KEY_ID'),
                    'private_key' => str_replace('\\n', "\n", env('FIREBASE_PRIVATE_KEY')),
                    'client_email' => env('FIREBASE_CLIENT_EMAIL'),
                    'client_id' => env('FIREBASE_CLIENT_ID'),
                    'auth_uri' => env('FIREBASE_AUTH_URI'),
                    'client_secret' => '', // أضف ده

                    'token_uri' => env('FIREBASE_TOKEN_URI'),
                    'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
                    'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-fbsvc%40' . env('FIREBASE_PROJECT_ID') . '.iam.gserviceaccount.com',
                    'universe_domain' => 'googleapis.com'
                ];

                // إنشاء ملف مؤقت
                $tempFile = storage_path('app/temp-firebase.json');
                file_put_contents($tempFile, json_encode($firebaseCredentials));

                // استخدام نفس الكود القديم
                $factory = (new Factory)->withServiceAccount($tempFile);
                $messaging = $factory->createMessaging();

                $message = [
                    'token' => $owner->fcm_token,
                    'notification' => [
                        'title' => 'تقييم جديد لمكانك',
                        'body'  => 'قام ' . Auth::user()->name . ' بتقييم ' . $place->name_ar . ' بـ ' . $request->rating . ' نجوم',
                    ],
                    'data' => [
                        'type' => 'rating',
                        'id'   => (string)$rating->id,
                        'place_id' => (string)$place->id,
                    ],
                ];

                $messaging->send($message);
            }
        } catch (\Throwable $e) {
            \Log::error('فشل إرسال إشعار التقييم: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'تم حفظ تقييمك بنجاح!',
            'rating'  => $rating
        ], 201);
    }


    public function updateRating(Request $request, Places $place, Rating $rating)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'يجب تسجيل الدخول لتعديل التقييم.'], 401);
        }
        if ($rating->user_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح لك بتعديل هذا التقييم.'], 403);
        }
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);
        $rating->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return response()->json(['message' => 'تم تحديث تقييمك بنجاح!', 'rating' => $rating], 200);
    }

    public function deleteRating(Request $request, Places $place, Rating $rating)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'يجب تسجيل الدخول لحذف التقييم.'], 401);
        }
        if ($rating->user_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح لك بحذف هذا التقييم.'], 403);
        }
        $rating->delete();
        return response()->json(['message' => 'تم حذف تقييمك بنجاح!'], 200);
    }




    public function getReviews(Places $place)
    {
        try {
            if (!$place->exists()) {
                return response()->json(['error' => 'المكان غير موجود.'], 404);
            }
            $reviews = Rating::where('place_id', $place->id)
                ->with('user')
                ->get()
                ->map(function ($review) {
                    $hasReported = Auth::check() && ReviewReport::where('user_id', Auth::id())
                        ->where('review_id', $review->id)
                        ->exists();
                    return [
                        'id' => $review->id,
                        'name' => $review->user->name,
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'created_at' => $review->created_at->toDateTimeString(),
                        'avatar' => $review->user->avatar ? $review->user->avatar[0] : 'أ',
                        'user_id' => $review->user_id,
                        'has_reported' => $hasReported,
                    ];
                });
            \Log::info('Fetching reviews for place_id: ' . $place->id);
            return response()->json(['reviews' => $reviews], 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching reviews: ' . $e->getMessage());
            return response()->json(['error' => 'فشل في جلب التقييمات.'], 500);
        }
    }
}
