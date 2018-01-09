<?php

namespace App\Http\Controllers;

use App\Game;
use App\Game_User;
use App\User;
use DB;

class StatisticsControllerAPI
{

    ////////////////////////////////////////////////////////////////////////////////
    //Returns the General Statistics
    public function index(){
        $statistics =array (
            "topPlayers"  => $this->getTopPlayers(),
            "totalGames" => $this->getTotalGames()
        );
        return response()->json($statistics);
    }


    public function getTopPlayers(){
        $games = DB::table('games')->where('status', 'terminated')
                                    ->join('users','users.id','=','winner')
                                    ->groupBy('winner','users.nickname')
                                    ->selectRaw('winner, users.nickname as nick, count(*) as games')
                                    ->orderBy('games', 'desc')
                                    ->limit(3)->get();
   
        return $games;
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
      
        return $totalGames;
    }

    ////////////////////////////////////////////////////////////////////////////////
    //Returns the User Statistics

    public function user($id){
        $userStatistics =array (
            "victorys"  => $this->getUserGames($id),
            "totalGames" => $this->getUserWins($id)
        );
        return response()->json($userStatistics);
    }



    public function getUserGames($id){
        $userTotalGames = DB::table('games')->where('status', 'terminated')
        								->join('game_user', 'game_user.game_id', '=', 'games.id')
        								->where('game_user.user_id', $id)
	          							->groupBy('games.type')
	                                    ->selectRaw('games.type, count(*) as games')
	                                    ->get();


        //We need to fabricate total because we didnt retrieve it, whit the previus query
        $typeTotal =array (
            "type"  => "total",
            "games" => DB::table('games')->where('status', 'terminated')
                        ->join('game_user', 'game_user.game_id', '=', 'games.id')->where('game_user.user_id', $id)->count()
        );
        $userTotalGames->push($typeTotal);//Adds the type to game*/    
      
        return $userTotalGames;
    }


    public function getUserWins($id){

        $userTotalVictorys = DB::table('games')->where('status', 'terminated')->where('winner', $id)
                                            ->groupBy('type')
                                            ->selectRaw('type, count(*) as games')
                                            ->get();
      
        return $userTotalVictorys;
    }

}
