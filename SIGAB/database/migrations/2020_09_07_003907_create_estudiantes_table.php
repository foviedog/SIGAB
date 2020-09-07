<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->string('persona_id', 15)->primary();
            $table->foreign('persona_id')->references('persona_id')->on('personas');
            $table->string('direccion_lectivo', 80);
            $table->integer('cant_hijos');
            $table->string('tipo_colegio_procedencia', 13); /* verificar la cantidad de caracteres */
            $table->string('condicion_discapacidad', 250)->nullable();
            $table->date('anio_ingreso_ebdi');
            $table->date('anio_ingreso_UNA');
            $table->string('carrera_matriculada_1', 45);
            $table->string('carrera_matriculada_2', 45)->nullable();
            $table->integer('anio_graduacion_estimado_1');
            $table->integer('anio_graduacion_estimado_2')->nullable();
            $table->string('anio_desercion', 45)->nullable(); /* verificar tipo de dato */
            $table->string('tipo_beca', 70)->nullable();
            $table->double('nota_admision');
            $table->string('apoyo_educativo', 150)->nullable();
            $table->integer('residencias_UNA')->nullable();
            //$table->timestamps();

            $table->index('persona_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiantes');
    }
}
