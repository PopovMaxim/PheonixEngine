<?php

Route::get('dashboard', 'DashboardController@index')->middleware('auth')->name('dashboard');
Route::post('accept-quick-bonus', 'DashboardController@acceptQuickBonus')->middleware('auth')->name('accept-quick-bonus');