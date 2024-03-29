<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    private $numberOfUsers = 30;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('pt_PT');
      
        DB::table('users')->insert($this->fakeUser($faker, true));

        DB::table('users')->insert($this->botAlmeida($faker));


        for ($i = 0; $i < $this->numberOfUsers; ++$i) {
            DB::table('users')->insert($this->fakeUser($faker, false));
        }
    }

    private function fakeUser(Faker\Generator $faker, $admin)
    {
        static $password;
        $createdAt = Carbon\Carbon::now()->subDays(30);
        $updatedAt = $faker->dateTimeBetween($createdAt);

        $nickname = $admin ? 'admin' : $faker->unique()->userName;
        $email = $admin ? 'admin@mail.dad' : $faker->unique()->safeEmail;
        
        return [
            'name' => $faker->name,
            'email' => $email,
            'password' => $password ?: $password = bcrypt('secret'),
            'nickname' => $nickname,
            'admin' => $admin,
            'blocked' => false,
            'reason_blocked' => null,
            'reason_reactivated' => null,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
            'remember_token' => str_random(10),
            'verified' => 1,
        ];
    }

    private function botAlmeida(Faker\Generator $faker)
    {
        static $password;

        $nickname = 'Bot';
        
        return [
            'name' =>  $nickname,
            'email' => $nickname,
            'password' => $password ?: $password = bcrypt('secret'),
            'nickname' => $nickname,
            'verified' => 1,
        ];
    }
}
