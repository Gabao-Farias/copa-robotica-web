<?php

use Illuminate\Database\Seeder;

class IntegrantesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $equipes = \App\Equipe::latest()->get();

        foreach ($equipes as $equipe)
        {
            $equipe->integrantes()->saveMany(factory(App\Integrante::class, 8)->make());
        }
    }
}
