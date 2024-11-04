<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class RateLimiterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $limit = 100;
        $key = "rate_limit:{$request->ip()}";

        if(auth()->check()){

            switch ($request->user()->role){
                case "admin":
                    return $next($request);
                case "host":
                    $limit = 500;
                    $key = "rate_limit:{$request->user()->id}";
                    break;
            }
        }

        if (RateLimiter::tooManyAttempts($key, $limit)) {
            throw new ThrottleRequestsException('Too many requests');
        }

        RateLimiter::hit($key, 60 * 60); // 1 hour

        return $next($request);
    }
}
