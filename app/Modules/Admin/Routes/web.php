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

Route::middleware('auth')->prefix('admin')->group(function() {
    Route::prefix('users')->group(function() {
        Route::get('/', 'UsersController@index')->name('admin.users');
    });
    
    Route::prefix('transactions')->group(function() {
        Route::get('/', 'TransactionsController@index')->name('admin.transactions');
    });

    Route::prefix('subscribes')->group(function() {
        Route::get('/', 'SubscribesController@index')->name('admin.subscribes');
    });

    Route::prefix('tariffs')->group(function() {
        Route::get('/', 'TariffsController@index')->name('admin.tariffs');
    });

    Route::prefix('support')->group(function() {
        Route::get('/{id?}', 'SupportController@index')->where('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}')->name('admin.support');
    });
});
