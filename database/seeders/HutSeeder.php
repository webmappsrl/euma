<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $import_cmd = 'php artisan eumadb:import-huts "/huts/EUMA_HUTS_EOOA.xlsx"';
        echo "import huts 10 Hellenic -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-huts "/huts/EUMA_HUTS_PZS.xlsx"';
        echo "import huts 2 Slovenia -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-huts "/huts/EUMA_HUTS_FPSM.xlsx"';
        echo "import huts 13 Noth Macedonia -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-huts "/huts/EUMA_HUTS_CAI.xlsx"';
        echo "import huts 11 Italia -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-huts "/huts/EUMA_HUTS_HPS.xlsx"';
        echo "import huts 6 Croazia -> $import_cmd \n";
        exec($import_cmd);
    }
}
