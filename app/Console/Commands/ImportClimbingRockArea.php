<?php

namespace App\Console\Commands;

use App\Imports\ClimbingRockAreasImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportClimbingRockArea extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eumadb:import-climbing-rock-areas
                            {path : Set the path of file, it should be locataded in /storage/importer folder (ex. /climbing-rock-areas/EUMA_CLIMBING_ROCK_AREAS_IMPORT_FILE_EXAMPLE.xlsx)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command imports and syncs all the Climbing rock areas associated to a member from a given xlsx file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = Storage::disk('importer')->path($this->argument('path'));
        Excel::import(new ClimbingRockAreasImport, $path);

        return 0;
    }
}
