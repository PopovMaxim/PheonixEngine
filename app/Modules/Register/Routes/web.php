<?php

Route::middleware('guest')
    ->match(['get', 'post'], 'register/{sponsor?}/{leg?}', 'RegisterController@index')
    ->name('register');