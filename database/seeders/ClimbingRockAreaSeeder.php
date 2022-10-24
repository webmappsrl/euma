<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClimbingRockAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $import_cmd = 'php artisan eumadb:import-climbing-rock-areas "/climbing-rock-areas/EUMA_CLIMBING_ROCK_AREAS_CHS.xlsx"';
        echo "import crags 7 Czech Republic -> $import_cmd \n";
        exec($import_cmd);
    }
}
