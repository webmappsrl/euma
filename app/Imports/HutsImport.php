<?php

namespace App\Imports;

use App\Models\Hut;
use App\Models\Member;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HutsImport implements ToCollection, WithHeadingRow
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
                
                Hut::updateOrCreate(
                    [
                        'import_id' => $row['id'],
                        'member_id' => $member->id
                    ],
                    [
                        'official_name'     => $row['official_name'],
                        'second_official_name'     => ($row['second_official_name'])?$row['second_official_name']:'',
                        'description' => ($row['description'])?$row['description']:'',
                        'url' => ($row['url'])?$row['url']:'',
                        'managed' => (strtolower($row['managed']) == 'yes')?true:false,
                        'address' => ($row['address'])?$row['address']:'',
                        'operating_name' => ($row['operating_name'])?$row['operating_name']:'',
                        'operating_email' => ($row['operating_email'])?$row['operating_email']:'',
                        'operating_phone' => ($row['operating_phone'])?$row['operating_phone']:'',
                        'owner' => ($row['owner'])?$row['owner']:'',
                        'geometry'    => DB::select("SELECT ST_GeomFromText('POINT($lng $lat)') As wkt")[0]->wkt, 
                        'elevation'    => ($row['elevation'])?$row['elevation']:0,
                    ]
                );
            } catch (Exception $e) {
                array_push($failed_ids,$row['member_acronym'].' - '.$row['id']);
                Log::info('Error creating Huts from '. $row['member_acronym'] .' with id: '.$row['id']."\n ERROR: ".$e->getMessage());
            }
            if ($failed_ids) {
                foreach ($failed_ids as $id) {
                    Log::channel('failed_import')->info($id);
                }
            }
        }
    } 
}
