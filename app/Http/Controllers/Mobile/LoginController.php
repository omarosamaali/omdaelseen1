<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index()
    {
        return view('mobile.auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        // نحاول تسجيل الدخول ونجبره على استخدام remember = true
        if (! Auth::attempt($request->only('email', 'password'), true)) {
            return back()->withErrors([
                'email' => 'بيانات الدخول غير صحيحة.',
            ]);
        }

        $user = Auth::user();

        if ($user->status == 'banned') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'حسابك محظور. يرجى التواصل مع الإدارة.',
            ]);
        }

        if ($user->status == 'inactive') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'حسابك غير مفعل. يرجى التحقق من بريدك الإلكتروني لتفعيله.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('mobile.welcome', absolute: false));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('mobile/login');
    }
}
