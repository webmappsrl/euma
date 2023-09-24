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
        foreach ($rows as $row) {
            try {
                $lat = $row['lat'];
                $lng = $row['lng'];
                $member = Member::where('acronym', $row['member_acronym'])->get()[0];

                Hut::updateOrCreate(
                    [
                        'import_id' => $row['id'],
                        'member_id' => $member->id
                    ],
                    [
                        'official_name'     => $row['official_name'],
                        'second_official_name'     => ($row->has('second_official_name')) ? $row['second_official_name'] : '',
                        'description' => ($row->has('description')) ? $row['description'] : '',
                        'url' => ($row->has('url')) ? $row['url'] : '',
                        'managed' => (strtolower($row['managed']) == 'yes') ? true : false,
                        'address' => ($row->has('address')) ? $row['address'] : '',
                        'operating_name' => ($row->has('operating_name')) ? $row['operating_name'] : '',
                        'operating_email' => ($row->has('operating_email')) ? $row['operating_email'] : '',
                        'operating_phone' => ($row->has('operating_phone')) ? $row['operating_phone'] : '',
                        'owner' => ($row->has('owner')) ? $row['owner'] : '',
                        'geometry'    => DB::select("SELECT ST_GeomFromText('POINT($lng $lat)') As wkt")[0]->wkt,
                        'elevation'    => ($row->has('elevation')) ? $row['elevation'] : 0,
                        'wastewater_treatment' => ($row->has('wastewater_treatment') && strtolower($row['wastewater_treatment']) == 'yes') ? true : false,
                        'waste_management_system' => ($row->has('waste_management_system')) ? $row['waste_management_system'] : '',
                        'water_supply' => ($row->has('water_supply') && strtolower($row['water_supply']) == 'yes') ? true : false,
                        'electric_and_heating_energy_source' => ($row->has('electric_and_heating_energy_source') && strtolower($row['electric_and_heating_energy_source']) == 'yes') ? true : false,
                        'area_type' => ($row->has('area_type')) ? $row['area_type'] : '',
                        'sanitary_facility' => ($row->has('sanitary_facility') && strtolower($row['sanitary_facility']) == 'yes') ? true : false,
                        'kitchen_facility' => ($row->has('kitchen_facility') && strtolower($row['kitchen_facility']) == 'yes') ? true : false,
                    ]
                );
            } catch (Exception $e) {
                array_push($failed_ids, $row['member_acronym'].' - '.$row['id']);
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
