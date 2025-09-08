<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Places;
use App\Models\ReviewReport;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Places $place)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'يجب تسجيل الدخول لتقييم المكان.'], 401);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if (Rating::where('user_id', Auth::id())->where('place_id', $place->id)->exists()) {
            return response()->json(['error' => 'لقد قيّمت هذا المكان بالفعل.'], 422);
        }

        $rating = Rating::create([
            'user_id' => Auth::id(),
            'place_id' => $place->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'تم حفظ تقييمك بنجاح!', 'rating' => $rating], 201);
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

    public function reportReview(Request $request, Places $place)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'يجب تسجيل الدخول للإبلاغ عن المحتوى.'], 401);
        }
        $request->validate([
            'report_type' => 'required|string|in:review_report',
            'review_id' => 'required|exists:ratings,id',
        ]);
        if (ReviewReport::where('user_id', Auth::id())
            ->where('place_id', $place->id)
            ->where('review_id', $request->review_id)
            ->exists()
        ) {
            return response()->json(['error' => 'لقد قمت بالإبلاغ عن هذا التقييم بالفعل.'], 422);
        }
        ReviewReport::create([
            'user_id' => Auth::id(),
            'place_id' => $place->id,
            'review_id' => $request->review_id,
            'report_type' => $request->report_type,
        ]);
        return response()->json(['success' => true, 'message' => 'تم تسجيل البلاغ بنجاح!'], 201);
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
