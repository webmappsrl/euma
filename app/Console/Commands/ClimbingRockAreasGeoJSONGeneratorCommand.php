<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClimbingRockAreasGeoJSONGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eumadb:climbing-rock-area-geojson-generator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It generats a Feature Collection GeoJSON with all the Climbing Rock Areas in the database. Output file: /storage/exporter/geojson/climbing_rock_areas/climbing_rock_areas.geojson';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $exporter = Storage::disk('exporter');

        $results = DB::select("SELECT jsonb_build_object(
            'type',     'FeatureCollection',
            'features', jsonb_agg(features.feature)
        )
        FROM (
          SELECT jsonb_build_object(
            'type',       'Feature',
            'geometry',   ST_AsGeoJSON(geometry)::jsonb,
            'properties', to_jsonb(inputs) - 'geometry'
          ) AS feature
          FROM (SELECT url, geometry FROM climbing_rock_areas) inputs) features;");

        $exporter->put('geojson/climbing_rock_areas/climbing_rock_areas.geojson', $results[0]->jsonb_build_object);

        return Command::SUCCESS;
    }
}