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

    Route::post('balance/westwallet', 'OverviewController@westwalletBalance')->name('admin.balance.westwallet');

    Route::get('overview', 'OverviewController@index')->name('admin.overview');

    Route::prefix('users')->group(function() {
        Route::get('/', 'UsersController@index')->middleware('role_or_permission:super_admin|user')->name('admin.users');
        Route::get('{id}', 'UsersController@show')->middleware('role_or_permission:super_admin|user.read')->name('admin.users.read');
        Route::match(['get', 'post'], 'edit/{id}', 'UsersController@edit')->middleware('role_or_permission:super_admin|user.edit')->name('admin.users.edit');
        
        Route::post('balance', 'UsersController@balance')->name('admin.users.balance');
    });
    
    Route::prefix('transactions')->group(function() {
        Route::get('/', 'TransactionsController@index')->name('admin.transactions');
        
        Route::prefix('refills')->group(function() {
            Route::get('/', 'Transactions\RefillsController@index')->name('admin.transactions.refills');
            Route::get('{uuid}', 'Transactions\RefillsController@read')->name('admin.transactions.refills.read');
            Route::match(['get', 'post'], '{uuid}/edit', 'Transactions\RefillsController@edit')->name('admin.transactions.refills.edit');
        });

        Route::prefix('transfers')->group(function() {
            Route::get('/', 'Transactions\TransfersController@index')->name('admin.transactions.transfers');
            Route::get('{uuid}', 'Transactions\TransfersController@read')->name('admin.transactions.transfers.read');
        });

        Route::prefix('withdrawal')->group(function() {
            Route::get('/', 'Transactions\WithdrawalController@index')->name('admin.transactions.withdrawal');
            Route::get('{uuid}', 'Transactions\WithdrawalController@send')->name('admin.transactions.withdrawal.send');
        });
    });

    Route::prefix('subscribes')->group(function() {
        Route::get('/', 'SubscribesController@index')->name('admin.subscribes');
        Route::match(['get', 'post'], '{uuid}/edit/{tab?}', 'SubscribesController@edit')->name('admin.subscribes.edit');
    });

    Route::prefix('mailing')->group(function() {
        Route::match(['get', 'post'], '/', 'MailingController@index')->name('admin.mailing');
    });
    
    Route::prefix('products')->group(function() {
        Route::prefix('tariffs')->group(function() {
            Route::get('/', 'Products\TariffsController@index')->name('admin.products.tariffs');
            Route::match(['get', 'post'], 'stats/{id?}', 'Products\TariffsController@stats')->name('admin.products.tariffs.stats');
            Route::match(['get', 'post'], 'form/{id?}', 'Products\TariffsController@form')->name('admin.products.tariffs.form');
            Route::match(['get', 'post'], 'delete/{id?}', 'Products\TariffsController@delete')->name('admin.products.tariffs.delete');
        });

        Route::prefix('lines')->group(function() {
            Route::match(['get', 'post'], 'form/{id?}', 'Products\LineController@form')->name('admin.products.line.form');
            Route::match(['get', 'post'], 'delete/{id?}', 'Products\LineController@delete')->name('admin.products.line.delete');
        });

        Route::prefix('distribs')->group(function() {
            //Route::get('/', 'Transactions\TransfersController@index')->name('admin.transactions.transfers');
            //Route::get('{uuid}', 'Transactions\TransfersController@read')->name('admin.transactions.transfers.read');
        });
    });

    Route::prefix('support')->group(function() {
        Route::get('/{uuid?}', 'SupportController@index')->name('admin.support');
        Route::post('{uuid}/close', 'SupportController@close')->name('admin.support.close');
    });
});

Route::post('admin/users/auth/{id}', 'UsersController@auth')->middleware('role_or_permission:super_admin|user.auth')->name('admin.users.auth');
Route::post('admin/users/logout', 'UsersController@logout')->middleware('auth')->name('admin.users.logout');