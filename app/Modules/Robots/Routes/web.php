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

Route::middleware('auth')->prefix('subscribes')->group(function() {
    Route::match(['get', 'post'], '/', 'RobotsController@index')->name('subscribes');
    Route::match(['get', 'post'], '{uuid}', 'RobotsController@read')->name('subscribes.read');
});
