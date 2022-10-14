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

Route::prefix('admin')->middleware(['role:super_admin|support'])->group(function() {

    Route::prefix('users')->group(function() {
        Route::get('/', 'UsersController@index')->middleware('role_or_permission:super_admin|user')->name('admin.users');
        Route::match(['get', 'post'], 'edit/{id}', 'UsersController@edit')->middleware('role_or_permission:super_admin|user')->name('admin.users.edit');

        Route::post('auth/{id}', 'UsersController@auth')->middleware('role_or_permission:super_admin|user.auth')->name('admin.users.auth');
    });
    
    Route::prefix('transactions')->group(function() {
        Route::get('/', 'TransactionsController@index')->name('admin.transactions');
    });

    Route::prefix('subscribes')->group(function() {
        Route::get('/', 'SubscribesController@index')->name('admin.subscribes');
    });

    Route::prefix('tariffs')->group(function() {
        Route::get('/', 'TariffsController@index')->name('admin.tariffs');
        Route::match(['get', 'post'], 'create', 'TariffsController@create')->name('admin.tariffs.create');
        //Route::match(['get', 'post'], '{id}/edit', 'TariffsController@edit')->where('id')->name('admin.tariffs.edit');
    });

    Route::prefix('support')->group(function() {
        Route::get('/{uuid?}', 'SupportController@index')->name('admin.support');
    });
});

Route::post('admin/users/logout', 'UsersController@logout')->middleware('auth')->name('admin.users.logout');