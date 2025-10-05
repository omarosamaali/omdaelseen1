<?php

namespace App\Http\Controllers;

use App\Models\TripRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewTrip;

class TripRequestController extends Controller
{
    // ... create method remains the same

    public function store(Request $request)
    {
        $validated = $request->validate([
            'travelers_count' => 'required|integer|min:1|max:50',
            'interests' => 'required|string',
            'user_id' => 'required|integer',
            'reference_number' => 'nullable|string|unique:trip_requests,reference_number'
        ]);

        $validated['interests'] = json_decode($validated['interests'], true);

        if (empty($request->input('reference_number'))) {
            $tripRequest = TripRequest::create([
                'travelers_count' => $validated['travelers_count'],
                'interests' => $validated['interests'],
                'user_id' => $validated['user_id'],
            ]);
            $referenceNumber = 'REF' . str_pad($tripRequest->id, 10, '0', STR_PAD_LEFT);
            $tripRequest->update(['reference_number' => $referenceNumber]);
        } else {
            $tripRequest = TripRequest::create([
                'reference_number' => $request->input('reference_number'),
                'travelers_count' => $validated['travelers_count'],
                'interests' => $validated['interests'],
                'user_id' => $validated['user_id'],
            ]);
            $referenceNumber = $request->input('reference_number');
        }

        // إرسال البريد
        // Mail::to('chinaomda@gmail.com')->send(new NewTrip($tripRequest));
        $admins = \App\Models\User::where('role', 'admin')->pluck('email')->toArray();
        Mail::to($admins)->send(new NewTrip($tripRequest));

        return redirect()->route('mobile.order.success')
            ->with('success', 'تم إرسال طلب الرحلة بنجاح!')
            ->with('reference_number', $referenceNumber);
    }
}
