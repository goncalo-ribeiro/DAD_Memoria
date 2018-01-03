<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordAPI extends Controller
{

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if($request->oldPassword != $request->newPassword){
            if (Hash::check($request->oldPassword, $user->password)) {
                $user->password = bcrypt($request->newPassword);
                $user->save();
                return redirect()->route('dashboard')->with('success', 'Password updated successfully');
            }
            return response()->json(['msg'=>'Password update successfully'], 200);
            //return redirect()->back()->withErrors(array('oldPassword' => 'The password entered is incorrect'));
        }
        
        return response()->json(['msg'=>'Error changin password'], 500);
    }
}