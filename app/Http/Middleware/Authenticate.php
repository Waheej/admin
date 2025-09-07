<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {

        if (auth()->guard('customers')->check() && in_array('customers', $guards)) {
            return $next($request);
        }

        if (auth()->guard('web')->check()) {
            return $next($request);
        }

        if (str_contains(request()->path(), 'admin')) {
            return redirect()->route('login');
        }

        return apiResponse(
            false,
            trans('messages.unauthorized'),
            Response::HTTP_UNAUTHORIZED
        );
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
