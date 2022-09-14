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
        Schema::create('climbing_rock_area_climbing_rock_type', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('climbing_rock_area_id')->nullable();
            $table->foreignId('climbing_rock_type_id')->nullable();

            $table->foreign('climbing_rock_area_id')->references('id')->on('climbing_rock_areas')->onDelete('cascade');
            $table->foreign('climbing_rock_type_id')->references('id')->on('climbing_rock_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('climbing_rock_areas_climbing_rock_type');
    }
};
