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

Route::get('/dramas', 'ApiController@drama')->middleware('auth.apikey');
Route::get('/genres', 'ApiController@genres')->middleware('auth.apikey');
Route::get('/drama', 'ApiController@genre')->middleware('auth.apikey');
Route::get('/search', 'ApiController@search')->middleware('auth.apikey');
Route::get('/popular', 'ApiController@popular')->middleware('auth.apikey');
Route::get('/new', 'ApiController@new')->middleware('auth.apikey');
Route::get('/stream', 'ApiController@getStreamLink')->middleware('auth.apikey');