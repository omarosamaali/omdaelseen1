<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function toggleFollow(Request $request)
    {
        // تأكد من أن المستخدم مسجل الدخول
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated', 'message' => 'Unauthenticated'], 401);
        }

        // جلب المستخدم الذي سيتم متابعته
        $userToFollow = User::find($request->user_id);

        if (!$userToFollow) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        // لا يمكن للمستخدم أن يتابع نفسه
        if (Auth::user()->id === $userToFollow->id) {
            return response()->json(['status' => 'error', 'message' => 'Cannot follow yourself'], 403);
        }

        // استخدام طريقة toggle() لتبديل حالة المتابعة
        Auth::user()->following()->toggle($userToFollow->id);

        // التحقق من الحالة بعد التبديل لإرسال الاستجابة الصحيحة
        $isFollowing = Auth::user()->isFollowing($userToFollow);

        if ($isFollowing) {
            return response()->json(['status' => 'followed', 'message' => 'User followed successfully']);
        } else {
            return response()->json(['status' => 'unfollowed', 'message' => 'User unfollowed successfully']);
        }
    }
}