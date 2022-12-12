<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
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
        // if(auth()->user()->role == 'admin' || auth()->user()->hasRole('admin')){
            return $next($request);
        // }
        // if(auth()->user()->role == 'user' || auth()->user()->hasRole('user')){
        //     return $next($request);
        // }
    }
}
