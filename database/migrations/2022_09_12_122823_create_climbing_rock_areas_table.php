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
        Schema::create('climbing_rock_areas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('alternative_name');
            $table->point('geometry');
            $table->text('local_rules_url');
            $table->text('local_rules_description')->nullable();
            $table->text('local_rules_document')->nullable();
            $table->boolean('local_restricions')->default(false);
            $table->text('local_restrictions_desctription')->nullable();
            $table->point('parking_position')->nullable();
            $table->integer('location_quality')->nullable();
            $table->integer('routes_number')->nullable();
            $table->text('geobox_closest_town')->nullable();
            $table->integer('elevation')->nullable();
            $table->integer('geobox_elevation');
            $table->jsonb('geobox_location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('climbing_rock_areas');
    }
};