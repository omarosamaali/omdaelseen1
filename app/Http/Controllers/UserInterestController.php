<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInterestController extends Controller
{
    protected $layout;

    public function __construct()
    {
        $this->layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';
    }
    public function index($user_id = null)
    {
        // Use the provided user_id, or fall back to the authenticated user's ID
        $userId = $user_id ?? Auth::id();

        $userInterests = UserInterest::with('user')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        foreach ($userInterests as $interest) {
            if ($interest->interest_type === 'event') {
                $interest->load('event');
            } elseif ($interest->interest_type === 'help_word') {
                $interest->load('help_word');
            }
        }

        return view('users.user_interests.index', compact('userInterests'))->with('layout', $this->layout);
    }    public function show(UserInterest $userInterest)
    {
        // Load the user relationship
        $userInterest->load('user');

        // Conditionally load the interest relationship based on interest_type
        if ($userInterest->interest_type === 'event') {
            $userInterest->load('event');
        } elseif ($userInterest->interest_type === 'help_word') {
            $userInterest->load('help_word');
        }

        return view('users.user_interests.show', compact('userInterest'))->with('layout', $this->layout);
    }

    public function destroy(UserInterest $userInterest)
    {
        $userInterest->delete();
        return redirect()->route('user.user_interests.index')->with('success', 'تم حذف الإهتمام بنجاح.');    }
}
