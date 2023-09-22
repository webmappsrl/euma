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
            //change the trail_network_location column name
            $table->renameColumn('trail_network_location', 'trail_network_location_country');
            $table->string('trail_network_location_state')->nullable();
            $table->string('trail_network_location_region')->nullable();
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

            //change the trail_network_location column name
            $table->renameColumn('trail_network_location_country', 'trail_network_location');
            $table->dropColumn('trail_network_location_state');
            $table->dropColumn('trail_network_location_region');
        });
    }
};
