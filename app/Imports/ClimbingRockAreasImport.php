<?php

namespace App\Imports;

use App\Models\ClimbingRockArea;
use App\Models\ClimbingRockType;
use App\Models\ClimbingStyle;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClimbingRockAreasImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $lat = $row['lat'];
        $lng = $row['lng'];
        $ClimbingRockArea = new ClimbingRockArea([
            'name'     => $row['name'],
            'alternative_name' => ($row['alternative_name'])?$row['alternative_name']:'',
            'description' => ($row['description'])?$row['description']:'',
            'local_rules_url' => ($row['local_rules_url'])?$row['local_rules_url']:'',
            'local_rules_description' => ($row['local_rules_description'])?$row['local_rules_description']:'',
            'location_quality' => ($row['location_quality'])?$row['location_quality']:null,
            'routes_number' => ($row['routes_number'])?$row['routes_number']:null,
            'geometry'    => DB::select("SELECT ST_GeomFromText('POINT($lng $lat)') As wkt")[0]->wkt, 
            'elevation'    => ($row['elevation'])?$row['elevation']:null,
            'local_restrictions'    => ($row['local_restrictions'] == 'yes')?true:false,
            'local_restrictions_description' => ($row['local_restrictions_description'])?$row['local_restrictions_description']:'',
        ]);
        if ($row['parking_lat'] && $row['parking_lng']) {
            $parking_lat = $row['parking_lat'];
            $parking_lng = $row['parking_lng'];
            $ClimbingRockArea->parking_position = DB::select("SELECT ST_GeomFromText('POINT($parking_lng $parking_lat)') As wkt")[0]->wkt;
        }

        $ClimbingRockArea->Member()->associate(Member::where('acronym',$row['member_acronym'])->get()[0]);
        
        $ClimbingRockArea->save();
        
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

        return $ClimbingRockArea;
    }
}
