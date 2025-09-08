<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // أول حاجة شوف لو في locale في الـ session
        $locale = Session::get('locale');

        // لو مفيش، استعمل الـ default
        if (!$locale) {
            $locale = config('app.locale', 'en');
        }

        // تأكد إن الـ locale ده متاح
        if (in_array($locale, ['en', 'ar', 'zh'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
