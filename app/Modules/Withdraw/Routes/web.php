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

Route::middleware('auth')->prefix('withdraw')->group(function() {
    Route::get('/', 'WithdrawController@index')->name('withdraw');
    Route::get('/{uuid}', 'WithdrawController@read')->name('withdraw.read');
    Route::post('request', 'WithdrawController@request')->name('withdraw.request');
    Route::post('cancel', 'WithdrawController@cancel')->name('withdraw.cancel');
});
