<?php

use Illuminate\Support\Facades\Route;

// ======================================================================================================================================
//                                                           Control de Actividades de promocion
// ======================================================================================================================================

Route::group(['middleware' => ['auth']], function () {

    //Registrar una actividad de promocion
    Route::get('/actividad-promocion/registrar', 'ActividadesPromocionController@create')->name('actividad-promocion.create')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');
    
    /* Rutas para informacion de actividades de promocion */
    Route::post('/actividad-promocion', 'ActividadesPromocionController@store')->name('actividad-promocion.store')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    // Listado de actividades de promocion
    Route::get('/actividad-promocion', 'ActividadesPromocionController@index')->name('actividad-promocion.listado')
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
    Route::patch('/actividad-promocion/autorizar', 'ActividadesPromocionController@autorizar')->name('actividad-promocion.autorizar')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    // Detalle de actividad promocion
    Route::get('/detalle-actividad-promocion/{id_actividad}', 'ActividadesPromocionController@show')->name('actividad-promocion.show')
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
    Route::patch('/actividad-promocion/{id_actividad}', 'ActividadesPromocionController@update')->name('actividad-promocion.update')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    // ********************************************
    //      Control de listas de asistencia PC
    // ********************************************
    
    Route::get('/lista-asistencia-promocion/{actividad_id}', 'AsistenciaPromocionController@show')->name('asistencia-promocion.show')
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

    Route::get('/lista-asistencia-promocion/participante/{participante_id}', 'AsistenciaPromocionController@obtenerParticipante')->name('asistencia-promocion.edit')
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

    Route::post('/lista-asistencia-promocion', 'AsistenciaPromocionController@store')->name('asistencia-promocion.store')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::delete('/lista-asistencia-promocion/{participante_id}', 'AsistenciaPromocionController@destroy')->name('asistencia-promocion.destroy')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

});