<?php

use Illuminate\Support\Facades\Route;

// ======================================================================================================================================
//                                                           Control Estudiantil
// ======================================================================================================================================

Route::group(['middleware' => ['auth']], function () {

    /* Ruta de detalle del estudiante*/
    Route::get('/estudiante/detalle/{id_estudiante}', 'EstudianteController@show')->name('estudiante.show')
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

    /* Rutas para editar  y actualizar la informacion del estudiante*/
    Route::patch('/estudiante/detalle/{id_estudiante}', 'EstudianteController@update')->name('estudiante.update')
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

    /* Ruta para cambiar imagen del estudiante*/
    Route::post('/estudiante/imagen/cambiar', 'EstudianteController@update_avatar')->name('estudiante.update.avatar')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    // Muestra el listado de los estudiantes ordenados por su apellido
    Route::get('/listado-estudiantil', 'EstudianteController@index')->name('listado-estudiantil')
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

    Route::get('/estudiantes/graduados/listar', 'GraduadoController@index')->name('graduados.listar')
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

    /* Rutas para informacion de Guias academicas */
    Route::patch('/estudiante/guia-academica/actualizar/{id_guia}', 'GuiasAcademicaController@update')->name('guia-academica.update')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::get('/estudiante/guia-academica/listar', 'GuiasAcademicaController@index')->name('guia-academica.listar')
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

    Route::get('/estudiante/guia-academica/registrar/{id_estudiante}', 'GuiasAcademicaController@create')->name('guia-academica.create')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::get('/estudiante/guia-academica/{id_guia}', 'GuiasAcademicaController@show')->name('guia-academica.show')
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

    Route::post('/estudiante/guia-academica', 'GuiasAcademicaController@store')->name('guia-academica.store')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::get('/estudiante/guia-academica/{id_guia}/eliminar-archivo', 'GuiasAcademicaController@deleteFile')->name('guia-academica.delete_file')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::get('/estudiante/guia-academica/download/{nombre}', 'GuiasAcademicaController@download')->name('guia-academica.download')
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

    Route::delete('/estudiante/guia-academica/eliminar/{id_guia}', 'GuiasAcademicaController@destroy')->name('guia-academica.delete')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    /* Rutas para informacion de estudiantes */
    Route::get('/estudiante/registrar', 'EstudianteController@create')->name('estudiante.create')
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

    Route::post('/estudiante', 'EstudianteController@store')->name('estudiante.store')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    /* Rutas para informacion laboral */
    Route::get('/estudiante/trabajo/{id_estudiante}', 'TrabajoController@index')->name('trabajo.listar')
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

    Route::patch('/estudiante/trabajo/registrar', 'TrabajoController@store')->name('trabajo.store')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::get('/estudiante/trabajo/registrar/{id_estudiante}', 'TrabajoController@create')->name('trabajo.create')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::get('/estudiante/trabajo/obtener/{id_trabajo}', 'TrabajoController@edit')->name('trabajo.edit')
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

    Route::patch('/estudiante/trabajo/actualizar/{id_trabajo}', 'TrabajoController@update')->name('trabajo.update')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::delete('/estudiante/trabajo/eliminar/{id_trabajo}', 'TrabajoController@destroy')->name('trabajo.delete')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    /* Rutas para informacion de Graduados */
    Route::get('/estudiante/graduacion/{id_estudiante}', 'GraduadoController@show')->name('graduado.show')
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

    Route::get('/estudiante/graduacion/registrar/{id_estudiante}', 'GraduadoController@create')->name('graduado.create')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::patch('/estudiante/graduacion', 'GraduadoController@store')->name('graduado.store')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::get('/estudiante/graduacion/obtener/{id_graduacion}', 'GraduadoController@edit')->name('graduado.edit')
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

    Route::patch('/estudiante/graduacion/actualizar/{id_graduacion}', 'GraduadoController@update')->name('graduado.update')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

    Route::delete('/estudiante/graduacion/eliminar/{id_graduacion}', 'GraduadoController@destroy')->name('graduado.delete')
    ->middleware(
        'roles:
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
            Estudiante asistente académica
    ');

});