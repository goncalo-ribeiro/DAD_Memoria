<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Mail\RegisterUser;
use App\StoreUserRequest;
use Hash;

class UserControllerAPI extends Controller
{
    public function getUsers(Request $request)
    {
        return UserResource::collection(User::all());
    }

    public function getUser($id)
    {
        return new UserResource(User::find($id));
    }

    public function store(Request $request)
    {
        //'name', 'nickname', 'email', 'password', 'blocked'
        $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'nickname' => 'required|unique:users,nickname',
                'password' => 'required|confirmed|min:6',
            ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->email_token = str_random(10);
        $user->save();
        Mail::to($user)->send(new RegisterUser($user->email_token, $user));
        return response()->json(new UserResource($user), 201);
    }

    public function update(Request $request, $id)
    {
        if (Auth::id() != $id) {
            return response()->json(['message'=>'Erro, está a tentar editar os dados de outro utilizador'], 400);   
        }
        $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'nickname' => 'required|unique:users,nickname',
            ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    }

    public function delete($id)
    {
        $user = Auth::user();
        if ($user->admin == 1 || $user->id == $id ) {
            $user = User::findOrFail($id);

            if ($user->admin == 1) {
                return response()->json(['message'=>'Erro, você não pode apagar um administrador'], 400);
            }

            $user->delete();
            return response()->json(['message'=>'O utilizador foi removido com sucesso'], 204);
        }
        return response()->json(['message'=>'Não está autorizado a remover este utilizador'], 400);
    }

    public function emailAvailable(Request $request)
    {
        $totalEmail = 1;
        if ($request->has('email') && $request->has('id')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->where('id', '<>', $request->id)->count();
        } else if ($request->has('email')) {
            $totalEmail = DB::table('users')->where('email', '=', $request->email)->count();
        }
        return response()->json($totalEmail == 0);
    }


    public function block(Request $request, $id)
    {
        $userAdmin = $request->user();

        if ($userAdmin->admin != 1) {
            return response()->json(['message'=>'Erro, você não é um administrador'], 400);
        }

        $request->validate([
                'reason_blocked' => 'required|string'
            ]);
        $request->request->add(['blocked' => 1]);
        $request->request->add(['reason_reactivated' => null]);
        $user = User::findOrFail($id);

        if ($user->admin == 1) {
            return response()->json(['message'=>'Erro, você não pode bloquear um administrador'], 400);
        }

        if ($user->blocked != 0) {
            return response()->json(['message'=>'Erro, o utilizador ja se encontra bloqueado'], 400);   
        }

        $user->update($request->all());
        return response()->json(['message'=>'O utilizador foi bloqueado com sucesso'], 200);
    }

    public function reactivate(Request $request, $id)
    {
        $userAdmin = $request->user();

        if ($userAdmin->admin != 1) {
            return response()->json(['message'=>'Erro, você não é um administrador'], 400);
        }

        $request->validate([
                'reason_reactivated' => 'required|string'
            ]);
        $request->request->add(['blocked' => 0]);
        $request->request->add(['reason_blocked' => null]);
        $user = User::findOrFail($id);

        if ($user->blocked == 0) {
            return response()->json(['message'=>'Erro, o utilizador ja se encontra ativado'], 400);   
        }

        $user->update($request->all());
        return response()->json(['message'=>'O utilizador foi reativado com sucesso'], 200);
    }
}
