<?php

namespace App\Http\Controllers;

use App\Models\TripRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TripRequestController extends Controller
{
    // ... create method remains the same

    public function store(Request $request)
    {
        $validated = $request->validate([
            'travelers_count' => 'required|integer|min:1|max:50',
            'interests' => 'required|string',
            'user_id' => 'required|integer',
            'reference_number' => 'nullable|string|unique:trip_requests,reference_number'  // أضف validation للفرادة
        ]);

        $validated['interests'] = json_decode($validated['interests'], true);

        // استخدم الرقم المرسل من JS إذا وُجد، وإلا تولد واحداً احتياطياً
        $referenceNumber = $request->input('reference_number');
        if (!$referenceNumber) {
            // احتياطي: استخدم ID بعد الإدراج
            $tripRequest = TripRequest::create([
                'travelers_count' => $validated['travelers_count'],
                'interests' => $validated['interests'],
                'user_id' => $validated['user_id'],
            ]);
            $referenceNumber = 'REF' . str_pad($tripRequest->id, 10, '0', STR_PAD_LEFT);
            $tripRequest->update(['reference_number' => $referenceNumber]);
        } else {
            // حفظ الرقم المرسل من JS
            TripRequest::create([
                'reference_number' => $referenceNumber,
                'travelers_count' => $validated['travelers_count'],
                'interests' => $validated['interests'],
                'user_id' => $validated['user_id'],
            ]);
        }

        // إعادة التوجيه مع الرقم (سيكون نفسه المعروض في النموذج)
        return redirect()->route('mobile.order.success')
            ->with('success', 'تم إرسال طلب الرحلة بنجاح!')
            ->with('reference_number', $referenceNumber);
    }
}
