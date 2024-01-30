<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $guard = null)
    {
  
        if (!Auth::guard($guard)->check()) {         
            return response()->json(['status'=>false,'message'=>'Unauthorized'], 401);
        }

        return $next($request);

    }
}