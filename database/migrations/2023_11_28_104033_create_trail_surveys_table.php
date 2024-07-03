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
        Schema::create('trail_surveys', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members');

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
            $table->string('other_trails_users')->nullable(); //to be casted as enum ( trail runners, bikers, e-bikers, motorcyclists, horse riders, quad drivers, others) 
            $table->text('other_trails_users_comment')->nullable();
            $table->boolean('trails_constructed_and_maintained_by_np_lc_so')->default(false); //np = national parks, lc = local communities, so = state organisations
            $table->decimal('trails_constructed_by_national_parks_percentage', 10, 2)->nullable();
            $table->decimal('trails_constructed_by_local_communities_percentage', 10, 2)->nullable();
            $table->decimal('trails_constructed_by_state_organisation_percentage', 10, 2)->nullable();
            $table->decimal('trails_maintained_themself_by_national_parks_percentage', 10, 2)->nullable();
            $table->decimal('trails_maintained_themself_by_local_communities_percentage', 10, 2)->nullable();
            $table->decimal('trails_maintained_themself_by_state_organisation_percentage', 10, 2)->nullable();
            $table->decimal('trails_maintained_mo_by_national_parks_percentage', 10, 2)->nullable();
            $table->decimal('trails_maintained_mo_by_local_communities_percentage', 10, 2)->nullable();
            $table->decimal('trails_maintained_mo_by_state_organisation_percentage', 10, 2)->nullable();
            $table->text('trails_constructed_and_maintained_comments')->nullable();
            $table->boolean('approach_trails_to_climbing')->default(false);
            $table->decimal('percentage_of_approach_trails_to_climbing')->nullable();
            $table->boolean('grading_system_difficulty')->default(false);
            $table->text('difficulty_grading_system_description')->nullable();
            $table->boolean('trails_grading_system')->default(false);
            $table->text('trails_grading_system_description')->nullable();
            $table->boolean('trails_clearly_visible')->default(false);
            $table->text('trails_clearly_visible_description')->nullable();
            $table->boolean('trails_allowed_on_any_area')->default(false);
            $table->text('trails_allowed_on_any_area_description')->nullable();
            $table->boolean('trails_keepers_specified')->default(false);
            $table->text('trails_keepers_specified_description')->nullable();
            $table->decimal('mountain_trails_construction_cost', 10, 2)->nullable(); // €/km
            $table->decimal('low_mountain_trails_construction_cost', 10, 2)->nullable(); // €/km
            $table->decimal('lowland_trails_construction_cost', 10, 2)->nullable(); // €/km
            $table->boolean('trails_construction_maintained_frequently')->default(false);
            $table->string('average_trails_construction_maintenance_period')->nullable();
            $table->decimal('mountain_trails_maintenance_cost', 10, 2)->nullable(); // €/km
            $table->decimal('low_mountain_trails_maintenance_cost', 10, 2)->nullable(); // €/km
            $table->decimal('lowland_trails_maintenance_cost', 10, 2)->nullable(); // €/km
            $table->boolean('trails_physically_marked')->default(false);
            $table->text('trails_marking_system_description')->nullable();
            $table->boolean('trails_signs_maintained_frequently')->default(false);
            $table->string('average_trails_signs_maintenance_period')->nullable();
            $table->text('trails_signs_maintenance_scope')->nullable();
            $table->decimal('average_annual_sign_maintenance_cost_for_mountains')->nullable(); // €/km
            $table->decimal('average_annual_sign_maintenance_cost_for_low_mountains')->nullable(); // €/km
            $table->decimal('average_annual_sign_maintenance_cost_for_lowlands')->nullable(); // €/km
            $table->string('trails_maintenance_done_by')->nullable(); //to be casted as enum (volunteers, professionals, both)
            $table->text('trails_maintenance_system_description')->nullable();
            $table->decimal('trails_percentage_maintenance_costs_covered_by_public_funding', 10, 2)->nullable(); // %
            $table->text('trails_maintenance_comments')->nullable();
            $table->boolean('trails_recognized_by_government')->default(false);
            $table->text('trails_recognized_by_government_comments')->nullable();
            $table->boolean('new_paths_agreement')->default(false);
            $table->text('new_paths_agreement_comments')->nullable();
            $table->boolean('liability_exempted')->default(false);
            $table->text('liability_exempted_comments')->nullable();
            $table->boolean('trails_sustainability')->default(false);
            $table->text('trails_sustainability_comments')->nullable();
            $table->boolean('has_digital_database')->default(false);
            $table->text('digital_database_description')->nullable();
            $table->boolean('hikers_have_free_access_to_database')->default(false);
            $table->text('trails_issues')->nullable();
            $table->text("hikers_free_access_db_description")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trail_surveys');
    }
};
