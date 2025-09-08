<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();
        $placeId = $request->place_id;
        $user->favoritePlaces()->toggle($placeId);
        $isFavorited = $user->favoritePlaces()->where('place_id', $placeId)->exists();

        if ($isFavorited) {
            return response()->json(['status' => 'added', 'message' => 'تمت الإضافة إلى المفضلة.']);
        } else {
            return response()->json(['status' => 'removed', 'message' => 'تمت الإزالة من المفضلة.']);
        }
    }
}
