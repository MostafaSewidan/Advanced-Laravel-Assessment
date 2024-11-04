<?php

namespace App\Http\Middleware;

use App\Repositories\LoggingRequestRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class LoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->is("api/admin/dashboard")){

            $loggingRequestRepo = new LoggingRequestRepository();

            $loggingRequestRepo->create(
                $request->ip(), 
                $request->all(), 
                $request->headers->all()
            );
        }

        return $next($request);
    }
}
