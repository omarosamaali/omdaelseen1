<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\ProfileController;
use App\Http\Controllers\Mobile\ChinaDiscoverController;
use App\Models\Places;
use App\Models\Favorites;
use App\Models\Followers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FollowController;

Route::middleware('mobile_auth')->group(function () {

Route::post('/users/toggle-follow', [FollowController::class, 'toggleFollow'])
    ->middleware('auth') // تأكد أن المستخدم مسجل الدخول
    ->name('users.toggle-follow');

    Route::get('mobile/my-places', function () {
        $myPlaces = Places::where('user_id', Auth::user()->id)->get();
        return view('mobile.china-discovers.my-places', compact('myPlaces'));
    })->name('mobile.china-discovers.my-places');

    Route::get('mobile/my-interests', function () {
        $favoritePlaces = auth()->user()->favoritePlaces;

        // مررها إلى الـ view باسم واضح ومناسب
        return view('mobile.profile.my-interests', compact('favoritePlaces'));
    })->name('mobile.profile.my-interests');

    Route::post('/favorites/toggle', [FavoriteController::class, 'toggleFavorite'])->middleware('auth')->name('favorites.toggle');


    Route::get('mobile/china-discovers/create', [ChinaDiscoverController::class, 'create'])->name('mobile.china-discovers.create');
    Route::post('mobile/china-discovers', [ChinaDiscoverController::class, 'store'])->name('mobile.china-discovers.store');
    Route::get('mobile/china-discovers/edit/{id}', [ChinaDiscoverController::class, 'edit'])->name('mobile.china-discovers.edit');
    Route::put('mobile/china-discovers/{id}', [ChinaDiscoverController::class, 'update'])->name('mobile.china-discovers.update');
    Route::get('get-subcategories/{id}', [ChinaDiscoverController::class, 'getSubcategories'])->name('mobile.china-discovers.get-subcategories');
    Route::post('/translate', [ChinaDiscoverController::class, 'translate'])->name('mobile.translate');
    Route::get('mobile/china-discovers/all-places', [ChinaDiscoverController::class, 'allPlaces'])->name('mobile.china-discovers.all-places');
    Route::get('mobile/china-discovers/{id?}', [ChinaDiscoverController::class, 'index'])->name('mobile.china-discovers.index');
    Route::get('mobile/info_place/{place}', function (Places $place) {
        return view('mobile.china-discovers.info_place', compact('place'));
    })->name('mobile.china-discovers.info_place');
    Route::get('/all-places/{region_id?}', [ChinaDiscoverController::class, 'allPlaces'])->name('all.places');
    Route::get('mobile', function () {
        return view('mobile.welcome');
    })->name('mobile.welcome');

    Route::get('mobile/profile', function () {
        $count = Places::where('user_id', Auth::user()->id)->count();
        $countInterests = Favorites::where('user_id', Auth::user()->id)->count();
        $myFollowers = Followers::where('follower_id', Auth::user()->id)->count();
        $iFollow = Followers::where('following_id', Auth::user()->id)->count();
        return view('mobile.profile.profile', compact('count', 'countInterests', 'myFollowers', 'iFollow'));
        
    })->name('mobile.profile.profile');
    Route::get('mobile/verify', function () {
        return view('mobile.profile.verify');
    })->name('mobile.profile.verify');
    Route::get('mobile/success', function () {
        return view('mobile.profile.success');
    })->name('mobile.profile.success');
    Route::get('mobile/notifications', function () {
        return view('mobile.profile.notifications');
    })->name('mobile.profile.notifications');
    Route::get('mobile/my-medals', function () {
        return view('mobile.profile.my-medals');
    })->name('mobile.profile.my-medals');
    Route::get('mobile/edit-profile', function () {
        return view('mobile.profile.edit-profile');
    })->name('mobile.profile.edit-profile');
    Route::delete('mobile/profile/delete-account', [ProfileController::class, 'deleteAccount'])->name('mobile.profile.delete-account');
    Route::post('mobile/profile/update', [ProfileController::class, 'updateProfile'])->name('mobile.profile.update');
    Route::post('mobile/profile/send-otp', [ProfileController::class, 'sendOtp'])->name('mobile.profile.send-otp');
    Route::post('mobile/profile/verify-otp', [ProfileController::class, 'verifyOtp'])->name('mobile.profile.verify-otp');
});
