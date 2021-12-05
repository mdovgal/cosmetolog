<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo(){
        if (Auth::check()  && auth()->user()->role == 'custm'){
//var_dump('/');
//var_dump(RouteServiceProvider::GUEST_HOME);
            return RouteServiceProvider::GUEST_HOME;
        }
//var_dump(Auth::check()  && auth()->user()->role == 'cosmt');
        if (Auth::check()  && auth()->user()->role == 'cosmt'){
//var_dump('/cosmetologt');
//var_dump(RouteServiceProvider::COSMETOLOG_HOME);
            return RouteServiceProvider::COSMETOLOG_HOME;
        }
//var_dump(Auth::check()  && auth()->user()->role == 'admin');
        if (Auth::check() && auth()->user()->role == 'admin') {
//var_dump('/admin');
//var_dump(RouteServiceProvider::ADMIN_HOME);
            return RouteServiceProvider::ADMIN_HOME;
        }

        return RouteServiceProvider::GUEST_HOME;
exit('LoginController::redirectTo');
        return url('/profile/',auth()->user()->id);
    }
}
