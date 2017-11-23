<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_availabilities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('city_id');
            $table->integer('quantity');
            $table->timestamps();
        });

         Schema::table('product_availabilities', function(Blueprint $table){
            $table->unique(['product_id', 'city_id']);
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('city_id')->references('id')->on('cities');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_availabilities');
    }
}
