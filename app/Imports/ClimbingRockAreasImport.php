<?php

namespace App\Imports;

use App\Models\ClimbingRockArea;
use App\Models\ClimbingStyle;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
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
            'description' => ($row['description'])?$row['description']:'',
            'local_rules_url' => ($row['local_rules_url'])?$row['local_rules_url']:$row['source_url'],
            'location_quality' => ($row['location_quality'])?$row['location_quality']:'',
            'routes_number' => ($row['routes_number'])?$row['routes_number']:'',
            'geometry'    => DB::select("SELECT ST_GeomFromText('POINT($lng $lat)') As wkt")[0]->wkt, 
            'elevation'    => $row['elevation'],
        ]);
        if ($row['parking_lat'] && $row['parking_lng']) {
            $parking_lat = $row['parking_lat'];
            $parking_lng = $row['parking_lng'];
            $ClimbingRockArea->parking_position = DB::select("SELECT ST_GeomFromText('POINT($parking_lng $parking_lat)') As wkt")[0]->wkt;
        }

        $ClimbingRockArea->Member()->associate(Member::where('acronym',$row['member_acronym'])->get()[0]);
        
        $ClimbingRockArea->climbingStyles()->sync(ClimbingStyle::where('name',explode(':',$row['climbing_style']))->get()[0]);

        return $ClimbingRockArea;
    }
}
