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
            $table->integer('wastewater_mechanical_plus_biological_treatment')->nullable();
            $table->decimal('wastewater_mechanical_plus_biological_treatment_percentage', 5, 2)->nullable();
            $table->integer('wastewater_no_treatment')->nullable();
            $table->decimal('wastewater_no_treatment_percentage', 5, 2)->nullable();
            $table->integer('wastewater_public_grid')->nullable();
            $table->decimal('wastewater_public_grid_percentage', 5, 2)->nullable();
            $table->integer('wastewater_unspecified')->nullable();
            $table->decimal('wastewater_unspecified_percentage', 5, 2)->nullable();
            $table->integer('wastewater_treatment_grand_total')->nullable();

            //waste management system
            $table->integer('waste_management_system_yes')->nullable();
            $table->decimal('waste_management_system_yes_percentage', 5, 2)->nullable();
            $table->integer('waste_management_system_no')->nullable();
            $table->decimal('waste_management_system_no_percentage', 5, 2)->nullable();
            $table->integer('waste_management_system_grand_total')->nullable();

            //water supply
            $table->integer('surface_water_supply')->nullable();
            $table->decimal('surface_water_supply_percentage', 5, 2)->nullable();
            $table->integer('ground_well_water_supply')->nullable();
            $table->decimal('ground_well_water_supply_percentage', 5, 2)->nullable();
            $table->integer('public_supply')->nullable();
            $table->decimal('public_supply_percentage', 5, 2)->nullable();
            $table->integer('no_water_supply')->nullable();
            $table->decimal('no_water_supply_percentage', 5, 2)->nullable();
            $table->integer('water_supply_grand_total')->nullable();

            //source of energy
            $table->integer('source_of_energy_public_grid')->nullable();
            $table->decimal('source_of_energy_public_grid_percentage', 5, 2)->nullable();
            $table->integer('source_of_energy_renewable')->nullable();
            $table->decimal('source_of_energy_renewable_percentage', 5, 2)->nullable();
            $table->integer('source_of_energy_generator')->nullable();
            $table->decimal('source_of_energy_generator_percentage', 5, 2)->nullable();
            $table->integer('no_source_of_energy')->nullable();
            $table->decimal('no_source_of_energy_percentage', 5, 2)->nullable();
            $table->integer('source_of_energy_grand_total')->nullable();

            //national park / protected areas
            $table->integer('national_parks')->nullable();
            $table->decimal('national_parks_percentage', 5, 2)->nullable();
            $table->integer('protected_areas')->nullable();
            $table->decimal('protected_areas_percentage', 5, 2)->nullable();
            $table->integer('no_national_parks')->nullable();
            $table->decimal('no_national_parks_percentage', 5, 2)->nullable();
            $table->integer('national_parks_grand_total')->nullable();

            //sanitary
            $table->integer('sanitary_dry_toilets')->nullable();
            $table->integer('sanitary_wet_toilets')->nullable();
            $table->integer('sanitary_toilets_separation')->nullable();
            $table->integer('sanitary_toilets')->nullable();
            $table->integer('sanitary_showers')->nullable();
            $table->integer('sanitary_total_with_toilets')->nullable();
            $table->decimal('sanitary_total_with_toilets_percentage', 5, 2)->nullable();
            $table->integer('sanitary_total_without_toilets')->nullable();
            $table->decimal('sanitary_total_without_toilets_percentage', 5, 2)->nullable();

            //kitchen
            $table->integer('electric_kitchen')->nullable();
            $table->decimal('electric_kitchen_percentage', 5, 2)->nullable();
            $table->integer('gas_kitchen')->nullable();
            $table->decimal('gas_kitchen_percentage', 5, 2)->nullable();
            $table->integer('wood_kitchen')->nullable();
            $table->decimal('wood_kitchen_percentage', 5, 2)->nullable();
            $table->integer('no_kitchen')->nullable();
            $table->decimal('no_kitchen_percentage', 5, 2)->nullable();
            $table->integer('kitchen_grand_total')->nullable();

            //types of huts
            $table->integer('hut_type_hut')->nullable();
            $table->integer('hut_type_biwak')->nullable();
            $table->integer('hut_type_cabane')->nullable();
            $table->integer('hut_type_other')->nullable();
            $table->integer('hut_type_grand_total')->nullable();
            $table->integer('hut_type_lowest_elevation')->nullable();
            $table->integer('hut_type_highest_elevation')->nullable();

            //ownership
            $table->integer('ownership_mountaineering_association')->nullable();
            $table->integer('ownership_mountain_club')->nullable();
            $table->integer('ownership_eos_poa_sox_seo_xos_sho_xoo')->nullable();
            $table->integer('ownership_municipality')->nullable();
            $table->integer('ownership_state')->nullable();
            $table->integer('ownership_private_property')->nullable();
            $table->integer('ownership_other')->nullable();
            $table->integer('ownership_grand_total')->nullable();
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
            $table->dropColumn([
                'wastewater_mechanical_plus_biological_treatment',
                'wastewater_mechanical_plus_biological_treatment_percentage',
                'wastewater_no_treatment',
                'wastewater_no_treatment_percentage',
                'wastewater_public_grid',
                'wastewater_public_grid_percentage',
                'wastewater_unspecified',
                'wastewater_unspecified_percentage',
                'wastewater_treatment_grand_total',
                'waste_management_system_yes',
                'waste_management_system_yes_percentage',
                'waste_management_system_no',
                'waste_management_system_no_percentage',
                'waste_management_system_grand_total',
                'surface_water_supply',
                'surface_water_supply_percentage',
                'ground_well_water_supply',
                'ground_well_water_supply_percentage',
                'public_supply',
                'public_supply_percentage',
                'no_water_supply',
                'no_water_supply_percentage',
                'water_supply_grand_total',
                'source_of_energy_public_grid',
                'source_of_energy_public_grid_percentage',
                'source_of_energy_renewable',
                'source_of_energy_renewable_percentage',
                'source_of_energy_generator',
                'source_of_energy_generator_percentage',
                'no_source_of_energy',
                'no_source_of_energy_percentage',
                'source_of_energy_grand_total',
                'national_parks',
                'national_parks_percentage',
                'protected_areas',
                'protected_areas_percentage',
                'no_national_parks',
                'no_national_parks_percentage',
                'national_parks_grand_total',
                'sanitary_dry_toilets',
                'sanitary_wet_toilets',
                'sanitary_toilets_separation',
                'sanitary_toilets',
                'sanitary_showers',
                'sanitary_total_with_toilets',
                'sanitary_total_with_toilets_percentage',
                'sanitary_total_without_toilets',
                'sanitary_total_without_toilets_percentage',
                'electric_kitchen',
                'electric_kitchen_percentage',
                'gas_kitchen',
                'gas_kitchen_percentage',
                'wood_kitchen',
                'wood_kitchen_percentage',
                'no_kitchen',
                'no_kitchen_percentage',
                'kitchen_grand_total',
                'hut_type_hut',
                'hut_type_biwak',
                'hut_type_cabane',
                'hut_type_other',
                'hut_type_grand_total',
                'hut_type_lowest_elevation',
                'hut_type_highest_elevation',
                'ownership_mountaineering_association',
                'ownership_mountain_club',
                'ownership_eos_poa_sox_seo_xos_sho_xoo',
                'ownership_municipality',
                'ownership_state',
                'ownership_private_property',
                'ownership_other',
                'ownership_grand_total',
            ]);
        });
    }
};
