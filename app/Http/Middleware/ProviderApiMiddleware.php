<?php

namespace App\Http\Middleware;

use Config;
use Closure;
use JWTAuth;
use Exception;


class ProviderApiMiddleware
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
        Config::set('auth.providers.users.model', 'App\Provider');

        try {

            if (! $user = JWTAuth::parseToken()->authenticate(false, 'provider')) {
                return response()->json(['user_not_found'], 404);
            } else {
                \Auth::loginUsingId($user->id);
            }

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['error' => 'token_invalid'], 400);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['error' => 'token_expired'], 401);
            }else{
                return response()->json(['error' => 'token_absent'], 400);
            }
        }

        return $next($request);
    }
}
