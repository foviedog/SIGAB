<?php

use Illuminate\Support\Facades\Route;

// ======================================================================================================================================
//                                                           Control de Actividades Internas
// ======================================================================================================================================

Route::group(['middleware' => ['auth']], function () {

    /* Rutas para informacion de actividades internas */
    //Registrar una actividad interna
    Route::get('/actividad-interna/registrar', 'ActividadesInternaController@create')->name('actividad-interna.create')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::post('/actividad-interna', 'ActividadesInternaController@store')->name('actividad-interna.store')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    // Listado de actividades internas
    Route::get('/actividad-interna', 'ActividadesInternaController@index')->name('actividad-interna.listado')
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

    // Autorizar actividad interna
    Route::patch('/actividad-interna/autorizar', 'ActividadesInternaController@autorizar')->name('actividad-interna.autorizar')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    // Detalle de actividad interna
    Route::get('/detalle-actividad-interna/{id_actividad}', 'ActividadesInternaController@show')->name('actividad-interna.show')
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

    // Actualización de los datos de la actividad
    Route::patch('/actividad-interna/{id_actividad}', 'ActividadesInternaController@update')->name('actividad-interna.update')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::delete('/actividad-interna/{id_actividad}', 'ActividadesInternaController@destroy')->name('actividad-interna.destroy')
    ->middleware(
        'roles:
        Dirección
        Subdirección
        Académica responsable de Aseguramiento de la Calidad de la Carrera
        Académica responsable de SIGAB
    ');

    // ********************************************
    //      Control de listas de asistencia
    // ********************************************
    
    Route::get('/lista-asistencia/{actividad_id}', 'ListaAsistenciaController@show')->name('lista-asistencia.show')
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

    Route::get('/lista-asistencia/participante/{participante_id}', 'ListaAsistenciaController@obtenerParticipante')->name('lista-asistencia.edit')
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

    Route::post('/lista-asistencia', 'ListaAsistenciaController@store')->name('lista-asistencia.store')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::post('/lista-asistencia/invitado', 'ListaAsistenciaController@storeInvitado')->name('lista-asistencia.storeInvitado')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::delete('/lista-asistencia/{participante_id}', 'ListaAsistenciaController@destroy')->name('lista-asistencia.destroy')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    // ********************************************
    //      Control de evidencias
    // ********************************************

    Route::get('/evidencias/{evidencia_id}', 'EvidenciaController@show')->name('evidencias.show')
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

    Route::post('/evidencias', 'EvidenciaController@store')->name('evidencias.store')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::delete('/evidencias/{evidencia_id}', 'EvidenciaController@destroy')->name('evidencias.destroy')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::get('/evidencias/download/{evidencia_id}', 'EvidenciaController@download')->name('evidencias.download')
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

});