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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/cabinet', 'CabinetController@index')->name('cabinet');
Route::get('/list', 'ListController@index')->name('list');

Route::prefix('property')->group(function () {
    Route::get('/add', 'PropertyController@add')->name('property.add');
    Route::post('/save', 'PropertyController@save')->name('property.save');
    Route::get('/view/{id}', 'PropertyController@view')->name('property.view');
});

Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::post('/save_type', 'AdminController@saveType')->name('admin.save_type');
});



