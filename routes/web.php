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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/verify', 'VerifyController@index')->name('verify');

Route::get('/profile', 'ProfileController@userEdit')->name('profile');
Route::post('/profile/change', 'ProfileController@userChange')->name('profile.change');

Route::get('/cabinet', 'CabinetController@index')->name('cabinet');
Route::get('/list', 'ListController@index')->name('list');

Route::prefix('property')->group(function () {
    Route::get('/add', 'PropertyController@add')->name('property.add');
    Route::get('/edit/{id}', 'PropertyController@edit')->name('property.edit');
    Route::post('/save', 'PropertyController@save')->name('property.save');
    Route::post('/edit_save', 'PropertyController@editSave')->name('property.edit_save');
    Route::get('/view/{id}', 'PropertyController@view')->name('property.view');
    Route::post('/delete/{id}', 'PropertyController@delete')->name('property.delete');
});

Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin');

});

Route::get('/client/{id}', 'ClientController@showClient')->name('client');
Route::get('/agent/{id}', 'ClientController@showAgent')->name('agent');

Route::prefix('image')->group(function () {
    Route::post('/delete/{id}', 'ImageController@delete')->name('image.delete');
    Route::post('/edit', 'ImageController@edit')->name('image.edit');
});

Route::prefix('document')->group(function () {
    Route::post('/delete/{id}', 'DocumentController@delete')->name('document.delete');
    Route::post('/edit', 'DocumentController@edit')->name('document.edit');
});



