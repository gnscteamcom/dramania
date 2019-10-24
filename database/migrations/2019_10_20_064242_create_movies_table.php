<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('poster');
            $table->text('description');
            $table->float('rating');
            $table->string('slug')->nullable();
            $table->json('genres');
            $table->string('url');
            $table->bigInteger('xls_id')->nullable()->unsigned();
            $table->foreign('xls_id')->references('id')->on('xls_files')->onDelete('cascade');
            $table->bigInteger('language_id')->nullable()->unsigned();
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
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
        Schema::dropIfExists('movies');
    }
}
