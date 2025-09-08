<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Followers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FollowController extends Controller
{
    public function toggleFollow(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'error' => 'يجب تسجيل الدخول أولاً'
                ], 401);
            }
            $request->validate([
                'user_id' => 'required|integer|exists:users,id'
            ]);
            $currentUser = Auth::user();
            $targetUserId = $request->input('user_id');
            if ($currentUser->id == $targetUserId) {
                return response()->json([
                    'success' => false,
                    'error' => 'لا يمكنك متابعة نفسك'
                ], 400);
            }
            $targetUser = User::find($targetUserId);
            if (!$targetUser) {
                return response()->json([
                    'success' => false,
                    'error' => 'المستخدم غير موجود'
                ], 404);
            }
            DB::beginTransaction();
            try {
                $existingFollow = Followers::where('follower_id', $currentUser->id)
                    ->where('following_id', $targetUserId)
                    ->first();
                $isFollowing = false;
                $followersCount = null;
                if ($existingFollow) {
                    $existingFollow->delete();
                    $isFollowing = false;
                    Log::info("User {$currentUser->id} unfollowed user {$targetUserId}");
                } else {
                    Followers::create([
                        'follower_id' => $currentUser->id,
                        'following_id' => $targetUserId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $isFollowing = true;
                    Log::info("User {$currentUser->id} followed user {$targetUserId}");
                }
                $followersCount = Followers::where('following_id', $targetUserId)->count();
                DB::commit();
                return response()->json([
                    'success' => true,
                    'is_following' => $isFollowing,
                    'followers_count' => $followersCount,
                    'message' => $isFollowing ? 'تمت المتابعة بنجاح' : 'تم إلغاء المتابعة بنجاح'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => 'بيانات غير صحيحة',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Follow toggle error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'target_user_id' => $request->input('user_id'),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ في الخادم'
            ], 500);
        }
    }

    public function getFollowStatus(Request $request, $userId)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'error' => 'غير مصرح'
                ], 401);
            }
            $isFollowing = Auth::user()->isFollowing(User::findOrFail($userId));
            $followersCount = Followers::where('following_id', $userId)->count();
            return response()->json([
                'success' => true,
                'is_following' => $isFollowing,
                'followers_count' => $followersCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ'
            ], 500);
        }
    }
}
