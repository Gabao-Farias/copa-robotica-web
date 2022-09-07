<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
        	'name' => 'Mesario 1',
        	'email' => 'mesario1@tournament.app',
        	'password' => bcrypt('#QueroCafe')
        ]);

        \App\User::create([
            'name' => 'Mesario 2',
            'email' => 'mesario2@tournament.app',
            'password' => bcrypt('#QueroCafe')
        ]);
    }
}
