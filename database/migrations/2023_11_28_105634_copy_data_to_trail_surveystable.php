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



            // DB::statement('INSERT INTO trail_surveys (member_id, trail_length_km, trail_network_area, trail_network_location, trails_area_mountains_percentage, trails_area_low_mountain_percentage, trails_area_lowland_percentage, trails_on_sealed_roads, trails_on_sealed_roads_percentage, via_ferratas_in_network, via_ferratas_count, via_ferratas_managing_description, free_access_to_trails, free_access_to_trails_comments, trails_aligned_with_legislation, trails_aligned_with_legislation_comments, trails_for_hikers_only, other_trails_users, other_trails_users_comment, trails_constructed_and_maintained_by_np_lc_so, trails_constructed_by_national_parks_percentage, trails_constructed_by_local_communities_percentage, trails_constructed_by_state_organisation_percentage, trails_maintained_themself_by_national_parks_percentage, trails_maintained_themself_by_local_communities_percentage, trails_maintained_themself_by_state_organisation_percentage, trails_maintained_mo_by_national_parks_percentage, trails_maintained_mo_by_local_communities_percentage, trails_maintained_mo_by_state_organisation_percentage, trails_constructed_and_maintained_comments, approach_trails_to_climbing, percentage_of_approach_trails_to_climbing, grading_system_difficulty, difficulty_grading_system_description, trails_grading_system, trails_grading_system_description, trails_clearly_visible, trails_clearly_visible_description, trails_allowed_on_any_area)
            // SELECT id, trail_length_km, trail_network_area, trail_network_location, trails_area_mountains_percentage, trails_area_low_mountain_percentage, trails_area_lowland_percentage, trails_on_sealed_roads, trails_on_sealed_roads_percentage, via_ferratas_in_network, via_ferratas_count, via_ferratas_managing_description, free_access_to_trails, free_access_to_trails_comments, trails_aligned_with_legislation, trails_aligned_with_legislation_comments, trails_for_hikers_only, other_trails_users, other_trails_users_comment, trails_constructed_and_maintained_by_np_lc_so, trails_constructed_by_national_parks_percentage, trails_constructed_by_local_communities_percentage, trails_constructed_by_state_organisation_percentage, trails_maintained_themself_by_national_parks_percentage, trails_maintained_themself_by_local_communities_percentage, trails_maintained_themself_by_state_organisation_percentage, trails_maintained_mo_by_national_parks_percentage, trails_maintained_mo_by_local_communities_percentage, trails_maintained_mo_by_state_organisation_percentage, trails_constructed_and_maintained_comments, approach_trails_to_climbing, percentage_of_approach_trails_to_climbing, grading_system_difficulty, difficulty_grading_system_description, trails_grading_system, trails_grading_system_description, trails_clearly_visible, trails_clearly_visible_description, trails_allowed_on_any_area) FROM members;
            // ');
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
            //
        });
    }
};
