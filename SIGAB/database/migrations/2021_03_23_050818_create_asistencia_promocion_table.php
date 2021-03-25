<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciaPromocionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencia_promocion', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('actividad_id')->unsigned();
            $table->foreign('actividad_id')->references('actividad_id')->on('actividades_internas');
            $table->string('cedula', 30);
            $table->string('nombre', 50);
            $table->string('apellidos', 100);
            $table->string('correo', 100);
            $table->string('numero_telefono', 30);
            $table->string('procedencia', 250);

            $table->unique(["cedula", "actividad_id"], 'asistencia_promocion_unique');

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
        Schema::dropIfExists('asistencia_promocion');
    }
}
