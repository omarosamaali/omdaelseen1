<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Explorers; // التصنيفات الرئيسية
use App\Models\Branches;  // التصنيفات الفرعية
use App\Models\Regions;   // المناطق
use App\Models\Places;    // الأماكن
use App\Models\Reviews;   // المراجعات (افترضنا اسم المودل)
use App\Models\Reports;   // البلاغات (افترضنا اسم المودل)
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
        $user = Auth::user();
        $totalMainCategories = Explorers::count();
        $totalSubCategories = Branches::count();
        $totalRegions = Regions::count();
        $totalPlaces = Places::count();
        // $totalReviews = Reviews::count(); 
        // $totalReports = Reports::count();

        $latestPlaces = Places::with(['mainCategory', 'subCategory', 'region'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.omdaHome.dashboard.index', compact(
            'totalMainCategories',
            'totalSubCategories',
            'totalRegions',
            'totalPlaces',
            // 'totalReviews',
            // 'totalReports',
            'latestPlaces',
            // 'latestReports'
        ))->with('layout', $this->layout);
    }
}