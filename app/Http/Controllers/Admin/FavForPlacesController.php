<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Places;
use App\Models\Rating;
use App\Models\Favorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavForPlacesController extends Controller
{
    protected $layout;

    public function __construct()
    {
        $this->layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';
    }

    // للوصول إلى التقييمات عن طريق place_id
    public function index(Places $place, Request $request)
    {
        $place->load(['ratings.user', 'favorites', 'mainCategory', 'subCategory', 'region']);

        $ratings = $place->ratings;

        return view('admin.omdaHome.fav_for_places.index', [
            'ratings' => $ratings,
            'place' => $place,
            'layout' => $this->layout
        ]);
    }

    // للوصول إلى المستخدمين الذين أضافوا المكان للمفضلة
    public function fav_places(Places $place, Request $request)
    {
        $place->load(['favorites', 'mainCategory', 'subCategory', 'region']);

        $favoriteUsers = $place->favorites;

        return view('admin.omdaHome.fav_places.index', [
            'favoriteUsers' => $favoriteUsers,
            'place' => $place,
            'layout' => $this->layout
        ]);
    }

    public function allFavorites(Request $request)
    {
        $favorites = Favorites::with(['user', 'place'])->get();

        return view('admin.omdaHome.fav_for_places.all_favorites', [
            'favorites' => $favorites,
            'layout' => $this->layout
        ]);
    }

    // لحذف التقييم
    public function destroy(Rating $rating)
    {
        $rating->delete();

        return redirect()->back()->with('success', 'تم حذف التقييم بنجاح');
    }
}