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

Route::get('/', 'WelcomeController@index');

Auth::routes([
    'register' => false
]);

Route::get('/app', 'HomeController@index')->name('home');
Route::get('/sell', 'HomeController@index')->name('home');
Route::get('/stocks', 'HomeController@index')->name('home');
Route::get('/add-stock', 'HomeController@index')->name('home');
Route::get('/workers', 'HomeController@index')->name('home');
Route::get('/report', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@index')->name('home');
Route::get('/overall-report', 'HomeController@index')->name('home');
Route::get('/item/show/{id}', 'HomeController@index')->name('home');
Route::get('/stocks-out', 'HomeController@index')->name('home');
Route::get('/stocks-in', 'HomeController@index')->name('home');


Route::post('item/store', 'ItemController@store');
Route::post('item/destroy', 'ItemController@destroy');
Route::post('item/update', 'ItemController@update');
Route::post('item/index', 'ItemController@index');
Route::get('item/get/{id}', 'ItemController@show');


Route::post('cart/add', 'CartController@add');
Route::post('cart/destroy', 'CartController@destroy');
Route::post('cart/clear', 'CartController@clear');
Route::post('cart/confirm', 'CartController@confirm');
Route::get('cart/all', 'CartController@all');


Route::get('worker/all', 'WorkerController@all');
Route::get('worker/view', 'WorkerController@view');
Route::post('worker/update', 'WorkerController@update');
Route::post('worker/update-password', 'WorkerController@update_password');
Route::post('worker/destroy', 'WorkerController@destroy');
Route::post('worker/create', 'WorkerController@create');
Route::post('worker/update-my-profile', 'WorkerController@umprof');
Route::post('worker/update-my-password', 'WorkerController@umpass');
Route::post('worker/check-user-password', 'WorkerController@checkUserPassword');


Route::post('report/get-single-day', 'ReportController@get_single_day');
Route::post('report/get-range', 'ReportController@get_range');
Route::get('report/overall', 'ReportController@overall');



