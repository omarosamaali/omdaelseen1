<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Followers;
use App\Models\Places;

class FollowersUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $topUsers = User::select('id', 'explorer_name', 'avatar', 'country')->where('status', 1)
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
            ->with('follower')
            ->get()
            ->map(function ($f) {
                $f->is_following_back = Followers::where('follower_id', auth()->id())
                    ->where('following_id', $f->follower_id)
                    ->exists();
                return $f;
            });

        $myFollowings = Followers::where('follower_id', auth()->id())
            ->with('following')
            ->get()
            ->map(function ($f) {
                $f->is_following_back = Followers::where('follower_id', $f->following_id)
                    ->where('following_id', auth()->id())
                    ->exists();
                return $f;
            });



        return view('mobile.profile.followers', compact('topUsers', 'myFollowers'));
    }
    public function following()
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

        // هنا بنجيب الناس اللي أنا متابعهم
        $myFollowings = Followers::where('follower_id', auth()->id())
            ->with('following') // علاقة following في الموديل
            ->get()
            ->map(function ($following) {
                // هل الشخص اللي أنا متابعه بيتابعني كمان؟
                $isFollowBack = Followers::where('follower_id', $following->following_id)
                    ->where('following_id', auth()->id())
                    ->exists();

                $following->is_follow_back = $isFollowBack;
                return $following;
            });

        return view('mobile.profile.following', compact('topUsers', 'myFollowings'));
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


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
