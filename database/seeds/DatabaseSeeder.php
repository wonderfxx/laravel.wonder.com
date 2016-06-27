<?php

use App\Models\GamePackageList;
use database\seeds\GameListSeeder;
use database\seeds\GamePackageListSeeder;
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
         $this->call(GamePackageListSeeder::class);
//        $this->call(GameListSeeder::class);
    }
}
 