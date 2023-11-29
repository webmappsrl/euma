<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Member;
use App\Models\CragSurvey;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CragSurveyImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $member = Member::search($row['member_name'])->first();

        // Handle the date field
        if (isset($row['created_at'])) {
            $dateString = str_replace('OEZ', 'EET', $row['created_at']);
            $row['created_at'] = Carbon::createFromFormat('Y/m/d g:i:s A T', $dateString);
        }

        //get all the columns from the cragsurvey table
        $surveyTableColumns = \Schema::getColumnListing('crag_surveys');
        // Create a new array with the columns that are in the cragsurvey table
        $finalArray = array_intersect_key($row, array_flip($surveyTableColumns));

        // If a member was found, add the member_id to the array
        if ($member) {
            $finalArray['member_id'] = $member->id;
        }

        return new CragSurvey($finalArray);
    }

    public function headingRow(): int
    {
        return 2;
    }
}
