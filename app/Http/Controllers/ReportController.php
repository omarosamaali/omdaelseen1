<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReviewReport;
use App\Models\Places;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;  // ضيف السطر ده

class ReportController extends Controller
{
    public function mobileIndex(Request $request)
    {
        $query = Report::with(['user', 'place', 'place.user']);
        if ($request->has('filter') && $request->filter) {
            $filter = $request->filter;
            switch ($filter) {
                case 'pending':
                    $query->where('status', 'pending');
                    break;
                case 'resolved':
                    $query->where('status', 'resolved');
                    break;
                case 'dismissed':
                    $query->where('status', 'dismissed');
                    break;
            }
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(20);
        $all_reports = Report::count();
        $review_reports = ReviewReport::with(['user', 'place', 'place.user', 'rating'])
            ->orderBy('created_at', 'desc')
            ->get();
        $currentFilter = $request->filter;
        return view('mobile.admin.reports.index', compact('reports', 'review_reports', 'currentFilter', 'all_reports'))
            ->with('layout', 'layouts.mobile');
    }

    public function mobileShow($id)
    {
        $report = Report::with(['user', 'place', 'place.user'])->findOrFail($id);
        return view('mobile.admin.reports.show', compact('report'))
            ->with('layout', 'layouts.mobile');
    }

    public function mobileReviewShow($id)
    {
        $report = ReviewReport::with(['user', 'place', 'place.user', 'rating'])->findOrFail($id);
        return view('mobile.admin.reports.review_show', compact('report'))
            ->with('layout', 'layouts.mobile');
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:content_report,fake_account',
            'user_id' => 'required|exists:users,id',
            'place_id' => 'required|exists:places,id',
        ]);

        $report = Report::create([
            'user_id' => $request->user_id,
            'place_id' => $request->place_id,
            'report_type' => $request->report_type,
        ]);

