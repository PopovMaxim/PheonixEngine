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

Route::middleware('auth')->prefix('support')->group(function () {
    Route::get('/', 'SupportController@index')->name('support');
    Route::get('closed', 'SupportController@closed')->name('support.closed');
    Route::match(['get', 'post'], 'create', 'SupportController@create')->name('support.create');
    Route::match(['get', 'post'], '{uuid}', 'SupportController@show')->name('support.show');
    Route::post('{uuid}/close', 'SupportController@close')->name('support.close');
});
