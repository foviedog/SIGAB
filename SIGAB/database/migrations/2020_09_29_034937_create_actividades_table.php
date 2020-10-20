<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('tema', 100)->nullable();
            $table->string('lugar', 60)->nullable();
            $table->string('estado', 45)->nullable();
            $table->integer('duracion')->nullable();
            $table->date('fecha_inicio_actividad')->nullable();
            $table->date('fecha_final_actividad')->nullable();
            $table->longText('descripcion')->nullable();
            $table->string('evaluacion', 500)->nullable();
            $table->longText('objetivos')->nullable();
            $table->string('responsable_coordinar', 15);
            $table->foreign('responsable_coordinar')->references('persona_id')->on('personal');
            $table->timestamps();
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividades');
    }
}
