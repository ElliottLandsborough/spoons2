<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geos', function(Blueprint $table) {
            $table->increments('id');
            // google usually returns either 6 or 7 decimal places
            /*
            +----------------+-------------+
            |    Decimals    |  Precision  |
            +----------------+-------------+
            |    5           |  1m         |
            |    4           |  11m        |
            |    3           |  111m       |
            +----------------+-------------+
            */
            // Latitude measurements range from 0° to (+/-)90°
            $table->decimal('lat', 9, 7);
            // Longitude measurements range from 0° to (+/-)180°
            $table->decimal('lon', 10, 7);
            // pub id
            $table->integer('pub_id')->unique();
            // google places id
            $table->text('place_id')->nullable();
            // prcise lat/lon
            $table->text('lat_precice')->nullable();
            $table->text('lon_precice')->nullable();
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
        Schema::drop('geos');
    }
}