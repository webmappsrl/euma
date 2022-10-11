<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $import_cmd = 'php artisan eumadb:import-trails "/trails/EUMA_TRAILS_PZS.xlsx"';
        echo "import trails 2 -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-trails "/trails/EUMA_TRAILS_HPS.xlsx"';
        echo "import trails 6 -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-trails "/trails/EUMA_TRAILS_CAI.xlsx"';
        echo "import trails 11 -> $import_cmd \n";
        exec($import_cmd);
    }
}
