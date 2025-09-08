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
        $topUsers = User::select('id', 'explorer_name', 'avatar', 'country')
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

        return view('mobile.profile.followers', compact('topUsers'));
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
