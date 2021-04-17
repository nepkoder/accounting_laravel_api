<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
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

        if (is_null($request->bearerToken())) {
            return response()->json(['message' => 'Token required.'], 401);
        }

        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            // if invalid
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['message' => 'Token invalid']);
                // if expired
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['message' => 'Token expired']);
            } else {
                return response()->json(['message' => 'Token not found.']);
            }
        }
        return $next($request);
    }
}
