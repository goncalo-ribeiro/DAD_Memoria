<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ConfigTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(GamesTableSeeder::class);
        $this->call(GamesUserTableSeeder::class);
    }
}
