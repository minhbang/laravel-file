<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'files', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'title' );
            $table->string( 'name' );
            $table->string( 'mime', 60 );
            $table->integer( 'size' )->unsigned();
            $table->integer( 'hit' )->unsigned()->default( 0 );
            $table->tinyInteger( 'tmp' )->default( 0 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'files' );
    }

}
