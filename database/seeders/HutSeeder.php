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
        $import_cmd = 'php artisan eumadb:import-huts "/huts/EUMA_HUTS_IMPORT_FILE_EXAMPLE.xlsx"';
        echo "import huts 10 -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-huts "/huts/EUMA_HUTS_PZS.xlsx"';
        echo "import huts 2 -> $import_cmd \n";
        exec($import_cmd);
    }
}
