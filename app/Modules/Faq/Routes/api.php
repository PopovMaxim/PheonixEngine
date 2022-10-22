<?php

use App\Modules\Faq\Entities\Categories;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1/faq')->group(function () {
    Route::get('/', function (Request $request) {
        return Categories::query()->with('items')->get();
    });
});