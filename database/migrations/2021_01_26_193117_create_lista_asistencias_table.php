<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListaAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('lista_asistencias', function (Blueprint $table) {
            $table->id();
            $table->string('persona_id', 15);
            $table->foreign('persona_id')->references('persona_id')->on('personas');
            $table->bigInteger('actividad_id')->unsigned();
            $table->foreign('actividad_id')->references('actividad_id')->on('actividades_internas');
            $table->unique(["persona_id", "actividad_id"], 'persona_actividad_unique');

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
        $table->dropUnique('persona_actividad_unique');
        Schema::dropIfExists('lista_asistencias');
    }
}
