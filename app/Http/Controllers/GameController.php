<?php

namespace App\Http\Controllers;

use App\Game;

class GameController
{
    public function index(){
    	$games = Game::where('status', 'pending')->get();
    	return view('game.lobby', compact('games'));
    }

    public function reset($token){
        return view('game.lobby')->with('token', $token);
    }
}
