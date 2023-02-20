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
    protected $signature = 'eumadb:trails-csv-generator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It generats a CSV file with all the data of the Trails in the database except the Geometry. Output file:/storage/exporter/csv/trails/trails.csv';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = storage_path().'/exporter/csv/trails/trails.csv';

        $results = DB::select("COPY (select t.id, original_name, english_name, ref, import_id, CONCAT('https://prod.eumadb.webmapp.it/resources/trails/',t.id) as eumadb_url, url, source_gpx_url, source_geojson_url, m.acronym as member_acronym from trails as t LEFT JOIN members as m on t.member_id=m.id) TO '$path'  WITH DELIMITER ',' CSV HEADER;");

        return Command::SUCCESS;
    }
}
