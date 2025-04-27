<?php

namespace App\Http\Controllers\Admin;

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

    public function index()
    {
        $userInterests = UserInterest::with(['user', 'event', 'help_word'])->latest()->paginate(10);
        return view('admin.omdaHome.user_interests.index', compact('userInterests'))->with('layout', $this->layout);
    }

    public function show(UserInterest $userInterest)
    {
        $userInterest->load(['user', 'event', 'help_word']);
        return view('admin.omdaHome.user_interests.show', compact('userInterest'))->with('layout', $this->layout);
    }

    public function destroy(UserInterest $userInterest)
    {
        $userInterest->delete();
        return redirect()->route('admin.user_interests.index')->with('success', 'تم حذف الإهتمام بنجاح.');
    }

    public function redirect($id)
    {
        $userInterest = UserInterest::findOrFail($id);

        if ($userInterest->interest_type === 'event') {
            $event = $userInterest->event;
            if ($event && $event->type === 'معرض') {
                return redirect()->route('users.event.index', ['interest_id' => $userInterest->interest_id]);
            } elseif ($event && $event->type === 'مناسبة') {
                return redirect()->route('users.meet.index', ['interest_id' => $userInterest->interest_id]);
            }
        } elseif ($userInterest->interest_type === 'help_word') {
            return redirect()->route('users.help_words.index', ['interest_id' => $userInterest->interest_id]);
        }

        return redirect()->back()->with('error', 'نوع الاهتمام غير صالح أو المورد غير موجود');
    }
}
