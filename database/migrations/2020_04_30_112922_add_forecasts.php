<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForecasts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id();
            $table->integer('hour');
            $table->string('date');
            $table->string('humidity');
            $table->integer('temp');
            $table->integer('feels_like');
            $table->string('description');
            $table->string('summary');
            $table->float('wind_speed');
            $table->integer('wind_dir');
            $table->integer('pressure');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forecasts');
    }
}
