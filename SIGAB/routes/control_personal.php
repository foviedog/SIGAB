<?php

use Illuminate\Support\Facades\Route;

// ======================================================================================================================================
//                                                           Control de Personal
// ======================================================================================================================================

Route::group(['middleware' => ['auth']], function () {

    /* Rutas para informacion del personal */
    Route::post('/personal', 'PersonalController@store')->name('personal.store')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::get('/personal/registrar', 'PersonalController@create')->name('personal.create')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::get('/personal/listar', 'PersonalController@index')->name('personal.listar')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Asistente administrativa
            Secretaria
            Estudiante asistente académica
    ');

    Route::get('/personal/detalle/{id_personal}', 'PersonalController@show')->name('personal.show')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Asistente administrativa
            Secretaria
            Estudiante asistente académica
    ');

    Route::get('/personal/obtener/{id_personal}', 'PersonalController@edit')->name('personal.edit')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Asistente administrativa
            Secretaria
            Estudiante asistente académica
    ');

    Route::patch('/personal/detalle/{id_personal}', 'PersonalController@update')->name('personal.update')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    /* Ruta para cambiar imagen del personal*/
    Route::post('/personal/imagen/cambiar', 'PersonalController@update_avatar')->name('personal.update.avatar')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');


    /* Rutas para informacion de Carga Academica */
    Route::get('/personal/carga-academica/{id_personal}', 'CargasAcademicaController@index')->name('cargaacademica.show')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Asistente administrativa
            Secretaria
            Estudiante asistente académica
    ');

    Route::get('/personal/carga-academica/registrar/{id_personal}', 'CargasAcademicaController@create')->name('cargaacademica.create')
    ->middleware(
        'roles:
            Dirección
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::patch('/personal/carga-academica', 'CargasAcademicaController@store')->name('cargaacademica.store')
    ->middleware(
        'roles:
            Dirección
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::get('/personal/carga-academica/obtener/{id_carga_academica}', 'CargasAcademicaController@edit')->name('cargaacademica.edit')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Asistente administrativa
            Secretaria
            Estudiante asistente académica
    ');

    Route::patch('/personal/carga-academica/actualizar/{id_carga_academica}', 'CargasAcademicaController@update')->name('cargaacademica.update')
    ->middleware(
        'roles:
            Dirección
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::delete('/personal/carga-academica/eliminar/{id_carga_academica}', 'CargasAcademicaController@destroy')->name('cargaacademica.delete')
    ->middleware(
        'roles:
            Dirección
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::delete('/personal/carga-academica/eliminar/{id_carga_academica}', 'CargasAcademicaController@destroy')->name('cargaacademica.delete')
    ->middleware(
        'roles:
            Dirección
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');


    Route::delete('/personal/eliminar/{id_personal}', 'PersonalController@destroy')->name('personal.destroy')
    ->middleware(
        'roles:
            Dirección
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

});