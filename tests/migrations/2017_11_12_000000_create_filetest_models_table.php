<?php

use Illuminate\Database\Migrations\Migration;

class CreateFiletestModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filetest_model1s', function ($table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('file_id');
        });
        Schema::create('filetest_model2s', function ($table) {
            $table->increments('id');
            $table->string('name', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('filetest_model1s');
        Schema::drop('filetest_model2s');
    }
}