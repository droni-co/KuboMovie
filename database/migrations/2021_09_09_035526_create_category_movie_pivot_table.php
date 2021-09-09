<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryMoviePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_movie', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('movie_id')->index();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->primary(['category_id', 'movie_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_movie');
    }
}