        if ($report) {
            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل البلاغ بنجاح'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'فشل تسجيل البلاغ'
        ], 500);
    }

    public function reportPlace(Request $request, $placeId)
    {
        try {
            $place = Places::findOrFail($placeId);

            $existingReport = Report::where('user_id', Auth::id())
                ->where('place_id', $placeId)
                ->first();

            if ($existingReport) {
                return response()->json([
                    'success' => false,
                    'error' => 'لقد أبلغت عن هذا المكان من قبل'
                ], 400);
            }

            $report = Report::create([
                'user_id' => Auth::id(),
                'place_id' => $placeId,
            ]);

            // 📢 إشعار لصاحب المكان
            $owner = $place->user;
            if ($owner && $owner->fcm_token) {
                $this->sendNotificationToOwner($owner, $place, $report);
            }

            // 📢 إشعار لكل الأدمنز
            $admins = \App\Models\User::where('role', 'admin')
                ->whereNotNull('fcm_token')
                ->pluck('fcm_token');

            foreach ($admins as $token) {
                $this->sendNotificationToAdmin($token, $place, $report);
            }

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل البلاغ بنجاح'
            ]);
        } catch (\Exception $e) {
            \Log::error('Report Place Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ أثناء تسجيل البلاغ'
            ], 500);
        }
    }
    private function sendNotificationToAdmin($token, $place, $report)
    {
        try {
            $accessToken = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/v1/projects/omdachina25/messages:send', [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => '🚨 بلاغ جديد ضد مكان',
                        'body'  => 'تم الإبلاغ عن: ' . ($place->name_ar ?? 'مكان غير معروف'),
                    ],
                    'data' => [
                        'type'      => 'admin_place_report',
                        'place_id'  => (string)$place->id,
                        'place_name' => $place->name_ar ?? 'مكان غير معروف',
                        'report_id' => (string)$report->id,
                    ],
                    'webpush' => [
                        'fcm_options' => [
                            // لو عندك صفحة للإدارة تعرض البلاغات
                            'link' => url('/admin/reports/places/' . $report->id)
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                \Log::error('FCM Admin Send Failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Log::error('Notification Admin Send Error: ' . $e->getMessage());
        }
    }


    private function sendNotificationToOwner($owner, $place, $report)
    {
        try {
            // الحصول على access token من Google
            $accessToken = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post('https://fcm.googleapis.com/v1/projects/omdachina25/messages:send', [
                'message' => [
                    'token' => $owner->fcm_token,
                    'notification' => [
                        'title' => 'تم الإبلاغ عن مكانك',
                        'body'  => 'تم تلقي بلاغ جديد عن مكانك: ' . ($place->name_ar ?? 'مكان غير معروف'),
                    ],
                    'data' => [
                        'type'      => 'place_report',
                        'place_id'  => (string)$place->id,
                        'place_name' => $place->name_ar ?? 'مكان غير معروف',
                        'report_id' => (string)$report->id,
                        'status'    => $report->status ?? 'pending', // مهم عشان UI يعرف نوع الرسالة
                    ],
                    'webpush' => [
                        'fcm_options' => [
                            'link' => url('/mobile/info_place/' . $place->id)
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                \Log::error('FCM Send Failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Log::error('Notification Send Error: ' . $e->getMessage());
        }
    }

    private function getAccessToken()
    {
        $firebaseCredentials = [
            'type' => env('FIREBASE_TYPE'),
            'project_id' => env('FIREBASE_PROJECT_ID'),
            'private_key_id' => env('FIREBASE_PRIVATE_KEY_ID'),
            'private_key' => str_replace('\\n', "\n", env('FIREBASE_PRIVATE_KEY')),
            'client_email' => env('FIREBASE_CLIENT_EMAIL'),
            'client_id' => env('FIREBASE_CLIENT_ID'),
            'auth_uri' => env('FIREBASE_AUTH_URI'),
            'token_uri' => env('FIREBASE_TOKEN_URI'),
            'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
            'client_x509_cert_url' => 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-fbsvc%40' . env('FIREBASE_PROJECT_ID') . '.iam.gserviceaccount.com',
            'universe_domain' => 'googleapis.com'
        ];

        // إنشاء ملف مؤقت
        $tempPath = sys_get_temp_dir() . '/firebase-temp.json';
        file_put_contents($tempPath, json_encode($firebaseCredentials));

        // استخدام نفس الطريقة القديمة
        $credentialsFilePath = $tempPath;

        $client = new \Google_Client();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();

        return $client->getAccessToken()['access_token'];
    }


    public function acceptMobile($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->update([
                'status' => 'resolved',
                'resolved_at' => now(),
                'resolved_by' => Auth::id(),
            ]);
            if ($report->place) {
                $report->place->update([
                    'status' => 'inactive',
                ]);
            }
            return redirect()->route('mobile.reports.index')
                ->with('success', 'تم قبول البلاغ وتم تعطيل المكان');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }

    public function dismissMobile($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->update([
                'status' => 'dismissed',
                'resolved_at' => now(),
                'resolved_by' => Auth::id(),
            ]);
            return redirect()->route('mobile.reports.index')
                ->with('success', 'تم رفض البلاغ');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }

    public function reviewAccept($id)
    {
        try {
            $report = ReviewReport::findOrFail($id);
            $report->update([
                'status' => 'resolved',
                'resolved_at' => now(),
                'resolved_by' => Auth::id()
            ]);
            return redirect()->route('mobile.reports.index')
                ->with('success', 'تم قبول بلاغ المراجعة');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }

    public function review_dismiss($id)
    {
        try {
            $report = ReviewReport::findOrFail($id);
            $report->update([
                'status' => 'dismissed',
                'resolved_at' => now(),
                'resolved_by' => Auth::id()
            ]);
            return redirect()->route('admin.reports.index')
                ->with('success', 'تم رفض بلاغ المراجعة');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $query = Report::with(['user', 'place', 'place.user']);
        $reports = $query->orderBy('created_at', 'desc')->paginate(20);
        $all_reports = Report::count();
        $review_reports = ReviewReport::with(['user', 'place', 'place.user', 'rating'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.reports.index', compact('reports', 'review_reports', 'all_reports'));
    }

    public function show($id)
    {
        $report = Report::with(['user', 'place', 'place.user'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    public function review_show($id)
    {
        $report = ReviewReport::with(['user', 'place', 'place.user', 'rating'])->findOrFail($id);
        return view('admin.reports.review_show', compact('report'));
    }

    public function accept($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->update([
                'status' => 'resolved',
                'resolved_at' => now(),
                'resolved_by' => Auth::id(),
            ]);
            if ($report->place) {
                $report->place->update([
                    'status' => 'inactive',
                ]);
            }
            return redirect()->route('admin.reports.index')
                ->with('success', 'تم قبول البلاغ وتم تعطيل المكان');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }

    public function dismiss($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->update([
                'status' => 'dismissed',
                'resolved_at' => now(),
                'resolved_by' => Auth::id(),
            ]);
            return redirect()->route('admin.reports.index')
                ->with('success', 'تم رفض البلاغ');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }
}
