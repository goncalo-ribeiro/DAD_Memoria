<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateDataPostRequest;
use App\Http\Requests\UpdatePasswordPostRequest;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function edit()
    {
        return view('user.editUserData');
    }

    public function updateData(UpdateDataPostRequest $request)
    {
        $user = Auth::user();
        if($user->nickname != $request->nickname && User::where('nickname', $request->nickname)->exists()){
            return redirect()->back()->withErrors(array('nickname' => 'Nickname em uso'));
        }

        if($user->email != $request->email && !User::where('email', $request->email)->exists()){
            return redirect()->back()->withErrors(array('email' => 'E-Mail em uso'));
        }
        if($user->name != $request->name || $user->nickname != $request->nickname || $user->email != $request->email){
            $user->fill($request->all());
            $user->save();
            return redirect()->route('home')->with('success', 'User data updated successfully');
        }

        return redirect()->route('home');

        
    }

    public function updatePassword(UpdatePasswordPostRequest $request)
    {
        $user = Auth::user();
        if($request->oldPassword != $request->newPassword){
            if (Hash::check($request->oldPassword, $user->password)) {
                $user->password = bcrypt($request->newPassword);
                $user->save();
                return redirect()->route('home')->with('success', 'Password updated successfully');
            }
            return redirect()->back()->withErrors(array('oldPassword' => 'The password entered is incorrect'));
        }
        
        return redirect()->route('home');
    }
}
