<?php

Route::middleware('auth')->prefix('network')->group(function() {
    Route::get('tree', 'TreeController@index')->name('network.tree');
    Route::get('line/{level_depth?}/{tariff_line?}', 'LineController@index')->name('network.line');
    Route::get('promo', 'PromoController@index')->name('network.promo');
    Route::get('partners', 'PartnersController@index')->name('network.partners');

    Route::get('leader-pull', 'LeaderPullController@index')->name('network.leader-pull');
});
