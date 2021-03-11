<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesPromocionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades_promocion', function (Blueprint $table) {
            $table->bigInteger('actividad_id')->unsigned()->primary();
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->string('tipo_actividad', 45)->nullable();
            $table->string('recursos', 500)->nullable();
            $table->string('instituciones_patrocinadoras', 500)->nullable();
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
        Schema::dropIfExists('actividades_promocion');
    }
}
