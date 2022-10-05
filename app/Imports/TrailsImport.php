<?php

namespace App\Imports;

use App\Models\Member;
use App\Models\Trail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Symm\Gisconverter\Gisconverter;

class TrailsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (array_key_exists('source_geojson_url',$row) && $row['source_geojson_url']) {
            $geojson_content = file_get_contents($row['source_geojson_url']);
            $geojson = json_decode($geojson_content);
            $geometry = json_encode($geojson->geometry);
        } else {
            $gpx_content = file_get_contents($row['source_gpx_url']);
            $gpx = Gisconverter::gpxToGeojson($gpx_content);
            $geometry = $gpx;
        }

        $trail = new Trail([
            'name'     => ($row['name'])?$row['name']:'',
            'ref' => ($row['ref'])?$row['ref']:'',
            'url' => ($row['url'])?$row['url']:'',
            'source_geojson_url' => ($row['source_geojson_url'])?$row['source_geojson_url']:'',
            'source_gpx_url' => ($row['source_gpx_url'])?$row['source_gpx_url']:'',
            'geometry'    => DB::select("SELECT ST_AsText(ST_GeomFromGeoJSON('$geometry')) As wkt")[0]->wkt, 
        ]);

        $trail->Member()->associate(Member::where('acronym',$row['member_acronym'])->get()[0]);

        return $trail;
    }
}
