<?php

use Illuminate\Support\Facades\Route;

// ======================================================================================================================================
//                       Control de Cursos
// ======================================================================================================================================

Route::group(['middleware' => ['auth']], function () {

    //Ruta para el listado
    //Es una ruta de tipo GET, como primer parámetro se le define la ruta de acceso
    //y en el segundo parámetro se le define el controlador, seguido del método.
    //Finalmente se le asigna un nombre a la ruta.
    Route::get('/curso/listado', 'CursoController@index')->name('cursos.index')
    ->middleware( //La estructura del acceso de la ruta se define esta misma forma para todas
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    '); //Se debe escribir 'roles:' seguido de los roles del sistema. DEBEN IR IDÉNTICOS CON RESPECTO A LA BASE DE DATOS.
    
    Route::get('/curso/detalle/{codigo}', 'CursoController@show')->name('cursos.show')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    Route::get('/curso/registrar', 'CursoController@create')->name('cursos.create')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    Route::post('/curso/registrar', 'CursoController@store')->name('cursos.store')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    Route::patch('/curso/actualizar/{codigo}', 'CursoController@update')->name('cursos.update')
    ->middleware(
        'roles:
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

});