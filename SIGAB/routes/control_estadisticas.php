<?php

use Illuminate\Support\Facades\Route;

// ======================================================================================================================================
//                                                              GENERACIÓN DE DATOS Y ESTADÍSTICAS
// ======================================================================================================================================

Route::group(['middleware' => ['auth']], function () {

    // ********************************************************
    //        Reportes de actividades
    // ********************************************************

    Route::get('/reportes/actividades', 'ReportesActividadesController@show')->name('reportes-actividades.show')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    Route::get('/reportes/tipos-actividad/{act}', 'ReportesActividadesController@devolverTipos')->name('reportes-actividades.tipos')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    Route::get('/reportes/activdades/resultado', 'ReportesActividadesController@resultado')->name('reportes-actividades.resultado')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    Route::post('/reportes/actividades/reporte', 'ReportesActividadesController@obtReporte')->name('reportes-actividades.reporte')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    // ********************************************************
    //      Reportes de involucramiento del personal
    // ********************************************************
    Route::get('/reportes/involucramiento', 'ReportesInvolucramientoController@show')->name('reportes-involucramiento.show')
        ->middleware(
            'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    Route::get('/reportes/involucramiento/resultado', 'ReportesInvolucramientoController@resultado')->name('reportes-involucramiento.resultado')
        ->middleware(
            'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    Route::get('/reportes/involucramiento/personal/{personal_id}', 'ReportesInvolucramientoController@obtenerPersonal')->name('reportes-involucramiento.personal')
        ->middleware(
            'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    // ****************************************************************************************************************
    //      Reportes de involucramiento ANUAL del personal
    // ****************************************************************************************************************
    Route::get('/reportes/involucramiento/anual', 'ReporteInvolucramientoAnualController@show')->name('involucramiento-anual.show')
        ->middleware(
            'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');
    Route::post('/reportes/involucramiento/anual', 'ReporteInvolucramientoAnualController@reporte')->name('involucramiento-anual.reporte')
        ->middleware(
            'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    // ****************************************************************************************************************
    //      Reportes de involucramiento POR CICLO del personal
    // ****************************************************************************************************************

    Route::get('/reportes/involucramiento/ciclo', 'ReporteInvolucramientoPorCicloController@show')->name('involucramiento-ciclo.show')
        ->middleware(
            'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

    Route::post('/reportes/involucramiento/ciclo/reporte', 'ReporteInvolucramientoPorCicloController@reporte')->name('involucramiento-ciclo.reporte')
        ->middleware(
            'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');

});