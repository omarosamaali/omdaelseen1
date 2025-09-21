<?php

// app/Http/Middleware/SetLayout.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class SetLayout
{
    public function handle($request, Closure $next)
    {
        $layout = Auth::check() && Auth::user()->role === 'admin'
            ? 'layouts.appProfileAdmin'
            : 'layouts.appProfile';

        View::share('layout', $layout);

        return $next($request);
    }
}
