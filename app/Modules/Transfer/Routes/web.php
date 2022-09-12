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

Route::middleware('auth')->prefix('transfer')->group(function() {
    Route::get('/', 'TransferController@index')->name('transfer');
    Route::post('send', 'TransferController@send')->middleware('throttle:1,1')->name('transfer.send');
    Route::post('generate-account-number', 'TransferController@generateAccountNumber')->name('transfer.generate-account-number');
});
