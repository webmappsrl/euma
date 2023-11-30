<?php

namespace App\Console\Commands;

use App\Classes\ImportTrailsApi\ImportTrailsApi;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportTracksWithUpdatedAtAPICommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'euma:import_tracks_api_with
                            {id : The ID of the member to import}
                            {--force : Forces the import regardless of the updated_at date (for the first time use this option)}
                            {--single_feature= : ID of a single feature to import instead of a list (e.g. 1889)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command imports the trails of the give member based on the last updated_at property of each trail. For the first time use --force option';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $member_id = $this->argument('id');
        $force = $this->option('force');
        $single_feature = $this->option('single_feature');

        $importTrailsApi = new ImportTrailsApi($member_id, $force);

        // get All External id => updated_at array
        $apiTracksList = $importTrailsApi->checkAndGetList($single_feature);
        
        // get All Trails id => updated_at array
        $trailsImportidUpdatedat = $importTrailsApi->getTrailsListWithUpdatedAt();
        
        if ($single_feature) {
            $importTrailsApi->sync($single_feature);
        } else if ($force) {
            $importTrailsApi->sync($apiTracksList);
        } else {
            $updateIDs = [];
            $deleteIDs = [];

            // Creates an array of Trails to be synced because the source value is more recent.
            foreach ($apiTracksList as $id => $updated_at) {
                if (empty($trailsImportidUpdatedat) || !array_key_exists($id, $trailsImportidUpdatedat) || Carbon::parse($trailsImportidUpdatedat[$id]) < Carbon::parse($updated_at)) {
                    $updateIDs[$id] = $updated_at;
                }
            }
            $updateIDs = [
                3407 => "2023-09-28 00:59:48",
                86400000 => "2023-08-07 13:21:21",
                24651 => "2023-06-01 13:21:04",
                16808 => "2023-10-05 00:55:42",
                21833 => "2023-09-28 00:59:48",
                235050000 => "2023-08-10 18:57:23",
                24657 => "2023-09-16 23:43:07",
                5400 => "2023-09-28 00:59:48",
                12988 => "2023-08-07 13:32:09"
            ];
            if (!empty($updateIDs)) {
                $importTrailsApi->sync($updateIDs);
            } else {
                Log::info("No Trails to update for member with id $member_id");
            }
        }

        // Creates an array of Trails to be deleted because the source value does not exists anymore.
        foreach ($trailsImportidUpdatedat as $id => $updated_at) {
            if (!array_key_exists($id, $apiTracksList)) {
                $deleteIDs[$id] = $updated_at;
            }
        }
        if (!empty($deleteIDs)) {
            $importTrailsApi->delete($deleteIDs);
        } else {
            Log::info("No Trails to be deleted for member with id $member_id");
        }
    }
}
