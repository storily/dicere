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
Route::get('login/token/{token}', [
    'as' => 'login.token',
    'uses' => 'Auth\LoginController@withToken'
]);

Route::get('/', 'PublicController@index')->name('root');
Route::get('/docs', 'PublicController@docs')->name('docs');
Route::get('/admin', 'HomeController@index')->name('admin');
Route::post('/admin/reindex', 'HomeController@reindex')->name('reindex');

Route::resource('datasets', 'DatasetController');
Route::resource('items', 'ItemController');
Route::resource('tags', 'TagController');
