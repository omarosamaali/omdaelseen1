<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:content_report,fake_account',
            'user_id' => 'required|exists:users,id',
            'place_id' => 'required|exists:places,id',
        ]);

        $report = Report::create([
            'user_id' => $request->user_id,
            'place_id' => $request->place_id,
            'report_type' => $request->report_type,
        ]);

        if ($report) {
            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل البلاغ بنجاح'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'فشل تسجيل البلاغ'
        ], 500);
    }
}
