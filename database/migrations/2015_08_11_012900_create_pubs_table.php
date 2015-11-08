<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pubs', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->decimal('xmas_lunch', 10, 2);
            $table->decimal('xmas_price', 10, 2);
            $table->text('name');
            $table->text('name_slug');
            $table->text('address_line_1');
            $table->text('address_line_2');
            $table->text('town');
            $table->text('county_id');
            $table->text('post_code');
            $table->text('url');
            $table->integer('cover_image_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pubs');
    }
}
