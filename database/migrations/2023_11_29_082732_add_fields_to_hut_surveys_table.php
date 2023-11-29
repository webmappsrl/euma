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
        Schema::table('hut_surveys', function (Blueprint $table) {
            //waste water treatment
            $table->integer('mechanical_plus_biological_treatment')->nullable();
            $table->integer('no_treatment')->nullable();
            $table->integer('public_grid')->nullable();
            $table->integer('unspecified')->nullable();
            $table->integer('wastewater_treatment_grand_total')->nullable();

            //waste management system
            $table->integer('waste_management_system_yes')->nullable();
            $table->integer('waste_management_system_no')->nullable();
            $table->integer('waste_management_system_grand_total')->nullable();

            //water supply
            $table->integer('surface_water')->nullable();
            $table->integer('ground_well_water')->nullable();
            $table->integer('public_supply')->nullable();
            $table->integer('none')->nullable();
            $table->integer('water_supply_grand_total')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hut_surveys', function (Blueprint $table) {
            //
        });
    }
};
