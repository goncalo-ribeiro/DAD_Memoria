<?php

namespace App\Http\Controllers;

use App\User;
use App\Game;
use DB;

class StatisticsControllerAPI
{
    /*public function index(){
    	$games = Game::where('status', 'pending')->get();
    	return view('game.lobby', compact('games'));
    }*/

    public function index(){
		
    }

    public function getTopPlayers(){
        $games = DB::table('games')->where('status', 'terminated')
                                    ->join('users','users.id','=','winner')
                                    ->groupBy('winner','users.nickname')
                                    ->selectRaw('winner, users.nickname as nick, count(*) as games')
                                    ->orderBy('games', 'desc')
                                    ->limit(3)->get();
                                    //->pluck('total','nick');
                                    //$games
   
        return response()->json($games);
        //return response()->json(['nick' => 'Abigail', 'total' => 'CA']);
    }

    

    public function getTotalGames(){
        $totalGames = DB::table('games')->where('status', 'terminated')
                                    ->groupBy('type')
                                    ->selectRaw('type, count(*) as games')
                                    ->get();

        //We need to fabricate total because we didnt retrieve it, whit the previus query
        $typeTotal =array (
            "type"  => "total",
            "games" => Game::all()->where('status', 'terminated')->count()
        );
        $totalGames->push($typeTotal);//Adds the type to game      
      
        return response()->json($totalGames);
    }

}
