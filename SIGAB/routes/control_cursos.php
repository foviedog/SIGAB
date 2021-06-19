<?php

use Illuminate\Support\Facades\Route;

// ======================================================================================================================================
//                                                           Control de Cursos
// ======================================================================================================================================

Route::group(['middleware' => ['auth']], function () {

    Route::get('/curso/listado', 'CursoController@index')->name('cursos.index')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    Route::get('/curso/detalle', 'CursoController@show')->name('cursos.show')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    Route::get('/curso/registrar', 'CursoController@create')->name('cursoss.create')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

});