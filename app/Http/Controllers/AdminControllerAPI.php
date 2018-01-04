<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminControllerAPI extends Controller
{

    public function updatePassword(Request $request)
    {


        $user = $request->user();

        if ($user->admin != 1) {
            return response()->json(['message'=>'Erro, você não é um administrador'], 400);
        }

        if($request->oldPassword != $request->newPassword){
            if (Hash::check($request->oldPassword, $user->password)) {
                $user->password = bcrypt($request->newPassword);
                $user->save();
                return response()->json(['message'=>'Password atualizada com sucesso'], 200);
            }
            return response()->json(['message'=>'Erro, a Password velha está errada'], 400);
            //return redirect()->back()->withErrors(array('oldPassword' => 'The password entered is incorrect'));
        }
        
        return response()->json(['message'=>'Erro, a Password velha é igual à nova'], 400);
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user();

        if ($user->admin != 1) {
            return response()->json(['message'=>'Erro, você não é um administrador'], 400);
        }

        if($request->email != $user->email){
            $user->email = $request->email;
            $user->save();
            return response()->json(['message'=>'Email atualizado com sucesso'], 200);
        }
        return response()->json(['message'=>'Erro, o email velho é igual ao novo'], 400);
    }

}