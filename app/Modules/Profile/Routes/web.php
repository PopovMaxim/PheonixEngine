<?php

Route::middleware('auth')->prefix('profile')->group(function() {
    Route::match(['get', 'post'], 'settings', 'ProfileController@index')->name('profile.settings');
    Route::match(['get', 'post'], 'activity-log', 'ProfileController@activityLog')->name('profile.activity-log');
});
