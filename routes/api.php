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
// Generals routes
    Route::get('/product_params', 'ProductController@params');
    Route::get('/product_params/{product_id}', 'ProductController@params');
    Route::get('/product_view_params/{product_id}', 'ProductController@params_view');

    Route::get('/catalog/products', 'CatalogController@allcatalog');

// Routers for Cart
    Route::get('/cart/{user_id}', 'CartController@index');
    Route::post('/cart/{user_id}', 'CartController@save');
    Route::post('/cart/{cart_id}/add_product/{product_id}/quantity/{quantity}', 'CartController@save_item');

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


});