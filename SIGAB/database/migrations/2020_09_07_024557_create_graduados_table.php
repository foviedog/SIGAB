<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGraduadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graduados', function (Blueprint $table) {
            $table->id();
            $table->string('persona_id', 15);
            $table->foreign('persona_id')->references('persona_id')->on('personas'); /* falta ->onDelete('cascade'); */
            $table->string('grado_academico', 15);
            $table->string('carrera_cursada', 80);
            $table->integer('anio_graduacion');
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
        Schema::dropIfExists('graduados');
    }
}
