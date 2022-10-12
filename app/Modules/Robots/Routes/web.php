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
    Route::match(['get', 'post'], 'accept-terms', 'RobotsController@acceptTerms')->name('subscribes.accept-terms');
});

Route::middleware('auth')->prefix('distribution')->group(function() {
    Route::match(['get', 'post'], '/', 'DistributionController@index')->name('distribution');
    Route::post('{id}/download', 'DistributionController@download')->name('distribution.download');
    Route::match(['get', 'post'], '{id}/archive', 'DistributionController@archive')->name('distribution.archive');
});
