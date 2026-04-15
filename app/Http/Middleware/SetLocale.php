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
        $available = config('app.available_locales', ['ar', 'en']);
        $default   = config('app.locale', 'ar');

        $locale = $request->route('locale')
            ?? Session::get('locale')
            ?? $default;

        if (!in_array($locale, $available, true)) {
            $locale = $default;
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        view()->share('currentLocale', $locale);
        view()->share('isRtl', $locale === 'ar');

        return $next($request);
    }
}
