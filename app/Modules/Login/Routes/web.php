<?php

Route::middleware('guest')->prefix('login')->group(function () {
    Route::get('/', 'LoginController@index')->name('login');
    Route::middleware('throttle:authorize')->post('authorize', 'LoginController@authorize')->name('login.authorize');
});