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

Route::middleware('auth')->prefix('refill')->group(function() {
    Route::match(['get', 'post'], '/', 'RefillController@index')->name('refill');
    Route::match(['get', 'post'], '/{type?}/{currency?}', 'RefillController@form')->name('refill.form');
    Route::get('/{type?}/{currency?}/{uuid?}', 'RefillController@pay')->name('refill.pay');
    Route::post('/{type?}/{currency?}/{uuid?}', 'RefillController@cancel')->name('refill.cancel');
});

Route::match(['get', 'post'], 'refill/ipn/{uuid}', 'RefillController@ipn')->name('refill.ipn');