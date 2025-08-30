<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle the favorite status of a place for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleFavorite(Request $request)
    {
        // تحقق من أن المستخدم قام بتسجيل الدخول
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();
        $placeId = $request->place_id;

        // استخدم طريقة toggle() لتبديل حالة المفضلة
        $user->favoritePlaces()->toggle($placeId);

        // التحقق من الحالة بعد التبديل لإرسال الاستجابة الصحيحة
        $isFavorited = $user->favoritePlaces()->where('place_id', $placeId)->exists();

        if ($isFavorited) {
            return response()->json(['status' => 'added', 'message' => 'تمت الإضافة إلى المفضلة.']);
        } else {
            return response()->json(['status' => 'removed', 'message' => 'تمت الإزالة من المفضلة.']);
        }
    }
}
