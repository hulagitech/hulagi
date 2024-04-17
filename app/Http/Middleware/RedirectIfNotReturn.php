<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotReturn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle($request, Closure $next)
    // {
    //     return $next($request);
    // }

    public function handle($request, Closure $next, $guard = 'return')
	{
	    
	    if (!Auth::guard($guard)->check()) {
	    	
	        return redirect('return/login');
	    }

	    return $next($request);
	}
}
