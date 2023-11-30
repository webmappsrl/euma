<?php

namespace App\Classes\ImportTrailsApi;

use App\Jobs\ImportSingleTrailAPIJob;
use App\Models\Member;
use App\Models\Trail;
use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ImportTrailsApi
{
    // DATA
    protected $id;
    protected $force;
    protected $member;

    /**
     * It sets all needed properties in order to perform the sync of trails table from external URLs
     *
     *
     * @param integer $id of the Member
     * @param boolean $force where to ignore the last updated_at date or not
     */
    public function __construct(int $id, bool $force = false)
    {
        $this->id = $id;
        $this->force = $force;
    }

    /**
     * It checks the parameters of the command euma:import_tracks_api_with to see if they are
     *
     *
     * @return array
     */
    public function checkAndGetList($single_feature = 0)
    {
        $array = [];
        // Check the Member
        Log::info('Checking paramtere ID');
        $this->member = Member::find(intval($this->id));
        if (empty($this->member)) {
            throw new Exception('No Member found with this ID ' . $this->id);
        }

        if ($single_feature) {
            // Check on availibale API URLS
            Log::info('Checking paramtere API URLs');
            $api_single_track_url = Http::get(rtrim($this->member->api_single_track_url,'/').'/'.$single_feature);
            if (empty($api_single_track_url->json())) {
                throw new Exception('The API single track URL provided: ' . rtrim($this->member->api_single_track_url,'/').'/'.$single_feature . ' is not valid!');
            }
            $api_single_track_url = $api_single_track_url->json();
            if (!array_key_exists('properties',$api_single_track_url) || !array_key_exists('updated_at',$api_single_track_url['properties'])) {
                throw new Exception('The API single track URL provided: ' . rtrim($this->member->api_single_track_url,'/').'/'.$single_feature . ' does not have updated_at in properties!');
            }
            $array[$single_feature] = $api_single_track_url['properties']['updated_at'];
        } else {
            // Check on availibale API URLS
            Log::info('Checking paramtere API URLs');
            $api_tracks_list_url = Http::get($this->member->api_tracks_list_url);
            if (empty($api_tracks_list_url->json())) {
                throw new Exception('The API tracks list URL provided for member with ID ' . $this->id . ' is not valid!');
            }
            $array = $api_tracks_list_url->json();
        }

        return $array;
    }

    /**
     * It creates a list if IDs and updated_at key and valuses from trails table 
     *
     * @return array
     */
    public function getTrailsListWithUpdatedAt()
    {
        $features = Trail::where('member_id', $this->id)
        ->get();

        return $features->pluck('updated_at', 'import_id')->toArray();
    }

    /**
     * It updates or creates the Trail based on the list if IDs from the given list
     *
     * @param array $ids_array an array of ids to be synced to Trails
     * @return array array of ids of newly created Trails
     */
    public function sync(array $ids_array)
    {
    $count = 1;
    $count_all = count($ids_array);
    $count_job_processed_key = $this->id.'_count_job_processed'; 
    $count_job_failed_key = $this->id.'_count_job_failed';
    $failed_job_data_key = $this->id.'_failed_job_data';
    Cache::put($count_job_processed_key, 0);
    Cache::put($count_job_failed_key, 0);
    Cache::put($failed_job_data_key, []);
    $single_track_base_url = rtrim($this->member->api_single_track_url, '/');

    foreach ($ids_array as $id => $updated_at) {
        
        ImportSingleTrailAPIJob::dispatch($id, $single_track_base_url, $this->member,$count_job_processed_key,$count_job_failed_key,$failed_job_data_key);
        Log::info('Imported ID ' . $this->id . ' -- ' . $count . ' out of ' . $count_all);
        $count++;
    }
    while(true) {
        $job_processed = cache::get($count_job_processed_key);
        $job_failed = cache::get($count_job_failed_key);
        $failedJobData = cache::get($failed_job_data_key);
        if ($job_processed === null ||  $job_failed === null) {
            break;
        } elseif ($count_all === $job_processed + $job_failed) {
            // Send an email about the failed job
            if (!empty($failedJobData)) {
                \Mail::to($this->member->contact_email)->send(new \App\Mail\TrailImportApiFailedJobs($failedJobData, $this->member));
            }
            break;
        }
    }
    }
    
    /**
     * It deletes the Trail based on the list if IDs from the given list
     *
     * @param array $ids_array an array of ids to be deleted
     * 
     */
    public function delete(array $ids_array)
    {
        $single_track_bsae_url = rtrim($this->member->api_single_track_url, '/');

        foreach ($ids_array as $id => $updated_at) {
            Log::info('Deleting '.$single_track_bsae_url.'/'.$id);
            Trail::where('member_id', $this->member->id)
                ->where('import_id', $id)
                ->delete();
        }
    }
}
