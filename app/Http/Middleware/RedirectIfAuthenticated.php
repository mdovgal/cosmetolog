<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//print '<pre>';
//var_dump(Auth::check());
//var_dump(auth()->user()->role);
//exit();
//        if(!Auth::check()){
//            return $next($request);
//        }
        if(Auth::guard($guard)->check()  && auth()->user()->role == 'custm'){
            return redirect(RouteServiceProvider::GUEST_HOME);
        }
        if(Auth::guard($guard)->check()  && auth()->user()->role == 'cosmt'){
            return redirect(RouteServiceProvider::COSMETOLOG_HOME);
        }
        if (Auth::guard($guard)->check() && auth()->user()->role == 'admin') {
            return redirect(RouteServiceProvider::ADMIN_HOME);
        }

        return $next($request);
    }
}
