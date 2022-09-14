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
        Schema::create('external_database_trail', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('trail_id')->nullable();
            $table->foreignId('external_database_id')->nullable();

            $table->foreign('trail_id')->references('id')->on('trails')->onDelete('cascade');
            $table->foreign('external_database_id')->references('id')->on('external_databases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trail_external_database');
    }
};
