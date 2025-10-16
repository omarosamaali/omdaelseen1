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
        $locale = Session::get('locale');
        
        if (!$locale) {
            $locale = config('app.locale', 'en');
        }

        if (in_array($locale, ['en', 'ar', 'zh'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
