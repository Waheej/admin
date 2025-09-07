<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware class for handling localization of incoming requests.
 */

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('customers')->check() ){
            app()->setLocale(auth('customers')->user()->locale);
            return $next($request);
        }

        if (Auth::guard('web')->check() ){
            app()->setLocale(auth('web')->user()->locale);
            return $next($request);
        }

        $local = (!($request->hasHeader('lang')) || ($request->hasHeader('lang') == '')) ? 'en' : $request->header('lang');

        app()->setLocale($local);

        return $next($request);
    }
}
