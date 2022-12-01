<?php

namespace App\Imports;

use App\Models\Member;
use App\Models\Trail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Symm\Gisconverter\Gisconverter;

class TrailsImport implements ToCollection, WithHeadingRow
{

    public function collection($rows)
    {
        $count = 1;
        $count_all = count($rows);
        foreach ($rows as $row) 
        {
            if ($row['source_geojson_url']) {
                $geojson_content = file_get_contents($row['source_geojson_url']);
                $geojson = json_decode($geojson_content);
                $geometry = json_encode($geojson->geometry);
            } else {
                $gpx_content = file_get_contents($row['source_gpx_url']);
                $gpx = Gisconverter::gpxToGeojson($gpx_content);
                $geometry = $gpx;
            }
            
            $member = Member::where('acronym',$row['member_acronym'])->get()[0];

            $trail = Trail::updateOrCreate(
                [
                    'import_id' => $row['id'],
                    'member_id' => $member->id
                ],
                [
                    'name' => ($row['name'])?$row['name']:'',
                    'ref' => ($row['ref'])?$row['ref']:'',
                    'url' => ($row['url'])?$row['url']:'',
                    'source_geojson_url' => ($row['source_geojson_url'])?$row['source_geojson_url']:'',
                    'source_gpx_url' => ($row['source_gpx_url'])?$row['source_gpx_url']:'',
                    'geometry' => DB::select("SELECT ST_AsText(ST_GeomFromGeoJSON('$geometry')) As wkt")[0]->wkt,
                ]
            );

            Log::info('Imported row #'. $count . ' out of ' . $count_all);
            $count++;
        }
    } 
}
