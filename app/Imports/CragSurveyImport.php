<?php

namespace App\Imports;

use App\Models\CragSurvey;
use App\Models\Member;
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
        $member = Member::where('name_en', 'ilike', '%' . $row['member_name'] . '%')->first();
        //get all the columns from the cragsurvey table
        $surveyTableColumns = \Schema::getColumnListing('crag_surveys');
        //get all the columns from the excel file
        $excelColumns = array_keys($row);
        //compare the 2 arrays and remove the columns from the excel file that are not in the cragsurvey table
        $columnsToImport = array_intersect($surveyTableColumns, $excelColumns);
        //create a new array with the columns that are in the cragsurvey table
        $row = array_intersect_key($row, array_flip($columnsToImport));

        //create an array that has keys from the cragsurvey table and values from the excel file
        $finalArray = array_combine($surveyTableColumns, $row);
        $finalArray['member_id'] = $member ?  $member->id : null;

        return new CragSurvey($finalArray);
    }

    public function headingRow(): int
    {
        return 2;
    }
}
