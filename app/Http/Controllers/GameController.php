<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;

class GameController
{
    public function index(Request $request){
    	$games = Game::where('status', 'pending')->get();
    	return view('game.lobby', compact('games'));
    }

    public function reset(Request $request, $token){
        
        //$request->session()->put('token', $token);        este metodo foi substituido pelo flash em baixo porque guardava indefinidamente na sessão o token ao contrario do flash que apenas o guarda até o próximo pedido
        
        $request->session()->flash('token', "$token");
        
        //$request->session()->flush();          este metodo permite limpar as variaveis de sessão guardadas

        return redirect('/');//->with('token', $token);
    }
}
