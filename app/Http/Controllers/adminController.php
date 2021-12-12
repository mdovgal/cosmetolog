<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','user-role']);
    }

    public function index()
    {
        return view('admin');
    }

    protected function redirectTo(){exit('redirectTo');
        if (Auth::check()  && auth()->user()->role == 'custm'){
            return RouteServiceProvider::GUEST_HOME;
        }
        if (Auth::check()  && auth()->user()->role == 'cosmt'){
            return RouteServiceProvider::COSMETOLOG_HOME;
        }

        if (Auth::check() && auth()->user()->role == 'admin') {
            return RouteServiceProvider::ADMIN_HOME;
        }

        return RouteServiceProvider::GUEST_HOME;
        exit('LoginController::redirectTo');
        return url('/profile/',auth()->user()->id);
    }
}
