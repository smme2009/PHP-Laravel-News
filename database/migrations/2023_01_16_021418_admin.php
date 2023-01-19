<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//後台管理員
class Admin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->bigIncrements('admin_id');
            $table->string('account')->unique();
            $table->string('password');
            $table->string('name');
            $table->integer('created_time')->unsigned()->nullable();
            $table->integer('updated_time')->unsigned()->nullable();
            $table->integer('deleted_time')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
