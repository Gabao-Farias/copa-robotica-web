<?php

use App\TorneioConfig;
use Illuminate\Database\Seeder;

class TorneioConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TorneioConfig::create([
        	'nome' => 'fase_torneio',
        	'valor' => '1'
        ]);
    }
}
