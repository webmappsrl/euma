<?php

namespace App\Imports;

use App\Models\Member;
use App\Models\Trail;
use Exception;
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
        $failed_ids = [];
        foreach ($rows as $row) 
        {
            try {
                if ($row['source_geojson_url']) {
                    // $geojson_content = file_get_contents($row['source_geojson_url']);
                    $geojson_content = $this->getCurl($row['source_geojson_url']);
                    $geojson = json_decode($geojson_content);
                    $geometry = json_encode($geojson->geometry);
                } else {
                    // $gpx_content = file_get_contents($row['source_gpx_url']);
                    $gpx_content = $this->getCurl($row['source_gpx_url']);
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
                        'ref' => ($row['ref'])?$row['ref']:'',
                        'url' => ($row['url'])?$row['url']:'',
                        'source_geojson_url' => ($row['source_geojson_url'])?$row['source_geojson_url']:'',
                        'source_gpx_url' => ($row['source_gpx_url'])?$row['source_gpx_url']:'',
                        'geometry' => DB::select("SELECT ST_AsText(ST_Force2D(ST_GeomFromGeoJSON('$geometry'))) As wkt")[0]->wkt,
                    ]
                );
    
                if (isset($row['original_name']) && !empty($row['original_name'])){
                    $trail->original_name = $row['original_name'];
                }
                if (isset($row['english_name']) && !empty($row['english_name'])){
                    $trail->original_name = $row['english_name'];
                }
                if (isset($row['name']) && !empty($row['name'])){
                    $trail->original_name = $row['name'];
                }
                $trail->save();
    
                Log::info('Imported row #'. $count . ' out of ' . $count_all);
                $count++;
            } catch (Exception $e) {
                array_push($failed_ids,$row['member_acronym'].' - '.$row['id']);
                Log::info('Error creating Trail from '. $row['member_acronym'] .' with id: '.$row['id']."\n ERROR: ".$e->getMessage());
            }
        }
        if ($failed_ids) {
            foreach ($failed_ids as $id) {
                Log::channel('failed_import')->info($id);
            }
        }
    } 

    public function getCurl($url) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ));

        $response = curl_exec($curl);

        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpcode == 200) {
            return $response;
        }

        return false;
    }
}
