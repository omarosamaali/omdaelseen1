<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Places;
use App\Models\Favorites;
use App\Models\ReviewReport;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function indexUsers()
    {
        $userId = Auth::id();
        $reports = Report::where('user_id', $userId)->with('place')->get();
        $review_reports = ReviewReport::where('user_id', $userId)->with(['place', 'rating'])->get();
        $places = Places::where('user_id', $userId)->get();
        $favorites = Favorites::where('user_id', $userId)->with('place')->get();
        $ratings = Rating::where('user_id', $userId)->with('place')->get();
        $reportsAgainstMe = Report::whereHas('place', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with(['place', 'user'])->get();
        $reportsOnPlacesIRated = Report::whereHas('place.ratings', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with(['place', 'user'])->get();
        $reviewReportsAgainstMe = ReviewReport::whereHas('rating', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with(['place', 'rating', 'user'])->get();
        return view('mobile.profile.notificationsUsers', compact(
            'review_reports',
            'reports',
            'places',
            'reportsOnPlacesIRated',
            'favorites',
            'ratings',
            'reportsAgainstMe',
            'reviewReportsAgainstMe'
        ));
    }

    public function index()
    {
        $reports = Report::all();
        $review_reports = ReviewReport::all();
        $places = Places::all();
        $favorites = Favorites::all();
        $ratings = Rating::all();
        return view('mobile.profile.notifications', compact(
            'review_reports',
            'reports',
            'places',
            'favorites',
            'ratings'
        ));
    }

    public function search(Request $request)
    {
        $search = $request->get('query');

        $places = Places::where('name_ar', 'like', "%{$search}%")
            ->orWhere('name_en', 'like', "%{$search}%")
            ->get();

        $favorites = Favorites::whereHas('place', function ($q) use ($search) {
            $q->where('name_ar', 'like', "%{$search}%")
                ->orWhere('name_en', 'like', "%{$search}%");
        })->orWhereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->with(['place', 'user'])->get();

        $ratings = Rating::whereHas('place', function ($q) use ($search) {
            $q->where('name_ar', 'like', "%{$search}%")
                ->orWhere('name_en', 'like', "%{$search}%");
        })->orWhereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })->with(['place', 'user'])->get();

        $reports = Report::whereHas('place', function ($q) use ($search) {
            $q->where('name_ar', 'like', "%{$search}%")
                ->orWhere('name_en', 'like', "%{$search}%");
        })->with(['place'])->get();

        $review_reports = ReviewReport::whereHas('place', function ($q) use ($search) {
            $q->where('name_ar', 'like', "%{$search}%")
                ->orWhere('name_en', 'like', "%{$search}%");
        })->with(['place'])->get();

        return response()->json([
            'places' => $places,
            'favorites' => $favorites,
            'ratings' => $ratings,
            'reports' => $reports,
            'review_reports' => $review_reports,
        ]);
    }
}
