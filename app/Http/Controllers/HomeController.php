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
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.dashboard');
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
            return redirect()->route('dashboard')->with('success', 'User data updated successfully');
        }

        return redirect()->route('dashboard');

        
    }

    public function updatePassword(UpdatePasswordPostRequest $request)
    {
        $user = Auth::user();
        if($request->oldPassword != $request->newPassword){
            if (Hash::check($request->oldPassword, $user->password)) {
                $user->password = bcrypt($request->newPassword);
                $user->save();
                return redirect()->route('dashboard')->with('success', 'Password updated successfully');
            }
            return redirect()->back()->withErrors(array('oldPassword' => 'The password entered is incorrect'));
        }
        
        return redirect()->route('dashboard');
    }

    public function deleteAccount(){
        //futuramente apagar recursivamente os dados do utilizador
        Auth::user()->delete();
        return redirect()->route('lobby')->with('success', 'Account deleted successfully');;
    }

    public function reset(Request $request, $token){
        
        //$request->session()->put('token', $token);        este metodo foi substituido pelo flash em baixo porque guardava indefinidamente na sessão o token ao contrario do flash que apenas o guarda até o próximo pedido
        
        $request->session()->flash('token', "$token");
        
        //$request->session()->flush();          este metodo permite limpar as variaveis de sessão guardadas

        return redirect('/');//->with('token', $token);
    }

    public function validateUser(Request $request, $id, $token)
    {
        $user = User::findOrFail($id);

        if ($token == $user->email_token) {
            $user->verified = 1;
            $user->email_token = null;
            $user->save();
            $request->session()->flash('success', "O utilizador foi verificado com sucesso");
            return redirect('/#login');
        }

        return redirect('/#error');//->with('token', $token);
    }
}
