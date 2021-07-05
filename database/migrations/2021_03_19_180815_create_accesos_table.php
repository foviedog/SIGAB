<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("rol_id");
            $table->foreign('rol_id')->references('id')->on('roles');
            $table->unsignedBigInteger("tarea_id");
            $table->foreign('tarea_id')->references('id')->on('tareas');
            $table->unique(["rol_id", "tarea_id"], 'accesos_unique');
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
        Schema::dropIfExists('accesos');
    }
}
