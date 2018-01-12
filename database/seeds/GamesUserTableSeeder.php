<?php

use Illuminate\Database\Seeder;

class GamesUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$games=DB::table('games');
   		$total_games=$games->max('id');

        $faker = Faker\Factory::create('pt_PT');
        for ($i = 1; $i <= $total_games; ++$i) {
        	$game=DB::table('games')->where('id',$i);

        	$total_players=$game->value('total_players');
        	$creator=$game->value('created_by');
        	$winner=$game->where('id',$i)->value('winner');

        	$players=$this->generatePlayers($faker, $creator, $winner, $total_players);
        	
        	foreach ($players as $player) {
				DB::table('game_user')->insert($this->fakeGames($faker, $i, $player));
			}            
        }
    }

    private function fakeGames(Faker\Generator $faker, $game_id, $user_id)
    {
        return [
            'game_id' => $game_id,
            'user_id' => $user_id,
        ];
    }

    private function generatePlayers(Faker\Generator $faker, $creator, $winner, $total_players){
    	
    	if($creator==$winner || $total_players==1) $players=array($creator);
    	else $players=array($creator, $winner);
    	

    	//Adds credible possible winners
    	for($i=count($players); $i<$total_players; $i++){
			$randPlayer=$faker->numberBetween(2, DB::table('users')->max('id'));
			$bool=false;

			//Check if player already was added
			foreach ($players as $player) {
				if($player==$randPlayer) $bool=true;
			}

			//In case the player is invalid runs the for again
			if($bool) $i--;
			else $players[$i]=$randPlayer;	
    	}

    	return $players;//Retuns the players ids
    }

    
}
