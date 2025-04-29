<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserInterest;
use App\Models\Event;
use App\Models\HelpWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInterestController extends Controller
{
    public function destroy($interestType, $interestId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'غير مصادق'], 401);
        }

        $deleted = $user->interests()
            ->where('interest_type', $interestType)
            ->where('interest_id', $interestId)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'تم إزالة الاهتمام بنجاح']);
        }

        return response()->json(['success' => false, 'message' => 'الاهتمام غير موجود'], 404);
    }


    public function check(Request $request)
    {
        $user = Auth::user();

        // If the user is not authenticated, return false (interest is not added)
        if (!$user) {
            return response()->json(['is_added' => false], 401);
        }

        $interestType = $request->query('interest_type');
        $interestId = $request->query('interest_id');

        $isAdded = $user->interests()
            ->where('interest_type', $interestType)
            ->where('interest_id', $interestId)
            ->exists();

        return response()->json(['is_added' => $isAdded]);
    }
    
    
    
    
    
    
    public function store(Request $request)
{
    
    $request->validate([
        'interest_type' => 'required|in:event,help_word',
        'interest_id' => [
            'required',
            'integer',
            function ($attribute, $value, $fail) use ($request) {
                if ($request->interest_type === 'event') {
                    if (!Event::find($value)) {
                        $fail('The selected event does not exist.');
                    }
                } elseif ($request->interest_type === 'help_word') {
                    if (!HelpWord::find($value)) {
                        $fail('The selected help word does not exist.');
                    }
                }
            },
        ],
    ]);
    
    // Verificar si ya existe el interés para este usuario
    $exists = UserInterest::where('user_id', Auth::id())
        ->where('interest_type', $request->interest_type)
        ->where('interest_id', $request->interest_id)
        ->exists();
        
    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Este interés ya ha sido añadido anteriormente.',
        ]);
    }

    $userInterest = UserInterest::create([
        'user_id' => Auth::id(),
        'interest_type' => $request->interest_type,
        'interest_id' => $request->interest_id,
    ]);

    // Notify admin
    $admin = \App\Models\User::where('role', 'admin')->first();
    if ($admin) {
        $admin->notify(new \App\Notifications\NewUserInterest($userInterest));
    }

    return response()->json([
        'success' => true,
        'message' => 'Interest added successfully!',
    ]);
}}