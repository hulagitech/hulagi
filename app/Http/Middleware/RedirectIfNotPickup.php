<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotPickup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'pickup')
    {
        if (!Auth::guard($guard)->check()) {
	    	
	        return redirect('pickup/login');
	    }

	    return $next($request);
    }
}
