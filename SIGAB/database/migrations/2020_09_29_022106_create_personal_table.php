<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal', function (Blueprint $table) {
            $table->string('persona_id', 15)->primary();
            $table->foreign('persona_id')->references('persona_id')->on('personas');
            $table->string('carga_academica', 250)->nullable();
            $table->string('grado_academico', 100)->nullable();
            $table->string('tipo_nombramiento', 40)->nullable();
            $table->string('tipo_puesto', 60)->nullable();
            $table->string('jornada', 60)->nullable();
            $table->string('lugar_trabajo_externo', 60)->nullable();
            $table->integer('anio_propiedad')->nullable();
            $table->longText('experiencia_profesional')->nullable();
            $table->longText('experiencia_academica')->nullable();
            $table->string('regimen_administrativo', 60)->nullable();
            $table->string('regimen_docente', 60)->nullable();
            $table->string('area_especializacion_1', 100)->nullable();
            $table->string('area_especializacion_2', 100)->nullable();
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
        Schema::dropIfExists('personal');
    }
}
