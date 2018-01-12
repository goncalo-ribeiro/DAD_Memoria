<?php

use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
	private $numberOfGames = 10;
	private $player = 3;//to distribute across all players check run method()
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pt_PT');

        //In case someone wants to distribute across all players 
        //$players = $faker->numberBetween(1,DB::table('users')->max('id'));

        for ($i = 0; $i < $this->numberOfGames; ++$i) {
            DB::table('games')->insert($this->fakeSingleplayerGames($faker, $this->player));
        }

        for ($i = 0; $i < $this->numberOfGames; ++$i) {
            DB::table('games')->insert($this->fakeMultiplayerGames($faker, $this->player));
        }
    }

    private function fakeSingleplayerGames(Faker\Generator $faker, $created_by)
    {
    	$bot=DB::table('users')->where('name','bot')->value('id');

        $createdAt = Carbon\Carbon::now()->subDays(30);
        $updatedAt = $faker->dateTimeBetween($createdAt);

        return [
            'type' => 'singleplayer',
            'status' => $faker->randomElement(['pending' ,'active', 'terminated', 'canceled']),
            'total_players' => 1,
            'created_by' => $created_by,
            'winner' => $faker->randomElement([$bot,$created_by]),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    private function fakeMultiplayerGames(Faker\Generator $faker, $created_by)
    {
    	$total_players=$faker->numberBetween(1,4);

    	$players=$this->generatePlayers($faker, $created_by, $total_players);

    	$faker->randomElement(['singleplayer' ,'multiplayer']);
        $createdAt = Carbon\Carbon::now()->subDays(30);
        $updatedAt = $faker->dateTimeBetween($createdAt);

        return [
            'type' => 'multiplayer',
            'status' => $faker->randomElement(['pending' ,'active', 'terminated', 'canceled']),
            'total_players' => $total_players,
            'created_by' => $created_by,
            'winner' => $faker->randomElement($players),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    private function generatePlayers(Faker\Generator $faker, $creator, $total_players){
    	$players=array($creator);

    	//Adds credible possible winners
    	for($i=1; $i<$total_players; $i++){
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

    	return $players;
    }
}
