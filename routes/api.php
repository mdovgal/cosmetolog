<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {
// generals
    Route::get('/product_params', 'ProductController@params');
    Route::get('/product_params/{product_id}', 'ProductController@params');

// Routers for Categories
    Route::get('/catalog', 'CatalogController@index');
    Route::put('/catalog/{catalog}', 'CatalogController@update');
    Route::delete('/catalog/{catalog}', 'CatalogController@delete');
    Route::post('/catalog', 'CatalogController@create');

// Routers for Products
    Route::get('/products/category/{category}', 'ProductController@index');
//    Route::get('/product/{product}/edit', 'ProductController@find');
    Route::post('/product', 'ProductController@save');
    Route::put('/product', 'ProductController@update');
    Route::get('/products/{product}', 'ProductController@find');
    Route::delete('/product/{product}', 'ProductController@delete');

// Routers for Users
    Route::post('/users', 'UsersController@store');
    Route::get('/users', 'UsersController@index');
    Route::get('/users/{user}', 'UsersController@show');
    Route::put('/users/{user}', 'UsersController@update');
    Route::delete('/users/{user}', 'UsersController@destroy');


// old routers
    Route::get('/category', 'CategoryController@index');

    Route::get('/article/user/{user}', 'ArticleController@index');
    Route::post('/article', 'ArticleController@save');

});