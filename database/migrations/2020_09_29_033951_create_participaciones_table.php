<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participaciones', function (Blueprint $table) {
            $table->string('persona_id', 15)->primary();
            $table->foreign('persona_id')->references('persona_id')->on('personal');
            $table->longText('capacitacion_didactica')->nullable();
            $table->longText('publicaciones')->nullable();
            $table->longText('cursos_impartidos')->nullable();
            $table->longText('miembro_comisiones')->nullable();
            $table->longText('miembro_prueba_grado')->nullable();
            $table->longText('evaluador_defensa_publica')->nullable();
            $table->longText('evaluacion_interna_ppaa')->nullable();
            $table->longText('evaluacion_externa_ppaa')->nullable();
            $table->longText('reconocimientos')->nullable();
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
        Schema::dropIfExists('participacions');
    }
}
