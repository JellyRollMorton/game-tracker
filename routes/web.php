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

Route::group(['middleware' => 'auth'], function() {
	Route::get('/', 'DashboardController@show')->middleware('auth');
	Route::get('api/players/search', 'API\PlayerController@search');
	Route::get('about', 'AboutController@show');
	Route::apiResource('api/players', 'API\PlayerController');
	Route::apiResource('api/games', 'API\GameController');
	Route::apiResource('api/player_rankings', 'API\PlayerRankingsController');
	Route::resource('players', 'PlayerController');
	Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();