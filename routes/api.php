<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/game/getboard', 'MineSweeperController@genereteBoard')->name('genereteboard');
Route::get('/game/init', 'MineSweeperController@initGame')->name('init')->middleware('auth:api');
Route::post('/game/checkcell', 'MineSweeperController@checkCell')->name('checkcell')->middleware('auth:api');
Route::post('/game/toggleflag', 'MineSweeperController@toggleFlag')->name('toggleflag')->middleware('auth:api');
