<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::truncate();

        $csvFile = fopen(base_path("storage/app/seeder/member.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Member::create([
                    'name_en' => $data['1'],
                    'name_orig' => $data['2'],
                    'acronym' => $data['3'],
                    'country' => $data['4'],
                    'web' => $data['5'],
                    'members' => $data['6'],
                    'since' => $data['7'],
                    'type' => $data['8'] === 'EXTERNAL MEMBER' ? 'EXTERNAL-MEMBER' : $data['8'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
