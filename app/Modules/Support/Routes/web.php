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
    Route::match(['get', 'post'], '{id}', 'SupportController@show')->where('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}')->name('support.show');
    Route::post('{id}/close', 'SupportController@close')->where('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}')->name('support.close');
});
