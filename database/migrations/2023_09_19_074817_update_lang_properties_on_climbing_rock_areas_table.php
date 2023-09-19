<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('climbing_rock_areas', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('local_rules_description');
            $table->dropColumn('local_restrictions_description');

            $table->text('english_description')->nullable();
            $table->text('english_local_rules_description')->nullable();
            $table->text('english_local_restrictions_description')->nullable();

            $table->text('original_description')->nullable();
            $table->text('original_local_rules_description')->nullable();
            $table->text('original_local_restrictions_description')->nullable();
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
            $table->text('local_restrictions_description')->nullable();
            $table->text('local_rules_description')->nullable();
            $table->text('description')->nullable();

            $table->dropColumn('english_description');
            $table->dropColumn('english_local_rules_description');
            $table->dropColumn('english_local_restrictions_description');

            $table->dropColumn('original_description');
            $table->dropColumn('original_local_rules_description');
            $table->dropColumn('original_local_restrictions_description');
        });
    }
};
