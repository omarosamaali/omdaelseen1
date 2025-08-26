<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\ProfileController;
use App\Http\Controllers\Mobile\ChinaDiscoverController;

Route::get('mobile/china-discovers', [ChinaDiscoverController::class, 'index'])->name('mobile.china-discovers.index');

Route::get('mobile', function () {
    return view('mobile.welcome');
})->name('mobile.welcome');

Route::middleware('mobile_auth')->group(function () {

    Route::get('mobile/profile', function () {
        return view('mobile.profile.profile');
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
