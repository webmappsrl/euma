<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TrailsCSVGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eumadb:trails-csv-generator {member_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It generats a CSV file with all the data of the Trails in the database except the Geometry, if the member_id is not provided. Output file:/storage/exporter/csv/trails/trails.csv';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $member_id = $this->argument('member_id');
        $path =  $member_id ? storage_path() . '/exporter/csv/trails/' . $member_id . '/trails.csv' : storage_path() . '/exporter/csv/trails/trails.csv';

        // Check if directory exists and if not, create it
        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $query = "select t.id, original_name, english_name, ref, import_id, CONCAT('https://database.european-mountaineers.eu/resources/trails/',t.id) as eumadb_url, url, source_gpx_url, source_geojson_url, m.acronym as member_acronym from trails as t LEFT JOIN members as m on t.member_id=m.id";

        if ($member_id) {
            $query .= " WHERE t.member_id = " . intval($member_id);
        }

        $results = DB::select(DB::raw($query));

        $file = fopen($path, 'w');

        foreach ($results as $result) {
            fputcsv($file, (array) $result);
        }

        fclose($file);

        return Command::SUCCESS;
    }
}
