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

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index')->name('/');
// Authentication Routes...
Route::get('bG9naW4=', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('bG9naW4=', 'Auth\LoginController@login');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('/');
 });

Route::get('system/dashboard', 'AdminController@dashboard')->middleware(['auth'])->name('system.dashboard');
Route::get('system/restore', 'AdminController@restore')->middleware(['auth'])->name('system.restore');
Route::get('system/genres', 'AdminController@genres')->middleware(['auth'])->name('system.genres');
Route::get('system/editGenre/{id}', 'AdminController@editGenre')->middleware(['auth'])->name('system.editGenre');
Route::post('system/editGenrePost/{id}', 'AdminController@editGenrePost')->middleware(['auth'])->name('system.editGenrePost');
Route::get('system/createGenre', 'AdminController@createGenre')->middleware(['auth'])->name('system.createGenre');
Route::post('system/createGenrePost', 'AdminController@createGenrePost')->middleware(['auth'])->name('system.createGenrePost');
Route::get('system/deleteGenre/{id}', 'AdminController@deleteGenre')->middleware(['auth'])->name('system.deleteGenre');


Route::post('system/upload', 'AdminController@upload')->middleware(['auth'])->name('system.upload');
Route::post('system/insertDrama', 'AdminController@insertDrama')->middleware(['auth'])->name('system.insertDrama');
Route::post('system/removeDraft', 'AdminController@removeDraft')->middleware(['auth'])->name('system.removeDraft');
Route::get('system/dramas', 'AdminController@dramas')->middleware(['auth'])->name('system.dramas');
Route::get('system/editDrama/{id}', 'AdminController@editDrama')->middleware(['auth'])->name('system.editDrama');
Route::post('system/editDramaPost/{id}', 'AdminController@editDramaPost')->middleware(['auth'])->name('system.editDramaPost');

Route::get('system/searchDrama', 'SearchController@searchDrama')->middleware(['auth'])->name('system.searchDrama');

Route::get('system/tags', 'AdminController@tags')->middleware(['auth'])->name('system.tags');
Route::get('system/createTag', 'AdminController@createTag')->middleware(['auth'])->name('system.createTag');
Route::post('system/createTagPost', 'AdminController@createTagPost')->middleware(['auth'])->name('system.createTagPost');
Route::get('system/deleteTag/{id}', 'AdminController@deleteTag')->middleware(['auth'])->name('system.deleteTag');

Route::get('system/changePassword', 'AdminController@changePassword')->middleware(['auth'])->name('system.changePassword');
Route::post('system/changePasswordPost', 'AdminController@changePasswordPost')->middleware(['auth'])->name('system.changePasswordPost');
