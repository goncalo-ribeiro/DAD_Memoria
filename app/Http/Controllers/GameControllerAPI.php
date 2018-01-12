<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;

use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Game;
use App\Game_User;

class GameControllerAPI extends Controller
{

    public function store(Request $request)
    {
        //'name', 'nickname', 'email', 'password', 'blocked'
        $request->validate([
                'total_players' => 'required|min:1|max:4', 
                'created_by' => 'required',
                'winner' => 'required',
                'players' => 'required',
            ]);
        $game = new Game();
        $game->fill($request->all());
        $game->status = 'terminated';
        $game->type = $request->total_players == 1 ? 'singleplayer' : 'multiplayer';
        $game->save();

        foreach($request->players as $player){
            $gameUser=new Game_User();
            $gameUser->game_id=$game->id;
            $gameUser->user_id=$player;
            $gameUser->timestamps = false;
            $gameUser->save();
        }
        
        return response()->json(['message'=>'Ok'], 200);
    }
}
