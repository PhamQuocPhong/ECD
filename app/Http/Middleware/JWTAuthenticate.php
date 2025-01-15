<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Exceptions\TokenException;

class JWTAuthenticate
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        }   catch (JWTException $e) {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                throw new TokenException(__('auth.token_expired'), HTTP_UNAUTHORIZED);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                throw new TokenException(__('auth.token_invalid'), HTTP_UNAUTHORIZED);
            }else{
                throw new TokenException(__('auth.token_required'), HTTP_INTERNAL_SERVER_ERROR );
            }
        }
        return $next($request);
    }
}