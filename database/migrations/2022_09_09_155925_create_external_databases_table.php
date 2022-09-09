<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalDatabasesTable extends Migration
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
            $table->string('name')->nullable();
            $table->string('url')->nullable();
            $table->string('mobile_app_name')->nullable();
            $table->json('mobile_app_os')->nullable();
            $table->enum('offline',['yes', 'no', 'commercial'])->nullable();
            $table->enum('download',['yes', 'no', 'commercial'])->nullable();
            $table->enum('scope',['global', 'continental', 'state','regional','local'])->nullable();
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
}
