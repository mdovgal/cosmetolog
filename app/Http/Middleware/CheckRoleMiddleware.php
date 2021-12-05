<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class CheckRoleMiddleware
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
        if (Auth::check()  && auth()->user()->role == 'custm'){
            return redirect(RouteServiceProvider::GUEST_HOME);
        }
        if(Auth::check() && auth()->user()->role ==='cosmt')
        {
            return redirect(RouteServiceProvider::COSMETOLOG_HOME);
        }
        return $next($request);
    }
}
