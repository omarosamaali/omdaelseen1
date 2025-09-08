<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\ProfileController;
use App\Http\Controllers\Mobile\ChinaDiscoverController;
use App\Models\Places;
use App\Models\Favorites;
use App\Models\Followers;
use App\Models\Report;
use App\Models\ReviewReport;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RatingController;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\FavForPlacesController;
use App\Http\Controllers\Mobile\NotificationController;
use App\Models\Rating;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\FollowersUserController;

Route::get('/mobile/followers', [FollowersUserController::class, 'index'])->name('mobile.profile.followers');

Route::post('/set-language', [LanguageController::class, 'setLanguage'])->name('set.language');

Route::post('/update-hidden-notifications', function (Request $request) {
    $hiddenNotifications = $request->input('hidden_notifications');
    Cookie::queue('hidden_notifications', $hiddenNotifications, 60 * 24 * 30);
    return response()->json(['status' => 'success']);
})->middleware('web');

Route::get('/mobile/notifications/search', [NotificationController::class, 'search'])
    ->name('mobile.notifications.search');

Route::get('/mobile/notifications', [NotificationController::class, 'index'])->name('mobile.notifications.index');
Route::get('/admin/fav_for_places/{place}', [FavForPlacesController::class, 'index'])
    ->name('admin.fav_for_places.index');
Route::delete('/admin/fav_for_places/{rating}', [FavForPlacesController::class, 'destroy'])->name('admin.fav_for_places.destroy');
Route::get('/admin/fav_places/{place}', [FavForPlacesController::class, 'fav_places'])
    ->name('admin.fav_places.index');

Route::get('/admin/all_favorites', [FavForPlacesController::class, 'allFavorites'])
    ->name('admin.all_favorites.index');
Route::post('/admin/reports/{id}/accept', [ReportController::class, 'acceptMobile'])->name('mobile.reports.accept');
Route::post('/admin/reports/{id}/dismiss', [ReportController::class, 'dismissMobile'])->name('mobile.reports.dismiss');

Route::get('/mobile/reports', [ReportController::class, 'mobileIndex'])->name('mobile.reports.index');
Route::get('/mobile/reports/{id}', [ReportController::class, 'mobileShow'])->name('mobile.reports.show');
Route::prefix('mobile/reports')->name('mobile.reports.')->group(function () {
    Route::get('/', [ReportController::class, 'mobileIndex'])->name('index');
    Route::get('/{id}', [ReportController::class, 'mobileShow'])->name('show');
    Route::get('/{id}/review', [ReportController::class, 'mobileReviewShow'])->name('review_show');
    Route::post('/{id}/review/accept', [ReportController::class, 'reviewAccept'])->name('review_accept');
    Route::post('/{id}/review/dismiss', [ReportController::class, 'reviewDismiss'])->name('review_dismiss');
    Route::post('/', [ReportController::class, 'store'])->name('store');
    Route::post('/place/{placeId}', [ReportController::class, 'reportPlace'])->name('report_place');
});
// Public Routes (Accessible without login)


Route::get('mobile/profile/discovers', function () {
    $users = User::withCount('followers')->withCount('favorites')->withCount('ratings')->where('status', 1)->where('role', 'user')->get();
    return view('mobile.profile.discovers', compact('users'));
})->name('mobile.profile.discovers');

Route::get('mobile/info_place/{place}', function (Places $place) {
    $place->loadCount('ratings');
    $place->loadAvg('ratings', 'rating');
    $hasReported = false;
    if (auth()->check()) {
        $hasReported = Report::where('user_id', Auth::id())
            ->where('place_id', $place->id)
            ->exists();
    }
    $followersCount = Followers::where('following_id', $place->user->id)->count();
    $placesCount = Places::where('user_id', $place->user_id)->count();
    $ratingCount = Rating::where('place_id', $place->id)->count();
    return view('mobile.china-discovers.info_place', compact('ratingCount', 'placesCount', 'followersCount', 'place', 'hasReported'));
})->name('mobile.china-discovers.info_place');

