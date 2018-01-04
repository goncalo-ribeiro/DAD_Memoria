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
Route::post('login', 'LoginControllerAPI@login');
Route::post('logout','LoginControllerAPI@logout');

Route::middleware('auth:api')->post('updatePassword','AdminAPI@updatePassword');
Route::middleware('auth:api')->post('updateEmail','AdminAPI@updateEmail');

// o middleware admin:api não funciona porque não consegue fazer retrieve do user logo nao consegue verificar se é admin
// no entanto os metodos chamados pelas rotas acima verificam se o user logado é admin
Route::middleware('admin:api')->get('teste', function () {return response()->json(['msg'=>'Só um teste'], 200);});
