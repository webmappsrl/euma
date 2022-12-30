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
        echo "import trails 2 Slovenia -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-trails "/trails/EUMA_TRAILS_HPS.xlsx"';
        echo "import trails 6 Croazia -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-trails "/trails/EUMA_TRAILS_CAI.xlsx"';
        echo "import trails 11 Italia -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-trails-osmid "/trails/EUMA_TRAILS_ERA.csv"';
        echo "import trails 36 Italia -> $import_cmd \n";
        exec($import_cmd);
    }
}
