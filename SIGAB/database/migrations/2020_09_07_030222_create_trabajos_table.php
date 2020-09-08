<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->id();
            $table->string('persona_id', 15);
            $table->foreign('persona_id')->references('persona_id')->on('personas');
            $table->string('nombre_organizacion', 45);
            $table->string('tipo_organizacion', 45);
            $table->string('tiempo_desempleado', 45)->nullable();
            $table->string('cargo_actual', 45);
            $table->string('jefe_inmediato', 45)->nullable();
            $table->string('telefono_trabajo', 45)->nullable();
            $table->string('jornada_laboral', 45);
            $table->string('correo_trabajo', 80)->nullable();
            $table->longText('interes_capacitacion')->nullable();
            $table->longText('otros_estudios')->nullable();
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
        Schema::dropIfExists('trabajos');
    }
}
