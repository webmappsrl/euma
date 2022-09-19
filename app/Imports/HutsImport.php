<?php

namespace App\Imports;

use App\Models\Hut;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HutsImport implements ToModel, WithHeadingRow
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
        $hut = new Hut([
            'name'     => $row['name'],
            'description' => ($row['description'])?$row['description']:'',
            'url' => ($row['url'])?$row['url']:'',
            'managed' => ($row['managed'] == 'yes')?true:false,
            'address' => ($row['address'])?$row['address']:'',
            'operating_name' => ($row['operating_name'])?$row['operating_name']:'',
            'operating_email' => ($row['operating_email'])?$row['operating_email']:'',
            'operating_phone' => ($row['operating_phone'])?$row['operating_phone']:'',
            'owner' => ($row['owner'])?$row['owner']:'',
            'geometry'    => DB::select("SELECT ST_GeomFromText('POINT($lng $lat)') As wkt")[0]->wkt, 
            'elevation'    => ($row['elevation'])?$row['elevation']:0,
        ]);

        $hut->Member()->associate(Member::where('acronym',$row['member_acronym'])->get()[0]);

        return $hut;
    }
}
