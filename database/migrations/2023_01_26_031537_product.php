<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->string('name');
            $table->integer('price')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->bigInteger('storage_id')->unsigned();
            $table->integer('created_time')->unsigned()->nullable();
            $table->integer('updated_time')->unsigned()->nullable();
            $table->integer('deleted_time')->unsigned()->nullable();

            $table->index('name');
            $table->index('storage_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
