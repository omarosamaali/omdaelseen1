<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Followers;
use App\Models\Places;

class FollowersUserController extends Controller
{
    public function index()
    {
        $topUsers = User::select('id', 'explorer_name', 'avatar', 'country')
            ->where('status', 1)
            ->where('role', 'user')
            ->withCount('places')
            ->orderBy('places_count', 'DESC')
            ->limit(3)
            ->get()
            ->map(function ($user, $index) {
                return [
                    'user' => $user,
                    'followers_count' => Followers::where('following_id', $user->id)->count(),
                    'rank' => $index + 1
                ];
            });

        $myFollowers = Followers::where('following_id', auth()->id())
            ->with(['follower' => function ($query) {
                $query->withCount(['followers', 'places']); // إضافة عدد المتابعين والأماكن
            }])
            ->get()
            ->map(function ($f) {
                $f->is_following_back = Followers::where('follower_id', auth()->id())
                    ->where('following_id', $f->follower_id)
                    ->exists();
                return $f;
            });

        $myFollowings = Followers::where('follower_id', auth()->id())
            ->with(['following' => function ($query) {
                $query->withCount(['followers', 'places']); // إضافة places_count أيضاً
            }])
            ->get()
            ->map(function ($f) {
                $f->is_following_back = Followers::where('follower_id', $f->following_id)
                    ->where('following_id', auth()->id())
                    ->exists();
                return $f;
            });

        return view('mobile.profile.followers', compact('topUsers', 'myFollowers'));
    }    public function following()
    {
        $myFollowings = Followers::where('follower_id', auth()->id())
            ->with(['following' => function ($query) {
            $query->withCount('followers');
        }])
            ->get()
            
            ->map(function ($following) {
                $isFollowBack = Followers::where('follower_id', $following->following_id)
                    ->where('following_id', auth()->id())
                    ->exists();

                $following->is_follow_back = $isFollowBack;
                return $following;
            });

        return view('mobile.profile.following', compact( 'myFollowings'));
    }

    public function toggle($userId)
    {
        $existing = Followers::where('follower_id', auth()->id())
            ->where('following_id', $userId)
            ->first();

        if ($existing) {
            // لو أنا بالفعل متابع → أعمل إلغاء متابعة
            $existing->delete();
            return back()->with('status', 'تم إلغاء المتابعة');
        } else {
            // لو مش متابع → أعمل متابعة
            Followers::create([
                'follower_id' => auth()->id(),
                'following_id' => $userId,
            ]);
            return back()->with('status', 'تمت المتابعة');
        }
    }

}
