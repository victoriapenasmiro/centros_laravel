<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentrosAmbitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centros_ambitos', function (Blueprint $table) {
            $table->id();
            $table->integer('centro_id');
            $table->integer('ambito_id');

            $table->foreign('centro_id')->references('id')->on('centros');
            $table->foreign('ambito_id')->references('id')->on('ambitos');
            
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
        Schema::dropIfExists('centros_ambitos');
    }
}
