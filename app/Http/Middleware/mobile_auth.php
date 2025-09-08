<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class mobile_auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق أولاً من تسجيل دخول المستخدم
        if (!Auth::check()) {
            return redirect()->route('mobile.auth.login');
        }

        // توجيه المستخدمين بناءً على دورهم (role)
        if (Auth::user()->role === 'admin' && $request->routeIs('mobile.profile.profile')) {
            return redirect()->route('mobile.profile.profileAdmin');
        }

        if (Auth::user()->role === 'user' && $request->routeIs('mobile.profile.profileAdmin')) {
            return redirect()->route('mobile.profile.profile');
        }

        return $next($request);
    }
}
