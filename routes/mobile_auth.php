<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\LoginController;
use App\Http\Controllers\Mobile\RegisterController;
use App\Http\Controllers\Mobile\ForgotPasswordController;

Route::post('mobile/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('mobile.auth.forgot-password.send');
Route::post('mobile/otp-verification', [ForgotPasswordController::class, 'verifyOtp'])->name('mobile.auth.otp.verify');
Route::post('mobile/create-password', [ForgotPasswordController::class, 'updatePassword'])->name('mobile.auth.password.update');

Route::get('mobile/password-reset-successfully', function () {
    return view('mobile.auth.password-reset-successfully');
})->name('mobile.auth.password-reset-successfully');

Route::get('mobile/create-password', function () {
    return view('mobile.auth.create-password');
})->name('mobile.auth.create-password');

Route::get('mobile/forgot-password', function(){
    return view('mobile.auth.forgot-password');
})->name('mobile.auth.forgot-password');

Route::get('mobile/otp-verification', function () {
    return view('mobile.auth.otp-verification');
})->name('mobile.auth.otp-verification');

Route::get('mobile/login', [LoginController::class, 'index'])->name('mobile.auth.login');
Route::post('mobile/login', [LoginController::class, 'store'])->name('mobile.auth.sign-in');

Route::post('mobile/logout', [LoginController::class, 'logout'])->name('mobile.auth.logout');

Route::get('mobile/register', [RegisterController::class, 'index'])->name('mobile.auth.register');
Route::post('mobile/register', [RegisterController::class, 'store'])->name('mobile.auth.sign-up');
