<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorites;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

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
            // لو اتضافت للمفضلة، ابعت إشعار
            $place = Place::find($placeId);
            if ($place && $place->user && $place->user->fcm_token) {
                $messaging = app('firebase.messaging');
                $message = CloudMessage::new()
                    ->withNotification(Notification::create(
                        '📌 تمت إضافة مكانك إلى المفضلة!',
                        $user->name . ' أضاف ' . $place->name_ar . ' إلى المفضلة.'
                    ))
                    ->withChangedTarget('token', $place->user->fcm_token);

                $messaging->send($message);
            }

            return response()->json(['status' => 'added', 'message' => 'تمت الإضافة إلى المفضلة.']);
        } else {
            return response()->json(['status' => 'removed', 'message' => 'تمت الإزالة من المفضلة.']);
        }
    }
}
