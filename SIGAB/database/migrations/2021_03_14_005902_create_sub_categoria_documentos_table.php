<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriaDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categoria_documentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 700);
            $table->bigInteger('categoria_documento_id')->unsigned();
            $table->foreign('categoria_documento_id')->references('id')->on('categoria_documentos')->onDelete('cascade');
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
        Schema::dropIfExists('sub_categoria_documentos');
    }
}
