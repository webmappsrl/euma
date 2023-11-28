<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('responsible_for_trails');
            $table->dropColumn('responsible_for_trails_comments');
            $table->dropColumn('trail_length_km');
            $table->dropColumn('trail_network_area');
            $table->dropColumn('trail_network_location_country')->nullable();
            $table->dropColumn('trail_network_location_state')->nullable();
            $table->dropColumn('trail_network_location_region')->nullable();
            $table->dropColumn('trails_area_mountains_percentage');
            $table->dropColumn('trails_area_low_mountain_percentage');
            $table->dropColumn('trails_area_lowland_percentage');
            $table->dropColumn('trails_on_sealed_roads');
            $table->dropColumn('trails_on_sealed_roads_percentage');
            $table->dropColumn('via_ferratas_in_network');
            $table->dropColumn('via_ferratas_count');
            $table->dropColumn('via_ferratas_managing_description');
            $table->dropColumn('free_access_to_trails');
            $table->dropColumn('free_access_to_trails_comments');
            $table->dropColumn('trails_aligned_with_legislation');
            $table->dropColumn('trails_aligned_with_legislation_comments');
            $table->dropColumn('trails_for_hikers_only');
            $table->dropColumn('other_trails_users');
            $table->dropColumn('other_trails_users_comment');
            $table->dropColumn('trails_constructed_and_maintained_by_np_lc_so');
            $table->dropColumn('trails_constructed_by_national_parks_percentage');
            $table->dropColumn('trails_constructed_by_local_communities_percentage');
            $table->dropColumn('trails_constructed_by_state_organisation_percentage');
            $table->dropColumn('trails_maintained_themself_by_national_parks_percentage');
            $table->dropColumn('trails_maintained_themself_by_local_communities_percentage');
            $table->dropColumn('trails_maintained_themself_by_state_organisation_percentage');
            $table->dropColumn('trails_maintained_mo_by_national_parks_percentage');
            $table->dropColumn('trails_maintained_mo_by_local_communities_percentage');
            $table->dropColumn('trails_maintained_mo_by_state_organisation_percentage');
            $table->dropColumn('trails_constructed_and_maintained_comments');
            $table->dropColumn('approach_trails_to_climbing');
            $table->dropColumn('percentage_of_approach_trails_to_climbing');
            $table->dropColumn('grading_system_difficulty');
            $table->dropColumn('difficulty_grading_system_description');
            $table->dropColumn('trails_grading_system');
            $table->dropColumn('trails_grading_system_description');
            $table->dropColumn('trails_clearly_visible');
            $table->dropColumn('trails_clearly_visible_description');
            $table->dropColumn('trails_allowed_on_any_area');
            $table->dropColumn('trails_allowed_on_any_area_description');
            $table->dropColumn('trails_keepers_specified');
            $table->dropColumn('trails_keepers_specified_description');
            $table->dropColumn('mountain_trails_construction_cost');
            $table->dropColumn('low_mountain_trails_construction_cost');
            $table->dropColumn('lowland_trails_construction_cost');
            $table->dropColumn('trails_construction_maintained_frequently');
            $table->dropColumn('average_trails_construction_maintenance_period');
            $table->dropColumn('mountain_trails_maintenance_cost');
            $table->dropColumn('low_mountain_trails_maintenance_cost');
            $table->dropColumn('lowland_trails_maintenance_cost');
            $table->dropColumn('trails_physically_marked');
            $table->dropColumn('trails_marking_system_description');
            $table->dropColumn('trails_signs_maintained_frequently');
            $table->dropColumn('average_trails_signs_maintenance_period');
            $table->dropColumn('trails_signs_maintenance_scope');
            $table->dropColumn('average_annual_sign_maintenance_cost_for_mountains');
            $table->dropColumn('average_annual_sign_maintenance_cost_for_low_mountains');
            $table->dropColumn('average_annual_sign_maintenance_cost_for_lowlands');
            $table->dropColumn('trails_maintenance_done_by');
            $table->dropColumn('trails_maintenance_system_description');
            $table->dropColumn('trails_percentage_maintenance_costs_covered_by_public_funding');
            $table->dropColumn('trails_maintenance_comments');
            $table->dropColumn('trails_recognized_by_government');
            $table->dropColumn('trails_recognized_by_government_comments');
            $table->dropColumn('new_paths_agreement');
            $table->dropColumn('new_paths_agreement_comments');
            $table->dropColumn('liability_exempted');
            $table->dropColumn('liability_exempted_comments');
            $table->dropColumn('trails_sustainability');
            $table->dropColumn('trails_sustainability_comments');
            $table->dropColumn('has_digital_database');
            $table->dropColumn('digital_database_description');
            $table->dropColumn('hikers_have_free_access_to_database');
            $table->dropColumn('trails_issues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {

            $table->boolean('responsible_for_trails')->default(false);
            $table->text('responsible_for_trails_comments')->nullable();
            $table->decimal('trail_length_km', 10, 2)->nullable();
            $table->decimal('trail_network_area', 10, 2)->nullable();
            $table->string('trail_network_location_country')->nullable();
            $table->string('trail_network_location_state')->nullable();
            $table->string('trail_network_location_region')->nullable();
            $table->decimal('trails_area_mountains_percentage', 10, 2)->nullable();
            $table->decimal('trails_area_low_mountain_percentage', 10, 2)->nullable();
            $table->decimal('trails_area_lowland_percentage', 10, 2)->nullable();
            $table->boolean('trails_on_sealed_roads')->default(false);
            $table->decimal('trails_on_sealed_roads_percentage', 10, 2)->nullable();
            $table->boolean('via_ferratas_in_network')->default(false);
            $table->integer('via_ferratas_count')->nullable();
            $table->text('via_ferratas_managing_description')->nullable();
            $table->boolean('free_access_to_trails')->default(false);
            $table->text('free_access_to_trails_comments')->nullable();
            $table->boolean('trails_aligned_with_legislation')->default(false);
            $table->text('trails_aligned_with_legislation_comments')->nullable();
            $table->boolean('trails_for_hikers_only')->default(false);
            $table->boolean('other_trails_users')->default(false);
            $table->text('other_trails_users_comment')->nullable();
            $table->boolean('trails_constructed_and_maintained_by_np_lc_so')->default(false);
            $table->decimal('trails_constructed_by_national_parks_percentage', 10, 2)->nullable();
            $table->decimal('trails_constructed_by_local_communities_percentage', 10, 2)->nullable();
            $table->decimal('trails_constructed_by_state_organisation_percentage', 10, 2)->nullable();
            $table->decimal('trails_maintained_themself_by_national_parks_percentage', 10, 2)->nullable();
            $table->decimal('trails_maintained_themself_by_local_communities_percentage', 10, 2)->nullable();
            $table->decimal('trails_maintained_themself_by_state_organisation_percentage', 10, 2)->nullable();
        });
    }
};