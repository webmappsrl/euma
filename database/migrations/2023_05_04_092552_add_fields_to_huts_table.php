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
        //         wastewater_treatment	boolean
        // waste_management_system	text
        // water_supply	boolean
        // electric_and_heating_energy_source	text
        // area_type	Enum('natonal park', 'other protected area')
        // sanitary_facility	boolean
        // kitchen_facility	boolean
        Schema::table('huts', function (Blueprint $table) {
            $table->boolean('wastewater_treatment')->nullable();
            $table->text('waste_management_system')->nullable();
            $table->boolean('water_supply')->nullable();
            $table->boolean('electric_and_heating_energy_source')->nullable();
            $table->string('area_type')->nullable();
            $table->boolean('sanitary_facility')->nullable();
            $table->boolean('kitchen_facility')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('huts', function (Blueprint $table) {
            $table->dropColumn('wastewater_treatment');
            $table->dropColumn('waste_management_system');
            $table->dropColumn('water_supply');
            $table->dropColumn('electric_and_heating_energy_source');
            $table->dropColumn('area_type');
            $table->dropColumn('sanitary_facility');
            $table->dropColumn('kitchen_facility');
        });
    }
};
