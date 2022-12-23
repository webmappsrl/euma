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
        Schema::table('climbing_rock_area_external_database', function (Blueprint $table) {
            $table->text('specific_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('climbing_rock_area_external_database', function (Blueprint $table) {
            $table->dropColumn('specific_url');
        });
    }
};
