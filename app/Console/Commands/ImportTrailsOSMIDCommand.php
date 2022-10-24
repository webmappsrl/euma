<?php

namespace App\Console\Commands;

use App\Imports\TrailsOSMIDImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportTrailsOSMIDCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eumadb:import-trails-osmid
                            {path : Set the path of file, it should be locataded in /storage/importer folder (ex. /trails/EUMA_TRAILS_ERA.csv)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command imports and syncs all the trails associated to the member ERA from the given csv file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = Storage::disk('importer')->path($this->argument('path'));
        Log::info($path);
        Excel::import(new TrailsOSMIDImport, $path);

        return 0;
    }
}
