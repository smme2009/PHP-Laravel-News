<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class News extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('news_id');
            $table->string('title');
            $table->text('content');
            $table->bigInteger('image_id')->unsigned();
            $table->integer('show_time')->unsigned()->nullable();
            $table->integer('hide_time')->unsigned()->nullable();
            $table->boolean('status');
            $table->integer('created_time')->unsigned()->nullable();
            $table->integer('updated_time')->unsigned()->nullable();
            $table->integer('deleted_time')->unsigned()->nullable();

            $table->index('title');
            $table->index('image_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
