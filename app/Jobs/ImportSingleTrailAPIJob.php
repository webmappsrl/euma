<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Member;
use App\Models\Trail;
use App\Nova\Filters\Members;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Throwable;

class ImportSingleTrailAPIJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $single_track_base_url;
    protected $member;
    protected $count_job_processed_key;
    protected $count_job_failed_key;
    protected $failed_job_data_key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id,$single_track_base_url,$member,$count_job_processed_key,$count_job_failed_key,$failed_job_data_key)
    {
        $this->id = $id;
        $this->single_track_base_url = $single_track_base_url;
        $this->member = $member;
        $this->count_job_processed_key = $count_job_processed_key;
        $this->count_job_failed_key = $count_job_failed_key;
        $this->failed_job_data_key = $failed_job_data_key;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $feature = Http::get($this->single_track_base_url.'/'.$this->id);
            if ($feature->json()) {
                $geometry = json_encode($feature['geometry']);
            } 

            $trail = Trail::updateOrCreate(
                [
                    'import_id' => $this->id,
                    'member_id' => $this->member->id
                ],
                [
                    'ref' => ($feature['properties']['ref']) ? $feature['properties']['ref'] : '',
                    'url' => ($feature['properties']['url']) ? $feature['properties']['url'] : '',
                    'source_geojson_url' => $this->single_track_base_url.'/'.$this->id,
                    'geometry' => DB::select("SELECT ST_AsText(ST_Force2D(ST_GeomFromGeoJSON('$geometry'))) As wkt")[0]->wkt,
                ]
            );

            if (isset($feature['properties']['original_name']) && !empty($feature['properties']['original_name'])) {
                $trail->original_name = $feature['properties']['original_name'];
            }
            if (isset($feature['properties']['english_name']) && !empty($feature['properties']['english_name'])) {
                $trail->original_name = $feature['properties']['english_name'];
            }
            if (isset($feature['properties']['name']) && !empty($feature['properties']['name'])) {
                $trail->original_name = $feature['properties']['name'];
            }
            $trail->save();
            $job_processed = Cache::get($this->count_job_processed_key) ?? 0;
            Cache::put($this->count_job_processed_key, $job_processed+1, 600);

        } catch (Exception $e) {
            Log::info('Error creating Trail from '. $this->single_track_base_url.'/'.$this->id ."\n ERROR: ".$e->getMessage());
            $job_failed = Cache::get($this->count_job_failed_key) ?? 0;
            Cache::put($this->count_job_failed_key, $job_failed+1, 600);
            // Store the failed job details (you can customize this based on your needs)
            $failedJobData = Cache::get($this->failed_job_data_key);
            array_push($failedJobData,[
                'id' => $this->id,
                'url' => $this->single_track_base_url . '/' . $this->id,
                'error_message' => $e->getMessage(),
            ]);
            Cache::put($this->failed_job_data_key,$failedJobData,600);
        }
    }
}
