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

//Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/editUserData', 'HomeController@edit')->name('editUserData');
Route::post('/editUserData', 'HomeController@updateData')->name('updateData');
Route::put('/editUserData', 'HomeController@updatePassword')->name('updatePassword');
Route::get('/deleteAccount', 'HomeController@deleteAccount')->name('deleteAccount');

Route::get('/', 'GameController@index')->name('lobby');