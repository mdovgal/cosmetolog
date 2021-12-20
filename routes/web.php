<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', 'blogController@index');
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/product/{any}', function () {
    return view('welcome');
});

//Route::get('/cosmetolog/{any}', function () {
//    return view('cosmetolog');
//});


Auth::routes();

Route::get('/admin', 'adminController@index')->name('home');
Route::get('/admin/{any}', 'adminController@index')->where('any', '.*');
