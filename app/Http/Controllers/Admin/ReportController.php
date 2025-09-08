<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReviewReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $layout;

    public function __construct()
    {
        $this->layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';
    }

    /**
     * عرض جميع البلاغات
     */
    public function index(Request $request)
    {
        $query = Report::with(['user', 'place', 'place.user']);
        $review_reports = ReviewReport::with(['user', 'place', 'place.user', 'rating'])->get();

        if ($request->has('user_search') && $request->user_search) {
            $searchTerm = $request->user_search;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('place_search') && $request->place_search) {
            $searchTerm = $request->place_search;
            $query->whereHas('place', function ($q) use ($searchTerm) {
                $q->where('name_ar', 'like', '%' . $searchTerm . '%')
                    ->orWhere('name_en', 'like', '%' . $searchTerm . '%')
                    ->orWhere('name_ch', 'like', '%' . $searchTerm . '%');
            });
        }

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

        $query->orderBy('created_at', 'desc');

        $reports = $query->paginate(20);
        $currentFilter = $request->filter;

        return view('admin.omdaHome.reports.index', compact('review_reports', 'reports', 'currentFilter'))
            ->with('layout', $this->layout);
    }

    /**
     * إنشاء بلاغ مراجعة جديد
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'place_id' => 'required|exists:places,id',
                'review_id' => 'required|exists:ratings,id',
                'report_type' => 'required|string',
            ]);

            ReviewReport::create(array_merge($validated, ['status' => 1]));

            return redirect()->route('admin.reports.index')
                ->with('success', 'تم إنشاء بلاغ المراجعة بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إنشاء البلاغ: ' . $e->getMessage());
        }
    }

    /**
     * عرض صفحة إنشاء بلاغ مراجعة
     */
    public function create()
    {
        return view('admin.omdaHome.reports.create')
            ->with('layout', $this->layout);
    }

    /**
     * عرض تفاصيل البلاغ
     */
    public function show($id)
    {
        $report = Report::with(['user', 'place', 'place.user'])->findOrFail($id);
        return view('admin.omdaHome.reports.show', compact('report'))
            ->with('layout', $this->layout);
    }

    /**
     * عرض تفاصيل بلاغ المراجعة
     */
    public function review_show($id)
    {
        $report = ReviewReport::with(['user', 'place', 'place.user', 'rating'])->findOrFail($id);
        return view('admin.omdaHome.reports.review_show', compact('report'))
            ->with('layout', $this->layout);
    }

    /**
     * قبول بلاغ المراجعة
     */
    public function review_accept($id)
    {
        try {
            $report = ReviewReport::findOrFail($id);
            $report->update([
                'status' => 0,
                'resolved_at' => now(),
                'resolved_by' => Auth::id()
            ]);
            return redirect()->route('admin.reports.index')
                ->with('success', 'تم قبول بلاغ المراجعة');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }

    /**
     * تحرير البلاغ
     */
    public function edit($id)
    {
        $report = Report::with(['user', 'place', 'place.user'])->findOrFail($id);
        return view('admin.omdaHome.reports.edit', compact('report'))
            ->with('layout', $this->layout);
    }

    /**
     * قبول البلاغ وتعطيل المكان
     */
    public function accept($id)
    {
        try {
            $report = Report::with('place')->findOrFail($id);
            if ($report->place) {
                $report->place->update(['status' => 'inactive']);
            }
            $report->update([
                'status' => 'resolved',
                'resolved_at' => now(),
                'resolved_by' => Auth::id()
            ]);
            return redirect()->route('admin.reports.show', $report->id)
                ->with('success', 'تم قبول البلاغ وتعطيل المكان بنجاح');
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
                'resolved_by' => Auth::id()
            ]);
            return redirect()->route('admin.reports.show', $report->id)
                ->with('success', 'تم رفض البلاغ');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء معالجة البلاغ: ' . $e->getMessage());
        }
    }


    /**
     * تحذير صاحب المكان
     */
    public function warn($id)
    {
        try {
            $report = Report::with(['place', 'place.user'])->findOrFail($id);

            $report->update([
                'status' => 'resolved',
                'admin_action' => 'warning_sent',
                'resolved_at' => now(),
                'resolved_by' => Auth::id()
            ]);

            return redirect()->route('admin.reports.show', $report->id)
                ->with('success', 'تم إرسال تحذير لصاحب المكان');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إرسال التحذير: ' . $e->getMessage());
        }
    }
    /**
     * رفض بلاغ المراجعة
     */
    public function review_dismiss($id)
    {
        try {
            $report = ReviewReport::findOrFail($id);
            $report->update([
                'status' => 2,
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
    /**
     * حذف البلاغ نهائياً
     */
    public function destroy($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->delete();

            return redirect()->route('admin.reports.index')
                ->with('success', 'تم حذف البلاغ نهائياً');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء حذف البلاغ: ' . $e->getMessage());
        }
    }

    /**
     * تحديث ملاحظات الإدارة على البلاغ
     */
    public function updateNotes(Request $request, $id)
    {
        try {
            $request->validate([
                'admin_notes' => 'required|string|max:1000'
            ]);

            $report = Report::findOrFail($id);

            $report->update([
                'admin_notes' => $request->admin_notes,
                'updated_by' => Auth::id()
            ]);

            return redirect()->back()
                ->with('success', 'تم تحديث الملاحظات بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء تحديث الملاحظات: ' . $e->getMessage());
        }
    }

    /**
     * إحصائيات البلاغات
     */
    public function statistics()
    {
        $stats = [
            'total_reports' => Report::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'resolved_reports' => Report::where('status', 'resolved')->count(),
            'dismissed_reports' => Report::where('status', 'dismissed')->count(),
            'today_reports' => Report::whereDate('created_at', today())->count(),
            'this_week_reports' => Report::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month_reports' => Report::whereMonth('created_at', now()->month)->count(),
        ];

        $top_reporters = Report::selectRaw('user_id, COUNT(*) as reports_count')
            ->with('user')
            ->groupBy('user_id')
            ->orderBy('reports_count', 'desc')
            ->limit(10)
            ->get();

        $most_reported_places = Report::selectRaw('place_id, COUNT(*) as reports_count')
            ->with('place')
            ->groupBy('place_id')
            ->orderBy('reports_count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.omdaHome.reports.statistics', compact('stats', 'top_reporters', 'most_reported_places'))
            ->with('layout', $this->layout);
    }

    /**
     * معالجة جماعية للبلاغات
     */
    public function bulkAction(Request $request)
    {
        try {
            $request->validate([
                'report_ids' => 'required|array',
                'action' => 'required|in:accept,dismiss,delete'
            ]);

            $reportIds = $request->report_ids;
            $action = $request->action;

            switch ($action) {
                case 'accept':
                    $reports = Report::with('place')->whereIn('id', $reportIds)->get();
                    foreach ($reports as $report) {
                        if ($report->place) {
                            $report->place->update(['status' => 'inactive']);
                        }
                        $report->update([
                            'status' => 'resolved',
                            'admin_action' => 'place_inactive',
                            'resolved_at' => now(),
                            'resolved_by' => Auth::id()
                        ]);
                    }
                    $message = 'تم قبول البلاغات وتعطيل الأماكن المخالفة';
                    break;

                case 'dismiss':
                    Report::whereIn('id', $reportIds)->update([
                        'status' => 'dismissed',
                        'admin_action' => 'dismissed',
                        'resolved_at' => now(),
                        'resolved_by' => Auth::id()
                    ]);
                    $message = 'تم رفض البلاغات المحددة';
                    break;

                case 'delete':
                    Report::whereIn('id', $reportIds)->delete();
                    $message = 'تم حذف البلاغات نهائياً';
                    break;
            }

            return redirect()->route('admin.reports.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء المعالجة الجماعية: ' . $e->getMessage());
        }
    }
}
