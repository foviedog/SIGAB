<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->string('persona_id', 15)->primary()->onDelete('cascade'); /* TENER CUIDADO */
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->date('fecha_nacimiento');
            $table->string('telefono_fijo', 30)->nullable();
            $table->string('telefono_celular', 30)->nullable();
            $table->string('correo_personal', 45)->nullable();
            $table->string('correo_institucional', 45);
            $table->string('estado_civil', 45);
            $table->string('direccion_residencia', 250);
            $table->string('genero', 4);
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
        Schema::dropIfExists('personas');
    }
}
