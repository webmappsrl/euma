<?php

namespace App\Imports;

use App\Models\ClimbingRockArea;
use App\Models\ClimbingRockType;
use App\Models\ClimbingStyle;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClimbingRockAreasImport implements ToCollection, WithHeadingRow
{
    public function collection($rows)
    {
        $failed_ids = [];
        foreach ($rows as $row) 
        {
            try {
                $lat = $row['lat'];
                $lng = $row['lng'];
                $member = Member::where('acronym',$row['member_acronym'])->get()[0];

                $ClimbingRockArea = ClimbingRockArea::updateOrCreate(
                    [
                        'import_id' => $row['id'],
                        'member_id' => $member->id
                    ],
                    [
                        'description' => ($row['description'])?$row['description']:'',
                        'url' => $row['url'],
                        'local_rules_url' => ($row['local_rules_url'])?$row['local_rules_url']:'',
                        'local_rules_description' => ($row['local_rules_description'])?$row['local_rules_description']:'',
                        'location_quality' => ($row['location_quality'])?$row['location_quality']:null,
                        'routes_number' => ($row['routes_number'])?$row['routes_number']:null,
                        'geometry'    => DB::select("SELECT ST_GeomFromText('POINT($lng $lat)') As wkt")[0]->wkt, 
                        'elevation'    => ($row['elevation'])?$row['elevation']:null,
                        'local_restrictions'    => ($row['local_restrictions'] == 'yes')?true:false,
                        'local_restrictions_description' => ($row['local_restrictions_description'])?$row['local_restrictions_description']:'',
                    ]
                );
                
                if (isset($row['original_name']) && !empty($row['original_name'])){
                    $ClimbingRockArea->original_name = $row['original_name'];
                }
                if (isset($row['english_name']) && !empty($row['english_name'])){
                    $ClimbingRockArea->original_name = $row['english_name'];
                }
                if (isset($row['name']) && !empty($row['name'])){
                    $ClimbingRockArea->original_name = $row['name'];
                }

                if ($row['parking_lat'] && $row['parking_lng']) {
                    $parking_lat = $row['parking_lat'];
                    $parking_lng = $row['parking_lng'];
                    $ClimbingRockArea->parking_position = DB::select("SELECT ST_GeomFromText('POINT($parking_lng $parking_lat)') As wkt")[0]->wkt;
                }
                
                if ($row['climbing_style']) {
                    $styles = explode(',',$row['climbing_style']);
                    foreach ($styles as $style) {
                        $ClimbingStyle = ClimbingStyle::where('identifier',strtolower($style))->get();
                        if (!empty($ClimbingStyle) && count($ClimbingStyle) > 0) {
                            $ClimbingRockArea->climbingStyles()->attach($ClimbingStyle[0]->id);
                        }
                    }
                }
                
                if ($row['climbing_rock_type']) {
                    $types = explode(',',$row['climbing_rock_type']);
                    foreach ($types as $type) {
                        $type = str_replace(' ', '-', $type);
                        $ClimbingRockType = ClimbingRockType::where('identifier',strtolower($type))->get();
                        if (!empty($ClimbingRockType) && count($ClimbingRockType) > 0) {
                            $ClimbingRockArea->ClimbingRockTypes()->attach($ClimbingRockType[0]->id);
                        }
                    }
                }

                $ClimbingRockArea->save();
            } catch (Exception $e) {
                array_push($failed_ids,$row['member_acronym'].' - '.$row['id']);
                Log::info('Error creating Crags from '. $row['member_acronym'] .' with id: '.$row['id']."\n ERROR: ".$e->getMessage());
            }
            if ($failed_ids) {
                foreach ($failed_ids as $id) {
                    Log::channel('failed_import')->info($id);
                }
            }
        }
    } 
}
