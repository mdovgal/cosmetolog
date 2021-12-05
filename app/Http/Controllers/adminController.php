<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class adminController extends Controller
{
    public function __construct()
    {
//        $this->middleware('user-role');
//print '<pre>';var_dump(Auth::check(), auth()->user()->role); print '</pre>';exit();
        $this->middleware(['auth','user-role']);
    }

    public function index()
    {
        return view('admin');
    }

    protected function redirectTo(){exit('redirectTo');
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
