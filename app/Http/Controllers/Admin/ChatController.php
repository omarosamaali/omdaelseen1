<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TripRequest;
use App\Models\TripMessage;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show(TripRequest $trip)
    {
        $messages = $trip->messages()->with('sender')->orderBy('created_at', 'asc')->get();
        return view('admin.omdaHome.orders.chat', compact('trip', 'messages'));
    }

    public function send(Request $request, TripRequest $trip)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        TripMessage::create([
            'trip_request_id' => $trip->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->route('admin.omdaHome.orders.chat', $trip->id);
    }
}
