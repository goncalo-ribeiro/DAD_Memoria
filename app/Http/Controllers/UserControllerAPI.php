<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\DB;

use App\User;
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
        $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'age' => 'integer|between:18,75',
                'password' => 'min:3'
            ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json(new UserResource($user), 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'age' => 'integer|between:18,75'
            ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message'=>'O utilizador foi removido com sucesso'], 204);
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
