<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargasAcademicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargas_academicas', function (Blueprint $table) {
            $table->id();
            $table->string('persona_id', 15);
            $table->foreign('persona_id')->references('persona_id')->on('personal');
            $table->string('ciclo_lectivo');
            $table->integer('anio');
            $table->string('nombre_curso');
            $table->integer('nrc');
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
        Schema::dropIfExists('cargas_academicas');
    }
}
