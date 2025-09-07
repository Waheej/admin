<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetEmailToLower
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((request()->getMethod() == 'POST') || (request()->getMethod() == 'PUT') || (request()->getMethod() == 'PATCH')) {
            if (request()->has('email')) {
                request()->merge(['email' => strtolower(request()->email)]);
            }
        }
        return $next($request);
    }
}
