<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReviewReport;
use App\Models\Places;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function mobileIndex(Request $request)
    {
        $query = Report::with(['user', 'place', 'place.user']);
        if ($request->has('filter') && $request->filter) {
            $filter = $request->filter;
            switch ($filter) {
                case 'pending':
                    $query->where('status', 'pending');
                    break;
                case 'resolved':
                    $query->where('status', 'resolved');
                    break;
                case 'dismissed':
                    $query->where('status', 'dismissed');
                    break;
            }
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(20);
        $all_reports = Report::count();
        $review_reports = ReviewReport::with(['user', 'place', 'place.user', 'rating'])
            ->orderBy('created_at', 'desc')
            ->get();
        $currentFilter = $request->filter;
        return view('mobile.admin.reports.index', compact('reports', 'review_reports', 'currentFilter', 'all_reports'))
            ->with('layout', 'layouts.mobile');
    }

    public function mobileShow($id)
    {
        $report = Report::with(['user', 'place', 'place.user'])->findOrFail($id);
        return view('mobile.admin.reports.show', compact('report'))
            ->with('layout', 'layouts.mobile');
    }

    public function mobileReviewShow($id)
    {
        $report = ReviewReport::with(['user', 'place', 'place.user', 'rating'])->findOrFail($id);
        return view('mobile.admin.reports.review_show', compact('report'))
            ->with('layout', 'layouts.mobile');
    }

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

    public function reportPlace(Request $request, $placeId)
    {
        try {
            $place = Places::findOrFail($placeId);
            $existingReport = Report::where('user_id', Auth::id())
                ->where('place_id', $placeId)
                ->first();
            if ($existingReport) {
                return response()->json([
                    'success' => false,
                    'error' => 'لقد أبلغت عن هذا المكان من قبل'
                ]);
            }
            $report = Report::create([
                'user_id' => Auth::id(),
                'place_id' => $placeId,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل البلاغ بنجاح'
            ]);
        } catch (\Exception $e) {
            Log::error('Report Place Error:', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
                'place_id' => $placeId
            ]);

            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ أثناء تسجيل البلاغ'
            ], 500);
        }
    }

    public function acceptMobile($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->update([
                'status' => 'resolved',
                'resolved_at' => now(),
                'resolved_by' => Auth::id(),
            ]);
            if ($report->place) {
                $report->place->update([
                    'status' => 'inactive',
                ]);
            }
            return redirect()->route('mobile.reports.index')
                ->with('success', 'تم قبول البلاغ وتم تعطيل المكان');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }

    public function dismissMobile($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->update([
                'status' => 'dismissed',
                'resolved_at' => now(),
                'resolved_by' => Auth::id(),
            ]);
            return redirect()->route('mobile.reports.index')
                ->with('success', 'تم رفض البلاغ');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }

    public function reviewAccept($id)
    {
        try {
            $report = ReviewReport::findOrFail($id);
            $report->update([
                'status' => 'resolved',
                'resolved_at' => now(),
                'resolved_by' => Auth::id()
            ]);
            return redirect()->route('mobile.reports.index')
                ->with('success', 'تم قبول بلاغ المراجعة');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }

    public function review_dismiss($id)
    {
        try {
            $report = ReviewReport::findOrFail($id);
            $report->update([
                'status' => 'dismissed',
                'resolved_at' => now(),
                'resolved_by' => Auth::id()
            ]);
            return redirect()->route('admin.reports.index')
                ->with('success', 'تم رفض بلاغ المراجعة');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $query = Report::with(['user', 'place', 'place.user']);
        $reports = $query->orderBy('created_at', 'desc')->paginate(20);
        $all_reports = Report::count();
        $review_reports = ReviewReport::with(['user', 'place', 'place.user', 'rating'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.reports.index', compact('reports', 'review_reports', 'all_reports'));
    }

    public function show($id)
    {
        $report = Report::with(['user', 'place', 'place.user'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    public function review_show($id)
    {
        $report = ReviewReport::with(['user', 'place', 'place.user', 'rating'])->findOrFail($id);
        return view('admin.reports.review_show', compact('report'));
    }

    public function accept($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->update([
                'status' => 'resolved',
                'resolved_at' => now(),
                'resolved_by' => Auth::id(),
            ]);
            if ($report->place) {
                $report->place->update([
                    'status' => 'inactive',
                ]);
            }
            return redirect()->route('admin.reports.index')
                ->with('success', 'تم قبول البلاغ وتم تعطيل المكان');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }

    public function dismiss($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->update([
                'status' => 'dismissed',
                'resolved_at' => now(),
                'resolved_by' => Auth::id(),
            ]);
            return redirect()->route('admin.reports.index')
                ->with('success', 'تم رفض البلاغ');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }
}
