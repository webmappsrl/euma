<?php

namespace App\Imports;

use App\Models\Member;
use App\Models\Trail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use SimpleXMLElement;
use Symm\Gisconverter\Gisconverter;

class TrailsOSMIDImport implements ToCollection, WithHeadingRow
{

    public function collection($rows)
    {
        $failed_ids = [];
        foreach ($rows as $row) 
        {
            try {
                $osmid = $row['osmid'];
                $gpx_content = file_get_contents("https://hiking.waymarkedtrails.org/api/v1/details/relation/$osmid/geometry/gpx");
                $gpx = Gisconverter::gpxToGeojson($gpx_content);
                $geometry = $gpx;
                
                $member = Member::where('acronym','ERA')->get()[0];

                $xml_content = simplexml_load_file("https://www.openstreetmap.org/api/0.6/relation/$osmid");
                $xml_content = json_encode($xml_content);
                $xml = json_decode($xml_content, TRUE);
                $name = '';
                $ref = '';
                foreach ($xml['relation']['tag'] as $tag) {
                    if ($tag['@attributes']['k'] == 'name') {
                        $name = $tag['@attributes']['v'];
                    }   
                    if ($tag['@attributes']['k'] == 'ref') {
                        $ref = $tag['@attributes']['v'];
                    }   
                    if (empty($ref)) {
                        if ($tag['@attributes']['k'] == 'symbol') {
                            $ref = $tag['@attributes']['v'];
                        }   
                    }
                }

                Trail::updateOrCreate(
                    [
                        'import_id' => $osmid,
                        'member_id' => $member->id
                    ],
                    [
                        'name' => $name,
                        'ref' => $ref,
                        'url' => "https://openstreetmap.org/relation/$osmid",
                        'source_geojson_url' => '',
                        'source_gpx_url' => "https://hiking.waymarkedtrails.org/api/v1/details/relation/$osmid/geometry/gpx",
                        'geometry' => DB::select("SELECT ST_AsText(ST_GeomFromGeoJSON('$geometry')) As wkt")[0]->wkt,
                    ]
                );
            } catch (Exception $e) {
                array_push($failed_ids,$row['member_acronym'].' - '.$row['id']);
                Log::info('Error creating Trails with OSMID from '. $row['member_acronym'] .' with id: '.$row['id']."\n ERROR: ".$e->getMessage());
            }
            if ($failed_ids) {
                foreach ($failed_ids as $id) {
                    Log::channel('failed_import')->info($id);
                }
            }
        }
    } 
}
