<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Ruta principal que lleva al login */

Route::get('/', function () {
    return view('auth.login');
});

/* Ruta principal */
Route::get('/home', 'HomeController@index')->name('home');

/* Ruta para registrar usuario */
Route::get('/register', 'RegistroController@index')->name('register');
Route::post('/registroselper', 'RegistroController@show')->name('registroselper');
Route::post('/registro', 'RegistroController@register')->name('registro');

/* Ruta para actualizar el rol */
Route::get('/cambiar-rol', 'RegistroController@cambiarRol')->name('cambiar-rol');
Route::post('/cambiar-rol', 'RegistroController@mostrarPersonaRol')->name('cambiar-rol.show');
Route::patch('/cambiar-rol', 'RegistroController@actualizarRol')->name('cambiar-rol.update');

/* Ruta del auth */
Auth::routes([
    'register' => false, // Desactivado el auth con el registro
    'reset' => false, // Desactivado el auth con el reset de contraseñas
    'verify' => false, // Desactivado el auth con la verificación de email
]);

Route::group(['middleware' => ['auth']], function () {

    // ======================================================================================================================================
    //                                                           Control de perfil
    // ======================================================================================================================================

    /* Ruta para acceder a las notificaciones */
    Route::get('/perfil/notificaciones', 'PersonaController@notifications')->name('perfil.notifications');
    /* Ruta para obtener la cantidad de notificaciones */
    Route::get('/perfil/cant-notificaciones', 'PersonaController@obtenerNotificaciones')->name('perfil.cant.notifications');
    /* Ruta para acceder a mis actividades */
    Route::get('/perfil/mis-actividades', 'PersonaController@misActividades')->name('perfil.mis-actividades');
    /* Ruta para acceder actualizar contraseña */
    Route::get('/perfil/actualizar-contrasenna', 'PersonaController@cambiarContrasenna')->name('perfil.actualizar-contrasenna');
    /* Ruta para acceder a mis actividades */
    Route::patch('/perfil/actualizar-contrasenna', 'PersonaController@actualizarContrasenna')->name('perfil.actualizar-contrasenna');
    /* Ruta de detalle del perfil*/
    Route::get('/perfil', 'PersonaController@show')->name('perfil.show');
    /* Ruta de update del perfil*/
    Route::patch('/perfil/{persona_id}', 'PersonaController@update')->name('perfil.update');

    // ======================================================================================================================================
    //                                                           Control Estudiantil
    // ======================================================================================================================================

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

    // ======================================================================================================================================
    //                                                           Control de Personal
    // ======================================================================================================================================

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

    // ======================================================================================================================================
    //                                                           Control de Actividades Internas
    // ======================================================================================================================================

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

    // ======================================================================================================================================
    //                                                           Control de Actividades de promocion
    // ======================================================================================================================================

    /* Rutas para informacion de actividades de promocion */
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

    // ======================================================================================================================================
    //                                                              GENERACIÓN DE DATOS Y ESTADÍSTICAS
    // ======================================================================================================================================
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
    // ********************************************************
    //      Reportes de involucramiento ANUAL del personal
    // ********************************************************
    Route::get('/reportes/involucramiento/anual', 'ReportesInvolucramientoController@reporteAnual')->name('reportes-involucramiento.anual')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');
    
    //Esta ruta genera un script que protege que algunos datos sensibles sean visibles directamente en
    //el código fuente de la página
    Route::get('/js/scriptglobal.js', 'HomeController@scriptGeneral')->name('script.global');
    
    // ********************************************************
    //      Reportes de involucramiento POR CICLO del personal
    // ********************************************************

    Route::get('/reportes/involucramiento/ciclo', 'ReportesPorCicloController@show')->name('involucramiento-ciclo.show')
    ->middleware(
        'roles:
            Dirección
            Subdirección
            Académica responsable de Aseguramiento de la Calidad de la Carrera
            Académica responsable de SIGAB
    ');
});
