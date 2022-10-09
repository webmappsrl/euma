<?php

namespace App\Console\Commands;

use App\Imports\HutsImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportHuts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eumadb:import-huts
                            {path : Set the path of file, it should be locataded in /storage/importer folder (ex. /huts/EUMA_HUTS_IMPORT_FILE_EXAMPLE.xlsx)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command imports and syncs all the huts associated to a member from a given xlsx file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = Storage::disk('importer')->path($this->argument('path'));
        Log::info($path);
        Excel::import(new HutsImport, $path);

        return 0;
    }
}
