<?php

use App\Ringue;
use Illuminate\Database\Seeder;

class RinguesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ringue::create([
        	'nome' => 'Ringue 1'
        ]);

        Ringue::create([
        	'nome' => 'Ringue 2'
        ]);
    }
}
