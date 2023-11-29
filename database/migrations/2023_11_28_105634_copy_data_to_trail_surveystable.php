<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trail_surveys', function (Blueprint $table) {
            //get the columns from the trail_surveysß table
            $columns = Schema::getColumnListing('trail_surveys');
            //get only the columns that match the members table
            $columns = array_intersect($columns, Schema::getColumnListing('members'));

            //insert into trail_surveys table from members table
            DB::statement('INSERT INTO trail_surveys (member_id,' . implode(',', $columns) . ') SELECT id,' . implode(',', $columns) . ' FROM members;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trail_surveys', function (Blueprint $table) {
        });
    }
};
