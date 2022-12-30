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
        Schema::table('climbing_rock_areas', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('alternative_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('climbing_rock_areas', function (Blueprint $table) {
            $table->string('name');
            $table->string('alternative_name');
        });
    }
};
