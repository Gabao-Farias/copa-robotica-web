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
        $this->call(TorneioConfigsTableSeeder::class);
        $this->call(RinguesTableSeeder::class);
        $this->call(TorneioSeeder::class);
//        $this->call(EscolasTableSeeder::class);
//        $this->call(EquipesTableSeeder::class);
//        $this->call(IntegrantesTableSeeder::class);
    }
}
