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

Route::get('/news', 'ApiController@news')->middleware('auth.apikey');
Route::get('/genres', 'ApiController@genres')->middleware('auth.apikey');
Route::get('/drama', 'ApiController@genre')->middleware('auth.apikey');
Route::get('/search', 'ApiController@search')->middleware('auth.apikey');
Route::get('/populars', 'ApiController@populars')->middleware('auth.apikey');
Route::get('/latests', 'ApiController@latests')->middleware('auth.apikey');
Route::get('/stream', 'ApiController@getStreamLink')->middleware('auth.apikey');
Route::get('/movies', 'ApiController@movies')->middleware('auth.apikey');
Route::get('/ads', 'ApiController@ads')->middleware('auth.apikey');
Route::get('/languages', 'ApiController@languages')->middleware('auth.apikey');

/** english */
Route::get('/en/news', 'ApiEnController@news')->middleware('auth.apikey');
Route::get('/en/genres', 'ApiEnController@genres')->middleware('auth.apikey');
Route::get('/en/drama', 'ApiEnController@genre')->middleware('auth.apikey');
Route::get('/en/search', 'ApiEnController@search')->middleware('auth.apikey');
Route::get('/en/populars', 'ApiEnController@populars')->middleware('auth.apikey');
Route::get('/en/latests', 'ApiEnController@latests')->middleware('auth.apikey');
Route::get('/en/stream', 'ApiEnController@getStreamLink')->middleware('auth.apikey');
Route::get('/en/movies', 'ApiEnController@movies')->middleware('auth.apikey');