Route::get('/all-area-places/{branch_id}', [ChinaDiscoverController::class, 'allAreaPlaces'])->name('all-area-places');

Route::get('places/{place}/reviews', [RatingController::class, 'getReviews'])->name('places.reviews');

Route::middleware('mobile_auth')->group(function () {
    Route::get('mobile', function () {
        return view('mobile.welcome');
    })->name('mobile.welcome');
    Route::post('/users/toggle-follow', [FollowController::class, 'toggleFollow'])->name('users.toggle-follow');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggleFavorite'])->name('favorites.toggle');
    Route::post('places/{place}/rate', [RatingController::class, 'store'])->name('places.rate');
    Route::post('api/places/{place}/rate', [RatingController::class, 'store']);
    Route::put('places/{place}/ratings/{rating}', [RatingController::class, 'updateRating'])->name('places.ratings.update');
    Route::delete('places/{place}/ratings/{rating}', [RatingController::class, 'deleteRating'])->name('places.ratings.delete');
    Route::post('places/{place}/report-review', [RatingController::class, 'reportReview'])->name('places.report-review');
    Route::post('places/{place}/report', [ReportController::class, 'reportPlace'])->name('places.report');
    Route::post('/chef-profile/report-by-user', [ReportController::class, 'store']);
    Route::get('mobile/my-places', function () {
        $myPlaces = Places::where('user_id', Auth::user()->id)->get();
        return view('mobile.china-discovers.my-places', compact('myPlaces'));
    })->name('mobile.china-discovers.my-places');
    Route::get('mobile/my-interests', function () {
        $favoritePlaces = auth()->user()->favoritePlaces;
        return view('mobile.profile.my-interests', compact('favoritePlaces'));
    })->name('mobile.profile.my-interests');
    Route::post('/mobile/china-discovers/filter', [ChinaDiscoverController::class, 'filterPlaces'])
        ->name('mobile.china-discovers.filter');

    Route::get('mobile/china-discovers/create', [ChinaDiscoverController::class, 'create'])->name('mobile.china-discovers.create');
    Route::post('mobile/china-discovers', [ChinaDiscoverController::class, 'store'])->name('mobile.china-discovers.store');
    Route::get('mobile/china-discovers/edit/{id}', [ChinaDiscoverController::class, 'edit'])->name('mobile.china-discovers.edit');
    Route::put('mobile/china-discovers/{id}', [ChinaDiscoverController::class, 'update'])->name('mobile.china-discovers.update');
    Route::get('get-subcategories/{id}', [ChinaDiscoverController::class, 'getSubcategories'])->name('mobile.china-discovers.get-subcategories');
    Route::post('/translate', [ChinaDiscoverController::class, 'translate'])->name('translate');
    Route::get('mobile/china-discovers/all-places', [ChinaDiscoverController::class, 'allPlaces'])->name('mobile.china-discovers.all-places');
    Route::get('/all-places/{region_id?}', [ChinaDiscoverController::class, 'allPlaces'])->name('all.places');
    Route::post('mobile/china-discovers/filter-explorers', [ChinaDiscoverController::class, 'filterExplorers'])->name('mobile.china-discovers.filter-explorers');
    Route::get('mobile/china-discovers/all-sub-category', [ChinaDiscoverController::class, 'allSubCategory'])
        ->name('mobile.china-discovers.all-sub-category');
    Route::get('/all-sub-category/{explorer_id?}', [ChinaDiscoverController::class, 'allSubCategory'])
        ->name('all.sub-category');
    Route::get('mobile/china-discovers/{id?}', [ChinaDiscoverController::class, 'index'])->name('mobile.china-discovers.index');
    Route::delete('mobile/profile/delete-account', [ProfileController::class, 'deleteAccount'])->name('mobile.profile.delete-account');
    Route::post('mobile/profile/update', [ProfileController::class, 'updateProfile'])->name('mobile.profile.update');
    Route::post('mobile/profile/send-otp', [ProfileController::class, 'sendOtp'])->name('mobile.profile.send-otp');
    Route::post('mobile/profile/verify-otp', [ProfileController::class, 'verifyOtp'])->name('mobile.profile.verify-otp');
    Route::get('mobile/edit-profile', function () {
        return view('mobile.profile.edit-profile');
    })->name('mobile.profile.edit-profile');
    Route::get('mobile/verify', function () {
        return view('mobile.profile.verify');
    })->name('mobile.profile.verify');
    Route::get('mobile/success', function () {
        return view('mobile.profile.success');
    })->name('mobile.profile.success');
    Route::get('mobile/notifications', [NotificationController::class, 'index'])->name('mobile.profile.notifications');
    Route::get('mobile/notificationsUsers', [NotificationController::class, 'indexUsers'])->name('mobile.profile.notificationsUsers');
    Route::get('mobile/my-medals', function () {
        return view('mobile.profile.my-medals');
    })->name('mobile.profile.my-medals');

    // Profile Routes with Role-Based Redirection
    // The mobile_auth middleware will handle the redirection logic for these two routes.
    Route::get('mobile/profile', function () {
        $count = Places::where('user_id', Auth::user()->id)->count();
        $countInterests = Favorites::where('user_id', Auth::user()->id)->count();
        $activeUsers = User::where('status', 'active')->count();
        $myFollowers = Followers::where('follower_id', Auth::user()->id)->count();
        $iFollow = Followers::where('following_id', Auth::user()->id)->count();
        return view('mobile.profile.profile', compact('activeUsers', 'count', 'countInterests', 'myFollowers', 'iFollow'));
    })->name('mobile.profile.profile');

    Route::get('mobile/profileAdmin', function () {
        $all_places = Places::count();
        $all_users = User::count();
        $all_reports = Report::count();
        $count = Places::where('user_id', Auth::user()->id)->count();
        $countInterests = Favorites::where('user_id', Auth::user()->id)->count();
        $myFollowers = Followers::where('follower_id', Auth::user()->id)->count();
        $iFollow = Followers::where('following_id', Auth::user()->id)->count();
        $reports = Report::all();
        $review_reports = ReviewReport::all();
        return view('mobile.profile.profileAdmin', compact('review_reports', 'reports', 'all_reports', 'all_users', 'all_places', 'count', 'countInterests', 'myFollowers', 'iFollow'));
    })->name('mobile.profile.profileAdmin');

    // Admin-specific routes
    // The mobile_auth middleware will also handle redirection if a regular user tries to access these.
    Route::get('mobile/admin/users/edit/{ad}', [UserAdminController::class, 'editFromMobile'])->name('mobile.admin.users.edit');
    Route::put('mobile/admin/users/update/{user}', [UserAdminController::class, 'updateFromMobile'])->name('mobile.admin.users.update');
    Route::delete('mobile/admin/users/destroy/{user}', [UserAdminController::class, 'destroyFromMobile'])->name('mobile.admin.users.destroy');
    Route::get('mobile/admin/users/index', function (Request $request) {
        $query = User::withCount('followers')->withCount('favorites')->withCount('ratings');
        if ($request->filled('search')) {
            $search_term = $request->input('search');
            $query->where('explorer_name', 'like', '%' . $search_term . '%');
        }
        $users = $query->get();
        return view('mobile.admin.users.index', compact('users'));
    })->name('mobile.admin.users.index');

    Route::get('mobile/users/discovers', function (Request $request) {
        $query = User::withCount('followers')->withCount('favorites')->withCount('ratings');
        if ($request->filled('search')) {
            $search_term = $request->input('search');
            $query->where('explorer_name', 'like', '%' . $search_term . '%');
        }
        $users = $query->get();
        return view('mobile.profile.discovers', compact('users'));
    })->name('mobile.users.index');
});
