<?php

namespace App\Console\Commands;

use App\Imports\TrailsImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportTrails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eumadb:import-trails
                            {path : Set the path of file, it should be locataded in /storage/importer folder (ex. /trails/EUMA_TRAILS_IMPORT_FILE_EXAMPLE.xlsx)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command imports and syncs all the trails associated to a member from a given xlsx file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filePath = $this->argument('path');
        $disk = Storage::disk('importer');

        // Check if the file exists on the specified disk
        if (!$disk->exists($filePath)) {
            $errorMessage = "File not found: {$filePath} on disk 'importer'. Please ensure the file exists in the storage/importer directory.";
            Log::error($errorMessage);
            $this->error($errorMessage);
            return 1; // Indicate failure
        }

        $fullPath = $disk->path($filePath);
        Log::info("Starting import from: {$fullPath}");

        try {
            Excel::import(new TrailsImport, $fullPath);
            Log::info("Import completed successfully from: {$fullPath}");
            $this->info("Import completed successfully.");
            return 0; // Indicate success
        } catch (\Exception $e) {
            $errorMessage = "Error during import from {$fullPath}: " . $e->getMessage();
            Log::error($errorMessage);
            $this->error($errorMessage);
            return 1; // Indicate failure
        }
    }
}
