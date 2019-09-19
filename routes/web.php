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

Route::get('import', 'UtilsController@manga');
Route::get('/', 'AdminController@index');
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
Route::post('system/upload', 'AdminController@upload')->middleware(['auth'])->name('system.upload');
Route::post('system/insertDrama', 'AdminController@insertDrama')->middleware(['auth'])->name('system.insertDrama');
Route::post('system/removeDraft', 'AdminController@removeDraft')->middleware(['auth'])->name('system.removeDraft');
Route::get('system/dramas', 'AdminController@dramas')->middleware(['auth'])->name('system.dramas');
Route::get('system/editDrama/{id}', 'AdminController@editDrama')->middleware(['auth'])->name('system.editDrama');
Route::post('system/editDramaPost/{id}', 'AdminController@editDramaPost')->middleware(['auth'])->name('system.editDramaPost');

Route::get('system/tess', 'UtilsController@updateLinks')->middleware(['auth'])->name('system.updateLinks');
