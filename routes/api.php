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
Route::get('topplayers', 'StatisticsControllerAPI@getTopPlayers');
Route::get('totalgames', 'StatisticsControllerAPI@getTotalGames');

//Other stuff
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/user/admin', function (Request $request) {
    return $request->user();
});

Route::post('login', 'LoginControllerAPI@login');
Route::post('logout','LoginControllerAPI@logout');

Route::middleware('auth:api')->get('users', 'UserControllerAPI@getUsers');

Route::middleware('auth:api')->post('admin/password','AdminControllerAPI@updatePassword');
Route::middleware('auth:api')->post('admin/password/reset','ResetPasswordControllerAPI@sendResetLinkEmail');
Route::middleware('auth:api')->post('admin/email','AdminControllerAPI@updateEmail');

// o middleware admin:api não funciona porque não consegue fazer retrieve do user logo nao consegue verificar se é admin
// no entanto os metodos chamados pelas rotas acima verificam se o user logado é admin
Route::middleware('admin:api')->get('teste', function () {return response()->json(['msg'=>'Só um teste'], 200);});
