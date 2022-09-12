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
        Schema::create('huts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->text('description')->nullable();
            $table->point('geometry');
            $table->jsonb('geobox_location');
            $table->integer('elevation');
            $table->integer('geobox_elevation');
            $table->text('url')->nullable();
            $table->integer('geobox_feature_image')->nullable();
            $table->boolean('managed')->default(false);
            $table->string('address')->nullable();
            $table->string('operating_name')->nullable();
            $table->string('operating_email')->nullable();
            $table->string('operating_phone')->nullable();
            $table->string('owner')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('huts');
    }
};
