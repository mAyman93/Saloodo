<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', 'AuthController@login');
Route::post('/admin/login', 'AuthController@adminLogin');

Route::get('/bundle/all', 'BundleController@getAll');
Route::get('/bundle/{id}', 'BundleController@get');
Route::get('/product/all', 'ProductController@getAll');
Route::get('/product/{id}', 'ProductController@get');

//Routes that requires the user to be authenticated
Route::group(['middleware' => 'jwt.auth'], function() {
    
});

//Routes that requires the user to be an ADMIN
Route::group(['middleware' => 'admin'], function() {
    Route::post('/product/create', 'ProductController@create');
    Route::post('/product/update/{id}', 'ProductController@update');
    Route::delete('product/{id}', 'ProductController@delete');
    Route::get('/discount/all', 'DiscountController@getAll');
    Route::get('/discount/{productId}', 'DiscountController@getByProject');
    Route::post('/discount/create', 'DiscountController@create');
    Route::delete('/discount/{id}', 'DiscountController@delete');
    Route::post('/bundle/create', 'BundleController@create');
    Route::delete('/bundle/{id}', 'BundleController@delete');
});