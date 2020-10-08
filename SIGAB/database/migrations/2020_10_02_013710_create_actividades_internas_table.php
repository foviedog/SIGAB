<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesInternasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades_internas', function (Blueprint $table) {
            $table->bigInteger('actividad_id')->unsigned()->primary();
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->string('tipo_actividad', 45)->nullable();
            $table->string('proposito', 45)->nullable();
            $table->string('facilitador_actividad', 45)->nullable();
            $table->longText('agenda')->nullable();
            $table->string('ambito', 45)->nullable();
            $table->string('duracion', 45)->nullable();
            $table->string('certificacion_actividad', 45)->nullable();
            $table->string('publico_dirigido', 45)->nullable();
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
        Schema::dropIfExists('actividades_internas');
    }
}