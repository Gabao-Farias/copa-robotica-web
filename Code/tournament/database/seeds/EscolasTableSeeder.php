<?php

use Illuminate\Database\Seeder;

class EscolasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Escola::class, 8)->create();
    }
}
