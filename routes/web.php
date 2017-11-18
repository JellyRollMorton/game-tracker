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

Route::get('/', 'DashboardController@show');
Route::get('api/players/search', 'API\PlayerController@search');
Route::apiResource('photo', 'PhotoController');
Route::resource('players', 'PlayerController');
Route::resource('games', 'GameController');