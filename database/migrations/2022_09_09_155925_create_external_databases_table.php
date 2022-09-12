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
        Schema::create('external_databases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->text('url');
            $table->string('mobile_app_name')->nullable();
            $table->json('mobile_app_os')->nullable();
            $table->enum('offline',['yes', 'no', 'commercial'])->nullable();
            $table->enum('download',['yes', 'no', 'commercial'])->nullable();
            $table->enum('scope',['global', 'continental', 'state','regional','local'])->nullable();
            $table->enum('contribution',['users_self_service', 'users_self_service_administered', 'fully_administered'])->nullable();
            $table->string('languages')->nullable();
            $table->string('editor')->nullable();
            $table->string('editor_contact')->nullable();
            $table->string('characteristic')->nullable();
            $table->boolean('user_ascent_log')->default(false);
            $table->boolean('user_ascent_download')->default(false);
            $table->boolean('protection_info')->default(false);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_databases');
    }
};
