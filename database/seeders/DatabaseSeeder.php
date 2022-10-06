<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MemberSeeder::class,
            UserSeeder::class,
            ClimbingStyleSeeder::class,
            ClimbingRockTypeSeeder::class
        ]);

        $import_cmd = 'php artisan eumadb:import-huts "/huts/EUMA_HUTS_IMPORT_FILE_EXAMPLE.xlsx" 10';
        echo "import huts 10 -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-climbing-rock-areas "/climbing-rock-areas/EUMA_CLIMBING_ROCK_AREAS_IMPORT_FILE_EXAMPLE.xlsx" 7';
        echo "import crags 7 -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-trails "/trails/EUMA_TRAILS_IMPORT_FILE_EXAMPLE.xlsx" 11';
        echo "import trails 11 -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = ' php artisan eumadb:import-trails "/trails/EUMA_TRAILS_PZS.xlsx" 2';
        echo "import trails 2 -> $import_cmd \n";
        exec($import_cmd);
        
        $import_cmd = 'php artisan eumadb:import-trails "/trails/EUMA_TRAILS_HPS.xlsx" 6';
        echo "import trails 6 -> $import_cmd \n";
        exec($import_cmd);

    }
}
