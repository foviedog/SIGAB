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
Route::post('/registroselper', 'RegistroController@show');
Route::post('/registro', 'RegistroController@register');

/* Ruta del auth */
Auth::routes([
    'register' => false, // Desactivado el auth con el registro
    'reset' => false, // Desactivado el auth con el reset de contraseñas
    'verify' => false, // Desactivado el auth con la verificación de email
]);

// ======================================================================================================================================
//                                                           Control de perfil
// ======================================================================================================================================

/* Ruta de detalle del perfil*/
Route::get('/perfil/{persona_id}', 'PersonaController@show')->name('perfil.show');
/* Ruta de update del perfil*/
Route::patch('/perfil/{persona_id}', 'PersonaController@update')->name('perfil.update');


// ======================================================================================================================================
//                                                           Control Estudiantil
// ======================================================================================================================================

/* Ruta de detalle del estudiante*/
Route::get('/estudiante/detalle/{id_estudiante}', 'EstudianteController@show');
/* Rutas para editar  y actualizar la informacion del estudiante*/
Route::patch('/estudiante/detalle/{id_estudiante}', 'EstudianteController@update')->name('estudiante.update');
/* Ruta para cambiar imagen del estudiante*/
Route::post('/estudiante/imagen/cambiar', 'EstudianteController@update_avatar');

// Muestra el listado de los estudiantes ordenados por su apellido
Route::get('/listado-estudiantil', 'EstudianteController@index')->name('listado-estudiantil');
Route::get('/estudiantes/graduados/listar', 'GraduadoController@index')->name('graduados.listar');

/* Rutas para informacion de Guias academicas */
Route::patch('/estudiante/guia-academica/actualizar/{id_guia}', 'GuiasAcademicaController@update')->name('guia-academica.update');
Route::get('/estudiante/guia-academica/listar', 'GuiasAcademicaController@index')->name('guia-academica.listar');
Route::get('/estudiante/guia-academica/registrar/{id_estudiante}', 'GuiasAcademicaController@create')->name('guia-academica.create');
Route::get('/estudiante/guia-academica/{id_guia}', 'GuiasAcademicaController@show')->name('guia-academica.show');
Route::post('/estudiante/guia-academica', 'GuiasAcademicaController@store')->name('guia-academica.store');
Route::get('/estudiante/guia-academica/{id_guia}/eliminar-archivo', 'GuiasAcademicaController@deleteFile')->name('guia-academica.delete_file');
Route::get('/estudiante/guia-academica/download/{nombre}', 'GuiasAcademicaController@download')->name('guia-academica.download');



/* Rutas para informacion de estudiantes */
Route::get('/estudiante/registrar', 'EstudianteController@create')->name('estudiante.create');
Route::post('/estudiante', 'EstudianteController@store');

/* Rutas para informacion laboral */
Route::get('/estudiante/trabajo/{id_estudiante}', 'TrabajoController@index');
Route::patch('/estudiante/trabajo/registrar', 'TrabajoController@store')->name('trabajo.store');
Route::get('/estudiante/trabajo/registrar/{id_estudiante}', 'TrabajoController@create');
Route::get('/estudiante/trabajo/obtener/{id_trabajo}', 'TrabajoController@edit');
Route::patch('/estudiante/trabajo/actualizar/{id_trabajo}', 'TrabajoController@update');

/* Rutas para informacion de Graduados */
Route::get('/estudiante/graduacion/{id_estudiante}', 'GraduadoController@show')->name('graduado.show');
Route::get('/estudiante/graduacion/registrar/{id_estudiante}', 'GraduadoController@create')->name('graduado.create');
Route::patch('/estudiante/graduacion', 'GraduadoController@store')->name('graduado.store');
Route::get('/estudiante/graduacion/obtener/{id_graduacion}', 'GraduadoController@edit');
Route::patch('/estudiante/graduacion/actualizar/{id_graduacion}', 'GraduadoController@update');

// ======================================================================================================================================
//                                                           Control de Personal
// ======================================================================================================================================

/* Rutas para informacion del personal */
Route::post('/personal', 'PersonalController@store')->name('personal.store');
Route::get('/personal/registrar', 'PersonalController@create')->name('personal.create');
Route::get('/personal/listar', 'PersonalController@index')->name('personal.listar');
Route::get('/personal/detalle/{id_personal}', 'PersonalController@show')->name('personal.show');
Route::get('/personal/obtener/{id_personal}', 'PersonalController@edit');
Route::patch('/personal/detalle/{id_personal}', 'PersonalController@update')->name('personal.update');
/* Ruta para cambiar imagen del personal*/
Route::post('/personal/imagen/cambiar', 'PersonalController@update_avatar');


/* Rutas para informacion de Carga Academica */
Route::get('/personal/carga-academica/{id_personal}', 'CargasAcademicaController@index')->name('cargaacademica.show');
Route::get('/personal/carga-academica/registrar/{id_personal}', 'CargasAcademicaController@create')->name('cargaacademica.create');
Route::patch('/personal/carga-academica', 'CargasAcademicaController@store')->name('cargaacademica.store');
Route::get('/personal/carga-academica/obtener/{id_carga_academica}', 'CargasAcademicaController@edit')->name('cargaacademica.edit');
Route::patch('/personal/carga-academica/actualizar/{id_carga_academica}', 'CargasAcademicaController@update')->name('cargaacademica.update');

// ======================================================================================================================================
//                                                           Control de Actividades Internas
// ======================================================================================================================================

/* Rutas para informacion de actividades internas */
//Registrar una actividad interna
Route::get('/actividad-interna/registrar', 'ActividadesInternaController@create')->name('actividad-interna.create');
Route::post('/actividad-interna', 'ActividadesInternaController@store');
// Listado de actividades internas
Route::get('/actividad-interna', 'ActividadesInternaController@index')->name('actividad-interna.listado');
// Detalle de actividad interna
Route::get('/detalle-actividad-interna/{id_actividad}', 'ActividadesInternaController@show')->name('actividad-interna.show');
// Actualización de los datos de la actividad
Route::patch('/actividad-interna/{id_actividad}', 'ActividadesInternaController@update')->name('actividad-interna.update');

// ********************************************
//      Control de listas de asistencia
// ********************************************
Route::get('/lista-asistencia', 'ListaAsistenciaController@show');
