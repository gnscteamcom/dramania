<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXlsFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xls_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->bigInteger('size');
            $table->bigInteger('xls_status_id')->nullable()->unsigned();
            $table->foreign('xls_status_id')->references('id')->on('xls_statuses')->onDelete('cascade');
            $table->bigInteger('language_id')->nullable()->unsigned();
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->bigInteger('xls_file_type_id')->nullable()->unsigned();
            $table->foreign('xls_file_type_id')->references('id')->on('xls_file_types')->onDelete('cascade');
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
        Schema::dropIfExists('xls_files');
    }
}
