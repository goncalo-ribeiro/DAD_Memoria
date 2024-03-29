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
//Statistics Routes
Route::get('statistics', 'StatisticsControllerAPI@index');
Route::get('statistics/user/{id}', 'StatisticsControllerAPI@user');

//Other stuff
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/user/admin', function (Request $request) {
    return $request->user();
});

Route::post('login', 'LoginControllerAPI@login');
Route::post('logout','LoginControllerAPI@logout');

Route::post('users', 'UserControllerAPI@store');
Route::middleware('auth:api')->put('users/{id}', 'UserControllerAPI@update');
Route::middleware('auth:api')->get('users', 'UserControllerAPI@getUsers');
Route::middleware('auth:api')->put('users/block/{id}', 'UserControllerAPI@block');
Route::middleware('auth:api')->put('users/reactivate/{id}', 'UserControllerAPI@reactivate');
Route::middleware('auth:api')->delete('users/{id}', 'UserControllerAPI@delete');

Route::middleware('auth:api')->post('password/email','ResetPasswordControllerAPI@sendResetLinkEmail');
Route::post('password/reset','ResetPasswordControllerAPI@reset');

Route::middleware('auth:api')->put('admin/password','AdminControllerAPI@updatePassword');
Route::middleware('auth:api')->put('admin/email','AdminControllerAPI@updateEmail');

Route::get('images','ImageControllerAPI@getImages');
Route::middleware('auth:api')->post('images','ImageControllerAPI@uploadImage');
Route::middleware('auth:api')->put('images/activate/{imageId}','ImageControllerAPI@activate');
Route::middleware('auth:api')->put('images/desactivate/{imageId}','ImageControllerAPI@desactivate');
Route::middleware('auth:api')->delete('images/{imageId}', 'ImageControllerAPI@delete');

Route::middleware('auth:api')->post('games', 'GameControllerAPI@store');

// o middleware admin:api não funciona porque não consegue fazer retrieve do user logo nao consegue verificar se é admin
// no entanto os metodos chamados pelas rotas acima verificam se o user logado é admin
Route::middleware('admin:api')->get('teste', function () {return response()->json(['msg'=>'Só um teste'], 200);});
