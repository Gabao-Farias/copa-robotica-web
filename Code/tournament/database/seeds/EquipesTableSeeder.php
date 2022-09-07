<?php

use Illuminate\Database\Seeder;

class EquipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $escolas = \App\Escola::latest()->get();

        foreach ($escolas as $escola)
        {
            $escola->equipes()->save(factory(App\Equipe::class)->make());
        }
    }
}
