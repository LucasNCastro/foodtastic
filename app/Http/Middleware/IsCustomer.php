<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return Auth::user() && Auth::user()->isCustomer() ?  $next($request) : redirect('/');
    }
}
