<?php

Route::post('logout', 'LogoutController@index')
    ->middleware('auth')
    ->name('logout');
