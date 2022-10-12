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

Route::prefix('education')->middleware('auth')->group(function() {
    Route::get('{id}', 'EducationController@index')->name('education');
    Route::get('{id}/{number}', 'EducationController@read')->name('education.read');
    Route::get('{id}/{number}/video', 'EducationController@video')->name('education.video');
    Route::post('{id}/{number}/video-completed', 'EducationController@videoCompleted')->name('education.video-completed');
});
