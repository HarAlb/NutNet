<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description' , 350);
            $table->string('slug')->unique();
            $table->string('file_path')->unique();
            $table->string('thumb')->unique();
            $table->bigInteger('u_id')->unsigned();
            $table->timestamps();

            $table->index(['title']);
            $table->foreign('u_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
