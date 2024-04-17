<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfSortcenter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'sortcenter')
    {
	    if (Auth::guard($guard)->check()) {
	        return redirect('sortcenter/dashboard');
	    }

	    return $next($request);
	}
}
